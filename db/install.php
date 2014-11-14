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
 * @link https://docs.moodle.org/dev/Installing_and_upgrading_plugin_database_tables#install.php
 * @package   auth_lenauth
 * @copyright 2014 Igor Sazonov ( @tigusigalpa )
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_auth_lenauth_install() {
    global $DB;
    
    $default_info_field = new stdClass;
    $default_info_field->datatype = 'text';
    $default_info_field->descriptionformat = 1;
    $default_info_field->categoryid = 1;
    $default_info_field->sortorder = 1;
    $default_info_field->required = 0;
    $default_info_field->locked = 1;
    $default_info_field->visible = 1;
    $default_info_field->forceunique = 1;
    $default_info_field->signup = 0;
    $default_info_field->defaultformat = 0;
    
    //Facebook
    $facebook_info_field = new stdClass;
    $facebook_info_field->shortname = 'auth_lenauth_facebook_social_id';
    $facebook_info_field->name = get_string( 'auth_lenauth_facebook_binding', 'auth_lenauth' );
    $facebook_info_field_obj = (object) array_merge((array) $facebook_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record('user_info_field', $facebook_info_field_obj ) ) {
        set_config( 'auth_lenauth_facebook_social_id_field', 'auth_lenauth_facebook_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_facebook_button_text', get_string( 'auth_lenauth_facebook_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //Google
    $google_info_field = new stdClass;
    $google_info_field->shortname = 'auth_lenauth_google_social_id';
    $google_info_field->name = get_string( 'auth_lenauth_google_binding', 'auth_lenauth' );
    $google_info_field_obj = (object) array_merge((array) $google_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record('user_info_field', $google_info_field_obj ) ) {
        set_config( 'auth_lenauth_google_social_id_field', 'auth_lenauth_google_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_google_button_text', get_string( 'auth_lenauth_google_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //Yahoo
    $yahoo_info_field = new stdClass;
    $yahoo_info_field->shortname = 'auth_lenauth_yahoo_social_id';
    $yahoo_info_field->name = get_string( 'auth_lenauth_yahoo_binding', 'auth_lenauth' );
    $yahoo_info_field_obj = (object) array_merge((array) $yahoo_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record( 'user_info_field', $yahoo_info_field_obj ) ) {
        set_config( 'auth_lenauth_yahoo_social_id_field', 'auth_lenauth_yahoo_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_yahoo_button_text', get_string( 'auth_lenauth_yahoo_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //Twitter
    $twitter_info_field = new stdClass;
    $twitter_info_field->shortname = 'auth_lenauth_twitter_social_id';
    $twitter_info_field->name = get_string( 'auth_lenauth_twitter_binding', 'auth_lenauth' );
    $twitter_info_field_obj = (object) array_merge((array) $twitter_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record( 'user_info_field', $twitter_info_field_obj ) ) {
        set_config( 'auth_lenauth_twitter_social_id_field', 'auth_lenauth_twitter_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_twitter_button_text', get_string( 'auth_lenauth_twitter_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //VK
    $vk_info_field = new stdClass;
    $vk_info_field->shortname = 'auth_lenauth_vk_social_id';
    $vk_info_field->name = get_string( 'auth_lenauth_vk_binding', 'auth_lenauth' );
    $vk_info_field_obj = (object) array_merge((array) $vk_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record( 'user_info_field', $vk_info_field_obj ) ) {
        set_config( 'auth_lenauth_vk_social_id_field', 'auth_lenauth_vk_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_vk_button_text', get_string( 'auth_lenauth_vk_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //Yandex
    $yandex_info_field = new stdClass;
    $yandex_info_field->shortname = 'auth_lenauth_yandex_social_id';
    $yandex_info_field->name = get_string( 'auth_lenauth_yandex_binding', 'auth_lenauth' );
    $yandex_info_field_obj = (object) array_merge((array) $yandex_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record( 'user_info_field', $yandex_info_field_obj ) ) {
        set_config( 'auth_lenauth_yandex_social_id_field', 'auth_lenauth_yandex_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_yandex_button_text', get_string( 'auth_lenauth_yandex_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }
    
    //MailRu
    $mailru_info_field = new stdClass;
    $mailru_info_field->shortname = 'auth_lenauth_mailru_social_id';
    $mailru_info_field->name = get_string( 'auth_lenauth_mailru_binding', 'auth_lenauth' );
    $mailru_info_field_obj = (object) array_merge((array) $mailru_info_field, (array) $default_info_field);
    
    if ( $DB->insert_record( 'user_info_field', $mailru_info_field_obj ) ) {
        set_config( 'auth_lenauth_mailru_social_id_field', 'auth_lenauth_mailru_social_id', 'auth/lenauth' );
        set_config( 'auth_lenauth_mailru_button_text', get_string( 'auth_lenauth_mailru_button_text_default', 'auth_lenauth' ), 'auth/lenauth' );
    }


    set_config('auth_lenauth_display_buttons',      'inline-block', 'auth/lenauth');
    set_config('auth_lenauth_display_div',          'block',        'auth/lenauth');
    set_config('auth_lenauth_locale',               'en',           'auth/lenauth');

    set_config('auth_lenauth_button_margin_top',    10,             'auth/lenauth');
    set_config('auth_lenauth_button_margin_right',  10,             'auth/lenauth');
    set_config('auth_lenauth_button_margin_bottom', 10,             'auth/lenauth');
    set_config('auth_lenauth_button_margin_left',   10,             'auth/lenauth');
    
}