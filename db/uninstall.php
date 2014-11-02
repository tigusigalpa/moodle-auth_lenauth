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
 * @link https://docs.moodle.org/dev/Installing_and_upgrading_plugin_database_tables#uninstall.php
 * @package   auth_lenauth
 * @copyright 2014 Igor Sazonov ( @tigusigalpa )
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function xmldb_auth_lenauth_uninstall() {
    global $DB;
    
    $DB->delete_records( 'config_plugins', array( 'plugin' => 'auth/lenauth' ) );
    
    //Facebook
    $facebook_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_facebook_social_id' ) );
    if ( !empty( $facebook_info_field ) && !empty( $facebook_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $facebook_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_facebook_social_id' ) );
    
    //Google
    $google_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_google_social_id' ) );
    if ( !empty( $google_info_field ) && !empty( $google_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $google_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_google_social_id' ) );
    
    //Yahoo
    $yahoo_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_yahoo_social_id' ) );
    if ( !empty( $yahoo_info_field ) && !empty( $yahoo_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $yahoo_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_yahoo_social_id' ) );
    
    //Twitter
    $twitter_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_twitter_social_id' ) );
    if ( !empty( $twitter_info_field ) && !empty( $twitter_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $twitter_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_twitter_social_id' ) );
    
    //VK
    $vk_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_vk_social_id' ) );
    if ( !empty( $vk_info_field ) && !empty( $vk_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $vk_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_vk_social_id' ) );
    
    //Yandex
    $yandex_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_yandex_social_id' ) );
    if ( !empty( $yandex_info_field ) && !empty( $yandex_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $yandex_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_yandex_social_id' ) );
    
    //MailRu
    $mailru_info_field = $DB->get_record( 'user_info_field', array( 'shortname' => 'lenauth_mailru_social_id' ) );
    if ( !empty( $mailru_info_field ) && !empty( $mailru_info_field->id ) ) {
        $DB->delete_records( 'user_info_data', array( 'fieldid' => $mailru_info_field->id ) );
    }
    $DB->delete_records( 'user_info_field', array( 'shortname' => 'lenauth_mailru_social_id' ) );
}

