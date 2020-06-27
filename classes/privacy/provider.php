<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Privacy Subsystem implementation for auth_lenauth.
 *
 * @package auth_lenauth
 * @author  Igor Sazonov
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace auth_lenauth\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\core_userlist_provider;
use core_privacy\local\request\transform;
use core_privacy\local\request\userlist;
use Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth\LenAuth;

class provider implements
    \core_privacy\local\metadata\provider,
    core_userlist_provider,
    \core_privacy\local\request\plugin\provider
{
    /**
     * Returns meta data about this system.
     *
     * @param   collection $collection The initialised collection to add items to.
     * @return  collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection
    {
        return $collection->add_database_table('user_info_data', [
            'userid' => 'privacy:metadata:auth_lenauth:userid',
            'fieldid' => 'privacy:metadata:auth_lenauth:fieldid',
            'data' => 'privacy:metadata:auth_lenauth:data',
            'dataformat' => 'privacy:metadata:auth_lenauth:dataformat'
        ], 'privacy:metadata:auth_lenauth:tableexplanation');
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int         $userid     The user to search.
     * @return  contextlist $contextlist  The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid) : contextlist
    {
        $sql = "SELECT ctx.id
                  FROM {user_info_data} uind
                  JOIN {user_info_field} uif ON uda.fieldid = uif.id
                  JOIN {user_info_category} uic ON uif.categoryid = uic.id
                  JOIN {context} ctx ON ctx.instanceid = uind.userid
                       AND ctx.contextlevel = :contextlevel
                 WHERE uind.userid = :userid AND uif.categoryid = :categoryid";
        $params = [
            'userid' => $userid,
            'contextlevel' => CONTEXT_USER,
            'categoryid' => LenAuth::getUserInfoFieldsCategory('id')
        ];
        $contextlist = new contextlist();
        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users within a specific context.
     *
     * @param userlist $userlist The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist)
    {
        $context = $userlist->get_context();

        if (!$context instanceof \context_user) {
            return;
        }

        $sql = "SELECT uda.userid
                  FROM {user_info_data} uid
                  JOIN {user_info_field} uif ON uid.fieldid = uif.id
                  JOIN {user_info_category} uic ON uif.categoryid = uic.id
                 WHERE uid.userid = :userid AND uic.id = :categoryid";

        $params = [
            'userid' => $context->instanceid,
            'categoryid' => LenAuth::getUserInfoFieldsCategory('id')
        ];

        $userlist->add_from_sql('userid', $sql, $params);
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist)
    {
        $user = $contextlist->get_user();
        foreach ($contextlist->get_contexts() as $context) {
            // Check if the context is a user context.
            if ($context->contextlevel == CONTEXT_USER && $context->instanceid == $user->id) {
                $results = static::get_records($user->id);
                foreach ($results as $result) {
                    $data = (object) [
                        'name' => $result->name,
                        'description' => $result->description,
                        'data' => transform::date($result->data)
                    ];
                    \core_privacy\local\request\writer::with_context($context)->export_data([
                        get_string('pluginname', 'auth_lenauth')], $data);
                }
            }
        }
    }

    /**
     * Delete all user data which matches the specified context.
     *
     * @param   context $context A user context.
     */
    public static function delete_data_for_all_users_in_context(\context $context)
    {
        // Delete data only for user context.
        if ($context->contextlevel == CONTEXT_USER) {
            static::delete_data($context->instanceid);
        }
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist)
    {
        $context = $userlist->get_context();

        if ($context instanceof \context_user) {
            static::delete_data($context->instanceid);
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param   approved_contextlist    $contextlist    The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist)
    {
        $user = $contextlist->get_user();
        foreach ($contextlist->get_contexts() as $context) {
            // Check if the context is a user context.
            if ($context->contextlevel == CONTEXT_USER && $context->instanceid == $user->id) {
                static::delete_data($context->instanceid);
            }
        }
    }

    /**
     * Delete data related to a userid.
     *
     * @param  int $userid The user ID
     */
    protected static function delete_data($userid)
    {
        global $DB;
        $params = [
            'categoryid' => LenAuth::getUserInfoFieldsCategory('id'),
            'userid' => $userid
        ];

        $DB->delete_records_select('user_info_data', "fieldid IN (
                SELECT id FROM {user_info_field} WHERE categoryid = :categoryid)
                AND userid = :userid", $params);
    }

    /**
     * Get records related to this plugin and user.
     *
     * @param  int $userid The user ID
     * @return array An array of records.
     */
    protected static function get_records($userid)
    {
        global $DB;
        $sql = "SELECT *
                  FROM {user_info_data} uda
                  JOIN {user_info_field} uif ON uda.fieldid = uif.id
                  JOIN {user_info_category} uic ON uif.categoryid = uic.id
                 WHERE uda.userid = :userid AND uic.id = :categoryid";
        $params = [
            'userid' => $userid,
            'categoryid' => LenAuth::getUserInfoFieldsCategory('id')
        ];

        return $DB->get_records_sql($sql, $params);
    }
}
