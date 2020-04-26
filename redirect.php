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

defined('MOODLE_INTERNAL') || die;

require_once __DIR__ . '/../../auth/lenauth/autoload.php';

$code = '';
$state = '';
$error = false;
$error_code = '';
$OAuthToken = false;
$OAuthVerifier = false;

$auth_service = optional_param('auth_service', '', PARAM_TEXT);

if (!empty($auth_service)) {
    
    switch ($auth_service) {
        case 'facebook':
            $code = optional_param('code', '', PARAM_TEXT);
            if (empty($code)) {
                $error_inurl = optional_param('error', '', PARAM_TEXT);
                switch ($error_inurl) {
                    case 'access_denied':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                $error_inurl2 = optional_param('error_description', '', PARAM_TEXT);
                if (!empty($error_inurl2)) {
                    $error = true;
                    $error_code .= ' - ' . urldecode($error_inurl2);
                }
                if (empty($error_inurl)) {
                    $error = true;
                    $error_code = get_string('empty_code_param', 'auth_lenauth');
                }
            }

            break;
            
        case 'google':
            $code = optional_param('code', '', PARAM_TEXT);
            if (empty($code)) {
                $error_inurl = optional_param('error', '', PARAM_TEXT);
                switch ($error_inurl) {
                    case 'access_denied':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                if (empty($error_inurl)) {
                    $error = true;
                    $error_code = get_string('empty_code_param', 'auth_lenauth');
                }
            }

            break;
            
        case 'yahoo1':
            $code = $auth_service;
            $OAuthToken = false;
            if (isset($_REQUEST['oauth_token'])) $OAuthToken = optional_param('oauth_token', '', PARAM_TEXT);
            $OAuthVerifier = false;
            if (isset($_REQUEST['oauth_verifier'])) $OAuthVerifier = optional_param('oauth_verifier', '', PARAM_TEXT);
            break;
            
        case 'yahoo2':
            $code = optional_param('code', '', PARAM_TEXT);
            $state = optional_param('state', '', PARAM_TEXT);
            break;
            
        case 'twitter':
            $code = $auth_service;
            $OAuthToken = false;
            if (isset($_REQUEST['oauth_token'])) $OAuthToken = optional_param('oauth_token', '', PARAM_TEXT);
            $OAuthVerifier = false;
            if (isset($_REQUEST['oauth_verifier'])) $OAuthVerifier = optional_param('oauth_verifier', '', PARAM_TEXT);
            break;
        
        case 'vk':
            $code = optional_param('code', '', PARAM_TEXT);
            if (empty($code)) {
                $error_inurl = optional_param('error', '', PARAM_TEXT);
                switch ($error_inurl) {
                    case 'invalid_request':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                $error_inurl2 = optional_param('error_description', '', PARAM_TEXT);
                if (!empty($error_inurl2)) {
                    $error = true;
                    $error_code .= ' - ' . urldecode($error_inurl2);
                }
                if (empty($error_inurl)) {
                    $error = true;
                    $error_code = get_string('empty_code_param', 'auth_lenauth');
                }
            }

            break;
            
        case 'yandex':
            $code = optional_param('code', '', PARAM_INT);
            if (empty($code)) {
                $error_inurl = optional_param('error', '', PARAM_TEXT);
                if (!empty($error_inurl)) {
                    $error = true;
                    $error_code = $error_inurl;
                }
                if (empty($error_inurl)) {
                    $error = true;
                    $error_code = get_string('empty_code_param', 'auth_lenauth');
                }
            }
            break;

        case 'mailru':
            $code = optional_param('code', '', PARAM_TEXT);
            if (empty($code)) {
                $error_inurl = optional_param('error', '', PARAM_TEXT);
                if (!empty($error_inurl)) {
                    $error = true;
                    $error_code = $error_inurl;
                }
                if (empty($error_inurl)) {
                    $error = true;
                    $error_code = get_string('empty_code_param', 'auth_lenauth');
                }
            }
            break;

        /*case 'ok':
            
            $code = optional_param('code', '', PARAM_TEXT);
            if (empty($code)) {
                $error = true;
            }
            break;*/
                    
                    
    }
}

if (empty($error)) {
    global $CFG;
    $loginurl = $CFG->wwwroot . '/login/index.php';
    if (!empty($CFG->alternateloginurl)) {
        $loginurl = $CFG->alternateloginurl;
    }
    /**
     * @see auth.php#loginpage_hook()
     */
    $moodle_url_params = array('oauthcode' => $code, 'authprovider' => $auth_service);
    if (!empty($state)) $moodle_url_params['state'] = $state;
    if ($OAuthToken) $moodle_url_params['oauth_token'] = $OAuthToken;
    if ($OAuthVerifier) $moodle_url_params['oauth_verifier'] = $OAuthVerifier;
    $url = new moodle_url($loginurl, $moodle_url_params);
} else {
    $moodle_index_url_errors = array('oauth_failure' => $error);
    if (!empty($error_code)) {
        $moodle_index_url_errors['code'] = $error_code;
    }
    $url = new moodle_url('/', $moodle_index_url_errors);
}
redirect($url);