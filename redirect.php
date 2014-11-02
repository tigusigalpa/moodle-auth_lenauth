<?php

require( '../../config.php' );

$code = '';
$error = false;
$error_code = '';
$oauth_token = false;
$oauth_verifier = false;

$auth_service = optional_param( 'auth_service', '', PARAM_TEXT );

if ( !empty( $auth_service ) ) {
    
    switch ( $auth_service ) {
        case 'facebook':
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                $error_inurl = optional_param( 'error', '', PARAM_TEXT );
                switch ( $error_inurl ) {
                    case 'access_denied':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                $error_inurl2 = optional_param( 'error_description', '', PARAM_TEXT );
                if ( !empty( $error_inurl2 ) ) {
                    $error = true;
                    $error_code .= ' - ' . urldecode( $error_inurl2 );
                }
                if ( empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = get_string( 'empty_code_param', 'auth_lenauth' );
                }
            }

            break;
            
        case 'google':
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                $error_inurl = optional_param( 'error', '', PARAM_TEXT );
                switch ( $error_inurl ) {
                    case 'access_denied':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                if ( empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = get_string( 'empty_code_param', 'auth_lenauth' );
                }
            }

            break;
            
        case 'yahoo':
            $code = $auth_service;
            $oauth_token = false;
            if ( isset( $_REQUEST['oauth_token'] ) ) $oauth_token = optional_param( 'oauth_token', '', PARAM_TEXT );
            $oauth_verifier = false;
            if ( isset( $_REQUEST['oauth_verifier'] ) ) $oauth_verifier = optional_param( 'oauth_verifier', '', PARAM_TEXT );
            break;
            
        case 'twitter':
            $code = $auth_service;
            $oauth_token = false;
            if ( isset( $_REQUEST['oauth_token'] ) ) $oauth_token = optional_param( 'oauth_token', '', PARAM_TEXT );
            $oauth_verifier = false;
            if ( isset( $_REQUEST['oauth_verifier'] ) ) $oauth_verifier = optional_param( 'oauth_verifier', '', PARAM_TEXT );
            break;
        
        case 'vk':
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                $error_inurl = optional_param( 'error', '', PARAM_TEXT );
                switch ( $error_inurl ) {
                    case 'invalid_request':
                        $error = true;
                        $error_code = $error_inurl;
                        break;
                }
                $error_inurl2 = optional_param( 'error_description', '', PARAM_TEXT );
                if ( !empty( $error_inurl2 ) ) {
                    $error = true;
                    $error_code .= ' - ' . urldecode( $error_inurl2 );
                }
                if ( empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = get_string( 'empty_code_param', 'auth_lenauth' );
                }
            }

            break;
            
        case 'yandex':
            $code = optional_param( 'code', '', PARAM_INT );
            if ( empty( $code ) ) {
                $error_inurl = optional_param( 'error', '', PARAM_TEXT );
                if ( !empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = $error_inurl;
                }
                if ( empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = get_string( 'empty_code_param', 'auth_lenauth' );
                }
            }
            break;

        case 'mailru':
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                $error_inurl = optional_param( 'error', '', PARAM_TEXT );
                if ( !empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = $error_inurl;
                }
                if ( empty( $error_inurl ) ) {
                    $error = true;
                    $error_code = get_string( 'empty_code_param', 'auth_lenauth' );
                }
            }
            break;

        /*case 'ok':
            
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                $error = true;
            }
            break;*/
                    
                    
    }
}

if ( empty( $error ) ) {
    global $CFG;
    $loginurl = $CFG->wwwroot . '/login/index.php';
    if ( !empty( $CFG->alternateloginurl ) ) {
        $loginurl = $CFG->alternateloginurl;
    }
    /**
     * @see auth.php#loginpage_hook()
     */
    $moodle_url_params = array( 'oauthcode' => $code, 'authprovider' => $auth_service );
    if ( $oauth_token ) $moodle_url_params['oauth_token'] = $oauth_token;
    if ( $oauth_verifier ) $moodle_url_params['oauth_verifier'] = $oauth_verifier;
    $url = new moodle_url( $loginurl, $moodle_url_params );
} else {
    $moodle_index_url_errors = array( 'oauth_failure' => $error );
    if ( !empty( $error_code ) ) {
        $moodle_index_url_errors['code'] = $error_code;
    }
    $url = new moodle_url( '/', $moodle_index_url_errors );
}
redirect( $url );