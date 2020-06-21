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
 * Install trigger for component 'auth_lenauth'
 *
 * @link      https://docs.moodle.org/dev/Installing_and_upgrading_plugin_database_tables#install.php
 * @package   auth_lenauth
 * @copyright Igor Sazonov <sovletig@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../../auth/lenauth/autoload.php';

use \Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth\LenAuth;

function xmldb_auth_lenauth_install()
{
    global $DB;
    if ($categoryId = $DB->insert_record('user_info_category', (object) [
        'name' => get_string('pluginname', 'auth_lenauth'),
        'sortorder' => LenAuth::getUserInfoCategorySortOrder()])) {
        $defaultInfoField = [
            'datatype' => 'text',
            'descriptionformat' => 1,
            'categoryid' => $categoryId,
            'sortorder' => 1,
            'required' => 0,
            'locked' => 1,
            'visible' => 1,
            'forceunique' => 1,
            'signup' => 0,
            'defaultformat' => 0,
        ];
        foreach (array_keys(LenAuth::SETTINGS) as $social) {
            if ($fieldId = $DB->insert_record('user_info_field', (object) array_merge([
                'shortname' => $social . '_social_id',
                'name' => get_string($social . '_binding', 'auth_lenauth')
            ], $defaultInfoField))) {
                set_config(
                    $social . '_field_id',
                    $fieldId,
                    'auth_lenauth'
                );
                set_config(
                    $social . '_button_text',
                    get_string($social . '_button_text_default', 'auth_lenauth'),
                    'auth_lenauth'
                );
            }
        }
        set_config('display_buttons', 'inline-block', 'auth_lenauth');
        set_config('display_div', 'block', 'auth_lenauth');
        set_config('locale', 'en', 'auth_lenauth');
        set_config('default_country', '', 'auth_lenauth');
        set_config('user_prefix', 'lenauth_user_', 'auth_lenauth');
        set_config('can_reset_password', 0, 'auth_lenauth');
        set_config('can_confirm', 0, 'auth_lenauth');
        set_config('retrieve_avatar', 0, 'auth_lenauth');

        set_config('div_width', 0, 'auth_lenauth');
        set_config('button_width', 0, 'auth_lenauth');

        set_config('facebook_enabled', 0, 'auth_lenauth');
        set_config('google_enabled', 0, 'auth_lenauth');
        set_config('yahoo_enabled', 0, 'auth_lenauth');
        set_config('twitter_enabled', 0, 'auth_lenauth');
        set_config('vk_enabled', 0, 'auth_lenauth');
        set_config('yandex_enabled', 0, 'auth_lenauth');
        set_config('mailru_enabled', 0, 'auth_lenauth');

        set_config('div_margin_top', 0, 'auth_lenauth');
        set_config('div_margin_right', 0, 'auth_lenauth');
        set_config('div_margin_bottom', 0, 'auth_lenauth');
        set_config('div_margin_left', 0, 'auth_lenauth');

        set_config('button_margin_top', 10, 'auth_lenauth');
        set_config('button_margin_right', 10, 'auth_lenauth');
        set_config('button_margin_bottom', 10, 'auth_lenauth');
        set_config('button_margin_left', 10, 'auth_lenauth');

        $default_order = [
            1 => 'facebook', 2 => 'google', 3 => 'yahoo', 4 => 'twitter',
            5 => 'vk', 6 => 'yandex', 7 => 'mailru'
        ];
        set_config('order', json_encode($default_order), 'auth_lenauth');
    }
}
