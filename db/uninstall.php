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
 * Uninstall trigger for component 'auth_lenauth'
 *
 * @link      https://docs.moodle.org/dev/Installing_and_upgrading_plugin_database_tables#uninstall.php
 * @package   auth_lenauth
 * @copyright Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../../auth/lenauth/autoload.php';

use \Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth\LenAuth;

function xmldb_auth_lenauth_uninstall()
{
    global $DB;
    $DB->delete_records('config_plugins', ['plugin' => 'auth_lenauth']);
    if ($userInfoFieldsCategory = LenAuth::getUserInfoFieldsCategory()) {
        $DB->delete_records('user_info_category', ['id' => $userInfoFieldsCategory->id]);
        foreach (array_keys(LenAuth::SETTINGS) as $social) {
            if ($infoField = $DB->get_record('user_info_field', ['shortname' => $social . '_social_id'])) {
                $DB->delete_records('user_info_data', ['fieldid' => $infoField->id]);
            }
        }
    }
    return true;
}
