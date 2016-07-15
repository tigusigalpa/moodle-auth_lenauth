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
 * Strings for component 'auth_lenauth', language 'en'
 *
 * @package    auth_lenauth
 * @author     Igor Sazonov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['auth_lenauth_enabled_key'] = 'Enabled';
$string['auth_lenauth_buttontext_key'] = 'Button text';
$string['auth_lenauth_button_div_width'] = 'Width (<em>0 = auto</em>)';
$string['auth_lenauth_binding_key'] = 'Binding';
$string['auth_lenauth_output_settings'] = 'Output settings';

$string['pluginname'] = 'LenAuth';
$string['auth_lenauthdescription'] = 'This plugin for Moodle allows you easily add authentication methods (log-in or automatically sing-up) via OAuth providers of social plugins: Facebook. Google, Yahoo, Twitter, VK, Yandex, Mail.Ru. Several templates of social sign-in buttons and links, own text for buttons, lot of settings, English and Russian languages localization.';
$string['auth_lenauth_main_settings'] = 'Main settings';

$string['auth_lenauth_user_prefix_key'] = 'User prefix';
$string['auth_lenauth_user_prefix_desc'] = 'Moodle users nickname prefix, authorised via LenAuth';
$string['auth_lenauth_default_country_key'] = 'Default country';
$string['auth_lenauth_locale_en_key'] = 'International logos';
$string['auth_lenauth_locale_ru_key'] = 'Russian logos';
$string['auth_lenauth_static_html'] = 'Static HTML-code';
$string['auth_lenauth_style_not_defined'] = 'This style is not defined as a plugin style';
$string['auth_lenauth_locale_desc'] = 'Some services have local and international logos, for example, VK and Yandex';
$string['auth_lenauth_default_country_desc'] = 'Every user registered via LenAuth will have this country selected by default on register page';
$string['auth_lenauth_can_reset_password_key'] = 'User can reset/change an internal password (<em>recommended</em>)';
$string['auth_lenauth_can_reset_password_desc'] = 'If the option enabled, user can change an internal password (<strong>nothing by default</strong>) and authorise via Moodle login form without OAuth plugin';
$string['auth_lenauth_can_confirm_key'] = 'Moderate new users';
$string['auth_lenauth_can_confirm_desc'] = 'New users, registered via LenAuth needs to be moderated by Moodle administrator';
$string['auth_lenauth_retrieve_avatar_key'] = 'Retrieve avatar';
$string['auth_lenauth_retrieve_avatar_desc'] = 'If option checked and if user is newbie or exists without Moodle-based avatar, it will be uploaded automatically if it exists at social profile';
$string['auth_lenauth_dev_mode_key'] = 'Development mode';
$string['auth_lenauth_dev_mode_desc'] = 'If you are developer and you need to check OAuth webservices response, just set this option on.<br /><strong style="color:red">Moodle native DEVELOPER mode is required</strong>';

$string['auth_lenauth_empty_code_param'] = 'Someting wrong, code GET-param is empty. Check your App settings in LenAuth';

$string['auth_lenauth_buttons_settings'] = 'Buttons settings';

$string['auth_lenauth_buttons_location'] = 'Buttons location';
$string['auth_lenauth_display_inline'] = 'Inline';
$string['auth_lenauth_display_block'] = 'Block';

$string['auth_lenauth_margin_top_key'] = 'Margin top (px)';
$string['auth_lenauth_margin_right_key'] = 'Margin right (px)';
$string['auth_lenauth_margin_bottom_key'] = 'Margin bottom (px)';
$string['auth_lenauth_margin_left_key'] = 'Margin left (px)';
$string['auth_lenauth_order'] = 'Order';


$string['auth_lenauth_div_settings'] = 'Buttons area settings';
$string['auth_lenauth_div_location'] = 'Area location';
$string['auth_lenauth_output_style_key'] = 'Live style';
$string['auth_lenauth_bootstrap_fontawesome_needle'] = 'To make a correct output your theme is required CSS-framework Bootstrap and fonts Font-Awesome!';
$string['auth_lenauth_output_php_code_key'] = 'Theme PHP-code';

