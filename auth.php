<?php

/**
 * @author Igor Sazonov ( @tigusigalpa )
 * @link http://lms-service.org/lenauth-plugin-oauth-moodle/
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version 1.2.4
 * @uses auth_plugin_base core class
 *
 * Authentication Plugin: LenAuth Authentication
 * If the email doesn't exist, then the auth plugin creates the user.
 * If the email exist (and the user has for auth plugin this current one),
 * then the plugin login the user related to this email.
 *
 * This plugin uses some code parts from the Moodle plugin auth_googleoauth2
 * @link https://moodle.org/plugins/view.php?plugin=auth_googleoauth2
 * @link http://mouneyrac.github.io/moodle-auth_googleoauth2/
 * @author Jérôme Mouneyrac (jerome@mouneyrac.com) twitter: mouneyrac
 * auth_googleoauth2 was developed @since 2011 and supported now with a lot of updates and fixes at GitHub
 * Thanks to Jérôme about critical issues for security
 */

defined( 'MOODLE_INTERNAL' ) || die();

require_once( $CFG->libdir . '/authlib.php' ); //requires authentication core library
require_once( $CFG->libdir . '/formslib.php' );

/**
 * LenAuth authentication plugin.
 */
class auth_plugin_lenauth extends auth_plugin_base {

    /**
     * An array of plugin webservices settings
     *
     * @property request_token_url endpoint URI of webservice to exchange code for token
     * @property grant_type some key needed for some webservices, always value is authorization_code
     * @property request_api_url URI for final request to get user data response
     * @var array
     * @access protected
     */
    protected $_settings = array(
        /**
         * Facebook settings
         * @link https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0
         * @link https://developers.facebook.com/docs/graph-api/reference/v2.0/user
         */
        'facebook' => array(
            'request_token_url' => 'https://graph.facebook.com/oauth/access_token',
            'request_api_url'   => 'https://graph.facebook.com/me'
        ),

        /**
         * Google settings
         * @link https://developers.google.com/accounts/docs/OAuth2Login#authenticatingtheuser
         * @link https://developers.google.com/+/api/oauth
         */
        'google' => array(
            'request_token_url' => 'https://accounts.google.com/o/oauth2/token',
            'grant_type'        => 'authorization_code',

            /**
             * @deprecated but works only for email
             */
            //'request_api_url' => 'https://www.googleapis.com/userinfo/email'

            'request_api_url'   => 'https://www.googleapis.com/plus/v1/people/me'
        ),

        /**
         * Yahoo OAuth1 settings
         * @link https://developer.yahoo.com/oauth/
         * @link https://developer.yahoo.com/oauth/guide/
         * @link https://developer.yahoo.com/oauth/guide/oauth-userauth.html
         */
        'yahoo1' => array(
            'request_token_url' => 'https://api.login.yahoo.com/oauth/v2/get_request_token',
            'request_api_url'   => 'https://api.login.yahoo.com/oauth/v2/get_token',
            'yql_url'           => 'https://query.yahooapis.com/v1/yql'
        ),
        
        /**
         * Yahoo OAuth2 settings
         * @link https://developer.yahoo.com/oauth2/
         * @link https://developer.yahoo.com/oauth2/guide/
         * @link https://developer.yahoo.com/oauth2/guide/flows_authcode/
         * @link https://developer.yahoo.com/oauth2/guide/apirequests/
         */
        'yahoo2' => array(
            'request_token_url' => 'https://api.login.yahoo.com/oauth2/get_token',
            'request_api_url'   => 'https://api.login.yahoo.com/oauth2/get_token',
            'grant_type'        => 'authorization_code',
            'yql_url'           => 'https://query.yahooapis.com/v1/yql'
        ),

        /**
         * Twitter settings
         * @link https://dev.twitter.com/web/sign-in/implementing
         */
        'twitter' => array(
            'request_token_url' => 'https://api.twitter.com/oauth/request_token',
            'request_api_url'   => 'https://api.twitter.com/oauth/authenticate',
            'token_url'         => 'https://api.twitter.com/oauth/access_token',
            'expire'            => 3600 //just 1 hour because Twitter doesnt support expire
        ),

        /**
         * VK.com settings
         * @link http://vk.com/dev/auth_sites
         * @link http://vk.com/dev/api_requests
         */
        'vk' => array(
            'request_token_url' => 'https://oauth.vk.com/access_token',
            'request_api_url'   => 'https://api.vk.com/method/users.get'
        ),

        /**
         * @link http://api.yandex.ru/oauth/doc/dg/reference/obtain-access-token.xml
         * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
         */
        'yandex' => array(
            'request_token_url' => 'https://oauth.yandex.ru/token',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'https://login.yandex.ru/info',
            'format'            => 'json'
        ),
        
        /**
         * Mail.ru settings
         * @link http://api.mail.ru/docs/guides/oauth/sites/
         * @link http://api.mail.ru/docs/reference/rest/
         * @link http://api.mail.ru/docs/guides/restapi/
         */
        'mailru' => array(
            'request_token_url' => 'https://connect.mail.ru/oauth/token',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'http://www.appsmail.ru/platform/api'
        ),

        /**
         * Odnoklassniki.ru settings
         * @link http://apiok.ru/wiki/pages/viewpage.action?pageId=42476652
         * @link http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API+ru
         * @link http://apiok.ru/wiki/display/api/REST+API+-+users+ru
         * @link http://apiok.ru/wiki/display/api/users.getInfo+ru
         *
         */
        /*'ok' => array(
            'request_token_url' => 'http://api.odnoklassniki.ru/oauth/token.do',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'http://api.odnoklassniki.ru/fb.do'
        ),*/
    );
    
    protected $_default_order = array( 
        1 => 'facebook', 2 => 'google', 3 => 'yahoo', 4 => 'twitter', 
        5 => 'vk', 6 => 'yandex', 7 => 'mailru' 
    );

    protected $_send_oauth_request = true;

    protected $_set_password = true;

    /**
     * cURL default request type. Highly recommended is POST
     *
     * @var string
     * @access protected
     */
    protected $_curl_type = 'post';
    protected $_last_user_number = 0;
    protected $_user_info_fields = array();
    protected $_field_shortname;
    protected $_field_id;
    
    /**
     * List of available styles
     * @var array
     */
    protected $_styles_array = array( 'default', 'style1', 
        'style1-dark-white', 'style1-light-black', 'style1-text', 
        'style2-text', 'style3-text', 'style4-text', 
        'smooth-w32-button-square', 'smooth-w32-button-rounded', 
        'smooth-w32-button-circle', 'smooth-w48-button-square', 
        'smooth-w48-button-rounded', 'smooth-w48-button-circle', 
        'smooth-w64-button-square', 'smooth-w64-button-rounded', 
        'smooth-w64-button-circle', 'smooth-w32-classic-square', 
        'smooth-w32-classic-square', 'smooth-w32-classic-rounded', 
        'smooth-w32-classic-circle', 'smooth-w48-classic-square', 
        'smooth-w48-classic-rounded', 'smooth-w48-classic-circle', 
        'smooth-w64-classic-square', 'smooth-w64-classic-rounded', 
        'smooth-w64-classic-circle', 'simple-3d', 'simple-3d-small', 
        '3d-circle', '3d-circle-small', 'simple-flat', 'simple-flat-small', 
        'simple-flat-circle', 'simple-flat-circle-small', 'bootstrap-font-awesome','bootstrap-font-awesome-simple'
    );

    /**
     * defined as object of plugin config
     *
     * @var object
     * @access protected
     */
    protected $_oauth_config;
    
    private static $_instance;
    
    /**
     * VK API version
     * @var string
     */
    public static $vk_api_version = '5.52';
    
    /**
     * Yahoo API version
     * @var string
     */
    public static $yahoo_oauth_version = '1.0';
    
    /**
     * Twitter API version
     * @var string
     */
    public static $twitter_oauth_version = '1.0';

    protected static $_allowed_icons_types = array(
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
    );


    /**
     * Constructor.
     */
    public function __construct() {
        global $DB;

        $this->_oauth_config = get_config( 'auth/lenauth' ); // get plugin config object
        
        $this->_user_info_fields = $DB->get_records('user_info_field');
        $this->authtype = 'lenauth'; // define name of our authentication method
        $this->roleauth = 'auth_lenauth';
        $this->errorlogtag = '[AUTH lenauth]';
    }
    
