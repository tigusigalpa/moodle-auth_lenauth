<?php

/**
 * @author Igor Sazonov <sovletig@gmail.com>
 * @link http://lms-service.org/lenauth-plugin-oauth-moodle/
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version 2.0
 * @uses \auth_plugin_base core class
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

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir . '/authlib.php';
require_once $CFG->libdir . '/formslib.php';

/**
 * LenAuth authentication plugin.
 */
class auth_plugin_lenauth extends \auth_plugin_base
{
    /**
     * An array of plugin webservices settings
     *
     * @property request_token_url endpoint URI of webservice to exchange code for token
     * @property grant_type some key needed for some webservices, always value is authorization_code
     * @property request_api_url URI for final request to get user data response
     * @var array
     * @access protected
     */
    protected $settings = [
        /**
         * Facebook settings
         * @link https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0
         * @link https://developers.facebook.com/docs/graph-api/reference/v2.0/user
         */
        'facebook' => [
            'request_token_url' => 'https://graph.facebook.com/oauth/access_token',
            'request_api_url'   => 'https://graph.facebook.com/me'
        ],
        /**
         * Google settings
         * @link https://developers.google.com/accounts/docs/OAuth2Login#authenticatingtheuser
         * @link https://developers.google.com/+/api/oauth
         */
        'google' => [
            'request_token_url' => 'https://accounts.google.com/o/oauth2/token',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'https://www.googleapis.com/plus/v1/people/me'
        ],
        /**
         * Yahoo OAuth1 settings
         * @link https://developer.yahoo.com/oauth/
         * @link https://developer.yahoo.com/oauth/guide/
         * @link https://developer.yahoo.com/oauth/guide/oauth-userauth.html
         */
        'yahoo1' => [
            'request_token_url' => 'https://api.login.yahoo.com/oauth/v2/get_request_token',
            'request_api_url'   => 'https://api.login.yahoo.com/oauth/v2/get_token',
            'yql_url'           => 'https://query.yahooapis.com/v1/yql'
        ],
        /**
         * Yahoo OAuth2 settings
         * @link https://developer.yahoo.com/oauth2/
         * @link https://developer.yahoo.com/oauth2/guide/
         * @link https://developer.yahoo.com/oauth2/guide/flows_authcode/
         * @link https://developer.yahoo.com/oauth2/guide/apirequests/
         */
        'yahoo2' => [
            'request_token_url' => 'https://api.login.yahoo.com/oauth2/get_token',
            'request_api_url'   => 'https://api.login.yahoo.com/oauth2/get_token',
            'grant_type'        => 'authorization_code',
            'yql_url'           => 'https://query.yahooapis.com/v1/yql'
        ],
        /**
         * Twitter settings
         * @link https://dev.twitter.com/web/sign-in/implementing
         */
        'twitter' => [
            'request_token_url' => 'https://api.twitter.com/oauth/request_token',
            'request_api_url'   => 'https://api.twitter.com/oauth/authenticate',
            'token_url'         => 'https://api.twitter.com/oauth/access_token',
            'expire'            => 3600 //just 1 hour because Twitter doesnt support expire
        ],
        /**
         * VK.com settings
         * @link http://vk.com/dev/auth_sites
         * @link http://vk.com/dev/api_requests
         */
        'vk' => [
            'request_token_url' => 'https://oauth.vk.com/access_token',
            'request_api_url'   => 'https://api.vk.com/method/users.get'
        ],
        /**
         * @link http://api.yandex.ru/oauth/doc/dg/reference/obtain-access-token.xml
         * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
         */
        'yandex' => [
            'request_token_url' => 'https://oauth.yandex.ru/token',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'https://login.yandex.ru/info',
            'format'            => 'json'
        ],
        /**
         * Mail.ru settings
         * @link http://api.mail.ru/docs/guides/oauth/sites/
         * @link http://api.mail.ru/docs/reference/rest/
         * @link http://api.mail.ru/docs/guides/restapi/
         */
        'mailru' => [
            'request_token_url' => 'https://connect.mail.ru/oauth/token',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'http://www.appsmail.ru/platform/api'
        ],
        /**
         * Odnoklassniki.ru settings
         * @link http://apiok.ru/wiki/pages/viewpage.action?pageId=42476652
         * @link http://apiok.ru/wiki/display/api/Odnoklassniki+REST+API+ru
         * @link http://apiok.ru/wiki/display/api/REST+API+-+users+ru
         * @link http://apiok.ru/wiki/display/api/users.getInfo+ru
         *
         */
        /*'ok' => [
            'request_token_url' => 'http://api.odnoklassniki.ru/oauth/token.do',
            'grant_type'        => 'authorization_code',
            'request_api_url'   => 'http://api.odnoklassniki.ru/fb.do'
        ],*/
    ];

    /**
     * global $DB object
     *
     * @var null
     */
    protected $db = null;

    /**
     * global $CFG object
     *
     * @var null
     */
    protected $cfg = null;
    
    protected $default_order = [
        1 => 'facebook', 2 => 'google', 3 => 'yahoo', 4 => 'twitter',
        5 => 'vk', 6 => 'yandex', 7 => 'mailru'
    ];

    /**
     * @var bool
     */
    protected $send_oauth_request = true;

    protected $set_password = true;

    /**
     * cURL default request type. Highly recommended is POST
     *
     * @var string
     */
    protected $curl_type = 'post';

    protected $_last_user_number = 0;

    protected $user_info_fields = [];

    protected $_field_shortname;
    protected $_field_id;
    
    /**
     * List of available styles
     *
     * @var array
     */
    protected $styles_array = [
        'default', 'style1',
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
        'simple-flat-circle', 'simple-flat-circle-small',
        'bootstrap-font-awesome','bootstrap-font-awesome-simple',
    ];

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
     *
     * @var string
     */
    public static $yahoo_oauth_version = '1.0';
    
    /**
     * Twitter API version
     *
     * @var string
     */
    public static $twitter_oauth_version = '1.0';