/**
 * ERRORS
 */
$string['auth_lenauth_user_suspended'] = 'User is suspended';
$string['auth_lenauth_access_token_empty'] = 'Could not get access to access token. Check your App Settings';
/**
 * Facebook English locale
 */
$string['auth_lenauth_facebook_settings'] = 'Facebook Settings';
$string['auth_lenauth_facebook_dashboard'] = 'Facebook App Dashboard';
$string['auth_lenauth_facebook_app_id_key'] = 'App ID';
$string['auth_lenauth_facebook_desc'] = '
    <ol>
        <li>You need to have any social account at <a href="https://www.facebook.com/" target="_blank">Facebook</a></li>
        <li><a href="https://developers.facebook.com/apps/" target="_blank">Register</a> as Facebook developer</li>
        <li>At developers console you need to create an Application (<strong>+ Add a New App</strong> button) with category <strong>WWW Web-site</strong> and arbitrary title</li>
        <li>Fill in the application settings <strong>Site URL</strong> as <strong>{$a->wwwroot}</strong>. Next, click on the link <strong><a href="https://developers.facebook.com/apps/" target="_blank">Skip to Developer Dashboard</a></strong></li>
        <li>As a result, you will be given <strong>App ID</strong> and <strong>App Secret</strong> (to become visible, click <strong>Show</strong>). Copy them here.</li>
        <li><strong>IMPORTANT!</strong> at developers console go to tab <strong>Advanced</strong> and fill the field <strong>Valid OAuth redirect URIs</strong>: fill there <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=facebook</strong></li>
    </ol>';
$string['auth_lenauth_facebook_app_secret_key'] = 'App secret';
$string['auth_lenauth_facebook_button_text_default'] = 'Facebook';
$string['auth_lenauth_facebook_binding'] = 'Facebook Social ID';

/**
 * Google English locale
 */
$string['auth_lenauth_google_settings'] = 'Google Settings';
$string['auth_lenauth_google_dashboard'] = 'Project settings';
$string['auth_lenauth_google_client_id_key'] = 'Client ID';
$string['auth_lenauth_google_desc'] = '
    <ol>
        <li>You need to have any registered account at <a href="https://accounts.google.com/SignUp" target="_blank">Google</a></li>
        <li><a href="https://console.developers.google.com/" target="_blank">Create a Project</a> (<strong>Create Project</strong> button) at Google developers console</li>
        <li>At developers console in section <strong>APIs &amp; auth &raquo; Credentials</strong> create <strong>OAuth Client ID</strong></li>
        <li><strong>ATTENTION!</strong> Google Project allows to enter several <strong>Redirect URI</strong>, but you need to fill just one, and this is &mdash; <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=google</strong></li>
        <li>At the Project in section <strong>APIs &amp; auth &raquo; Credentials</strong> copy here <strong>CLIENT ID</strong> and <strong>CLIENT SECRET</strong></li>
        <li>Parameter <strong>Project ID</strong> is not required, you can copy it from menu section <strong>Overview</strong> at console at the top of page</li>
    </ol>';
$string['auth_lenauth_google_client_secret_key'] = 'Client secret';
$string['auth_lenauth_google_project_id_key'] = 'Project ID';
$string['auth_lenauth_google_button_text_default'] = 'Google';
$string['auth_lenauth_google_binding'] = 'Google Social ID';

/**
 * Yahoo English locale
 */
