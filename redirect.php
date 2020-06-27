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

require_once __DIR__ . '/../../auth/lenauth/autoload.php';

defined('MOODLE_INTERNAL') || die();

$code = '';
$state = '';
$error = false;
$error_code = '';
$OAuthToken = false;
$OAuthVerifier = false;
$provider = required_param('provider', PARAM_ALPHANUM);

switch ($provider) {
    case 'facebook':
        if ($state = optional_param('state', '', PARAM_ALPHANUM)) {
            if (confirm_sesskey($state)) {
                $code = explode('#', required_param('code', PARAM_ALPHANUMEXT))[0];
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
            }
        }
        break;
    case 'google':print_r($_GET);die;
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
        $code = $provider;
        $OAuthToken = false;
        if (isset($_REQUEST['oauth_token'])) {
            $OAuthToken = optional_param('oauth_token', '', PARAM_TEXT);
        }
        $OAuthVerifier = false;
        if (isset($_REQUEST['oauth_verifier'])) {
            $OAuthVerifier = optional_param('oauth_verifier', '', PARAM_TEXT);
        }
        break;
    case 'yahoo2':
        $code = optional_param('code', '', PARAM_TEXT);
        $state = optional_param('state', '', PARAM_TEXT);
        break;
    case 'twitter':
        $code = $provider;
        $OAuthToken = false;
        if (isset($_REQUEST['oauth_token'])) {
            $OAuthToken = optional_param('oauth_token', '', PARAM_TEXT);
        }
        $OAuthVerifier = false;
        if (isset($_REQUEST['oauth_verifier'])) {
            $OAuthVerifier = optional_param('oauth_verifier', '', PARAM_TEXT);
        }
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
}

if (empty($error)) {
    if ($code) {
        global $CFG;
        $loginUrl = $CFG->wwwroot . '/login/index.php';
        if (!empty($CFG->alternateloginurl)) {
            $loginUrl = $CFG->alternateloginurl;
        }
        /**
         * @see auth.php#loginpage_hook()
         */
        $moodleUrlParams = ['code' => $code, 'provider' => $provider];
        if (!empty($state)) {
            $moodleUrlParams['state'] = $state;
        }
        if ($OAuthToken) {
            $moodleUrlParams['oauth_token'] = $OAuthToken;
        }
        if ($OAuthVerifier) {
            $moodleUrlParams['oauth_verifier'] = $OAuthVerifier;
        }
        $url = new \moodle_url($loginUrl, $moodleUrlParams);
    }
} else {
    $moodleIndexUrlErrors = ['oauth_failure' => $error];
    if (!empty($error_code)) {
        $moodleIndexUrlErrors['code'] = $error_code;
    }
    $url = new \moodle_url('/', $moodleIndexUrlErrors);
}
if ($url) {
    try {
        redirect($url);
        die;
    } catch (\moodle_exception $e) {
        //
    }
}