    protected static $allowed_icons_types = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
    ];


    /**
     * Constructor.
     */
    public function __construct()
    {
        global $DB, $CFG;
        $this->db = $DB;
        $this->cfg = $CFG;

        $this->_oauth_config = get_config('auth/lenauth');
        
        $this->user_info_fields = $DB->get_records('user_info_field');
        $this->authtype = 'lenauth'; // define name of our authentication method
        $this->roleauth = 'auth_lenauth';
        $this->errorlogtag = '[AUTH lenauth]';
    }
    
    /**
     * Singleton
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance) && !(self::$_instance instanceof \auth_plugin_lenauth)) {
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
     * @param string $userName of user
     * @param string $password of user
     *
     * @return bool
     * @throws coding_exception
     * @throws dml_exception
     */
    public function user_login($userName, $password)
    {
        //get user record/object from DB by username
        $user = $this->db->get_record(
            'user',
            ['username' => $userName, 'mnethostid' => $this->cfg->mnet_localhost_id]
        );
        //check for user (username) exist and authentication method
        if (!empty($user) && ($user->auth == 'lenauth')) {
            $code = optional_param('code', '', PARAM_ALPHANUMEXT);
            if (empty($code)) {
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
    function is_internal()
    {
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
     * @param mixed $userName username (with system magic quotes)
     * @return integer
     */
    /*function password_expire($userName) {
        return isset( $this->_oauth_config->password_expire ) ? $this->_oauth_config->password_expire : 0;
    }*/
    
    /**
     * Returns true if plugin allows confirming of new users.
     *
     * @return boolean
     */
    function can_confirm()
    {
        return isset($this->_oauth_config->auth_lenauth_can_confirm) ? $this->_oauth_config->auth_lenauth_can_confirm : false;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @link https://docs.moodle.org/dev/Authentication_plugins#can_reset_password.28.29
     * @return boolean
     */
    function can_reset_password()
    {
        return isset($this->_oauth_config->auth_lenauth_can_reset_password) ? $this->_oauth_config->auth_lenauth_can_reset_password : false;
    }

    /**
     * Generate a valid urlencoded data to use it for cURL request
     *
     * @param  array $array
     * @return string with data for cURL request
     */
    protected function generateQueryData(array $array)
    {

        $query_array = [];
        foreach ($array as $key => $key_value) {
            $query_array[] = urlencode($key) . '=' . urlencode($key_value);
        }
        return join('&', $query_array);
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#loginpage_hook.28.29
     *
     * Hook for overriding behaviour of login page.
     * Another auth hook. Process login if $authorizationCode is defined in OAuth url.
     * Makes cURL POST/GET request to social webservice and fill response data to Moodle user.
     * We check access tokens in cookies, if the ones exists - get it from $_COOKIE, if no - setcookie
     *
     * @uses $SESSION, $CFG, $DB core global objects/variables
     * @return void or @moodle_exception if OAuth request returns error or fail
     *
     * @author Igor Sazonov ( @tigusigalpa )
     */
    function loginpage_hook()
    {
        global $SESSION, $CFG, $DB;
        
        $accessToken = false;
        $authorizationCode = optional_param('oauthcode', '', PARAM_TEXT); // get authorization code from url
        if (!empty($authorizationCode)) {
            $authProvider = required_param('authprovider', PARAM_TEXT); // get authorization provider (webservice name)
            @setcookie('auth_lenauth_authprovider', $authProvider, time() + 604800, '/');
            $hackAuthProvider = ($authProvider == 'yahoo1' || $authProvider == 'yahoo2') ? 'yahoo' : $authProvider;
            $config_field_str = 'auth_lenauth_' . $hackAuthProvider . '_social_id_field';
            $this->_field_shortname = $this->_oauth_config->$config_field_str;
            $this->_field_id = $this->_lenauth_get_fieldid();

            $params = $curlOptions = [];
            $encodeParams = $code = $redirectURI = true;
            $curlHeader = false;
            
            //if we have access_token in $_COOKIE, so do not need to make request fot the one
            $this->send_oauth_request = !isset($_COOKIE[$authProvider]['access_token']);
            
            //if service is not enabled, why should we make request? hack protect. maybe
            $enabledStr = 'auth_lenauth_' . $hackAuthProvider . '_enabled';
            if (empty($this->_oauth_config->$enabledStr)) {
                throw new \moodle_exception('Service not enabled in your LenAuth Settings', 'auth_lenauth');
            }
            switch ($authProvider) {
                case 'facebook':
                    /**
                     * @link https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0#exchangecode
                     */
                    $params['client_id'] = $this->_oauth_config->auth_lenauth_facebook_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_facebook_app_secret;
                    break;
                case 'google':
                    /**
                     * @link https://developers.google.com/accounts/docs/OAuth2Login#exchangecode
                     */
                    $params['client_id']     = $this->_oauth_config->auth_lenauth_google_client_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_google_client_secret;
                    $params['grant_type']    = $this->settings[$authProvider]['grant_type'];
                    break;
                case 'yahoo1':
                    if (!isset($_COOKIE[$authProvider]['access_token']) &&
                        !isset($_COOKIE[$authProvider]['oauth_verifier'])) {
                        $params = array_merge(
                            $this->yahooRequestArray($this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&'),
                            ['oauth_callback' => $this->redirectURI($authProvider)]
                        );
                        $code = $redirectURI = false;
                        $this->send_oauth_request = (isset($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'])) ? false : true;
                        $OAuthVerifier = false;
                        // yahoo =))
                        if (!$this->send_oauth_request && isset($SESSION->yahoo_expires) && !empty($SESSION->yahoo_expires)) {
                            $accessToken = $SESSION->yahoo_access_token = optional_param('oauth_token', '', PARAM_TEXT);
                            setcookie($authProvider . '[access_token]', $accessToken, time() + $SESSION->yahoo_expires/*, '/'*/);
                            $OAuthVerifier = $SESSION->yahoo_oauth_verifier = optional_param('oauth_verifier', '', PARAM_TEXT);
                            setcookie($authProvider . '[oauth_verifier]', $OAuthVerifier, time() + $SESSION->yahoo_expires/*, '/'*/);
                        } else {
                        }
                    } else {
                        $this->send_oauth_request = false;
                    }
                    break;
                case 'yahoo2':
                    $params['grant_type']    = $this->settings[$authProvider]['grant_type'];
                    $curlOptions = [
                        'USERPWD' => $this->_oauth_config->auth_lenauth_yahoo_consumer_key . ':' . $this->_oauth_config->auth_lenauth_yahoo_consumer_secret
                    ];
                    break;
                case 'twitter':
                    if (!empty($this->_oauth_config->auth_lenauth_twitter_enabled)) {
                        if (!isset($_COOKIE[$authProvider]['access_token'])) {
                            $params = array_merge(
                                $this->twitterRequestArray($this->_oauth_config->auth_lenauth_twitter_consumer_secret . '&'),
                                ['oauth_callback' => $this->redirectURI($authProvider)]
                            );
                            $code = $redirectURI = false;
                            
                            $this->send_oauth_request = (isset($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'])) ? false : true;
                            $OAuthVerifier = false;
                            if (!$this->send_oauth_request && isset($_COOKIE[$authProvider]['oauth_token_secret'])) {
                                $accessToken = $SESSION->twitter_access_token
                                    = optional_param('oauth_token', '', PARAM_TEXT);
                                setcookie($authProvider . '[access_token]', $accessToken, time()
                                    + $this->settings[$authProvider]['expire'], '/');
                                $OAuthVerifier = $SESSION->twitter_oauth_verifier
                                    = optional_param('oauth_verifier', '', PARAM_TEXT);
                                setcookie($authProvider . '[oauth_verifier]', $OAuthVerifier, time()
                                    + $this->settings[$authProvider]['expire'], '/');
                            } else {
                                $curlHeader = $this->setTwitterHeader($params);
                            }
                            
                            //$curlHeader = $this->setTwitterHeader($params, $accessToken/*, $OAuthTokenSecret = false*/);
                            /*$curlOptions = [
                                'CURLOPT_RETURNTRANSFER' => true,
                                'CURLOPT_FOLLOWLOCATION' => true
                            ];
                            if (!empty($params['oauth_callback'])) {
                                $curlOptions['CURLOPT_POSTFIELDS'] = http_build_query([]);
                            }*/
                            //TWITTER IS GOOD!!
                            $encodeParams = false;
                        } else {
                            $this->send_oauth_request = false;
                        }
                    }
                    break;
                case 'vk':
                    /**
                     * @link http://vk.com/dev/auth_sites
                     */
                    $params['client_id'] = $this->_oauth_config->auth_lenauth_vk_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_vk_app_secret;
                    break;
                case 'yandex':
                    $params['grant_type'] = $this->settings[$authProvider]['grant_type'];
                    $params['client_id'] = $this->_oauth_config->auth_lenauth_yandex_app_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_yandex_app_password;
                    break;
                case 'mailru':
                    $params['client_id'] = $this->_oauth_config->auth_lenauth_mailru_site_id;
                    $params['client_secret'] = $this->_oauth_config->auth_lenauth_mailru_client_secret;
                    $params['grant_type'] = $this->settings[$authProvider]['grant_type'];
                    break;
                //odnoklassniki.ru was wrote by school programmers at 1st class and it not used mojority. bye-bye!
                /*case 'ok':
                    $params['client_id']     = $this->_oauth_config->ok_app_id;
                    $params['client_secret'] = $this->_oauth_config->ok_secret_key;
                    break;*/
                default: // if authorization provider is wrong
                    throw new \moodle_exception('Unknown OAuth Provider', 'auth_lenauth');
            }
            // url for catch token value
            // exception for Yahoo OAuth, because it like..
            if ($code) {
                $params['code'] = $authorizationCode;
            }
            if ($redirectURI) {
                $params['redirect_uri'] = $this->redirectURI($authProvider);
            }
            //require cURL from Moodle core
            require_once $CFG->libdir . '/filelib.php';
            $curl = new \curl();
            //hack for twitter and Yahoo
            if (!empty($curlOptions) && is_array($curlOptions)) {
                $curl->setopt($curlOptions);
            }
            $curl->resetHeader(); // clean cURL header from garbage
            //Twitter and Yahoo has an own cURL headers, so let them to be!
            if (!$curlHeader) {
                $curl->setHeader('Content-Type: application/x-www-form-urlencoded');
            } else {
                $curl->setHeader($curlHeader);
            }
            $curlTokensValues = $xOAuthRequestAuthURL = $OAuthVerifier = '';
            // cURL REQUEST for tokens if we hasnt it in $_COOKIE
            if ($this->send_oauth_request) {
                switch ($this->curl_type) {
                    case 'post':
                        $curlTokensValues = $curl->post(
                            $this->settings[$authProvider]['request_token_url'],
                            //hack for twitter
                            $encodeParams ? $this->generateQueryData($params) : $params
                        break;
                    case 'get':
                        $curlTokensValues = $curl->get(
                            $this->settings[$authProvider]['request_token_url'] . '?' .
                            ($encodeParams ? $this->generateQueryData($params) : $params)
                        );
                        break;
                }
            }
            // check for token response
            if (!empty($curlTokensValues) || !$this->send_oauth_request) {
                $tokenValues  = [];
                // parse token values
                switch ($authProvider) {
                    case 'facebook':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            parse_str($curlTokensValues, $tokenValues);
                            $expires       = $tokenValues['expires']; //5183999 = 2 months
                            $accessToken  = $tokenValues['access_token'];
                            if (!empty($expires) && !empty($accessToken)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                            } else {
                                throw new \moodle_exception('Can not get access for "access_token" 
                                or/and "expires" params after request', 'auth_lenauth');
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'google':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            $tokenValues = json_decode($curlTokensValues, true);
                            $expires = $tokenValues['expires_in']; //3600 = 1 hour
                            $accessToken = $tokenValues['access_token'];
                            if (!empty($accessToken) && !empty($expires)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                            } else {
                                throw new \moodle_exception('Can not get access for "access_token" 
                                or/and "expires" params after request', 'auth_lenauth');
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'yahoo1':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['oauth_token_secret'])) {
                            parse_str($curlTokensValues, $tokenValues);
                            $expires = $SESSION->yahoo_expires = $tokenValues['oauth_expires_in']; //3600 = 1 hour
                            $accessToken = $SESSION->yahoo_access_token = $tokenValues['oauth_token'];
                            setcookie($authProvider . '[oauth_token_secret]', $tokenValues['oauth_token_secret'],
                                time() + $SESSION->yahoo_expires/*, '/'*/);
                            $xOAuthRequestAuthURL = $tokenValues['xoauth_request_auth_url'];
                        } else {
                            if ((isset($_COOKIE[$authProvider]['access_token'],
                                    $_COOKIE[$authProvider]['oauth_verifier'])) || isset($SESSION->yahoo_access_token,
                                    $SESSION->yahoo_oauth_verifier)) {
                                $accessToken = ( isset($_COOKIE[$authProvider]['access_token']) ) ? $_COOKIE[$authProvider]['access_token'] : $SESSION->yahoo_access_token;
                                $OAuthVerifier = ( isset($_COOKIE[$authProvider]['oauth_verifier']) ) ? $_COOKIE[$authProvider]['oauth_verifier'] : $SESSION->yahoo_oauth_verifier;
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'yahoo2':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            $tokenValues  = json_decode($curlTokensValues, true);
                            $expires       = $tokenValues['expires_in']; //3600 = 1 hour
                            $accessToken  = $tokenValues['access_token'];
                            $refresh_token = $tokenValues['refresh_token'];
                            $userId       = $tokenValues['xoauth_yahoo_guid'];
                            if (!empty($expires) && !empty($accessToken)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                                if (!empty($userId)) {
                                    setcookie($authProvider . '[user_id]', $userId, time() + $expires, '/');
                                }
                            } else {
                                throw new \moodle_exception('Can not get access for "access_token" 
                                or/and "expires" params after request', 'auth_lenauth');
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'], $_COOKIE[$authProvider]['user_id'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                                $userId = $_COOKIE[$authProvider]['user_id'];
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'twitter':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['oauth_token_secret'])) {
                            parse_str($curlTokensValues, $tokenValues);
                            $accessToken = $SESSION->twitter_access_token = $tokenValues['oauth_token'];
                            setcookie($authProvider . '[oauth_token_secret]', $tokenValues['oauth_token_secret'],
                                time() + $this->settings[$authProvider]['expire'], '/');
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'], $_COOKIE[$authProvider]['oauth_token_secret']) || isset($SESSION->twitter_access_token, $SESSION->twitter_oauth_verifier)) {
                                $accessToken = isset($_COOKIE[$authProvider]['access_token']) ? $_COOKIE[$authProvider]['access_token'] : $SESSION->twitter_access_token;
                                $OAuthVerifier = (isset($_COOKIE[$authProvider]['oauth_verifier'])) ? $_COOKIE[$authProvider]['oauth_verifier'] : $SESSION->twitter_oauth_verifier;
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'vk':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            $tokenValues  = json_decode($curlTokensValues, true);
                            if (isset($tokenValues['error'])) {
                                throw new \moodle_exception('Native VK Error ' . $tokenValues['error'] . ( isset($tokenValues['error_description']) ? ' with description: ' . $tokenValues['error_description'] : '' ), 'auth_lenauth');
                            }
                            $expires      = $tokenValues['expires_in']; //86400 = 24 hours
                            $accessToken  = $tokenValues['access_token'];
                            if (!empty($accessToken) && !empty($expires)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                            }
                            
                            $userId = $tokenValues['user_id'];
                            if (!empty($userId)) {
                                setcookie($authProvider . '[user_id]', $userId, time() + $expires, '/');
                            }
                            /**
                             * VK user may do not enter email, soooo =((
                             */
                            $userEmail = (isset($tokenValues['email'])) ? $tokenValues['email'] : false; // WOW!!! So early???))) Awesome!
                            if (!empty($userEmail)) {
                                setcookie($authProvider . '[user_email]', $userEmail, time() + $expires, '/');
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'], $_COOKIE[$authProvider]['user_id'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                                $userId = $_COOKIE[$authProvider]['user_id'];
                                if (isset($_COOKIE[$authProvider]['user_email'])) {
                                    $userEmail = $_COOKIE[$authProvider]['user_email'];
                                }
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'yandex':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            $tokenValues = json_decode($curlTokensValues, true);
                            $expires = $tokenValues['expires_in']; //31536000 = 1 year
                            $accessToken = $tokenValues['access_token'];
                            if (!empty($expires) && !empty($accessToken)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                            } else {
                                throw new \moodle_exception('Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth');
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    case 'mailru':
                        if ($this->send_oauth_request || !isset($_COOKIE[$authProvider]['access_token'])) {
                            $tokenValues = json_decode($curlTokensValues, true);
                            $expires = $tokenValues['expires_in']; //86400 = 24 hours
                            $accessToken = $tokenValues['access_token'];
                            if (!empty($expires) && !empty($accessToken)) {
                                setcookie($authProvider . '[access_token]', $accessToken, time() + $expires, '/');
                            } else {
                                //check native errors if exists
                                if (isset($tokenValues['error'])) {
                                    switch ($tokenValues['error']) {
                                        case 'invalid_client':
                                            throw new \moodle_exception('Mail.RU invalid OAuth settings. Check your Private Key and Secret Key', 'auth_lenauth');
                                        default:
                                            throw new \moodle_exception('Mail.RU Unknown Error with code: ' . $tokenValues['error']);
                                    }
                                }
                                if (empty($expires) || empty($accessToken)) {
                                    throw new \moodle_exception('Can not get access for "access_token" or/and "expires" params after request', 'auth_lenauth');
                                }
                            }
                        } else {
                            if (isset($_COOKIE[$authProvider]['access_token'])) {
                                $accessToken = $_COOKIE[$authProvider]['access_token'];
                            } else {
                                throw new \moodle_exception('Someting wrong, maybe expires', 'auth_lenauth');
                            }
                        }
                        break;
                    /*case 'ok':
                        $tokenValues  = json_decode( $curlTokensValues, true );
                        $accessToken  = $tokenValues['access_token'];
                        break;*/
                    default:
                        throw new \moodle_exception('Unknown OAuth Provider', 'auth_lenauth');
                }
            }

            if (!empty($accessToken)) {
                $queryParams = []; // array to generate data for final request to get user data
                $requestAPIURL = $this->settings[$authProvider]['request_api_url'];
                
                //some services check accounts for verifier, so we will check it too. No unverified accounts, only verified! only hardCORE!
                $isVerified = true;
                $imageURL = '';

                switch ($authProvider) {
                    case 'facebook':
                        $queryParams['access_token'] = $accessToken;
                        $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);

                        $socialUID = $curlFinalData['id'];
                        $userEmail = $curlFinalData['email'];
                        $firstName = $curlFinalData['first_name'];
                        $lastName = $curlFinalData['last_name'];
                        $isVerified = $curlFinalData['verified'];
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = 'http://graph.facebook.com/' . $socialUID . '/picture';
                        }
                        break;
                    
                    /**
                     * @link https://developers.google.com/accounts/docs/OAuth2Login#obtaininguserprofileinformation
                     */
                    case 'google':
                        $queryParams['access_token'] = $accessToken;
                        $queryParams['alt'] = 'json';
                        $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);
                        if (isset($curlFinalData['error'])) {
                            if (!empty($curlFinalData['error']['errors']) && is_array($curlFinalData['error']['errors'])) {
                                foreach ($curlFinalData['error']['errors'] as $error) {
                                    throw new \moodle_exception('Native Google error. Message: ' . $error['message'], 'auth_lenauth');
                                }
                            } else {
                                throw new \moodle_exception('Native Google error', 'auth_lenauth');
                            }
                        }
                        
                        $socialUID = $curlFinalData['id'];
                        $userEmail = $curlFinalData['emails'][0]['value'];
                        $firstName = $curlFinalData['name']['givenName'];
                        $lastName = $curlFinalData['name']['familyName'];
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = isset($curlFinalData['image']['url']) ? $curlFinalData['image']['url'] : '';
                        }
                        break;
                    
                    case 'yahoo1':
                        if (!$OAuthVerifier) {
                            header('Location: ' . $xOAuthRequestAuthURL); // yahoo =))
                            die;
                        }
                        $queryParams1 = array_merge(
                            $this->yahooRequestArray($this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $_COOKIE[$authProvider]['oauth_token_secret']),
                            [
                                'oauth_token'    => $accessToken,
                                'oauth_verifier' => $OAuthVerifier,
                            ]
                        );
                        $curlResponsePre = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams1));
                        parse_str($curlResponsePre, $values);
                        $queryParams2 = array_merge(
                            $this->yahooRequestArray($this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $values['oauth_token_secret']),
                            [
                                'oauth_token' => $values['oauth_token'],
                                'oauth_session_handle' => $values['oauth_session_handle'],
                            ]
                        );
                        $yetAnother = $curl->post($requestAPIURL . '?' . $this->generateQueryData($queryParams2));
                        parse_str($yetAnother, $yetAnotherValues);
                        $params = [
                            'q' => 'SELECT * FROM social.profile where guid="' . $yetAnotherValues['xoauth_yahoo_guid'] . '"',
                            'format' => 'json',
                            'env' => 'http://datatables.org/alltables.env',
                        ];
                        $authArray = array_merge(
                            $this->yahooRequestArray($this->_oauth_config->auth_lenauth_yahoo_consumer_secret . '&' . $yetAnotherValues['oauth_token_secret']),
                            [
                                'realm' => 'yahooapis.com',
                                'oauth_token' => $yetAnotherValues['oauth_token'],
                            ]
                        );
                        $header = '';
                        foreach ($authArray as $key => $value) {
                            $header .= ($header === '' ? ' ' : ',') . $this->urlEncodeRfc3986($key) . '="' . $this->urlEncodeRfc3986($value) . '"';
                        }
                        $curl->setHeader([
                            'Expect:',
                            'Accept: application/json',
                            'Authorization: OAuth ' . $header,
                        ]);
                        $curlResponse = $curl->post(
                            $this->settings[$authProvider]['yql_url'] . '?' . $this->generateQueryData($params)
                        );
                        $curlFinalData = json_decode($curlResponse, true);
                        $socialUID = $curlFinalData['query']['results']['profile']['guid'];
                        $emails = $curlFinalData['query']['results']['profile']['emails'];
                        if (!empty($emails) && is_array($emails)) {
                            foreach ($emails as $emailArray) {
                                $userEmail = $emailArray['handle'];
                                if (isset($emailArray['primary'])) {
                                    break;
                                }
                            }
                        }
                        $firstName = $curlFinalData['query']['results']['profile']['givenName'];
                        $lastName = $curlFinalData['query']['results']['profile']['familyName'];
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = isset($curlFinalData['query']['results']['profile']['image']['imageUrl'])
                                ? $curlFinalData['query']['results']['profile']['image']['imageUrl'] : '';
                        }
                        break;
                        
                    case 'yahoo2':
                        $requestAPIURL = 'https://social.yahooapis.com/v1/user/' . $userId . '/profile?format=json';
                        $queryParams['access_token'] = $accessToken;
                        $nowHeader = [
                            'Authorization: Bearer ' . $accessToken,
                            'Accept: application/json',
                            'Content-Type: application/json',
                        ];
                        $curl->resetHeader();
                        $curl->setHeader($nowHeader);
                        $curlResponse = $curl->get($requestAPIURL, $queryParams);
                        $curl->resetHeader();
                        $curlFinalData = json_decode($curlResponse, true);
                        $socialUID = $curlFinalData['profile']['guid'];
                        $emails = $curlFinalData['profile']['emails'];
                        if (!empty($emails) && is_array($emails)) {
                            foreach ($emails as $emailArray) {
                                $userEmail = $emailArray['handle'];
                                if (isset($emailArray['primary'])) {
                                    break;
                                }
                            }
                        }
                        $firstName = $curlFinalData['profile']['givenName'];
                        $lastName = $curlFinalData['profile']['familyName'];
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = isset($curlFinalData['profile']['image']['imageUrl'])
                                ? $curlFinalData['profile']['image']['imageUrl'] : '';
                        }
                        break;
                    case 'twitter':
                        if (!$OAuthVerifier) {
                            header('Location: ' . $this->settings[$authProvider]['request_api_url'] . '?'
                                . http_build_query(['oauth_token' => $accessToken]));
                            die;
                        }
                        $queryParams = array_merge(
                            $this->twitterRequestArray(),
                            [
                                'oauth_verifier' => $OAuthVerifier,
                                'oauth_token' => $accessToken,
                                'oauth_token_secret' => $_COOKIE[$authProvider]['oauth_token_secret']
                            ]
                        );
                        $curlHeader = $this->setTwitterHeader($queryParams, $accessToken,
                            $_COOKIE[$authProvider]['oauth_token_secret']);
                        $curl->setHeader($curlHeader);
                        $curlFinalDataPre = $curl->post(
                            $this->settings[$authProvider]['token_url'],
                            $queryParams
                        );
                        $json_decoded = json_decode($curlFinalDataPre, true);
                        if (isset($json_decoded['error']) && isset($json_decoded['request'])) {
                            throw new \moodle_exception('Native Twitter Error: ' . $json_decoded['error']
                                . '. For request ' . $json_decoded['request'], 'auth_lenauth');
                        }
                        parse_str($curlFinalDataPre, $curlFinalData);
                        $socialUID = $curlFinalData['user_id'];
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL_pre = 'https://twitter.com/' . $curlFinalData['screen_name'] . '/profile_image?size=original';
                            $imageHeader = get_headers($imageURL_pre, 1);
                            $imageURL = $imageHeader['location'];
                        }
                        break;
                    case 'vk':
                        /**
                         * @link http://vk.com/dev/api_requests
                         */
                        $queryParams['access_token'] = $accessToken;
                        $queryParams['user_id'] = !empty($userId) ? $userId : false;
                        $queryParams['v'] = self::$vk_api_version;
                        $curlResponse = $curl->post($requestAPIURL, $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);
                        $socialUID = $queryParams['user_id'];
                        /**
                         * If user_email is empty, its not so scare, because its second login and
                         */
                        $userEmail = isset($userEmail) ? $userEmail : false; //hack, because VK has bugs sometimes
                        $firstName = $curlFinalData['response'][0]['first_name'];
                        $lastName = $curlFinalData['response'][0]['last_name'];
                        /**
                         * @link http://vk.com/dev/users.get
                         */
                        $fieldsArray = ['avatar' => 'photo_200'];
                        $additionalFieldsPre = $curl->get('http://api.vk.com/method/users.get?user_ids='
                            . $socialUID . '&fields=' . join(',', $fieldsArray));
                        $additionalFields = json_decode($additionalFieldsPre, true);
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = isset($additionalFields['response'][0][$fieldsArray['avatar']])
                                ? $additionalFields['response'][0][$fieldsArray['avatar']] : '';
                        }
                        break;
                    /**
                     * @link http://api.yandex.ru/oauth/doc/dg/reference/accessing-protected-resource.xml
                     * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
                     */
                    case 'yandex':
                        $queryParams['format'] = $this->settings[$authProvider]['format'];
                        $queryParams['oauth_token'] = $accessToken;
                        $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);
                        $socialUID = $curlFinalData['id'];
                        $userEmail = $curlFinalData['default_email'];
                        $firstName = $curlFinalData['first_name'];
                        $lastName = $curlFinalData['last_name'];
                        $nickname = $curlFinalData['display_name']; //for future
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            /**
                             * @link https://tech.yandex.ru/passport/doc/dg/reference/response-docpage/#norights_5
                             */
                            $yandexAvatarSize = 'islands-200';
                            if (isset($curlFinalData['default_avatar_id'])) {
                                $imageURL = 'https://avatars.yandex.net/get-yapic/'
                                    . $curlFinalData['default_avatar_id'] . '/' . $yandexAvatarSize;
                            }
                        }
                        break;
                    case 'mailru':
                        $queryParams['app_id'] = $params['client_id'];
                        $secretKey = $params['client_secret'];
                        /**
                         * @link http://api.mail.ru/docs/reference/rest/users-getinfo/
                         */
                        $queryParams['method'] = 'users.getInfo';
                        $queryParams['session_key'] = $accessToken;
                        $queryParams['secure'] = 1;
                        /**
                         * Additional security from mail.ru
                         * @link http://api.mail.ru/docs/guides/restapi/#sig
                         */
                        ksort($queryParams);
                        $sig = '';
                        foreach ($queryParams as $k => $v) {
                            $sig .= "{$k}={$v}";
                        }
                        $queryParams['sig'] = md5($sig . $secretKey);
                        $curlResponse = $curl->post($requestAPIURL, $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);

                        $socialUID = $curlFinalData[0]['uid'];
                        $userEmail = $curlFinalData[0]['email'];
                        $firstName = $curlFinalData[0]['first_name'];
                        $lastName = $curlFinalData[0]['last_name'];
                        $isVerified = $curlFinalData[0]['is_verified'];
                        $birthday = $curlFinalData[0]['birthday']; //dd.mm.YYYY
                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            $imageURL = isset($curlFinalData[0]['pic_big']) ? $curlFinalData[0]['pic_big'] : '';
                        }
                        break;
                    /*case 'ok':
                        $queryParams['access_token'] = $accessToken;
                        $queryParams['method'] = 'users.getCurrentUser';
                        $queryParams['sig'] = md5('application_key=' . $this->_oauth_config->ok_public_key . 'method=' . $queryParams['method'] . md5($queryParams['access_token'] . $this->_oauth_config->ok_secret_key));
                        $queryParams['application_key'] = $this->_oauth_config->ok_public_key;
                        $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                        $curlFinalData = json_decode($curlResponse, true);

                        $firstName = $curlFinalData['first_name'];
                        $lastName = $curlFinalData['last_name'];
                        $socialUID = $curlFinalData['uid'];
                        break;*/
                    default:
                        throw new \moodle_exception('Unknown OAuth Provider', 'auth_lenauth');
                }
                //development mode
                if ($this->cfg->debugdeveloper == 1 && $this->_oauth_config->auth_lenauth_dev_mode) {
                    throw new \moodle_exception('lenauth_debug_info_not_error', 'auth_lenauth', '', 'AUTHPROVIDER: ' . $authProvider . ' >>>>>REQUEST:' . http_build_query($queryParams, '', '<--->') . ' >>>>>RESPONSE: ' . http_build_query($curlFinalData, '', ' <---> '));
                }
                /**
                 * Check for email returned by webservice. If exist - check for user with this email in Moodle Database
                 */
                if (!empty($curlFinalData)) {
                    if (!empty($socialUID)) {
                        if ($isVerified) {
                            if (!empty($userEmail)) {
                                if ($err = email_is_not_allowed($userEmail)) {
                                    throw new \moodle_exception($err, 'auth_lenauth');
                                }
                                $userLenAuth = $this->db->get_record(
                                    'user',
                                    [
                                        'email' => $userEmail,
                                        'deleted' => 0,
                                        'mnethostid' => $this->cfg->mnet_localhost_id,
                                    ]
                                );
                            } else {
                                if (empty($userLenAuth)) {
                                    $userLenAuth = $this->getUserDataBySocialId($socialUID);
                                }
                                /*if (empty($userLenAuth)) {
                                    $userLenAuth = $this->db->get_record('user', array('username' => $userName, 'deleted' => 0, 'mnethostid' => $CFG->mnet_localhost_id));
                                }*/
                            }
                        } else {
                            throw new \moodle_exception('Your social account is not verified', 'auth_lenauth');
                        }
                    } else {
                        throw new \moodle_exception('Empty Social UID', 'auth_lenauth');
                    }
                } else {
                    /**
                     * addon @since 24.12.2014
                     * I forgot about clear $_COOKIE, thanks again for Yandex Tech Team guys!!!
                     */
                    @setcookie($authProvider, null, time() - 3600);
                    throw new \moodle_exception('Final request returns nothing', 'auth_lenauth');
                }
                $lastUserNumber = intval($this->_oauth_config->auth_lenauth_last_user_number);
                $lastUserNumber = empty($lastUserNumber) ? 1 : $lastUserNumber + 1;
                //$userName = $this->_oauth_config->auth_lenauth_user_prefix . $lastUserNumber; //@todo
                /**
                 * If user with email from webservice not exists, we will create an account
                 */
                if (empty($userLenAuth)) {
                    $userName = $this->_oauth_config->auth_lenauth_user_prefix . $lastUserNumber;
                    //check for username exists in DB
                    $userLenAuth_check = $this->db->get_record('user', ['username' => $userName]);
                    $i_check = 0;
                    while (!empty($userLenAuth_check)) {
                        $userLenAuth_check = $userLenAuth_check + 1;
                        $userName = $this->_oauth_config->auth_lenauth_user_prefix . $lastUserNumber;
                        $userLenAuth_check = $DB->get_record('user', ['username' => $userName]);
                        $i_check++;
                        if ($i_check > 20) {
                            throw new \moodle_exception('Something wrong with usernames of LenAuth users. Limit of 20 queries is out. Check last mdl_user table of Moodle', 'auth_lenauth');
                        }
                    }
                    // create user HERE
                    $userLenAuth = create_user_record($userName, '', 'lenauth');
                    /**
                     * User exists...
                     */
                } else {
                    $userName = $userLenAuth->username;
                }
                set_config('auth_lenauth_last_user_number', $lastUserNumber, 'auth/lenauth');
                if (!empty($socialUID)) {
                    $user_social_uid_custom_field = new \stdClass();
                    $user_social_uid_custom_field->userid = $userLenAuth->id;
                    $user_social_uid_custom_field->fieldid = $this->_field_id;
                    $user_social_uid_custom_field->data = $socialUID;
                    if (!$DB->record_exists('user_info_data', ['userid' => $userLenAuth->id, 'fieldid' => $this->_field_id])) {
                        $DB->insert_record('user_info_data', $user_social_uid_custom_field);
                    } else {
                        $record = $this->db->get_record('user_info_data', ['userid' => $userLenAuth->id, 'fieldid' => $this->_field_id]);
                        $user_social_uid_custom_field->id = $record->id;
                        $this->db->update_record('user_info_data', $user_social_uid_custom_field);
                    }
                }

                //add_to_log( SITEID, 'auth_lenauth', '', '', $userName . '/' . $userEmail . '/' . $userid );

                // complete Authenticate user
                authenticate_user_login($userName, null);

                // fill $newUser object with response data from webservices
                $newUser = new \stdClass();
                if (!empty($userEmail)) {
                    $newUser->email = $userEmail;
                }
                if (!empty($firstName)) {
                    $newUser->firstname = $firstName;
                }
                if (!empty($lastName)) {
                    $newUser->lastname = $lastName;
                }
                if (!empty($this->_oauth_config->auth_lenauth_default_country)) {
                    $newUser->country = $this->_oauth_config->auth_lenauth_default_country;
                }
                if ($userLenAuth) {
                    if ($userLenAuth->suspended == 1) {
                        throw new \moodle_exception('auth_lenauth_user_suspended', 'auth_lenauth');
                    }
                    // update user record
                    if (!empty($newUser)) {
                        $newUser->id = $userLenAuth->id;
                            /*require_once( $CFG->libdir . '/gdlib.php' );

                            $fs = get_file_storage();
                            $file_obj = $fs->create_file_from_url( array(
                                'contextid' => context_user::instance( $newUser->id, MUST_EXIST )->id,
                                'component' => 'user',
                                'filearea'  => 'icon',
                                'itemid'    => 0,
                                'filepath'  => '/',
                                'source'    => '',
                                'filename'  => 'f' . $newUser->id . '.' . $ext
                            ), $imageURL );
                            //$newUser->picture = $file_obj->get_id();*/

                        $userLenAuth = (object) array_merge((array) $userLenAuth, (array) $newUser);
                        $this->db->update_record('user', $userLenAuth);

                        if ($this->_oauth_config->auth_lenauth_retrieve_avatar) {
                            //processing user avatar from social webservice
                            if (!empty($imageURL) && intval($userLenAuth->picture) === 0) {
                                $imageHeader = get_headers($imageURL, 1);
                                if (isset($imageHeader['Content-Type'])
                                    && is_string($imageHeader['Content-Type'])
                                    && in_array($imageHeader['Content-Type'], array_keys(self::$allowed_icons_types)) ) {
                                    $mime = $imageHeader['Content-Type'];
                                } else {
                                    // >>> @ Shaposhnikov D.
                                    foreach ($imageHeader['Content-Type'] as $ct) {
                                        if (!empty($ct)
                                            && is_string($ct)
                                            && in_array($ct, array_keys(self::$allowed_icons_types)) ) {
                                                $mime = $ct;
                                                break;
                                        }
                                    }
                                    // <<<
                                }
                                $ext = $this->getImageExtensionFromMime($mime);
                                if ($ext) {
                                    //create temp file
                                    $tempFileName = substr(microtime(), 0, 10) . '.tmp';
                                    $templFolder = $this->cfg->tempdir . '/filestorage';
                                    if (!file_exists($templFolder)) {
                                        mkdir($templFolder, $this->cfg->directorypermissions);
                                    }
                                    @chmod($templFolder, 0777);
                                    $tempfile = $templFolder . '/' . $tempFileName;
                                    if (copy($imageURL, $tempfile)) {
                                        require_once $this->cfg->libdir . '/gdlib.php';
                                        $userIconId = process_new_icon(\context_user::instance($newUser->id, MUST_EXIST), 'user', 'icon', 0, $tempfile);
                                        if ($userIconId) {
                                            $this->db->set_field('user', 'picture', $userIconId, ['id' => $newUser->id]);
                                        }
                                        unset($tempfile);
                                    }
                                    @chmod($templFolder, $CFG->directorypermissions);
                                }
                            }
                        }
                    }

                    complete_user_login($userLenAuth); // complete user login

                    // Redirection
                    $urltogo = $CFG->wwwroot;
                    if (user_not_fully_set_up($userLenAuth)) {
                        $urltogo = $CFG->wwwroot . '/user/edit.php';
                    } elseif (isset($SESSION->wantsurl) && ( strpos($SESSION->wantsurl, $CFG->wwwroot) === 0 )) {
                        $urltogo = $SESSION->wantsurl;
                        unset($SESSION->wantsurl);
                    } else {
                        unset($SESSION->wantsurl);
                    }
                }
                redirect($urltogo);
            } else {
                throw new \moodle_exception('auth_lenauth_access_token_empty', 'auth_lenauth');
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
    public function logoutpage_hook()
    {
        if (isset($_COOKIE['auth_lenauth_authprovider'])) {
            if (isset($_COOKIE[$_COOKIE['auth_lenauth_authprovider']])) {
                unset($_COOKIE[$_COOKIE['auth_lenauth_authprovider']]);
                setcookie($_COOKIE['auth_lenauth_authprovider'], null, -1, '/');
            }
            unset($_COOKIE['auth_lenauth_authprovider']);
            setcookie('auth_lenauth_authprovider', null, -1, '/');
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
    public function config_form($config, $err, $user_fields)
    {

        // set to defaults if undefined
        if (!isset($config->auth_lenauth_user_prefix)) {
            $config->auth_lenauth_user_prefix = 'lenauth_user_';
        }
        if (!isset($config->auth_lenauth_default_country)) {
            $config->auth_lenauth_default_country = '';
        }
        if (!isset($config->auth_lenauth_locale)) {
            $config->auth_lenauth_locale = 'en';
        }
        /*if ( empty( $config->can_change_password ) ) {
            $config->can_change_password = 0;
        } else {
            $config->can_change_password = 1;
        }*/
        if (empty($config->auth_lenauth_can_reset_password)) {
            $config->auth_lenauth_can_reset_password = 0;
        } else {
            $config->auth_lenauth_can_reset_password = 1;
        }
        if (empty($config->auth_lenauth_can_confirm)) {
            $config->auth_lenauth_can_confirm = 0;
        } else {
            $config->auth_lenauth_can_confirm = 1;
        }
        if (empty($config->auth_lenauth_retrieve_avatar)) {
            $config->auth_lenauth_retrieve_avatar = 0;
        } else {
            $config->auth_lenauth_retrieve_avatar = 1;
        }
        if (empty($config->auth_lenauth_dev_mode)) {
            $config->auth_lenauth_dev_mode = 0;
        } else {
            $config->auth_lenauth_dev_mode = 1;
        }
        
        if (!isset($config->auth_lenauth_display_buttons)) {
            $config->auth_lenauth_display_buttons = 'inline-block';
        }
        if (!isset($config->auth_lenauth_button_width)) {
            $config->auth_lenauth_button_width = 0;
        }
        if (!isset($config->auth_lenauth_button_margin_top)) {
            $config->auth_lenauth_button_margin_top = 10;
        }
        if (!isset($config->auth_lenauth_button_margin_right)) {
            $config->auth_lenauth_button_margin_right = 10;
        }
        if (!isset($config->auth_lenauth_button_margin_bottom)) {
            $config->auth_lenauth_button_margin_bottom = 10;
        }
        if (!isset($config->auth_lenauth_button_margin_left)) {
            $config->auth_lenauth_button_margin_left = 10;
        }
        
        if (!isset($config->auth_lenauth_display_div)) {
            $config->auth_lenauth_display_div = 'block';
        }
        if (!isset($config->auth_lenauth_div_width)) {
            $config->auth_lenauth_div_width = 0;
        }
        if (!isset($config->auth_lenauth_div_margin_top)) {
            $config->auth_lenauth_div_margin_top = 0;
        }
        if (!isset($config->auth_lenauth_div_margin_right)) {
            $config->auth_lenauth_div_margin_right = 0;
        }
        if (!isset($config->auth_lenauth_div_margin_bottom)) {
            $config->auth_lenauth_div_margin_bottom = 0;
        }
        if (!isset($config->auth_lenauth_div_margin_left)) {
            $config->auth_lenauth_div_margin_left = 0;
        }
        
        if (!isset($config->auth_lenauth_order)) {
            $order_array = $this->default_order;
        } else {
            $order_array = json_decode($config->auth_lenauth_order, true);
        }
        
        if (!isset($config->auth_lenauth_facebook_enabled)) {
            $config->auth_lenauth_facebook_enabled = 0;
        }
        if (!isset($config->auth_lenauth_facebook_app_id)) {
            $config->auth_lenauth_facebook_app_id = '';
        }
        if (!isset($config->auth_lenauth_facebook_app_secret)) {
            $config->auth_lenauth_facebook_app_secret = '';
        }
        if (!isset($config->auth_lenauth_facebook_button_text)) {
            $config->auth_lenauth_facebook_button_text = get_string('auth_lenauth_facebook_button_text_default', 'auth_lenauth');
        }
        
        if (!isset($config->auth_lenauth_google_enabled)) {
            $config->auth_lenauth_google_enabled = 0;
        }
        if (!isset($config->auth_lenauth_google_client_id)) {
            $config->auth_lenauth_google_client_id = '';
        }
        if (!isset($config->auth_lenauth_google_client_secret)) {
            $config->auth_lenauth_google_client_secret = '';
        }
        if (!isset($config->auth_lenauth_google_project_id)) {
            $config->auth_lenauth_google_project_id = '';
        }
        if (!isset($config->auth_lenauth_google_button_text)) {
            $config->auth_lenauth_google_button_text = get_string('auth_lenauth_google_button_text_default', 'auth_lenauth');
        }
        
        if (!isset($config->auth_lenauth_yahoo_enabled)) {
            $config->auth_lenauth_yahoo_enabled = 0;
        }
        if (!isset($config->auth_lenauth_yahoo_oauth_version)) {
            $config->auth_lenauth_yahoo_oauth_version = 1;
        }
        if (!isset($config->auth_lenauth_yahoo_application_id)) {
            $config->auth_lenauth_yahoo_application_id = '';
        }
        if (!isset($config->auth_lenauth_yahoo_consumer_key)) {
            $config->auth_lenauth_yahoo_consumer_key = '';
        }
        if (!isset($config->auth_lenauth_yahoo_consumer_secret)) {
            $config->auth_lenauth_yahoo_consumer_secret = '';
        }
        if (!isset($config->auth_lenauth_yahoo_button_text)) {
            $config->auth_lenauth_yahoo_button_text = get_string('auth_lenauth_yahoo_button_text_default', 'auth_lenauth');
        }
        
        if (!isset($config->auth_lenauth_twitter_enabled)) {
            $config->auth_lenauth_twitter_enabled = 0;
        }
        if (!isset($config->auth_lenauth_twitter_consumer_key)) {
            $config->auth_lenauth_twitter_consumer_key = '';
        }
        if (!isset($config->auth_lenauth_twitter_consumer_secret)) {
            $config->auth_lenauth_twitter_consumer_secret = '';
        }
        if (!isset($config->auth_lenauth_twitter_application_id)) {
            $config->auth_lenauth_twitter_application_id = '';
        }
        
        if (!isset($config->auth_lenauth_vk_enabled)) {
            $config->auth_lenauth_vk_enabled = 0;
        }
        if (!isset($config->auth_lenauth_vk_app_id)) {
            $config->auth_lenauth_vk_app_id = '';
        }
        if (!isset($config->auth_lenauth_vk_app_secret)) {
            $config->auth_lenauth_vk_app_secret = '';
        }
        if (!isset($config->auth_lenauth_vk_button_text)) {
            $config->auth_lenauth_vk_button_text = get_string('auth_lenauth_vk_button_text_default', 'auth_lenauth');
        }

        if (!isset($config->auth_lenauth_yandex_enabled)) {
            $config->auth_lenauth_yandex_enabled = 0;
        }
        if (!isset($config->auth_lenauth_yandex_app_id)) {
            $config->auth_lenauth_yandex_app_id = '';
        }
        if (!isset($config->auth_lenauth_yandex_app_password)) {
            $config->auth_lenauth_yandex_app_password = '';
        }
        if (!isset($config->auth_lenauth_yandex_button_text)) {
            $config->auth_lenauth_yandex_button_text = get_string('auth_lenauth_yandex_button_text_default', 'auth_lenauth');
        }

        if (!isset($config->auth_lenauth_mailru_enabled)) {
            $config->auth_lenauth_mailru_enabled = 0;
        }
        if (!isset($config->auth_lenauth_mailru_site_id)) {
            $config->auth_lenauth_mailru_site_id = '';
        }
        if (!isset($config->auth_lenauth_mailru_client_private)) {
            $config->auth_lenauth_mailru_client_private = '';
        }
        if (!isset($config->auth_lenauth_mailru_client_secret)) {
            $config->auth_lenauth_mailru_client_secret = '';
        }
        if (!isset($config->auth_lenauth_mailru_button_text)) {
            $config->auth_lenauth_mailru_button_text = get_string('auth_lenauth_mailru_button_text_default', 'auth_lenauth');
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

        print_auth_lock_options('lenauth', $user_fields, get_string('auth_fieldlocks_help', 'auth'), false, false);
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#process_config.28.24config.29
     * Processes and stores configuration data for this authentication plugin.
     *
     * @param  object $config
     * @access public
     * @author Igor Sazonov
     */
    public function process_config($config)
    {
        if (has_capability('moodle/user:update', \context_system::instance())) {
            // set to defaults if undefined while save
            if (!isset($config->auth_lenauth_user_prefix)) {
                $config->auth_lenauth_user_prefix = 'lenauth_user_';
            }
            if (!isset($config->auth_lenauth_default_country)) {
                $config->auth_lenauth_default_country = '';
            }
            if (!isset($config->auth_lenauth_locale)) {
                $config->auth_lenauth_locale = 'en';
            }
            /*if ( empty( $config->can_change_password ) ) {
                $config->can_change_password = 0;
            } else {
                $config->can_change_password = 1;
            }*/
            if (empty($config->auth_lenauth_can_reset_password)) {
                $config->auth_lenauth_can_reset_password = 0;
            } else {
                $config->auth_lenauth_can_reset_password = 1;
            }
            if (empty($config->auth_lenauth_can_confirm)) {
                $config->auth_lenauth_can_confirm = 0;
            } else {
                $config->auth_lenauth_can_confirm = 1;
            }
            if (empty($config->auth_lenauth_retrieve_avatar)) {
                $config->auth_lenauth_retrieve_avatar = 0;
            } else {
                $config->auth_lenauth_retrieve_avatar = 1;
            }
            if (empty($config->auth_lenauth_dev_mode)) {
                $config->auth_lenauth_dev_mode = 0;
            } else {
                $config->auth_lenauth_dev_mode = 1;
            }
            
            if (!isset($config->auth_lenauth_display_buttons)) {
                $config->auth_lenauth_display_buttons = 'inline-block';
            }
            if (!isset($config->auth_lenauth_button_width)) {
                $config->auth_lenauth_button_width = 0;
            }
            if (!isset($config->auth_lenauth_button_margin_top)) {
                $config->auth_lenauth_button_margin_top = 10;
            }
            if (!isset($config->auth_lenauth_button_margin_right)) {
                $config->auth_lenauth_button_margin_right = 10;
            }
            if (!isset($config->auth_lenauth_button_margin_bottom)) {
                $config->auth_lenauth_button_margin_bottom = 10;
            }
            if (!isset($config->auth_lenauth_button_margin_left)) {
                $config->auth_lenauth_button_margin_left = 10;
            }
            
            if (!isset($config->auth_lenauth_display_div)) {
                $config->auth_lenauth_display_div = 'block';
            }
            if (!isset($config->auth_lenauth_div_width)) {
                $config->auth_lenauth_div_width = 0;
            }
            if (!isset($config->auth_lenauth_div_margin_top)) {
                $config->auth_lenauth_div_margin_top = 0;
            }
            if (!isset($config->auth_lenauth_div_margin_right)) {
                $config->auth_lenauth_div_margin_right = 0;
            }
            if (!isset($config->auth_lenauth_div_margin_bottom)) {
                $config->auth_lenauth_div_margin_bottom = 0;
            }
            if (!isset($config->auth_lenauth_div_margin_left)) {
                $config->auth_lenauth_div_margin_left = 0;
            }
            
            if (!isset($config->auth_lenauth_order)) {
                $config->auth_lenauth_order = json_encode($this->default_order);
            }
            
            $config->auth_lenauth_facebook_enabled = !empty($config->auth_lenauth_facebook_enabled) ? 1 : 0;
            if (!isset($config->auth_lenauth_facebook_app_id)) {
                $config->auth_lenauth_facebook_app_id = '';
            }
            if (!isset($config->auth_lenauth_facebook_app_secret)) {
                $config->auth_lenauth_facebook_app_secret = '';
            }
            if (!isset($config->auth_lenauth_facebook_button_text)) {
                $config->auth_lenauth_facebook_button_text = get_string('auth_lenauth_facebook_button_text_default', 'auth_lenauth');
            }
            
            $config->auth_lenauth_google_enabled = !empty($config->auth_lenauth_google_enabled) ? 1 : 0;
            if (!isset($config->auth_lenauth_google_client_id)) {
                $config->auth_lenauth_google_client_id = '';
            }
            if (!isset($config->auth_lenauth_google_client_secret)) {
                $config->auth_lenauth_google_client_secret = '';
            }
            if (!isset($config->auth_lenauth_google_project_id)) {
                $config->auth_lenauth_google_project_id = '';
            }
            if (empty($config->auth_lenauth_google_button_text)) {
                $config->auth_lenauth_google_button_text = get_string('auth_lenauth_google_button_text_default', 'auth_lenauth');
            }
            
            $config->auth_lenauth_yahoo_enabled = !empty($config->auth_lenauth_yahoo_enabled) ? 1 : 0;
            $config->auth_lenauth_yahoo_oauth_version = !empty($config->auth_lenauth_yahoo_oauth_version) ? intval($config->auth_lenauth_yahoo_oauth_version) : 1;
            if (!isset($config->auth_lenauth_yahoo_application_id)) {
                $config->auth_lenauth_yahoo_application_id = '';
            }
            if (!isset($config->auth_lenauth_yahoo_consumer_key)) {
                $config->auth_lenauth_yahoo_consumer_key = '';
            }
            if (!isset($config->auth_lenauth_yahoo_consumer_secret)) {
                $config->auth_lenauth_yahoo_consumer_secret = '';
            }
            if (!isset($config->auth_lenauth_yahoo_button_text)) {
                $config->auth_lenauth_yahoo_button_text = get_string('auth_lenauth_yahoo_button_text_default', 'auth_lenauth');
            }
            
            $config->auth_lenauth_twitter_enabled = !empty($config->auth_lenauth_twitter_enabled) ? 1 : 0;
            if (!isset($config->auth_lenauth_twitter_consumer_key)) {
                $config->auth_lenauth_twitter_consumer_key = '';
            }
            if (!isset($config->auth_lenauth_twitter_consumer_secret)) {
                $config->auth_lenauth_twitter_consumer_secret = '';
            }
            if (!isset($config->auth_lenauth_twitter_application_id)) {
                $config->auth_lenauth_twitter_application_id = '';
            }
            if (!isset($config->auth_lenauth_twitter_button_text)) {
                $config->auth_lenauth_twitter_button_text = get_string('auth_lenauth_twitter_button_text_default', 'auth_lenauth');
            }
            
            $config->auth_lenauth_vk_enabled = ( !empty($config->auth_lenauth_vk_enabled) ) ? 1 : 0;
            if (!isset($config->auth_lenauth_vk_app_id)) {
                $config->auth_lenauth_vk_app_id = '';
            }
            if (!isset($config->auth_lenauth_vk_app_secret)) {
                $config->auth_lenauth_vk_app_secret = '';
            }
            if (empty($config->auth_lenauth_vk_button_text)) {
                $config->auth_lenauth_vk_button_text = get_string('auth_lenauth_vk_button_text_default', 'auth_lenauth');
            }

            $config->auth_lenauth_yandex_enabled = ( !empty($config->auth_lenauth_yandex_enabled) ) ? 1 : 0;
            if (!isset($config->auth_lenauth_yandex_app_id)) {
                $config->auth_lenauth_yandex_app_id = '';
            }
            if (!isset($config->auth_lenauth_yandex_app_password)) {
                $config->auth_lenauth_yandex_app_password = '';
            }
            if (!isset($config->auth_lenauth_yandex_button_text)) {
                $config->auth_lenauth_yandex_button_text = get_string('auth_lenauth_yandex_button_text_default', 'auth_lenauth');
            }

            $config->auth_lenauth_mailru_enabled = ( !empty($config->auth_lenauth_mailru_enabled) ) ? 1 : 0;
            if (!isset($config->auth_lenauth_mailru_site_id)) {
                $config->auth_lenauth_mailru_site_id = '';
            }
            if (!isset($config->auth_lenauth_mailru_client_private)) {
                $config->auth_lenauth_mailru_client_private = '';
            }
            if (!isset($config->auth_lenauth_mailru_client_secret)) {
                $config->auth_lenauth_mailru_client_secret = '';
            }
            if (!isset($config->auth_lenauth_mailru_button_text)) {
                $config->auth_lenauth_mailru_button_text = get_string('auth_lenauth_mailru_button_text_default', 'auth_lenauth');
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
            set_config('auth_lenauth_facebook_enabled', intval($config->auth_lenauth_facebook_enabled), 'auth/lenauth');
            set_config('auth_lenauth_facebook_app_id', trim($config->auth_lenauth_facebook_app_id), 'auth/lenauth');
            set_config('auth_lenauth_facebook_app_secret', trim($config->auth_lenauth_facebook_app_secret), 'auth/lenauth');
            set_config('auth_lenauth_facebook_button_text', trim($config->auth_lenauth_facebook_button_text), 'auth/lenauth');
            
            set_config('auth_lenauth_google_enabled', intval($config->auth_lenauth_google_enabled), 'auth/lenauth');
            set_config('auth_lenauth_google_client_id', trim($config->auth_lenauth_google_client_id), 'auth/lenauth');
            set_config('auth_lenauth_google_client_secret', trim($config->auth_lenauth_google_client_secret), 'auth/lenauth');
            set_config('auth_lenauth_google_project_id', trim($config->auth_lenauth_google_project_id), 'auth/lenauth');
            set_config('auth_lenauth_google_button_text', trim($config->auth_lenauth_google_button_text), 'auth/lenauth');
            
            set_config('auth_lenauth_yahoo_enabled', intval($config->auth_lenauth_yahoo_enabled), 'auth/lenauth');
            set_config('auth_lenauth_yahoo_oauth_version', intval($config->auth_lenauth_yahoo_oauth_version), 'auth/lenauth');
            set_config('auth_lenauth_yahoo_application_id', trim($config->auth_lenauth_yahoo_application_id), 'auth/lenauth');
            set_config('auth_lenauth_yahoo_consumer_key', trim($config->auth_lenauth_yahoo_consumer_key), 'auth/lenauth');
            set_config('auth_lenauth_yahoo_consumer_secret', trim($config->auth_lenauth_yahoo_consumer_secret), 'auth/lenauth');
            set_config('auth_lenauth_yahoo_button_text', trim($config->auth_lenauth_yahoo_button_text), 'auth/lenauth');

            set_config('auth_lenauth_twitter_enabled', intval($config->auth_lenauth_twitter_enabled), 'auth/lenauth');
            set_config('auth_lenauth_twitter_application_id', intval($config->auth_lenauth_twitter_application_id), 'auth/lenauth');
            set_config('auth_lenauth_twitter_consumer_key', trim($config->auth_lenauth_twitter_consumer_key), 'auth/lenauth');
            set_config('auth_lenauth_twitter_consumer_secret', trim($config->auth_lenauth_twitter_consumer_secret), 'auth/lenauth');
            set_config('auth_lenauth_twitter_button_text', trim($config->auth_lenauth_twitter_button_text), 'auth/lenauth');
            
            set_config('auth_lenauth_vk_enabled', intval($config->auth_lenauth_vk_enabled), 'auth/lenauth');
            set_config('auth_lenauth_vk_app_id', trim($config->auth_lenauth_vk_app_id), 'auth/lenauth');
            set_config('auth_lenauth_vk_app_secret', trim($config->auth_lenauth_vk_app_secret), 'auth/lenauth');
            set_config('auth_lenauth_vk_button_text', trim($config->auth_lenauth_vk_button_text), 'auth/lenauth');
            
            set_config('auth_lenauth_yandex_enabled', intval($config->auth_lenauth_yandex_enabled), 'auth/lenauth');
            set_config('auth_lenauth_yandex_app_id', trim($config->auth_lenauth_yandex_app_id), 'auth/lenauth');
            set_config('auth_lenauth_yandex_app_password', trim($config->auth_lenauth_yandex_app_password), 'auth/lenauth');
            set_config('auth_lenauth_yandex_button_text', trim($config->auth_lenauth_yandex_button_text), 'auth/lenauth');

            set_config('auth_lenauth_mailru_enabled', intval($config->auth_lenauth_mailru_enabled), 'auth/lenauth');
            set_config('auth_lenauth_mailru_site_id', intval($config->auth_lenauth_mailru_site_id), 'auth/lenauth');
            set_config('auth_lenauth_mailru_client_private', trim($config->auth_lenauth_mailru_client_private), 'auth/lenauth');
            set_config('auth_lenauth_mailru_client_secret', trim($config->auth_lenauth_mailru_client_secret), 'auth/lenauth');
            set_config('auth_lenauth_mailru_button_text', trim($config->auth_lenauth_mailru_button_text), 'auth/lenauth');

            /*set_config('ok_enabled',              intval( $config->ok_enabled ),                             'auth/lenauth');
            set_config('ok_app_id',               trim( $config->ok_app_id ),               'auth/lenauth');
            set_config('ok_public_key',           trim( $config->ok_public_key ),           'auth/lenauth');
            set_config('ok_secret_key',           trim( $config->ok_secret_key ),           'auth/lenauth');
            set_config('ok_button_text',          trim( $config->ok_button_text ),          'auth/lenauth');
            set_config('ok_social_id_field',      trim( $config->ok_social_id_field ),      'auth/lenauth');*/

            set_config('auth_lenauth_user_prefix', trim($config->auth_lenauth_user_prefix), 'auth/lenauth');
            set_config('auth_lenauth_default_country', trim($config->auth_lenauth_default_country), 'auth/lenauth');
            set_config('auth_lenauth_locale', trim($config->auth_lenauth_locale), 'auth/lenauth');
            //set_config('can_change_password',                  intval( $config->can_change_password ),              'auth/lenauth');
            set_config('auth_lenauth_can_reset_password', intval($config->auth_lenauth_can_reset_password), 'auth/lenauth');
            set_config('auth_lenauth_can_confirm', intval($config->auth_lenauth_can_confirm), 'auth/lenauth');
            set_config('auth_lenauth_retrieve_avatar', intval($config->auth_lenauth_retrieve_avatar), 'auth/lenauth');
            set_config('auth_lenauth_dev_mode', intval($config->auth_lenauth_dev_mode), 'auth/lenauth');
            
            set_config('auth_lenauth_display_buttons', trim($config->auth_lenauth_display_buttons), 'auth/lenauth');
            set_config('auth_lenauth_button_width', intval($config->auth_lenauth_button_width), 'auth/lenauth');
            set_config('auth_lenauth_button_margin_top', intval($config->auth_lenauth_button_margin_top), 'auth/lenauth');
            set_config('auth_lenauth_button_margin_right', intval($config->auth_lenauth_button_margin_right), 'auth/lenauth');
            set_config('auth_lenauth_button_margin_bottom', intval($config->auth_lenauth_button_margin_bottom), 'auth/lenauth');
            set_config('auth_lenauth_button_margin_left', intval($config->auth_lenauth_button_margin_left), 'auth/lenauth');
            
            set_config('auth_lenauth_display_div', trim($config->auth_lenauth_display_div), 'auth/lenauth');
            set_config('auth_lenauth_div_width', intval($config->auth_lenauth_div_width), 'auth/lenauth');
            set_config('auth_lenauth_div_margin_top', intval($config->auth_lenauth_div_margin_top), 'auth/lenauth');
            set_config('auth_lenauth_div_margin_right', intval($config->auth_lenauth_div_margin_right), 'auth/lenauth');
            set_config('auth_lenauth_div_margin_bottom', intval($config->auth_lenauth_div_margin_bottom), 'auth/lenauth');
            set_config('auth_lenauth_div_margin_left', intval($config->auth_lenauth_div_margin_left), 'auth/lenauth');
            
            $order_array = $this->_make_order($config->auth_lenauth_order);
            set_config('auth_lenauth_order', json_encode($order_array), 'auth/lenauth');
            return true;
        }
        throw new \moodle_exception('You do not have permissions', 'auth_lenauth');
    }
    
    /**
     * This function generate pretty (key-number=>name) array of socials order
     *
     * @param  array $order_array Orders array from $_POST config: user input for orders
     * @access private
     * @return array
     */
    private function _make_order(array $order_array)
    {
        $ret_array = [];
        foreach ($order_array as $service => $order) {
            $order = intval($order);
            while (isset($ret_array[$order])) {
                $order += 1;
            }
            $ret_array[$order] = $service;
        }
        ksort($ret_array);
        $i = 1;
        $ret_array_2 = [];
        foreach ($ret_array as $service) {
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
     * @param  object $newUser new user data
     * @uses   $USER core global object
     * @return boolean
     *
     */
    function user_update($oldUser, $newUser)
    {
        global $USER;
        if (!empty($newUser->email)) {
            $USER->email = $newUser->email;
        }
        return true;
    }

    public function urlEncodeRfc3986($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'urlEncodeRfc3986'], $input);
        }
        if (is_scalar($input)) {
            return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
        }
        return '';
    }

    /**
     * @param  $signature Signature atring
     * @return array
     */
    protected function yahooRequestArray(string $signature) : array
    {
        return [
            'oauth_consumer_key' => $this->_oauth_config->auth_lenauth_yahoo_consumer_key,
            'oauth_nonce' => md5(microtime(true) . $_SERVER['REMOTE_ADDR']),
            'oauth_signature_method' => 'PLAINTEXT',
            'oauth_timestamp' => time(),
            'oauth_version' => self::$yahoo_oauth_version,
            'oauth_signature' => $signature,
        ];
    }
    
    /**
     * This function generates array with Twitter request header
     *
     * @param array $params
     * @param bool  $OAuthToken
     * @param bool  $OAuthTokenSecret
     *
     * @return array
     */
    protected function setTwitterHeader(array $params, bool $OAuthToken = false, bool $OAuthTokenSecret = false)
    {
        if ($OAuthToken) {
            $params['oauth_token'] = $OAuthToken;
        }
        ksort($params);
        $encodedParams = [];
        foreach ($params as $key => $value) {
            $encodedParams[] = $key . '=' . $this->urlEncodeRfc3986($value);
        }
        $signature = implode('&', $this->urlEncodeRfc3986([
            strtoupper($this->curl_type),
            $this->send_oauth_request ? $this->settings['twitter']['request_token_url'] : $this->settings['twitter']['token_url'],
            implode('&', $encodedParams)
        ]));
        $params['oauth_signature'] = base64_encode(
            hash_hmac(
                'sha1',
                $signature,
                implode('&', $this->urlEncodeRfc3986(
                    [
                        $this->_oauth_config->auth_lenauth_twitter_consumer_secret,
                        $OAuthTokenSecret ? $OAuthTokenSecret : '',
                    ]
                )),
                true
            )
        );

        $header = '';
        foreach ($params as $key => $value) {
            if (preg_match('/^oauth_/', $key)) {
                $header .= ($header === '' ? ' ' : ', ') . $this->urlEncodeRfc3986($key) . '="' . $this->urlEncodeRfc3986($value) . '"';
            }
        }
        return [
            'Expect:',
            'Accept: application/json',
            'Authorization: OAuth' . $header,
        ];
    }

    protected function twitterRequestArray()
    {
        return [
            'oauth_consumer_key' => $this->_oauth_config->auth_lenauth_twitter_consumer_key,
            //'oauth_nonce' => md5( microtime( true ) . $_SERVER['REMOTE_ADDR'] ),
            'oauth_nonce' => md5(microtime(true)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => self::$twitter_oauth_version
        ];
    }
    
    protected function _lenauth_get_user_info_fields_array()
    {
        $ret = [];
        if (!empty($this->user_info_fields) && is_array($this->user_info_fields)) {
            foreach ($this->user_info_fields as $item) {
                $ret[$item->shortname] = $item->name;
            }
        }
        return $ret;
    }

    /**
     * The function gets additional field ID of specified webservice shortname from user_info_field table
     *
     * @return int
     * @throws \dml_exception
     */
    protected function _lenauth_get_fieldid()
    {
        return $this->_field_shortname ? $this->db->get_field(
            'user_info_field', 'id', ['shortname' => $this->_field_shortname]) : false;
    }
    
    /**
     * Function to generate valid redirect URI to use it without problems
     * Param $authProvider checks service we use and makes URI. Used in code for much faster work.
     *
     * @param  string $authProvider current OAuth provider
     * @param  int    provider OAuth version (ie for Yahoo)
     * @return string
     */
    protected function redirectURI(string $authProvider)
    {
        return $this->cfg->wwwroot . '/auth/lenauth/redirect.php?auth_service=' . $authProvider;
    }

    /**
     *
     * This function returns user object from Moodle database with given $socialUID param,
     * if user with this social_uid exists, function will return this user object,
     * if not - false
     *
     * @param  string $socialUID user internal ID of social webservice that comes from request
     * @return object|bool
     */
    protected function getUserDataBySocialId(string $socialUID)
    {
        $ret = false;
        if (!empty($this->_field_shortname)) {
            $ret = $this->db->get_record_sql(
                'SELECT u.* FROM {user} u
                                                    LEFT JOIN {user_info_data} uid ON u.id = uid.userid
                                                    LEFT JOIN {user_info_field} uif ON uid.fieldid = uif.id
                                                    WHERE uid.data = ?
                                                    AND uif.id = ?
                                                    AND uif.shortname = ?
                                                    AND u.deleted = ? AND u.mnethostid = ?',
                [$socialUID, $this->_field_id, $this->_field_shortname, 0, $this->cfg->mnet_localhost_id]
            );
        }
        return $ret;
    }

    /**
     * This function returns extension of web image mime type
     *
     * @param  string $mime Mime type
     * @return string If needle $mime type exists returns extension, if not - empty string
     */
    private function getImageExtensionFromMime(string $mime)
    {
        return isset(self::$allowed_icons_types[$mime]) ? self::$allowed_icons_types[$mime] : '';
    }
}
