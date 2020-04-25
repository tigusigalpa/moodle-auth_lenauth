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

function xmldb_auth_lenauth_install()
{
    global $DB;
    $defaultInfoField = new \stdClass();
    $defaultInfoField->datatype = 'text';
    $defaultInfoField->descriptionformat = 1;
    $defaultInfoField->categoryid = 1;
    $defaultInfoField->sortorder = 1;
    $defaultInfoField->required = 0;
    $defaultInfoField->locked = 1;
    $defaultInfoField->visible = 1;
    $defaultInfoField->forceunique = 1;
    $defaultInfoField->signup = 0;
    $defaultInfoField->defaultformat = 0;
    foreach (['facebook', 'google', 'yahoo', 'twitter', 'vk', 'yandex', 'mailru'] as $social) {
        $infoField = new \stdClass();
        $infoField->shortname = 'auth_lenauth_' . $social . '_social_id';
        $infoField->name = get_string('auth_lenauth_' . $social . '_binding', 'auth_lenauth');
        $infoFieldObj = (object) array_merge((array) $infoField, (array) $defaultInfoField);
        if ($DB->insert_record('user_info_field', $infoFieldObj)) {
            set_config(
                'auth_lenauth_' . $social . '_social_id_field',
                'auth_lenauth_' . $social . '_social_id',
                'auth_lenauth'
           );
            set_config(
                'auth_lenauth_' . $social . '_button_text',
                get_string('auth_lenauth_' . $social . '_button_text_default', 'auth_lenauth'),
                'auth_lenauth'
           );
        }
    }

    set_config('auth_lenauth_display_buttons', 'inline-block', 'auth_lenauth');
    set_config('auth_lenauth_display_div', 'block', 'auth_lenauth');
    set_config('auth_lenauth_locale', 'en', 'auth_lenauth');
    set_config('auth_lenauth_default_country', '', 'auth_lenauth');
    set_config('auth_lenauth_user_prefix', 'lenauth_user_', 'auth_lenauth');
    set_config('auth_lenauth_can_reset_password', 0, 'auth_lenauth');
    set_config('auth_lenauth_can_confirm', 0, 'auth_lenauth');
    set_config('auth_lenauth_retrieve_avatar', 0, 'auth_lenauth');
    
    set_config('auth_lenauth_div_width', 0, 'auth_lenauth');
    set_config('auth_lenauth_button_width', 0, 'auth_lenauth');
    
    set_config('auth_lenauth_facebook_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_google_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_yahoo_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_twitter_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_vk_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_yandex_enabled', 0, 'auth_lenauth');
    set_config('auth_lenauth_mailru_enabled', 0, 'auth_lenauth');
    
    set_config('auth_lenauth_div_margin_top', 0, 'auth_lenauth');
    set_config('auth_lenauth_div_margin_right', 0, 'auth_lenauth');
    set_config('auth_lenauth_div_margin_bottom', 0, 'auth_lenauth');
    set_config('auth_lenauth_div_margin_left', 0, 'auth_lenauth');

    set_config('auth_lenauth_button_margin_top', 10, 'auth_lenauth');
    set_config('auth_lenauth_button_margin_right', 10, 'auth_lenauth');
    set_config('auth_lenauth_button_margin_bottom', 10, 'auth_lenauth');
    set_config('auth_lenauth_button_margin_left', 10, 'auth_lenauth');
    
    $default_order = [
        1 => 'facebook', 2 => 'google', 3 => 'yahoo', 4 => 'twitter',
        5 => 'vk', 6 => 'yandex', 7 => 'mailru'
    ];
    set_config('auth_lenauth_order', json_encode($default_order), 'auth_lenauth');
}