$string['auth_lenauth_yahoo_settings'] = 'Yahoo Settings';
$string['auth_lenauth_yahoo_oauth_1_note'] = 'if you already have Yahoo OAuth account';
$string['auth_lenauth_yahoo_oauth_2_note'] = 'recommended for new apps';
$string['auth_lenauth_yahoo_application_id'] = 'Application ID';
$string['auth_lenauth_yahoo_consumer_key'] = 'Consumer Key';
$string['auth_lenauth_yahoo_consumer_secret'] = 'Consumer Secret';
$string['auth_lenauth_yahoo_button_text_default'] = 'Yahoo';
$string['auth_lenauth_yahoo_desc'] = '
    <ol>
        <li>You need to have any account at <a href="https://edit.yahoo.com/registration" target="_blank">Yahoo</a></li>
        <li>
            <ul><a href="https://developer.apps.yahoo.com/dashboard/createKey.html" target="_blank">Create an Application</a> (<strong>Create An App</strong>) at <a href="https://developer.apps.yahoo.com/projects" target="_blank">Yahoo Developer Network (YDN)</a>
                <li>Application Type: <strong>Web-based</strong></li>
                <li>Home Page URL: <strong>{$a->wwwroot}</strong></li>
                <li>Access Scopes: <strong>This app requires access to private user data.</strong></li>
                <li>Callback Domain: <strong style="color:red">{$a->wwwroot}</strong></li>
                <li>Select APIs for private user data access: check the option <strong>Social Directory (Profiles)</strong>, and after check the last mark <strong>Read/Write Public and Private</strong></li>
                <li>Terms of Use: <em>check the option</em></li>
            </ul>
        </li>
        <li>Copy here: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong> from Application settings</li>
        <li><em>Optionally</em>: copy here <strong>Application ID</strong>, at top of application settings page</li>
    </ol>';
$string['auth_lenauth_yahoo_binding'] = 'Yahoo Social ID';

$string['auth_lenauth_front_error'] = 'We can not authenticate you due OAuth authorization';
$string['auth_lenauth_error_code'] = 'Error code';

/**
 * Twitter English locale
 */
$string['auth_lenauth_twitter_settings'] = 'Twitter Settings';
$string['auth_lenauth_twitter_dashboard'] = 'Application dashboard';
$string['auth_lenauth_twitter_application_id'] = 'Application ID';
$string['auth_lenauth_twitter_consumer_key'] = 'Consumer Key';
$string['auth_lenauth_twitter_consumer_secret'] = 'Consumer Secret';
$string['auth_lenauth_twitter_button_text_default'] = 'Twitter';
$string['auth_lenauth_twitter_desc'] = '
    <ol>
        <li>You need to have any social account at <a href="https://twitter.com/" target="_blank">Twitter</a></li>
        <li>
            <ul><a href="https://apps.twitter.com/app/new" target="_blank">Create an application</a>
                <li>Name: <strong>Title of your application</strong></li>
                <li>Description: <strong>Describe your application</strong></li>
                <li>Website: <strong>{$a->wwwroot}</strong></li>
                <li>Callback URL: <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=twitter</strong></li>
                <li>Developer Rules of the Road: check the option <strong>Yes, I agree</strong></li>
            </ul>
        </li>
        <li>Copy here from application settings: <strong>Consumer Key</strong>, <strong>Consumer Secret</strong>. Tab <strong>Keys and Access Tokens</strong></li>
        <li><em>Optionally</em>: Copy here <strong>Application ID</strong> from URL of application page, e.g. <strong>1234567</strong> if URL is <strong>https://apps.twitter.com/app/1234567</strong></li>
    </ol>';
$string['auth_lenauth_twitter_binding'] = 'Twitter Social ID';

/**
 * VK English locale
 */