    /**
     * Singleton
     * @return object
     */
    public static function getInstance() {
        if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof auth_plugin_lenauth ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#prevent_local_passwords.28.29
     * Indicates if password hashes should be stored in local moodle database.
     * This function automatically returns the opposite boolean of what is_internal() returns.
     * Returning true means MD5 password hashes will be stored in the user table.
     * Returning false means flag 'not_cached' will be stored there instead.
     *
     * @return boolean
     * @access public
     */
    /*function prevent_local_passwords() {
        return !$this->_oauth_config->can_change_password;
    }*/

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#user_login.28.24username.2C_.24password.29
     * This must be rewritten by plugin to return boolean value, returns true if the username and password work
     * and false if they are wrong or don't exist.
     *
     * Check authentication method
     *
     * @param  string $username of user
     * @param  string $password of user
     * @return boolean
     * @access public
     *
     * @author Jerome Mouneyrac ( @mouneyrac )
     */
    function user_login( $username, $password ) {
        global $DB, $CFG;

        //get user record/object from DB by username
        $user = $DB->get_record( 'user', array( 'username' => $username,
            'mnethostid' => $CFG->mnet_localhost_id ) );

        //check for user (username) exist and authentication method
        if ( !empty( $user ) && ( $user->auth == 'lenauth' ) ) {
            $code = optional_param( 'code', '', PARAM_TEXT );
            if ( empty( $code ) ) {
                return false;
            }
            return true;
        }

        return false;
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#is_internal.28.29
     * Returns true if this authentication plugin is "internal".
     * Internal plugins use password hashes from Moodle user table for authentication.
     *
     * @return boolean
     * @access public
     */
    function is_internal() {
        return false;
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#can_change_password.28.29
     * Returns true if this authentication plugin can change users' password.
     *
     * @return boolean
     * @access protected
     */
    /*function can_change_password() {
        return $this->_oauth_config->can_change_password;
    }*/
    
    /**
     * return number of days to user password expires
     *
     * If userpassword does not expire it should return 0. If password is already expired
     * it should return negative value.
     *
     * @param mixed $username username (with system magic quotes)
     * @return integer
     */
    /*function password_expire($username) {
        return isset( $this->_oauth_config->password_expire ) ? $this->_oauth_config->password_expire : 0;
    }*/
    
    /**
     * Returns true if plugin allows confirming of new users.
     *
     * @return boolean
     */
    function can_confirm() {
        return isset( $this->_oauth_config->auth_lenauth_can_confirm ) ? $this->_oauth_config->auth_lenauth_can_confirm : false;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @link https://docs.moodle.org/dev/Authentication_plugins#can_reset_password.28.29
     * @return boolean
     */
    function can_reset_password() {
        return isset( $this->_oauth_config->auth_lenauth_can_reset_password ) ? $this->_oauth_config->auth_lenauth_can_reset_password : false;
    }

    /**
     * Generate a valid urlencoded data to use it for cURL request
     *
     * @param array $array
     * @return string with data for cURL request
     *
     * @author Igor Sazonov
     */
    protected function _generate_query_data( array $array ) {

        $query_array = array();
        foreach ( $array as $key => $key_value ) {
            $query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );
        }

        return join( '&', $query_array );
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#loginpage_hook.28.29
     *
     * Hook for overriding behaviour of login page.
     * Another auth hook. Process login if $authorizationcode is defined in OAuth url.
     * Makes cURL POST/GET request to social webservice and fill response data to Moodle user.
     * We check access tokens in cookies, if the ones exists - get it from $_COOKIE, if no - setcookie
     *
     * @uses $SESSION, $CFG, $DB core global objects/variables
     * @return void or @moodle_exception if OAuth request returns error or fail
     *
     * @author Igor Sazonov ( @tigusigalpa )
     */
    function loginpage_hook() {
        global $SESSION, $CFG, $DB;
        
        $access_token = false;
        $authorizationcode = optional_param( 'oauthcode', '', PARAM_TEXT ); // get authorization code from url
        if ( !empty( $authorizationcode ) ) {
            
            $authprovider = required_param( 'authprovider', PARAM_TEXT ); // get authorization provider (webservice name)
            @setcookie( 'auth_lenauth_authprovider', $authprovider, time() + 604800, '/' );
            $hack_authprovider = ( $authprovider == 'yahoo1' || $authprovider == 'yahoo2' ) ? 'yahoo' : $authprovider;
            $config_field_str = 'auth_lenauth_' . $hack_authprovider . '_social_id_field';
            $this->_field_shortname = $this->_oauth_config->$config_field_str;
            $this->_field_id = $this->_lenauth_get_fieldid();

            $params        = array(); // params to generate data for token request
            $encode_params = true;
            $code          = true;
            $redirect_uri  = true;
            $curl_header   = false;
            $curl_options  = array();
            
            //if we have access_token in $_COOKIE, so do not need to make request fot the one
            $this->_send_oauth_request = !isset( $_COOKIE[$authprovider]['access_token'] ) ? true : false;
            
            //if service is not enabled, why should we make request? hack protect. maybe
            $enabled_str = 'auth_lenauth_' . $hack_authprovider . '_enabled';
            if ( empty( $this->_oauth_config->$enabled_str ) ) {
                throw new moodle_exception( 'Service not enabled in your LenAuth Settings', 'auth_lenauth' );
            }

            switch ( $authprovider ) {
                case 'facebook':
                    /**
                     * @link https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0#exchangecode
                     */
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_facebook_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_facebook_app_secret;
                    break;
                
                case 'google':
                    /**
                     * @link https://developers.google.com/accounts/docs/OAuth2Login#exchangecode
                     */
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_google_client_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_google_client_secret;
                    $params['grant_type']    = $this->_settings[$authprovider]['grant_type'];
                    break;
                
                case 'yahoo1':
                    if ( !isset( $_COOKIE[$authprovider]['access_token'] ) && !isset( $_COOKIE[$authprovider]['oauth_verifier'] ) ) {
                        $params = array_merge(
                            $this->_lenauth_yahoo_request_array( $this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' )
                            ,array( 'oauth_callback' => $this->_lenauth_redirect_uri( $authprovider ) )
                        );

                        $code                             = false;
                        $redirect_uri                     = false;

                        $this->_send_oauth_request        = ( isset( $_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'] ) ) ? false : true;
                        $oauth_verifier                   = false;

                        // yahoo =))
                        if ( !$this->_send_oauth_request && isset( $SESSION->yahoo_expires ) && !empty( $SESSION->yahoo_expires ) ) {
                            $access_token   = $SESSION->yahoo_access_token = optional_param( 'oauth_token', '', PARAM_TEXT );
                            setcookie( $authprovider . '[access_token]', $access_token, time() + $SESSION->yahoo_expires/*, '/'*/ );
                            $oauth_verifier = $SESSION->yahoo_oauth_verifier = optional_param( 'oauth_verifier', '', PARAM_TEXT );
                            setcookie( $authprovider . '[oauth_verifier]', $oauth_verifier, time() + $SESSION->yahoo_expires/*, '/'*/ );
                        } else {

                        }
                    } else {
                        $this->_send_oauth_request = false;
                    }
                    break;
                    
                case 'yahoo2':
                    $params['grant_type']    = $this->_settings[$authprovider]['grant_type'];
                    $curl_options = array(
                        'USERPWD' => $this->_oauth_config->auth_lenauth_yahoo_consumer_key . ':' . $this->_oauth_config->auth_lenauth_yahoo_consumer_secret
                    );
                    break;
                    
                case 'twitter':
                    if ( !empty( $this->_oauth_config->auth_lenauth_twitter_enabled ) ) {
                        if ( !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $params = array_merge(
                                $this->_lenauth_twitter_request_array( $this->_oauth_config->auth_lenauth_twitter_consumer_secret . '&' )
                                ,array( 'oauth_callback' => $this->_lenauth_redirect_uri( $authprovider ) )
                            );
                            
                            $code                             = false;
                            $redirect_uri                     = false;
                            
                            $this->_send_oauth_request        = ( isset( $_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'] ) ) ? false : true;
                            $oauth_verifier                   = false;
                            
                            if ( !$this->_send_oauth_request && isset( $_COOKIE[$authprovider]['oauth_token_secret'] ) ) {
                                $access_token = $SESSION->twitter_access_token = optional_param( 'oauth_token', '', PARAM_TEXT );
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $this->_settings[$authprovider]['expire'], '/' );
                                $oauth_verifier = $SESSION->twitter_oauth_verifier = optional_param( 'oauth_verifier', '', PARAM_TEXT );
                                setcookie( $authprovider . '[oauth_verifier]', $oauth_verifier, time() + $this->_settings[$authprovider]['expire'], '/' );
                            } else {
                                $curl_header = $this->_lenauth_set_twitter_header( $params );
                            }
                            
                            //$curl_header = $this->_lenauth_set_twitter_header($params, $access_token/*, $oauth_token_secret = false*/);
                            /*$curl_options = array(
                                'CURLOPT_RETURNTRANSFER' => true,
                                'CURLOPT_FOLLOWLOCATION' => true
                            );
                            if ( !empty( $params['oauth_callback'] ) ) {
                                $curl_options['CURLOPT_POSTFIELDS'] = http_build_query( array() );
                            }*/
                            //TWITTER IS GOOD!!
                            $encode_params = false;
                            
                        } else {
                            $this->_send_oauth_request = false;
                        }
                    }
                    break;
                    
                case 'vk':
                    /**
                     * @link http://vk.com/dev/auth_sites
                     */
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_vk_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_vk_app_secret;
                    break;
                
                case 'yandex':
                    $params['grant_type']    = $this->_settings[$authprovider]['grant_type'];
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_yandex_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_yandex_app_password;
                    break;
                    
                case 'mailru':
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_mailru_site_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_mailru_client_secret;
                    $params['grant_type']    = $this->_settings[$authprovider]['grant_type'];
                    break;
                    
                //odnoklassniki.ru was wrote by school programmers at 1st class and it not used mojority. bye-bye!
                /*case 'ok':
                    $params['client_id']     = $this->_oauth_config->ok_app_id;
                    $params['client_secret'] = $this->_oauth_config->ok_secret_key;
                    break;*/

                default: // if authorization provider is wrong
                    throw new moodle_exception( 'Unknown OAuth Provider', 'auth_lenauth' );
            }

            // url for catch token value
            // exception for Yahoo OAuth, because it like..
            if ( $code ) $params['code']                  = $authorizationcode;
            if ( $redirect_uri ) $params['redirect_uri']  = $this->_lenauth_redirect_uri( $authprovider );
            
            //require cURL from Moodle core
            require_once( $CFG->libdir . '/filelib.php' ); // requires library with cURL class
            $curl = new curl();
            //hack for twitter and Yahoo
            if ( !empty( $curl_options ) && is_array( $curl_options ) ) {
                $curl->setopt( $curl_options );
            }
            $curl->resetHeader(); // clean cURL header from garbage
            
            //Twitter and Yahoo has an own cURL headers, so let them to be!
            if ( !$curl_header ) {
                $curl->setHeader( 'Content-Type: application/x-www-form-urlencoded' );
            } else {
                $curl->setHeader( $curl_header );
            }

            // cURL REQUEST for tokens if we hasnt it in $_COOKIE
            if ( $this->_send_oauth_request ) {
                if ($this->_curl_type == 'post') {
                    $curl_tokens_values = $curl->post(
                        $this->_settings[$authprovider]['request_token_url'],
                        //hack for twitter
                        $encode_params ? $this->_generate_query_data( $params ) : $params
                    );
                } else {
                    $curl_tokens_values = $curl->get(
                        $this->_settings[$authprovider]['request_token_url'] . '?' . ( $encode_params ? $this->_generate_query_data( $params ) : $params )
                    );
                }
            }
            
            // check for token response
            if ( !empty( $curl_tokens_values ) || !$this->_send_oauth_request ) {
                $token_values  = array();

                // parse token values
                switch ( $authprovider ) {
                    case 'facebook':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            parse_str( $curl_tokens_values, $token_values );
                            $expires       = $token_values['expires']; //5183999 = 2 months
                            $access_token  = $token_values['access_token'];
                            if ( !empty( $expires ) && !empty( $access_token ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                            } else {
                                throw new moodle_exception( 'Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth' );
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'google':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $token_values  = json_decode( $curl_tokens_values, true );
                            $expires       = $token_values['expires_in']; //3600 = 1 hour
                            $access_token  = $token_values['access_token'];
                            if ( !empty( $access_token ) && !empty( $expires ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                            } else {
                                throw new moodle_exception( 'Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth' );
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'yahoo1':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['oauth_token_secret'] ) ) {
                            parse_str( $curl_tokens_values, $token_values );
                            $expires       = $SESSION->yahoo_expires = $token_values['oauth_expires_in']; //3600 = 1 hour
                            $access_token  = $SESSION->yahoo_access_token = $token_values['oauth_token'];
                            setcookie( $authprovider . '[oauth_token_secret]', $token_values['oauth_token_secret'], time() + $SESSION->yahoo_expires/*, '/'*/ );
                            $xoauth_request_auth_url = $token_values['xoauth_request_auth_url'];
                        } else {
                            if ( ( isset( $_COOKIE[$authprovider]['access_token'], $_COOKIE[$authprovider]['oauth_verifier'] ) ) || isset( $SESSION->yahoo_access_token, $SESSION->yahoo_oauth_verifier ) ) {
                                $access_token   = ( isset( $_COOKIE[$authprovider]['access_token'] ) ) ? $_COOKIE[$authprovider]['access_token'] : $SESSION->yahoo_access_token;
                                $oauth_verifier = ( isset( $_COOKIE[$authprovider]['oauth_verifier'] ) ) ? $_COOKIE[$authprovider]['oauth_verifier'] : $SESSION->yahoo_oauth_verifier;
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'yahoo2':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $token_values  = json_decode( $curl_tokens_values, true );
                            $expires       = $token_values['expires_in']; //3600 = 1 hour
                            $access_token  = $token_values['access_token'];
                            $refresh_token = $token_values['refresh_token'];
                            $user_id       = $token_values['xoauth_yahoo_guid'];
                            if ( !empty( $expires ) && !empty( $access_token ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                                if ( !empty( $user_id ) ) {
                                    setcookie( $authprovider . '[user_id]', $user_id, time() + $expires, '/' );
                                }
                            } else {
                                throw new moodle_exception( 'Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth' );
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'], $_COOKIE[$authprovider]['user_id'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                                $user_id = $_COOKIE[$authprovider]['user_id'];
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'twitter':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['oauth_token_secret'] ) ) {
                            parse_str( $curl_tokens_values, $token_values );
                            $access_token = $SESSION->twitter_access_token = $token_values['oauth_token'];
                            setcookie( $authprovider . '[oauth_token_secret]', $token_values['oauth_token_secret'], time() + $this->_settings[$authprovider]['expire'], '/' );
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'], $_COOKIE[$authprovider]['oauth_token_secret'] ) || isset( $SESSION->twitter_access_token, $SESSION->twitter_oauth_verifier ) ) {
                                $access_token = isset( $_COOKIE[$authprovider]['access_token'] ) ? $_COOKIE[$authprovider]['access_token'] : $SESSION->twitter_access_token;
                                $oauth_verifier = ( isset( $_COOKIE[$authprovider]['oauth_verifier'] ) ) ? $_COOKIE[$authprovider]['oauth_verifier'] : $SESSION->twitter_oauth_verifier;
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'vk':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $token_values  = json_decode( $curl_tokens_values, true );
                            if ( isset( $token_values['error'] ) ) {
                                throw new moodle_exception( 'Native VK Error ' . $token_values['error'] . ( isset( $token_values['error_description'] ) ? ' with description: ' . $token_values['error_description'] : '' ), 'auth_lenauth' );
                            }
                            $expires       = $token_values['expires_in']; //86400 = 24 hours
                            $access_token  = $token_values['access_token'];
                            if ( !empty( $access_token ) && !empty( $expires ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                            }
                            
                            $user_id       = $token_values['user_id'];
                            if ( !empty( $user_id ) ) {
                                setcookie( $authprovider . '[user_id]', $user_id, time() + $expires, '/' );
                            }
                            /**
                             * VK user may do not enter email, soooo =((
                             */
                            $user_email    = ( isset( $token_values['email'] ) ) ? $token_values['email'] : false; // WOW!!! So early???))) Awesome!
                            if ( !empty( $user_email ) ) {
                                setcookie( $authprovider . '[user_email]', $user_email, time() + $expires, '/' );
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'], $_COOKIE[$authprovider]['user_id'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                                $user_id = $_COOKIE[$authprovider]['user_id'];
                                if ( isset( $_COOKIE[$authprovider]['user_email'] ) ) {
                                    $user_email = $_COOKIE[$authprovider]['user_email'];
                                }
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'yandex':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $token_values  = json_decode( $curl_tokens_values, true );
                            $expires       = $token_values['expires_in']; //31536000 = 1 year
                            $access_token  = $token_values['access_token'];
                            if ( !empty( $expires ) && !empty( $access_token ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                            } else {
                                throw new moodle_exception( 'Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth' );
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    case 'mailru':
                        if ( $this->_send_oauth_request || !isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                            $token_values  = json_decode( $curl_tokens_values, true );
                            $expires       = $token_values['expires_in']; //86400 = 24 hours
                            $access_token  = $token_values['access_token'];
                            if ( !empty( $expires ) && !empty( $access_token ) ) {
                                setcookie( $authprovider . '[access_token]', $access_token, time() + $expires, '/' );
                            } else {
                                //check native errors if exists
                                if ( isset( $token_values['error'] ) ) {
                                    switch ( $token_values['error'] ) {
                                        case 'invalid_client':
                                            throw new moodle_exception( 'Mail.RU invalid OAuth settings. Check your Private Key and Secret Key', 'auth_lenauth' );
                                        default:
                                            throw new moodle_exception( 'Mail.RU Unknown Error with code: ' . $token_values['error'] );
                                    }
                                }
                                if ( empty( $expires ) || empty( $access_token ) ) {
                                    throw new moodle_exception( 'Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth' );
                                }
                            }
                        } else {
                            if ( isset( $_COOKIE[$authprovider]['access_token'] ) ) {
                                $access_token = $_COOKIE[$authprovider]['access_token'];
                            } else {
                                throw new moodle_exception( 'Someting wrong, maybe expires', 'auth_lenauth' );
                            }
                        }
                        break;
                    /*case 'ok':
                        $token_values  = json_decode( $curl_tokens_values, true );
                        $access_token  = $token_values['access_token'];
                        break;*/
                    default:
                        throw new moodle_exception( 'Unknown OAuth Provider', 'auth_lenauth' );
                }
            }

            if ( !empty( $access_token ) ) {
                $queryparams = array(); // array to generate data for final request to get user data
                $request_api_url = $this->_settings[$authprovider]['request_api_url'];
                
                //some services check accounts for verifier, so we will check it too. No unverified accounts, only verified! only hardCORE!
                $is_verified = true;
                $image_url   = '';

                switch ( $authprovider ) {
                    case 'facebook':
                        $queryparams['access_token'] = $access_token;
                        $curl_response               = $curl->get( $request_api_url . '?' . $this->_generate_query_data( $queryparams ) );
                        $curl_final_data             = json_decode($curl_response, true);

                        $social_uid                  = $curl_final_data['id'];
                        $user_email                  = $curl_final_data['email'];
                        $first_name                  = $curl_final_data['first_name'];
                        $last_name                   = $curl_final_data['last_name'];
                        $is_verified                 = $curl_final_data['verified'];
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url = 'http://graph.facebook.com/' . $social_uid . '/picture';
                        }
                        break;
                    
                    /**
                     * @link https://developers.google.com/accounts/docs/OAuth2Login#obtaininguserprofileinformation
                     */
                    case 'google':
                        $queryparams['access_token'] = $access_token;
                        $queryparams['alt']          = 'json';
                        $curl_response               = $curl->get( $request_api_url . '?' . $this->_generate_query_data( $queryparams ) );
                        $curl_final_data             = json_decode( $curl_response, true );
                        if ( isset ( $curl_final_data['error'] ) ) {
                            if ( !empty( $curl_final_data['error']['errors'] ) && is_array( $curl_final_data['error']['errors'] ) ) {
                                foreach ( $curl_final_data['error']['errors'] as $error ) {
                                    throw new moodle_exception( 'Native Google error. Message: ' . $error['message'], 'auth_lenauth' );
                                }
                            } else {
                                throw new moodle_exception( 'Native Google error', 'auth_lenauth' );
                            }
                        }
                        
                        $social_uid                  = $curl_final_data['id'];
                        $user_email                  = $curl_final_data['emails'][0]['value'];
                        $first_name                  = $curl_final_data['name']['givenName'];
                        $last_name                   = $curl_final_data['name']['familyName'];
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url               = isset( $curl_final_data['image']['url'] ) ? $curl_final_data['image']['url'] : '';
                        }
                        break;
                    
                    case 'yahoo1':
                        if ( !$oauth_verifier ) {
                            header( 'Location: ' . $xoauth_request_auth_url ); // yahoo =))
                            die;
                        }

                        $queryparams1 = array_merge(
                            $this->_lenauth_yahoo_request_array( $this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $_COOKIE[$authprovider]['oauth_token_secret'] )
                            ,array(
                                'oauth_token'    => $access_token,
                                'oauth_verifier' => $oauth_verifier
                            )
                        );

                        $curl_response_pre           = $curl->get( $request_api_url . '?' . $this->_generate_query_data( $queryparams1 ) );
                        parse_str( $curl_response_pre, $values );

                        $queryparams2 = array_merge(
                            $this->_lenauth_yahoo_request_array( $this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $values['oauth_token_secret'] )
                            ,array(
                                'oauth_token'          => $values['oauth_token'],
                                'oauth_session_handle' => $values['oauth_session_handle']
                            )
                        );
                        $yet_another = $curl->post( $request_api_url . '?' . $this->_generate_query_data( $queryparams2 ) );
                        parse_str( $yet_another, $yet_another_values );

                        $params = array(
                            'q'      => 'SELECT * FROM social.profile where guid="' . $yet_another_values['xoauth_yahoo_guid'] . '"',
                            'format' => 'json',
                            'env'    => 'http://datatables.org/alltables.env',
                        );
                        $auth_array = array_merge(
                            $this->_lenauth_yahoo_request_array( $this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $yet_another_values['oauth_token_secret'] )
                            ,array(
                                'realm'       => 'yahooapis.com',
                                'oauth_token' => $yet_another_values['oauth_token']
                            )
                        );

                        $header = '';
                        foreach ( $auth_array as $key => $value ) {
                            $header .= ( $header === '' ? ' ' : ',' ) . $this->urlEncodeRfc3986( $key ) . '="' . $this->urlEncodeRfc3986( $value ) . '"';
                        }
                        $curl->setHeader(array(
                            'Expect:',
                            'Accept: application/json',
                            'Authorization: OAuth ' . $header
                        ));
                        $curl_response = $curl->post(
                            $this->_settings[$authprovider]['yql_url'] . '?' . $this->_generate_query_data( $params )
                        );
                        $curl_final_data = json_decode($curl_response, true);
                        $social_uid      = $curl_final_data['query']['results']['profile']['guid'];
                        $emails          = $curl_final_data['query']['results']['profile']['emails'];
                        if ( !empty( $emails ) && is_array( $emails ) ) {
                            foreach( $emails as $email_array ) {
                                $user_email = $email_array['handle'];
                                if ( isset( $email_array['primary'] ) ) break;
                            }
                        }
                        $first_name      = $curl_final_data['query']['results']['profile']['givenName'];
                        $last_name       = $curl_final_data['query']['results']['profile']['familyName'];
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url = isset( $curl_final_data['query']['results']['profile']['image']['imageUrl'] ) ? $curl_final_data['query']['results']['profile']['image']['imageUrl'] : '';
                        }
                        break;
                        
                    case 'yahoo2':
                        $request_api_url             = 'https://social.yahooapis.com/v1/user/' . $user_id . '/profile?format=json';
                        $queryparams['access_token'] = $access_token;
                        $now_header = array(
                            'Authorization: Bearer '. $access_token
                            ,'Accept: application/json'
                            ,'Content-Type: application/json'
                        );
                        $curl->resetHeader();
                        $curl->setHeader( $now_header );
                        $curl_response  = $curl->get( $request_api_url, $queryparams );
                        $curl->resetHeader();
                        $curl_final_data = json_decode($curl_response, true);
                        $social_uid      = $curl_final_data['profile']['guid'];
                        $emails          = $curl_final_data['profile']['emails'];
                        if ( !empty( $emails ) && is_array( $emails ) ) {
                            foreach( $emails as $email_array ) {
                                $user_email = $email_array['handle'];
                                if ( isset( $email_array['primary'] ) ) break;
                            }
                        }
                        $first_name      = $curl_final_data['profile']['givenName'];
                        $last_name       = $curl_final_data['profile']['familyName'];
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url = isset( $curl_final_data['profile']['image']['imageUrl'] ) ? $curl_final_data['profile']['image']['imageUrl'] : '';
                        }
                        break;
                        
                    case 'twitter':
                        if ( !$oauth_verifier ) {
                            header( 'Location: ' . $this->_settings[$authprovider]['request_api_url'] . '?' . http_build_query( array( 'oauth_token' => $access_token ) ) );
                            die;
                        }
                        $queryparams = array_merge(
                            $this->_lenauth_twitter_request_array()
                            ,array( 'oauth_verifier' => $oauth_verifier, 'oauth_token' => $access_token, 'oauth_token_secret' => $_COOKIE[$authprovider]['oauth_token_secret'] )
                        );
                        $curl_header = $this->_lenauth_set_twitter_header( $queryparams, $access_token, $_COOKIE[$authprovider]['oauth_token_secret'] );
                        $curl->setHeader( $curl_header );
                        
                        $curl_final_data_pre = $curl->post(
                            $this->_settings[$authprovider]['token_url'],
                            $queryparams
                        );
                        $json_decoded = json_decode( $curl_final_data_pre, true );
                        if ( isset( $json_decoded['error'] ) && isset( $json_decoded['request'] ) ) {
                            throw new moodle_exception( 'Native Twitter Error: ' . $json_decoded['error'] . '. For request ' . $json_decoded['request'], 'auth_lenauth' );
                        }
                        parse_str($curl_final_data_pre, $curl_final_data);
                        $social_uid = $curl_final_data['user_id'];
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url_pre = 'https://twitter.com/' . $curl_final_data['screen_name'] . '/profile_image?size=original';
                            $image_header = get_headers( $image_url_pre, 1 );
                            $image_url = $image_header['location'];
                        }
                        break;
                    
                    case 'vk':
                        /**
                         * @link http://vk.com/dev/api_requests
                         */
                        $queryparams['access_token'] = $access_token;
                        $queryparams['user_id']      = !empty( $user_id ) ? $user_id : false;
                        $queryparams['v']            = self::$vk_api_version;
                        $curl_response               = $curl->post( $request_api_url, $this->_generate_query_data( $queryparams ) );
                        $curl_final_data             = json_decode($curl_response, true);
                        
                        //$social_uid                  = ( isset( $user_id ) ) ? $user_id : $curl_final_data['response'][0]['id']; //dont forget about this
                        $social_uid                  = $queryparams['user_id'];
                        /**
                         * If user_email is empty, its not so scare, because its second login and 
                         */
                        $user_email                  = isset( $user_email ) ? $user_email : false; //hack, because VK has bugs sometimes
                        $first_name                  = $curl_final_data['response'][0]['first_name'];
                        $last_name                   = $curl_final_data['response'][0]['last_name'];

                        /**
                         * @link http://vk.com/dev/users.get
                         */
                        $fields_array                = array( 'avatar' => 'photo_200' );
                        $additional_fields_pre       = $curl->get( 'http://api.vk.com/method/users.get?user_ids=' . $social_uid . '&fields=' . join( ',', $fields_array ) );
                        $additional_fields           = json_decode( $additional_fields_pre, true );
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url               = isset($additional_fields['response'][0][$fields_array['avatar']]) ? $additional_fields['response'][0][$fields_array['avatar']] : '';
                        }
                        break;
                    
                    /**
                     * @link http://api.yandex.ru/oauth/doc/dg/reference/accessing-protected-resource.xml
                     * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
                     */
                    case 'yandex':
                        $queryparams['format']      = $this->_settings[$authprovider]['format'];
                        $queryparams['oauth_token'] = $access_token;
                        $curl_response              = $curl->get( $request_api_url . '?' . $this->_generate_query_data( $queryparams ) );
                        $curl_final_data            = json_decode( $curl_response, true );

                        $social_uid                 = $curl_final_data['id'];
                        /**
                         * fix @since 24.12.2014. Thanks for Yandex Tech team guys!!
                         * @link https://tech.yandex.ru/passport/
                         */
                        $user_email                 = $curl_final_data['default_email']; //was $curl_final_data['emails'][0]; - wrong!
                        $first_name                 = $curl_final_data['first_name'];
                        $last_name                  = $curl_final_data['last_name'];
                        $nickname                   = $curl_final_data['display_name']; //for future

                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            /**
                             * @link https://tech.yandex.ru/passport/doc/dg/reference/response-docpage/#norights_5
                             */
                            $yandex_avatar_size     = 'islands-200';
                            if ( isset( $curl_final_data['default_avatar_id'] ) ) {
                                $image_url          = 'https://avatars.yandex.net/get-yapic/' . $curl_final_data['default_avatar_id'] . '/' . $yandex_avatar_size;
                            }
                        }
                        break;

                    case 'mailru':
                        $queryparams['app_id']      = $params['client_id'];
                        $secret_key                 = $params['client_secret'];
                        /**
                         * @link http://api.mail.ru/docs/reference/rest/users-getinfo/
                         */
                        $queryparams['method']      = 'users.getInfo';
                        $queryparams['session_key'] = $access_token;
                        $queryparams['secure']      = 1;
                        
                        /**
                         * Additional security from mail.ru
                         * @link http://api.mail.ru/docs/guides/restapi/#sig
                         */
                        ksort( $queryparams );
                        $sig = '';
                        foreach ( $queryparams as $k => $v ) {
                            $sig .= "{$k}={$v}";
                        }
                        $queryparams['sig'] = md5( $sig . $secret_key );

                        $curl_response      = $curl->post( $request_api_url, $this->_generate_query_data( $queryparams ) );
                        $curl_final_data = json_decode( $curl_response, true );

                        $social_uid      = $curl_final_data[0]['uid'];
                        $user_email      = $curl_final_data[0]['email'];
                        $first_name      = $curl_final_data[0]['first_name'];
                        $last_name       = $curl_final_data[0]['last_name'];
                        $is_verified     = $curl_final_data[0]['is_verified'];
                        $birthday        = $curl_final_data[0]['birthday']; //dd.mm.YYYY
                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            $image_url = isset($curl_final_data[0]['pic_big']) ? $curl_final_data[0]['pic_big'] : '';
                        }
                        break;

                    /*case 'ok':
                        $queryparams['access_token'] = $access_token;
                        $queryparams['method']       = 'users.getCurrentUser';
                        $queryparams['sig']          = md5( 'application_key=' . $this->_oauth_config->ok_public_key . 'method=' . $queryparams['method'] . md5( $queryparams['access_token'] . $this->_oauth_config->ok_secret_key ) );
                        $queryparams['application_key'] = $this->_oauth_config->ok_public_key;
                        $curl_response               = $curl->get( $request_api_url . '?' . $this->_generate_query_data( $queryparams ) );
                        $curl_final_data             = json_decode( $curl_response, true );

                        $first_name                  = $curl_final_data['first_name'];
                        $last_name                   = $curl_final_data['last_name'];
                        $social_uid                  = $curl_final_data['uid'];
                        break;*/

                    default:
                        throw new moodle_exception( 'Unknown OAuth Provider', 'auth_lenauth' );
                }
                
                //development mode
                if ( $CFG->debugdeveloper == 1 && $this->_oauth_config->auth_lenauth_dev_mode ) {
                    throw new moodle_exception( 'lenauth_debug_info_not_error', 'auth_lenauth', '', 'AUTHPROVIDER: ' . $authprovider . ' >>>>>REQUEST:' . http_build_query( $queryparams, '', '<--->' ) . ' >>>>>RESPONSE: ' . http_build_query( $curl_final_data, '', ' <---> ' ) );
                }
                /**
                 * Check for email returned by webservice. If exist - check for user with this email in Moodle Database
                 */
                if ( !empty( $curl_final_data ) ) {
                    if ( !empty( $social_uid ) ) {
                        if ( $is_verified ) {
                            if ( !empty( $user_email ) ) {
                                if ( $err = email_is_not_allowed( $user_email ) ) {
                                    throw new moodle_exception( $err, 'auth_lenauth' );
                                }
                                $user_lenauth = $DB->get_record( 'user', array( 'email' => $user_email, 'deleted' => 0, 'mnethostid' => $CFG->mnet_localhost_id ) );
                            } else {
                                if ( empty( $user_lenauth ) ) {
                                    $user_lenauth = $this->_lenauth_get_userdata_by_social_id( $social_uid );
                                }
                                /*if ( empty( $user_lenauth ) ) {
                                    $user_lenauth = $DB->get_record('user', array('username' => $username, 'deleted' => 0, 'mnethostid' => $CFG->mnet_localhost_id));
                                }*/
                            }
                        } else {
                            throw new moodle_exception( 'Your social account is not verified', 'auth_lenauth' );
                        }
                    } else {
                        throw new moodle_exception( 'Empty Social UID', 'auth_lenauth' );
                    }
                } else {
                    /**
                     * addon @since 24.12.2014
                     * I forgot about clear $_COOKIE, thanks again for Yandex Tech Team guys!!!
                     */
                    @setcookie( $authprovider, null, time() - 3600 );
                    throw new moodle_exception( 'Final request returns nothing', 'auth_lenauth' );
                }
                $last_user_number = intval( $this->_oauth_config->auth_lenauth_last_user_number );
                $last_user_number = empty( $last_user_number ) ? 1 : $last_user_number+1;
                //$username = $this->_oauth_config->auth_lenauth_user_prefix . $last_user_number; //@todo
                /**
                 * If user with email from webservice not exists, we will create an account
                 */
                if ( empty( $user_lenauth ) ) {
                    $username = $this->_oauth_config->auth_lenauth_user_prefix . $last_user_number;
                    
                    //check for username exists in DB
                    $user_lenauth_check = $DB->get_record( 'user', array( 'username' => $username ) );
                    $i_check = 0;
                    while( !empty( $user_lenauth_check ) ) {
                        $user_lenauth_check = $user_lenauth_check + 1;
                        $username = $this->_oauth_config->auth_lenauth_user_prefix . $last_user_number;
                        $user_lenauth_check = $DB->get_record( 'user', array( 'username' => $username ) );
                        $i_check++;
                        if ( $i_check > 20 ) {
                            throw new moodle_exception( 'Something wrong with usernames of LenAuth users. Limit of 20 queries is out. Check last mdl_user table of Moodle', 'auth_lenauth' );
                        }
                    }
                    // create user HERE
                    $user_lenauth = create_user_record( $username, '', 'lenauth' );
                    /**
                     * User exists...
                     */
                } else {
                    $username = $user_lenauth->username;
                }
                set_config( 'auth_lenauth_last_user_number', $last_user_number, 'auth/lenauth' );
                
                if ( !empty( $social_uid ) ) {
                    $user_social_uid_custom_field = new stdClass;
                    $user_social_uid_custom_field->userid = $user_lenauth->id;
                    $user_social_uid_custom_field->fieldid = $this->_field_id;
                    $user_social_uid_custom_field->data = $social_uid;
                    if ( !$DB->record_exists( 'user_info_data', array( 'userid' => $user_lenauth->id, 'fieldid' => $this->_field_id ) ) ) {
                        $DB->insert_record('user_info_data', $user_social_uid_custom_field);
                    } else {
                        $record = $DB->get_record( 'user_info_data', array( 'userid' => $user_lenauth->id, 'fieldid' => $this->_field_id ) );
                        $user_social_uid_custom_field->id = $record->id;
                        $DB->update_record('user_info_data', $user_social_uid_custom_field);
                    }
                }

                //add_to_log( SITEID, 'auth_lenauth', '', '', $username . '/' . $user_email . '/' . $userid );

                // complete Authenticate user
                authenticate_user_login( $username, null );

                // fill $newuser object with response data from webservices
                $newuser = new stdClass();
                if ( !empty( $user_email ) ) {
                    $newuser->email = $user_email;
                }

                if ( !empty( $first_name ) ) {
                    $newuser->firstname = $first_name;
                }
                if ( !empty( $last_name ) ) {
                    $newuser->lastname = $last_name;
                }
                if ( !empty( $this->_oauth_config->auth_lenauth_default_country ) ) {
                    $newuser->country = $this->_oauth_config->auth_lenauth_default_country;
                }
                
                if ( $user_lenauth ) {
                    if ( $user_lenauth->suspended == 1 ) {
                        throw new moodle_exception( 'auth_lenauth_user_suspended', 'auth_lenauth' );
                    }
                    // update user record
                    if ( !empty( $newuser ) ) {
                        $newuser->id = $user_lenauth->id;
                            /*require_once( $CFG->libdir . '/gdlib.php' );

                            $fs = get_file_storage();
                            $file_obj = $fs->create_file_from_url( array(
                                'contextid' => context_user::instance( $newuser->id, MUST_EXIST )->id,
                                'component' => 'user',
                                'filearea'  => 'icon',
                                'itemid'    => 0,
                                'filepath'  => '/',
                                'source'    => '',
                                'filename'  => 'f' . $newuser->id . '.' . $ext
                            ), $image_url );
                            //$newuser->picture = $file_obj->get_id();*/

                        $user_lenauth = (object) array_merge( (array) $user_lenauth, (array) $newuser );
                        $DB->update_record( 'user', $user_lenauth );

                        if ( $this->_oauth_config->auth_lenauth_retrieve_avatar ) {
                            //processing user avatar from social webservice
                            if ( !empty( $image_url ) && intval( $user_lenauth->picture ) === 0) {
                                $image_header = get_headers( $image_url, 1 );

                                if ( isset( $image_header['Content-Type'] )
                                    && is_string( $image_header['Content-Type'] )
                                    && in_array( $image_header['Content-Type'], array_keys( self::$_allowed_icons_types ) ) ) {
                                    $mime = $image_header['Content-Type'];
                                } else {
                                    // >>> @ Shaposhnikov D.
                                    foreach ( $image_header['Content-Type'] as $ct ) {
                                        if ( !empty( $ct )
                                            && is_string( $ct )
                                            && in_array( $ct, array_keys( self::$_allowed_icons_types ) ) ) {
                                                $mime = $ct;
                                                break;
                                        }
                                    }
                                    // <<<
                                }
                                $ext = $this->_lenauth_get_image_extension_from_mime( $mime );
                                if ( $ext ) {
                                    //create temp file
                                    $tempfilename = substr( microtime(), 0, 10 ) . '.tmp';
                                    $templfolder = $CFG->tempdir . '/filestorage';
                                    if ( !file_exists( $templfolder ) ) {
                                        mkdir( $templfolder, $CFG->directorypermissions );
                                    }
                                    @chmod( $templfolder, 0777 );
                                    $tempfile = $templfolder . '/' . $tempfilename;
                                    if ( copy( $image_url, $tempfile ) ) {
                                        require_once( $CFG->libdir . '/gdlib.php' );
                                        $usericonid = process_new_icon( context_user::instance( $newuser->id, MUST_EXIST ), 'user', 'icon', 0, $tempfile );
                                        if ( $usericonid ) {
                                            $DB->set_field( 'user', 'picture', $usericonid, array( 'id' => $newuser->id ) );
                                        }
                                        unset( $tempfile );
                                    }
                                    @chmod( $templfolder, $CFG->directorypermissions );
                                }
                            }
                        }
                    }

                    complete_user_login( $user_lenauth ); // complete user login

                    // Redirection
                    $urltogo = $CFG->wwwroot;
                    if ( user_not_fully_set_up( $user_lenauth ) ) {
                        $urltogo = $CFG->wwwroot.'/user/edit.php';
                    } else if ( isset( $SESSION->wantsurl ) && ( strpos( $SESSION->wantsurl, $CFG->wwwroot ) === 0 ) ) {
                        $urltogo = $SESSION->wantsurl;
                        unset( $SESSION->wantsurl );
                    } else {
                        unset( $SESSION->wantsurl );
                    }
                }
                redirect( $urltogo );
            } else {
                throw new moodle_exception( 'auth_lenauth_access_token_empty', 'auth_lenauth' );
            }
        }
    }
    
    /**
     * Hook for overriding behaviour of logout page.
     * This method is called from login/logout.php page for all enabled auth plugins.
     *
     * @global object
     * @global string
     */
    public function logoutpage_hook() {
        if ( isset( $_COOKIE['auth_lenauth_authprovider'] ) ) {
            if ( isset( $_COOKIE[$_COOKIE['auth_lenauth_authprovider']] ) ) {
                unset( $_COOKIE[$_COOKIE['auth_lenauth_authprovider']] );
                setcookie( $_COOKIE['auth_lenauth_authprovider'], null, -1, '/' );
            }
            unset( $_COOKIE['auth_lenauth_authprovider'] );
            setcookie( 'auth_lenauth_authprovider', null, -1, '/' );
        }
        
        return true;
    }


    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#config_form.28.24config.2C_.24err.2C_.24user_fields.29
     * Prints a form for configuring this authentication plugin.
     * It's called from admin/auth.php, and outputs a full page with a form for configuring this plugin.
     *
     * @param  object $config An object of Moodle global config.
     * @param  array $err An array of current form errors
     * @return void. Just output form template
     *
     * @author Igor Sazonov
     */
    function config_form( $config, $err, $user_fields ) {

        // set to defaults if undefined
        if ( !isset( $config->auth_lenauth_user_prefix ) ) {
            $config->auth_lenauth_user_prefix = 'lenauth_user_';
        }
        if ( !isset( $config->auth_lenauth_default_country ) ) {
            $config->auth_lenauth_default_country = '';
        }
        if ( !isset( $config->auth_lenauth_locale ) ) {
            $config->auth_lenauth_locale = 'en';
        }
        /*if ( empty( $config->can_change_password ) ) {
            $config->can_change_password = 0;
        } else {
            $config->can_change_password = 1;
        }*/
        if ( empty( $config->auth_lenauth_can_reset_password ) ) {
            $config->auth_lenauth_can_reset_password = 0;
        } else {
            $config->auth_lenauth_can_reset_password = 1;
        }
        if ( empty( $config->auth_lenauth_can_confirm ) ) {
            $config->auth_lenauth_can_confirm = 0;
        } else {
            $config->auth_lenauth_can_confirm = 1;
        }
        if ( empty( $config->auth_lenauth_retrieve_avatar ) ) {
            $config->auth_lenauth_retrieve_avatar = 0;
        } else {
            $config->auth_lenauth_retrieve_avatar = 1;
        }
        if ( empty( $config->auth_lenauth_dev_mode ) ) {
            $config->auth_lenauth_dev_mode = 0;
        } else {
            $config->auth_lenauth_dev_mode = 1;
        }
        
        if ( !isset( $config->auth_lenauth_display_buttons ) ) {
            $config->auth_lenauth_display_buttons = 'inline-block';
        }
        if ( !isset( $config->auth_lenauth_button_width ) ) {
            $config->auth_lenauth_button_width = 0;
        }
        if ( !isset( $config->auth_lenauth_button_margin_top ) ) {
            $config->auth_lenauth_button_margin_top = 10;
        }
        if ( !isset( $config->auth_lenauth_button_margin_right ) ) {
            $config->auth_lenauth_button_margin_right = 10;
        }
        if ( !isset( $config->auth_lenauth_button_margin_bottom ) ) {
            $config->auth_lenauth_button_margin_bottom = 10;
        }
        if ( !isset( $config->auth_lenauth_button_margin_left ) ) {
            $config->auth_lenauth_button_margin_left = 10;
        }
        
        if ( !isset( $config->auth_lenauth_display_div ) ) {
            $config->auth_lenauth_display_div = 'block';
        }
        if ( !isset( $config->auth_lenauth_div_width ) ) {
            $config->auth_lenauth_div_width = 0;
        }
        if ( !isset( $config->auth_lenauth_div_margin_top ) ) {
            $config->auth_lenauth_div_margin_top = 0;
        }
        if ( !isset( $config->auth_lenauth_div_margin_right ) ) {
            $config->auth_lenauth_div_margin_right = 0;
        }
        if ( !isset( $config->auth_lenauth_div_margin_bottom ) ) {
            $config->auth_lenauth_div_margin_bottom = 0;
        }
        if ( !isset( $config->auth_lenauth_div_margin_left ) ) {
            $config->auth_lenauth_div_margin_left = 0;
        }
        
        if ( !isset( $config->auth_lenauth_order ) ) {
            $order_array = $this->_default_order;
        } else {
            $order_array = json_decode( $config->auth_lenauth_order, true );
        }
        
        if ( !isset( $config->auth_lenauth_facebook_enabled ) ) {
            $config->auth_lenauth_facebook_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_facebook_app_id ) ) {
            $config->auth_lenauth_facebook_app_id = '';
        }
        if ( !isset( $config->auth_lenauth_facebook_app_secret ) ) {
            $config->auth_lenauth_facebook_app_secret = '';
        }
        if ( !isset( $config->auth_lenauth_facebook_button_text ) ) {
            $config->auth_lenauth_facebook_button_text = get_string( 'auth_lenauth_facebook_button_text_default', 'auth_lenauth' );
        }
        
        if ( !isset( $config->auth_lenauth_google_enabled ) ) {
            $config->auth_lenauth_google_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_google_client_id ) ) {
            $config->auth_lenauth_google_client_id = '';
        }
        if ( !isset( $config->auth_lenauth_google_client_secret ) ) {
            $config->auth_lenauth_google_client_secret = '';
        }
        if ( !isset( $config->auth_lenauth_google_project_id ) ) {
            $config->auth_lenauth_google_project_id = '';
        }
        if ( !isset( $config->auth_lenauth_google_button_text ) ) {
            $config->auth_lenauth_google_button_text = get_string( 'auth_lenauth_google_button_text_default', 'auth_lenauth' );
        }
        
        if ( !isset( $config->auth_lenauth_yahoo_enabled ) ) {
            $config->auth_lenauth_yahoo_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_yahoo_oauth_version ) ) {
            $config->auth_lenauth_yahoo_oauth_version = 1;
        }
        if ( !isset( $config->auth_lenauth_yahoo_application_id ) ) {
            $config->auth_lenauth_yahoo_application_id = '';
        }
        if ( !isset( $config->auth_lenauth_yahoo_consumer_key ) ) {
            $config->auth_lenauth_yahoo_consumer_key = '';
        }
        if ( !isset( $config->auth_lenauth_yahoo_consumer_secret ) ) {
            $config->auth_lenauth_yahoo_consumer_secret = '';
        }
        if ( !isset( $config->auth_lenauth_yahoo_button_text ) ) {
            $config->auth_lenauth_yahoo_button_text = get_string( 'auth_lenauth_yahoo_button_text_default', 'auth_lenauth' );
        }
        
        if ( !isset( $config->auth_lenauth_twitter_enabled ) ) {
            $config->auth_lenauth_twitter_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_twitter_consumer_key ) ) {
            $config->auth_lenauth_twitter_consumer_key = '';
        }
        if ( !isset( $config->auth_lenauth_twitter_consumer_secret ) ) {
            $config->auth_lenauth_twitter_consumer_secret = '';
        }
        if ( !isset( $config->auth_lenauth_twitter_application_id ) ) {
            $config->auth_lenauth_twitter_application_id = '';
        }
        
        if ( !isset( $config->auth_lenauth_vk_enabled ) ) {
            $config->auth_lenauth_vk_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_vk_app_id ) ) {
            $config->auth_lenauth_vk_app_id = '';
        }
        if ( !isset( $config->auth_lenauth_vk_app_secret ) ) {
            $config->auth_lenauth_vk_app_secret = '';
        }
        if ( !isset( $config->auth_lenauth_vk_button_text ) ) {
            $config->auth_lenauth_vk_button_text = get_string( 'auth_lenauth_vk_button_text_default', 'auth_lenauth' );
        }

        if ( !isset( $config->auth_lenauth_yandex_enabled ) ) {
            $config->auth_lenauth_yandex_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_yandex_app_id ) ) {
            $config->auth_lenauth_yandex_app_id = '';
        }
        if ( !isset( $config->auth_lenauth_yandex_app_password ) ) {
            $config->auth_lenauth_yandex_app_password = '';
        }
        if ( !isset( $config->auth_lenauth_yandex_button_text ) ) {
            $config->auth_lenauth_yandex_button_text = get_string( 'auth_lenauth_yandex_button_text_default', 'auth_lenauth' );
        }

        if ( !isset( $config->auth_lenauth_mailru_enabled ) ) {
            $config->auth_lenauth_mailru_enabled = 0;
        }
        if ( !isset( $config->auth_lenauth_mailru_site_id ) ) {
            $config->auth_lenauth_mailru_site_id = '';
        }
        if ( !isset( $config->auth_lenauth_mailru_client_private ) ) {
            $config->auth_lenauth_mailru_client_private = '';
        }
        if ( !isset( $config->auth_lenauth_mailru_client_secret ) ) {
            $config->auth_lenauth_mailru_client_secret = '';
        }
        if ( !isset( $config->auth_lenauth_mailru_button_text ) ) {
            $config->auth_lenauth_mailru_button_text = get_string( 'auth_lenauth_mailru_button_text_default', 'auth_lenauth' );
        }

        /*if ( !isset( $config->ok_enabled ) ) {
            $config->ok_enabled = 0;
        }
        if ( !isset( $config->ok_app_id ) ) {
            $config->ok_app_id = '';
        }
        if ( !isset( $config->ok_public_key ) ) {
            $config->ok_public_key = '';
        }
        if ( !isset( $config->ok_secret_key ) ) {
            $config->ok_secret_key = '';
        }
        if ( !isset( $config->ok_button_text ) ) {
            $config->ok_button_text = get_string( 'auth_ok_button_text_default', 'auth_lenauth' );
        }
        if ( !isset( $config->ok_social_id_field ) ) {
            $config->ok_social_id_field = '';
        }*/

        include 'view_admin_config.php';

        print_auth_lock_options( 'lenauth', $user_fields, get_string( 'auth_fieldlocks_help', 'auth' ), false, false );
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#process_config.28.24config.29
     * Processes and stores configuration data for this authentication plugin.
     *
     * @param  object $config
     * @access public
     * @author Igor Sazonov
     */
    function process_config( $config ) {
        
        if ( has_capability( 'moodle/user:update', context_system::instance() ) ) {
            // set to defaults if undefined while save
            if ( !isset( $config->auth_lenauth_user_prefix ) ) {
                $config->auth_lenauth_user_prefix = 'lenauth_user_';
            }
            if ( !isset( $config->auth_lenauth_default_country ) ) {
                $config->auth_lenauth_default_country = '';
            }
            if ( !isset( $config->auth_lenauth_locale ) ) {
                $config->auth_lenauth_locale = 'en';
            }
            /*if ( empty( $config->can_change_password ) ) {
                $config->can_change_password = 0;
            } else {
                $config->can_change_password = 1;
            }*/
            if ( empty( $config->auth_lenauth_can_reset_password ) ) {
                $config->auth_lenauth_can_reset_password = 0;
            } else {
                $config->auth_lenauth_can_reset_password = 1;
            }
            if ( empty( $config->auth_lenauth_can_confirm ) ) {
                $config->auth_lenauth_can_confirm = 0;
            } else {
                $config->auth_lenauth_can_confirm = 1;
            }
            if ( empty( $config->auth_lenauth_retrieve_avatar ) ) {
                $config->auth_lenauth_retrieve_avatar = 0;
            } else {
                $config->auth_lenauth_retrieve_avatar = 1;
            }
            if ( empty( $config->auth_lenauth_dev_mode ) ) {
                $config->auth_lenauth_dev_mode = 0;
            } else {
                $config->auth_lenauth_dev_mode = 1;
            }
            
            if ( !isset( $config->auth_lenauth_display_buttons ) ) {
                $config->auth_lenauth_display_buttons = 'inline-block';
            }
            if ( !isset( $config->auth_lenauth_button_width ) ) {
                $config->auth_lenauth_button_width = 0;
            }
            if ( !isset( $config->auth_lenauth_button_margin_top ) ) {
                $config->auth_lenauth_button_margin_top = 10;
            }
            if ( !isset( $config->auth_lenauth_button_margin_right ) ) {
                $config->auth_lenauth_button_margin_right = 10;
            }
            if ( !isset( $config->auth_lenauth_button_margin_bottom ) ) {
                $config->auth_lenauth_button_margin_bottom = 10;
            }
            if ( !isset( $config->auth_lenauth_button_margin_left ) ) {
                $config->auth_lenauth_button_margin_left = 10;
            }
            
            if ( !isset( $config->auth_lenauth_display_div ) ) {
                $config->auth_lenauth_display_div = 'block';
            }
            if ( !isset( $config->auth_lenauth_div_width ) ) {
                $config->auth_lenauth_div_width = 0;
            }
            if ( !isset( $config->auth_lenauth_div_margin_top ) ) {
                $config->auth_lenauth_div_margin_top = 0;
            }
            if ( !isset( $config->auth_lenauth_div_margin_right ) ) {
                $config->auth_lenauth_div_margin_right = 0;
            }
            if ( !isset( $config->auth_lenauth_div_margin_bottom ) ) {
                $config->auth_lenauth_div_margin_bottom = 0;
            }
            if ( !isset( $config->auth_lenauth_div_margin_left ) ) {
                $config->auth_lenauth_div_margin_left = 0;
            }
            
            if ( !isset( $config->auth_lenauth_order ) ) {
                $config->auth_lenauth_order = json_encode( $this->_default_order );
            }
            
            $config->auth_lenauth_facebook_enabled = ( !empty( $config->auth_lenauth_facebook_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_facebook_app_id ) ) {
                $config->auth_lenauth_facebook_app_id = '';
            }
            if ( !isset( $config->auth_lenauth_facebook_app_secret ) ) {
                $config->auth_lenauth_facebook_app_secret = '';
            }
            if ( !isset( $config->auth_lenauth_facebook_button_text ) ) {
                $config->auth_lenauth_facebook_button_text = get_string( 'auth_lenauth_facebook_button_text_default', 'auth_lenauth' );
            }
            
            $config->auth_lenauth_google_enabled = ( !empty( $config->auth_lenauth_google_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_google_client_id ) ) {
                $config->auth_lenauth_google_client_id = '';
            }
            if ( !isset( $config->auth_lenauth_google_client_secret ) ) {
                $config->auth_lenauth_google_client_secret = '';
            }
            if ( !isset( $config->auth_lenauth_google_project_id ) ) {
                $config->auth_lenauth_google_project_id = '';
            }
            if ( empty( $config->auth_lenauth_google_button_text ) ) {
                $config->auth_lenauth_google_button_text = get_string( 'auth_lenauth_google_button_text_default', 'auth_lenauth' );
            }
            
            $config->auth_lenauth_yahoo_enabled = ( !empty( $config->auth_lenauth_yahoo_enabled ) ) ? 1 : 0;
            $config->auth_lenauth_yahoo_oauth_version = ( !empty( $config->auth_lenauth_yahoo_oauth_version ) ) ? intval( $config->auth_lenauth_yahoo_oauth_version ) : 1;
            if ( !isset( $config->auth_lenauth_yahoo_application_id ) ) {
                $config->auth_lenauth_yahoo_application_id = '';
            }
            if ( !isset( $config->auth_lenauth_yahoo_consumer_key ) ) {
                $config->auth_lenauth_yahoo_consumer_key = '';
            }
            if ( !isset( $config->auth_lenauth_yahoo_consumer_secret ) ) {
                $config->auth_lenauth_yahoo_consumer_secret = '';
            }
            if ( !isset( $config->auth_lenauth_yahoo_button_text ) ) {
                $config->auth_lenauth_yahoo_button_text = get_string( 'auth_lenauth_yahoo_button_text_default', 'auth_lenauth' );
            }
            
            $config->auth_lenauth_twitter_enabled = ( !empty( $config->auth_lenauth_twitter_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_twitter_consumer_key ) ) {
                $config->auth_lenauth_twitter_consumer_key = '';
            }
            if ( !isset( $config->auth_lenauth_twitter_consumer_secret ) ) {
                $config->auth_lenauth_twitter_consumer_secret = '';
            }
            if ( !isset( $config->auth_lenauth_twitter_application_id ) ) {
                $config->auth_lenauth_twitter_application_id = '';
            }
            if ( !isset( $config->auth_lenauth_twitter_button_text ) ) {
                $config->auth_lenauth_twitter_button_text = get_string( 'auth_lenauth_twitter_button_text_default', 'auth_lenauth' );
            }
            
            $config->auth_lenauth_vk_enabled = ( !empty( $config->auth_lenauth_vk_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_vk_app_id ) ) {
                $config->auth_lenauth_vk_app_id = '';
            }
            if ( !isset( $config->auth_lenauth_vk_app_secret ) ) {
                $config->auth_lenauth_vk_app_secret = '';
            }
            if ( empty( $config->auth_lenauth_vk_button_text ) ) {
                $config->auth_lenauth_vk_button_text = get_string( 'auth_lenauth_vk_button_text_default', 'auth_lenauth' );
            }

            $config->auth_lenauth_yandex_enabled = ( !empty( $config->auth_lenauth_yandex_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_yandex_app_id ) ) {
                $config->auth_lenauth_yandex_app_id = '';
            }
            if ( !isset( $config->auth_lenauth_yandex_app_password ) ) {
                $config->auth_lenauth_yandex_app_password = '';
            }
            if ( !isset( $config->auth_lenauth_yandex_button_text ) ) {
                $config->auth_lenauth_yandex_button_text = get_string( 'auth_lenauth_yandex_button_text_default', 'auth_lenauth' );
            }

            $config->auth_lenauth_mailru_enabled = ( !empty( $config->auth_lenauth_mailru_enabled ) ) ? 1 : 0;
            if ( !isset( $config->auth_lenauth_mailru_site_id ) ) {
                $config->auth_lenauth_mailru_site_id = '';
            }
            if ( !isset( $config->auth_lenauth_mailru_client_private ) ) {
                $config->auth_lenauth_mailru_client_private = '';
            }
            if ( !isset( $config->auth_lenauth_mailru_client_secret ) ) {
                $config->auth_lenauth_mailru_client_secret = '';
            }
            if ( !isset( $config->auth_lenauth_mailru_button_text ) ) {
                $config->auth_lenauth_mailru_button_text = get_string( 'auth_lenauth_mailru_button_text_default', 'auth_lenauth' );
            }

            /*$config->ok_enabled = ( !empty( $config->ok_enabled ) ) ? 1 : 0;
            if ( !isset( $config->ok_app_id ) ) {
                $config->ok_app_id = '';
            }
            if ( !isset( $config->ok_public_key ) ) {
                $config->ok_public_key = '';
            }
            if ( !isset( $config->ok_secret_key ) ) {
                $config->ok_secret_key = '';
            }
            if ( !isset( $config->ok_button_text ) ) {
                $config->ok_button_text = get_string( 'auth_ok_button_text_default', 'auth_lenauth' );
            }
            if ( !isset( $config->ok_social_id_field ) ) {
                $config->ok_social_id_field = '';
            }*/

            // save settings
            set_config('auth_lenauth_facebook_enabled',        intval( $config->auth_lenauth_facebook_enabled ),      'auth/lenauth');
            set_config('auth_lenauth_facebook_app_id',         trim( $config->auth_lenauth_facebook_app_id ),         'auth/lenauth');
            set_config('auth_lenauth_facebook_app_secret',     trim( $config->auth_lenauth_facebook_app_secret ),     'auth/lenauth');
            set_config('auth_lenauth_facebook_button_text',    trim( $config->auth_lenauth_facebook_button_text ),    'auth/lenauth');
            
            set_config('auth_lenauth_google_enabled',          intval( $config->auth_lenauth_google_enabled ),        'auth/lenauth');
            set_config('auth_lenauth_google_client_id',        trim( $config->auth_lenauth_google_client_id ),        'auth/lenauth');
            set_config('auth_lenauth_google_client_secret',    trim( $config->auth_lenauth_google_client_secret ),    'auth/lenauth');
            set_config('auth_lenauth_google_project_id',       trim( $config->auth_lenauth_google_project_id ),       'auth/lenauth');
            set_config('auth_lenauth_google_button_text',      trim( $config->auth_lenauth_google_button_text ),      'auth/lenauth');
            
            set_config('auth_lenauth_yahoo_enabled',           intval( $config->auth_lenauth_yahoo_enabled ),         'auth/lenauth');
            set_config('auth_lenauth_yahoo_oauth_version',     intval( $config->auth_lenauth_yahoo_oauth_version ),   'auth/lenauth');
            set_config('auth_lenauth_yahoo_application_id',    trim( $config->auth_lenauth_yahoo_application_id ),    'auth/lenauth');
            set_config('auth_lenauth_yahoo_consumer_key',      trim( $config->auth_lenauth_yahoo_consumer_key ),      'auth/lenauth');
            set_config('auth_lenauth_yahoo_consumer_secret',   trim( $config->auth_lenauth_yahoo_consumer_secret ),   'auth/lenauth');
            set_config('auth_lenauth_yahoo_button_text',       trim( $config->auth_lenauth_yahoo_button_text ),       'auth/lenauth');

            set_config('auth_lenauth_twitter_enabled',         intval( $config->auth_lenauth_twitter_enabled ),       'auth/lenauth');
            set_config('auth_lenauth_twitter_application_id',  intval( $config->auth_lenauth_twitter_application_id ),'auth/lenauth');
            set_config('auth_lenauth_twitter_consumer_key',    trim( $config->auth_lenauth_twitter_consumer_key ),    'auth/lenauth');
            set_config('auth_lenauth_twitter_consumer_secret', trim( $config->auth_lenauth_twitter_consumer_secret ), 'auth/lenauth');
            set_config('auth_lenauth_twitter_button_text',     trim( $config->auth_lenauth_twitter_button_text ),     'auth/lenauth');
            
            set_config('auth_lenauth_vk_enabled',              intval( $config->auth_lenauth_vk_enabled ),            'auth/lenauth');
            set_config('auth_lenauth_vk_app_id',               trim( $config->auth_lenauth_vk_app_id ),               'auth/lenauth');
            set_config('auth_lenauth_vk_app_secret',           trim( $config->auth_lenauth_vk_app_secret ),           'auth/lenauth');
            set_config('auth_lenauth_vk_button_text',          trim( $config->auth_lenauth_vk_button_text ),          'auth/lenauth');
            
            set_config('auth_lenauth_yandex_enabled',          intval( $config->auth_lenauth_yandex_enabled ),        'auth/lenauth');
            set_config('auth_lenauth_yandex_app_id',           trim( $config->auth_lenauth_yandex_app_id ),           'auth/lenauth');
            set_config('auth_lenauth_yandex_app_password',     trim( $config->auth_lenauth_yandex_app_password ),     'auth/lenauth');
            set_config('auth_lenauth_yandex_button_text',      trim( $config->auth_lenauth_yandex_button_text ),      'auth/lenauth');

            set_config('auth_lenauth_mailru_enabled',          intval( $config->auth_lenauth_mailru_enabled ),        'auth/lenauth');
            set_config('auth_lenauth_mailru_site_id',          intval( $config->auth_lenauth_mailru_site_id ),        'auth/lenauth');
            set_config('auth_lenauth_mailru_client_private',   trim( $config->auth_lenauth_mailru_client_private ),   'auth/lenauth');
            set_config('auth_lenauth_mailru_client_secret',    trim( $config->auth_lenauth_mailru_client_secret ),    'auth/lenauth');
            set_config('auth_lenauth_mailru_button_text',      trim( $config->auth_lenauth_mailru_button_text ),      'auth/lenauth');

            /*set_config('ok_enabled',              intval( $config->ok_enabled ),                             'auth/lenauth');
            set_config('ok_app_id',               trim( $config->ok_app_id ),               'auth/lenauth');
            set_config('ok_public_key',           trim( $config->ok_public_key ),           'auth/lenauth');
            set_config('ok_secret_key',           trim( $config->ok_secret_key ),           'auth/lenauth');
            set_config('ok_button_text',          trim( $config->ok_button_text ),          'auth/lenauth');
            set_config('ok_social_id_field',      trim( $config->ok_social_id_field ),      'auth/lenauth');*/

            set_config('auth_lenauth_user_prefix',             trim( $config->auth_lenauth_user_prefix ),             'auth/lenauth');
            set_config('auth_lenauth_default_country',         trim( $config->auth_lenauth_default_country ),         'auth/lenauth');
            set_config('auth_lenauth_locale',                  trim( $config->auth_lenauth_locale ),                  'auth/lenauth');
            //set_config('can_change_password',                  intval( $config->can_change_password ),              'auth/lenauth');
            set_config('auth_lenauth_can_reset_password',      intval( $config->auth_lenauth_can_reset_password ),    'auth/lenauth');
            set_config('auth_lenauth_can_confirm',             intval( $config->auth_lenauth_can_confirm ),           'auth/lenauth');
            set_config('auth_lenauth_retrieve_avatar',         intval( $config->auth_lenauth_retrieve_avatar ),       'auth/lenauth');
            set_config('auth_lenauth_dev_mode',                intval( $config->auth_lenauth_dev_mode ),              'auth/lenauth');
            
            set_config('auth_lenauth_display_buttons',         trim( $config->auth_lenauth_display_buttons ),         'auth/lenauth');
            set_config('auth_lenauth_button_width',            intval( $config->auth_lenauth_button_width ),          'auth/lenauth');
            set_config('auth_lenauth_button_margin_top',       intval( $config->auth_lenauth_button_margin_top ),     'auth/lenauth');
            set_config('auth_lenauth_button_margin_right',     intval( $config->auth_lenauth_button_margin_right ),   'auth/lenauth');
            set_config('auth_lenauth_button_margin_bottom',    intval( $config->auth_lenauth_button_margin_bottom ),  'auth/lenauth');
            set_config('auth_lenauth_button_margin_left',      intval( $config->auth_lenauth_button_margin_left ),    'auth/lenauth');
            
            set_config('auth_lenauth_display_div',             trim( $config->auth_lenauth_display_div ),             'auth/lenauth');
            set_config('auth_lenauth_div_width',               intval( $config->auth_lenauth_div_width ),             'auth/lenauth');
            set_config('auth_lenauth_div_margin_top',          intval( $config->auth_lenauth_div_margin_top ),        'auth/lenauth');
            set_config('auth_lenauth_div_margin_right',        intval( $config->auth_lenauth_div_margin_right ),      'auth/lenauth');
            set_config('auth_lenauth_div_margin_bottom',       intval( $config->auth_lenauth_div_margin_bottom ),     'auth/lenauth');
            set_config('auth_lenauth_div_margin_left',         intval( $config->auth_lenauth_div_margin_left ),       'auth/lenauth');
            
            $order_array = $this->_make_order( $config->auth_lenauth_order );
            set_config('auth_lenauth_order',                   json_encode( $order_array ),                           'auth/lenauth');

            return true;
        }

        throw new moodle_exception('You do not have permissions', 'auth_lenauth');
    }
    
    /**
     * This function generate pretty (key-number=>name) array of socials order
     * 
     * @param  array $order_array Orders array from $_POST config: user input for orders
     * @access private
     * @return array
     */
    private function _make_order( array $order_array ) {
        $ret_array = array();
        foreach ( $order_array as $service => $order ) {
            $order = intval( $order );
            while ( isset( $ret_array[$order] ) ) {
                $order+=1;
            }
            $ret_array[$order] = $service;
        }
        ksort( $ret_array );
        $i = 1;
        $ret_array_2 = array();
        foreach ( $ret_array as $service ) {
            $ret_array_2[$i] = $service;
            $i++;
        }
        
        return $ret_array_2;
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#user_update.28.24olduser.2C_.24newuser.29
     * Called when the user record is updated. It will modify the user information in external database.
     *
     * If email updated we store it to global $USER object
     *
     * @param  object $olduser before user update
     * @param  object $newuser new user data
     * @uses   $USER core global object
     * @return boolean
     *
     * @access public
     * @author Igor Sazonov
     *
     */
    function user_update( $olduser, $newuser ) {
        global $USER;
        if ( !empty( $newuser->email ) ) {
            $USER->email = $newuser->email;
        }
        
        return true;
    }

    public function urlEncodeRfc3986( $input ) {
        if ( is_array( $input ) ) {
            return array_map( array( $this, 'urlEncodeRfc3986' ), $input );
        }
        if ( is_scalar( $input ) ) {
            return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
        }
        return '';
    }

    /**
     * @param  $signature Signature atring
     * @return array
     */
    private function _lenauth_yahoo_request_array( $signature ) {
        return array(
            'oauth_consumer_key'     => $this->_oauth_config->auth_lenauth_yahoo_consumer_key,
            'oauth_nonce'            => md5( microtime( true ) . $_SERVER['REMOTE_ADDR'] ),
            'oauth_signature_method' => 'PLAINTEXT',
            'oauth_timestamp'        => time(),
            'oauth_version'          => self::$yahoo_oauth_version,
            'oauth_signature'        => $signature,
        );
    }
    
    
    /**
     *
     * This function generates array with Twitter request header
     * @param  array $params Array with parameters to be send with request header
     * @param  bool $send_oauth_request Boolean param about send OAuth request or not
     * @param  string $oauth_token OAuth token
     * @return array
     *
     * @access  protected
     * @author Igor Sazonov
     */
    protected function _lenauth_set_twitter_header( $params, $oauth_token = false, $oauth_token_secret = false ) {
        if ( $oauth_token ) {
            $params['oauth_token'] = $oauth_token;
        }
        ksort($params);
        $encodedParams = array();
        foreach ( $params as $key => $value ) {
            $encodedParams[] = $key . '=' . $this->urlEncodeRfc3986( $value );
        }
        $signature = implode( '&', $this->urlEncodeRfc3986( array(
            strtoupper( $this->_curl_type ),
            $this->_send_oauth_request ? $this->_settings['twitter']['request_token_url'] : $this->_settings['twitter']['token_url'],
            implode( '&', $encodedParams )
        ) ) );
        $params['oauth_signature'] = base64_encode(
                hash_hmac( 'sha1', $signature, implode( '&', $this->urlEncodeRfc3986(
                        array(
                            $this->_oauth_config->auth_lenauth_twitter_consumer_secret,
                            $oauth_token_secret ? $oauth_token_secret : ''
                        )
                ) ), 
                true )
        );

        $header = '';
        foreach ( $params as $key => $value ) {
            if ( preg_match( '/^oauth_/', $key ) ) {
                $header .= ( $header === '' ? ' ' : ', ' ) . $this->urlEncodeRfc3986( $key ) . '="' . $this->urlEncodeRfc3986( $value ) . '"';
            }
        }
        
        return array(
            'Expect:',
            'Accept: application/json',
            'Authorization: OAuth' . $header,
        );
    }

    private function _lenauth_twitter_request_array() {
        return array(
            'oauth_consumer_key'     => $this->_oauth_config->auth_lenauth_twitter_consumer_key,
            //'oauth_nonce'            => md5( microtime( true ) . $_SERVER['REMOTE_ADDR'] ),
            'oauth_nonce'            => md5( microtime( true ) ),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => time(),
            'oauth_version'          => self::$twitter_oauth_version
        );
    }
    
    protected function _lenauth_get_user_info_fields_array() {
        $ret_array = array();
        if ( !empty( $this->_user_info_fields ) && is_array( $this->_user_info_fields ) ) {
            foreach ($this->_user_info_fields as $item) {
                $ret_array[$item->shortname] = $item->name;
            }
        }
        
        return $ret_array;
    }
    
    /**
     * The function gets additional field ID of specified webservice shortname from user_info_field table
     *
     * @param  string $shortname a shortname of webservice defined here
     * @return int
     *
     * @access protected
     * @author Igor Sazonov (@tigusigalpa)
     */
    protected function _lenauth_get_fieldid() {
        global $DB;
        return $this->_field_shortname ? $DB->get_field( 'user_info_field', 'id', array( 'shortname' => $this->_field_shortname ) ) : false;
    }
    
    /**
     * Function to generate valid redirect URI to use it without problems
     * Param $authprovider checks service we use and makes URI. Used in code for much faster work.
     * 
     * @global object $CFG
     * @param  string $authprovider current OAuth provider
     * @param  int    provider OAuth version (ie for Yahoo)
     * @return string
     *
     * @access protected
     * @author Igor Sazonov (@tigusigalpa)
     */
    protected function _lenauth_redirect_uri( $authprovider ) {
        global $CFG;
        
        $return = $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=' . $authprovider;
        return $return;
    }

    /**
     *
     * This function returns user object from Moodle database with given $social_uid param,
     * if user with this social_uid exists, function will return this user object,
     * if not - false
     *
     * @global object $DB
     * @global object $CFG
     * @param  string $social_uid user internal ID of social webservice that comes from request
     * @return object|bool
     *
     * @access private
     * @author Igor Sazonov (@tigusigalpa)
     */
    private function _lenauth_get_userdata_by_social_id( $social_uid ) {
        global $DB, $CFG;

        $ret = false;
        if ( !empty( $this->_field_shortname ) ) {
            $ret = $DB->get_record_sql( 'SELECT u.* FROM {user} u
                                                    LEFT JOIN {user_info_data} uid ON u.id = uid.userid
                                                    LEFT JOIN {user_info_field} uif ON uid.fieldid = uif.id
                                                    WHERE uid.data = ?
                                                    AND uif.id = ?
                                                    AND uif.shortname = ?
                                                    AND u.deleted = ? AND u.mnethostid = ?'
                    , array( $social_uid, $this->_field_id, $this->_field_shortname, 0, $CFG->mnet_localhost_id ) );
        }
        
        return $ret;
    }

    /**
     * This function returns extension of web image mime type
     *
     * @param  $mime Mime type
     * @return string If needle $mime type exists returns extension, if not - empty string
     */
    private function _lenauth_get_image_extension_from_mime( $mime ) {
        return isset( self::$_allowed_icons_types[$mime] ) ? self::$_allowed_icons_types[$mime] : '';
    }

}
