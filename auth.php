<?php

/**
 * @author  Igor Sazonov <sovletig@gmail.com>
 * @link    http://lms-service.org/lenauth-plugin-oauth-moodle/
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version 2.0
 * @uses \auth_plugin_base core class
 *
 * Authentication Plugin: LenAuth Authentication
 * If the email doesn't exist, then the auth plugin creates the user.
 * If the email exist (and the user has for auth plugin this current one),
 * then the plugin login the user related to this email.
 */

defined('MOODLE_INTERNAL') || die();

require_once __DIR__ . '/../../auth/lenauth/autoload.php';
require_once __DIR__ . '/../../lib/authlib.php';
require_once __DIR__ . '/../../lib/formslib.php';

/**
 * LenAuth authentication plugin.
 */
class auth_plugin_lenauth extends \Tigusigalpa\Moodle\Auth\LenAuth\LenAuth
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

        $this->_oauth_config = get_config('auth_lenauth');
        
        $this->user_info_fields = $DB->get_records('user_info_field');
        $this->authtype = 'lenauth'; // define name of our authentication method
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
        return isset($this->_oauth_config->password_expire) ? $this->_oauth_config->password_expire : 0;
    }*/
    
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
}