$string['auth_lenauth_vk_settings'] = 'VK.com Settings';
$string['auth_lenauth_vk_dashboard'] = 'Application settings';
$string['auth_lenauth_vk_app_id_key'] = 'App ID';
$string['auth_lenauth_vk_app_secret_key'] = 'App secret';
$string['auth_lenauth_vk_button_text_default'] = 'VK';
$string['auth_lenauth_vk_desc'] = '
    <ol>
        <li>You need to have any account at social network <a href="http://vk.com/" target="_blank">VK</a></li>
        <li>
            <ul><a href="http://vk.com/editapp?act=create" target="_blank">Create an Application</a>
                <li>Category: <strong>Website</strong></li>
                <li>Site address: <strong>{$a->wwwroot}</strong></li>
                <li>Base domain: <strong>{$a->wwwroot}</strong> (<em style="color:red;font-weight:bold;">without <u>http://</u> or <u>https://</u> prefix</em>)</li>
            </ul>
        </li>
        <li>At <a href="http://vk.com/apps?act=manage" target="_blank">Manage apps dashboard</a> click on <strong>Manage</strong> link and in tab <strong>Settings</strong> of your Application manager copy here <strong>Application ID</strong> and <strong>Secure key</strong></li>
        <li><em>Optionally</em>: in tab <strong>Information</strong> fill information about your Application</li>
    </ol>';
$string['auth_lenauth_vk_binding'] = 'VK Social ID';

/**
 * Yandex English locale
 */
$string['auth_lenauth_yandex_settings'] = 'Yandex Settings';
$string['auth_lenauth_yandex_dashboard'] = 'Yandex App Dashboard';
$string['auth_lenauth_yandex_app_id'] = 'Site ID';
$string['auth_lenauth_yandex_desc'] = '
    <ol>
        <li>You need to have any account at <a href="https://passport.yandex.com/registration/" target="_blank">Yandex</a></li>
        <li><a href="https://oauth.yandex.com/client/new" target="_blank">Register</a> your OAuth client</li>
        <li>
            <ul><strong>Configure the client</strong>:
                <li>Fields <strong>Title</strong>, <strong>Description</strong>, </strong>Link to icon</strong> и <strong>Link to client site</strong> of client at your discretion</li>
                <li>The field <strong>Scopes</strong> need to be <strong>Yandex.Username</strong> and check 2 options (Email address; User name, surname and gender)</li>
                <li>The field <strong>Callback URL</strong> need to be as <strong style="color:red">{$a->wwwroot}/auth/lenauth/redirect.php?auth_service=yandex' . '</strong></li>
            </ul>
        </li>
        <li>Copy here 2 parameters: <strong>ID</strong>, <strong>Password</strong></li>
    </ol>';
$string['auth_lenauth_yandex_app_password_key'] = 'App password';
$string['auth_lenauth_yandex_button_text_default'] = 'Yandex';
$string['auth_lenauth_yandex_binding'] = 'Yandex Social ID';

/**
 * Mail.ru English locale
 */
$string['auth_lenauth_mailru_settings'] = 'Mail.ru Settings';
$string['auth_lenauth_mailru_dashboard'] = 'Mail.ru site settings';
$string['auth_lenauth_mailru_site_id'] = 'Site ID';
$string['auth_lenauth_mailru_client_private_key'] = 'Private key';
$string['auth_lenauth_mailru_client_secret_key'] = 'Secret key';
$string['auth_lenauth_mailru_button_text_default'] = 'Mail.ru';
$string['auth_lenauth_mailru_desc'] = '
    <ol>
        <li>You need to have any account at <a href="https://e.mail.ru/signup?from=main_noc" target="_blank">Mail.ru</a></li>
        <li><a href="http://api.mail.ru/sites/my/add" target="_blank">Register</a> your website. <em>Upload receiver.html is not required, it is desirable.</em></li>
        <li>Copy here 3 parameters: <strong>ID</strong>, <strong>Private key</strong>, <strong>Secret key</strong></li>
        <li><em>Optionally</em>: Set up your application: <strong>Icon for lists</strong>, <strong>Image for dialogs</strong></li>
    </ol>';
$string['auth_lenauth_mailru_binding'] = 'MailRu Social ID';

/**
 * Odnoklassniki English locale
 */
/*$string['auth_ok_settings'] = 'OdnoKlassniki';
$string['auth_ok_app_id_key'] = 'Application ID';
$string['auth_ok_public_key_key'] = 'Public key';
$string['auth_ok_secret_key_key'] = 'Secret key';
$string['auth_ok_button_text_default'] = 'Odnoklassniki';*/