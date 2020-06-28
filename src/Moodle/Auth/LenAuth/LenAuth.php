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

namespace Tigusigalpa\Auth_LenAuth\Moodle\Auth\LenAuth;

defined('MOODLE_INTERNAL') || die();

class LenAuth extends \auth_plugin_base
{
    public const SETTINGS = [
        'facebook' => [
            'fields' => [
                'version' => [
                    'type' => 'select',
                    'options' => [
                        '7.0' => '7.0',
                    ],
                ],
                'app_id' => [
                    'type' => 'text',
                ],
                'app_secret' => [
                    'type' => 'password'
                ],
            ],
            /**
             * Facebook settings
             * @link https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0
             * @link https://developers.facebook.com/docs/graph-api/using-graph-api/#me
             */
            'settings' => [
                'request_api_url'   => 'https://graph.facebook.com/me',
            ],
        ],
        'google' => [
            'fields' => [
                'client_id' => [
                    'type' => 'text',
                    'paramtype' => PARAM_URL
                ],
                'client_secret' => [
                    'type' => 'password'
                ],
            ],
            /**
             * Google settings
             * @link https://developers.google.com/accounts/docs/OAuth2Login#authenticatingtheuser
             * @link https://developers.google.com/+/api/oauth
             */
            'settings' => [
                'access_token_curl' => 'post'
            ],
        ],
        'yahoo' => [
            'fields' => [
                'application_id' => [
                    'type' => 'text',
                ],
                'consumer_key' => [
                    'type' => 'text',
                ],
                'consumer_secret' => [
                    'type' => 'password'
                ],
            ],
            /**
             * Yahoo OAuth2 settings
             * @link https://developer.yahoo.com/oauth2/
             * @link https://developer.yahoo.com/oauth2/guide/
             * @link https://developer.yahoo.com/oauth2/guide/flows_authcode/
             * @link https://developer.yahoo.com/oauth2/guide/apirequests/
             */
            'settings' => [
                'request_token_url' => 'https://api.login.yahoo.com/oauth2/get_token',
                'request_api_url'   => 'https://api.login.yahoo.com/oauth2/get_token',
                'grant_type'        => 'authorization_code',
                'yql_url'           => 'https://query.yahooapis.com/v1/yql'
            ],
        ],
        'twitter' => [
            'fields' => [
                'consumer_key' => [
                    'type' => 'text',
                ],
                'consumer_secret' => [
                    'type' => 'password'
                ],
                'application_id' => [
                    'type' => 'text',
                ],
            ],
            /**
             * Twitter settings
             * @link https://dev.twitter.com/web/sign-in/implementing
             */
            'settings' => [
                'request_token_url' => 'https://api.twitter.com/oauth/request_token',
                'request_api_url'   => 'https://api.twitter.com/oauth/authenticate',
                'token_url'         => 'https://api.twitter.com/oauth/access_token',
                'expire'            => 3600, //just 1 hour because Twitter doesnt support expire
            ],
            'meta' => [
                'api_version' => '1.0'
            ],
        ],
        'vk' => [
            'fields' => [
                'app_id' => [
                    'type' => 'text',
                ],
                'app_secret' => [
                    'type' => 'password'
                ],
            ],
            /**
             * VK.com settings
             * @link http://vk.com/dev/auth_sites
             * @link http://vk.com/dev/api_requests
             */
            'settings' => [
                'request_token_url' => 'https://oauth.vk.com/access_token',
                'request_api_url'   => 'https://api.vk.com/method/users.get',
            ],
            'meta' => [
                'api_version' => '5.52',
            ],
        ],
        'yandex' => [
            'fields' => [
                'app_id' => [
                    'type' => 'text',
                ],
                'app_password' => [
                    'type' => 'password'
                ],
            ],
            /**
             * @link http://api.yandex.ru/oauth/doc/dg/reference/obtain-access-token.xml
             * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
             */
            'settings' => [
                'request_token_url' => 'https://oauth.yandex.ru/token',
                'grant_type'        => 'authorization_code',
                'request_api_url'   => 'https://login.yandex.ru/info',
                'format'            => 'json',
            ],
        ],
        'mailru' => [
            'fields' => [
                'site_id' => [
                    'type' => 'text',
                ],
                'client_private' => [
                    'type' => 'password'
                ],
                'client_secret' => [
                    'type' => 'password'
                ],
            ],
            /**
             * Mail.ru settings
             * @link http://api.mail.ru/docs/guides/oauth/sites/
             * @link http://api.mail.ru/docs/reference/rest/
             * @link http://api.mail.ru/docs/guides/restapi/
             */
            'settings' => [
                'request_token_url' => 'https://connect.mail.ru/oauth/token',
                'grant_type'        => 'authorization_code',
                'request_api_url'   => 'http://www.appsmail.ru/platform/api',
            ],
        ],
    ];

    /**
     * List of available styles
     *
     * @var array
     */
    public const STYLES = [
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

    public const ALLOWED_ICONS_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
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

    /**
     * global $USER object
     *
     * @var null
     */
    protected $user = null;

    /**
     * @var bool
     */
    protected $sendOAuthRequest = true;

    /**
     * @var string Current provider name
     */
    protected $provider = '';

    /**
     * @var string Auth code to get access token
     */
    protected $code = '';

    protected $sesskey = '';

    /**
     * cURL default request type. Highly recommended is POST
     *
     * @var    string
     * @access protected
     */
    protected $curlType = 'post';

    protected $fieldShortName;
    protected $fieldId;

    /**
     * LenAuth constructor.
     *
     * @param string $provider
     */
    public function __construct(string $provider = '')
    {
        global $DB, $CFG, $USER;
        $this->db = $DB;
        $this->cfg = $CFG;
        $this->user = $USER;
        $this->authtype = 'lenauth';
        $this->sesskey = sesskey();
        $this->errorlogtag = '[AUTH lenauth]';
        if ($provider) {
            if (in_array($provider, array_keys(self::SETTINGS))) {
                $this->setProvider($provider);
            }
        }
    }

    public function getConfig(string $setting = '')
    {
        if (!$this->config) {
            $this->config = get_config('auth_lenauth');
        }
        if ($this->config) {
            if ($setting) {
                if (isset($this->config->$setting)) {
                    return $this->config->$setting;
                }
                return '';
            }
            return $this->config;
        }
        return null;
    }

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
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function user_login($userName, $password)
    {
        $user = $this->db->get_record(
            'user',
            ['username' => $userName, 'mnethostid' => $this->cfg->mnet_localhost_id]
        );
        //check for user (username) exist and authentication method
        if (!empty($user) && ($user->auth == 'lenauth')) {
            if ($this->code = optional_param('code', '', PARAM_ALPHANUMEXT)) {
                return true;
            }
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
    public function is_internal()
    {
        return false;
    }

    /**
     * Returns true if plugin allows confirming of new users.
     *
     * @return boolean
     */
    public function can_confirm()
    {
        if ($canConfirm = $this->getConfig('can_confirm')) {
            return $canConfirm;
        }
        return false;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @link https://docs.moodle.org/dev/Authentication_plugins#can_reset_password.28.29
     * @return boolean
     */
    public function can_reset_password()
    {
        if ($canResetPassword = $this->getConfig('can_reset_password')) {
            return $canResetPassword;
        }
        return false;
    }

    /**
     * Generate a valid urlencoded data to use it for cURL request
     *
     * @param  array $array
     * @return string with data for cURL request
     */
    protected function generateQueryData(array $array)
    {
        $query = [];
        foreach ($array as $key => $value) {
            $query[] = urlencode($key) . '=' . urlencode($value);
        }
        return join('&', $query);
    }

    public static function getUserInfoFieldsCategory(string $key = '')
    {
        global $DB;
        if ($row = $DB->get_record('user_info_category', ['name' => get_string('pluginname', 'auth_lenauth')])) {
            if ($key && isset($row->$key)) {
                return $row->$key;
            }
            return $row;
        }
        return null;
    }

    /**
     * The function gets additional field ID of specified webservice shortname from user_info_field table
     *
     * @return int
     * @throws \dml_exception
     */
    protected function getFieldId()
    {
        return $this->fieldShortName ? $this->db->get_field(
            'user_info_field',
            'id',
            ['shortname' => $this->fieldShortName]
        ) : false;
    }

    /**
     * Get provider
     *
     * @param string $provider Provider name
     *
     * @return string
     */
    protected function getProvider(string $provider = '') : string
    {
        $provider = $provider ? $provider : $this->provider;
        return in_array($provider, array_keys(self::SETTINGS)) ? $provider : '';
    }

    /**
     * Set provider variable
     *
     * @param string $provider Provider name
     *
     * @return bool
     */
    protected function setProvider(string $provider) : bool
    {
        if (in_array($provider, array_keys(self::SETTINGS))) {
            $this->provider = $provider;
            return true;
        }
        return false;
    }

    /**
     * Function to generate valid redirect URI to use it without problems
     * Param $provider checks service we use and makes URI. Used in code for much faster work.
     *
     * @param  string $provider current OAuth provider
     * @return string
     */
    protected function redirectURI(string $provider = '') : string
    {
        if ($this->getProvider($provider)) {
            return $this->cfg->wwwroot . '/auth/lenauth/redirect.php?provider=' . $this->getProvider($provider);
        }
        return '';
    }

    /**
     * Getting oAuth dialog URL by provider name
     *
     * @param string $provider Provider name
     *
     * @return string
     */
    public function OAuthLink(string $provider = '') : string
    {
        if ($provider = $this->getProvider($provider)) {
            switch ($provider) {
                case 'facebook':
                    /**
                     * https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/#logindialog
                     */
                    return 'https://www.facebook.com/v' . $this->getConfig('facebook_version')
                        . '/dialog/oauth'
                        . '?client_id=' . $this->getConfig('facebook_app_id')
                        . '&redirect_uri=' . urlencode($this->redirectURI($provider))
                        . '&state=' . $this->sesskey;
                case 'google':
                    /**
                     * https://developers.google.com/identity/protocols/oauth2/web-server#creatingclient
                     */
                    return 'https://accounts.google.com/o/oauth2/v2/auth'
                        . '?client_id=' . $this->getConfig('google_client_id')
                        . '&redirect_uri=' . urlencode($this->redirectURI($provider))
                        . '&response_type=code'
                        /**
                         * https://developers.google.com/identity/protocols/oauth2/scopes
                         * https://developers.google.com/identity/protocols/oauth2/scopes#google-sign-in
                         */
                        . '&scope=' . urlencode('email profile')//https://oauth2.googleapis.com/token
                        . '&state=' . $this->sesskey;
            }
        }
        return '';
    }

    /**
     * Getting URL for access token request by provider name
     *
     * @param string $provider Provider name
     *
     * @return string
     */
    protected function accessTokenURL(string $provider = '') : string
    {
        if ($provider = $this->getProvider($provider)) {
            switch ($provider) {
                case 'facebook':
                    /**
                     * https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/#exchangecode
                     */
                    return 'https://graph.facebook.com/v' . $this->getConfig('facebook_version') . '/oauth/access_token'
                        . '?client_id=' . $this->getConfig('facebook_app_id')
                        . '&redirect_uri=' . urlencode($this->redirectURI($provider))
                        . '&client_secret=' . $this->getConfig('facebook_app_secret')
                        . '&code=' . $this->code;
                case 'google':
                    /**
                     * https://developers.google.com/identity/protocols/oauth2/web-server#exchange-authorization-code
                     */
                    return 'https://oauth2.googleapis.com/token';
            }
        }
        return '';
    }

    protected function requestAPIURL(string $provider = '') : string
    {
        if ($provider = $this->getProvider($provider)) {
            switch ($provider) {
                case 'facebook':
                    /**
                     * https://developers.facebook.com/docs/graph-api/using-graph-api#me
                     */
                    return 'https://graph.facebook.com/me';
                case 'google':
                    /**
                     * https://developers.google.com/people/api/rest/v1/people/get#http-request
                     * https://developers.google.com/identity/protocols/oauth2/native-app#callinganapi
                     */
                    return 'https://people.googleapis.com/v1/people/me';
            }
        }
        return '';
    }

    /**
     * This function returns user object from Moodle database with given $socialUId param,
     * if user with this social_uid exists, function will return this user object,
     * if not - false
     *
     * @param  string $socialUId user internal ID of social webservice that comes from request
     * @return object|bool
     */
    protected function getUserDataBySocialId(string $socialUId)
    {
        $ret = false;
        if (!empty($this->fieldShortName)) {
            $ret = $this->db->get_record_sql(
                'SELECT u.* FROM {user} u
                            LEFT JOIN {user_info_data} uid ON u.id = uid.userid
                            LEFT JOIN {user_info_field} uif ON uid.fieldid = uif.id
                            WHERE uid.data = ?
                            AND uif.id = ?
                            AND uif.shortname = ?
                            AND u.deleted = ? AND u.mnethostid = ?',
                [$socialUId, $this->fieldId, $this->fieldShortName, 0, $this->cfg->mnet_localhost_id]
            );
        }
        return $ret;
    }

    public static function getUserInfoCategorySortOrder() : int
    {
        global $DB;
        if ($categories = $DB->get_records('user_info_category')) {
            $sortOrders = [];
            foreach ($categories as $category) {
                $sortOrders[$category->sortorder] = $category->sortorder;
            }
            return max($sortOrders) + 1;
        }
        return 1;
    }

    /**
     * This function returns extension of web image mime type
     *
     * @param  string $mime Mime type
     * @return string If needle $mime type exists returns extension, if not - empty string
     */
    protected function getImageExtensionFromMime(string $mime)
    {
        return isset(self::ALLOWED_ICONS_TYPES[$mime]) ? self::ALLOWED_ICONS_TYPES[$mime] : '';
    }

    /**
     * This function generate pretty (key-number=>name) array of socials order
     *
     * @param  array $orderArray Orders array from $_POST config: user input for orders
     * @access private
     * @return array
     */
    protected function makeOrder(array $orderArray)
    {
        $ret = $ret2 = [];
        foreach ($orderArray as $service => $order) {
            $order = intval($order);
            while (isset($ret[$order])) {
                $order += 1;
            }
            $ret[$order] = $service;
        }
        ksort($ret);
        $i = 1;
        foreach ($ret as $service) {
            $ret2[$i] = $service;
            $i++;
        }
        return $ret2;
    }

    protected function urlEncodeRfc3986($input)
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
            strtoupper($this->curlType),
            $this->sendOAuthRequest ? self::SETTINGS['twitter']['settings']['request_token_url']
                : self::SETTINGS['twitter']['settings']['token_url'],
            implode('&', $encodedParams)
        ]));
        $params['oauth_signature'] = base64_encode(
            hash_hmac(
                'sha1',
                $signature,
                implode('&', $this->urlEncodeRfc3986(
                    [
                        $this->getConfig('twitter_consumer_secret'),
                        $OAuthTokenSecret ? $OAuthTokenSecret : '',
                    ]
                )),
                true
            )
        );
        $header = '';
        foreach ($params as $key => $value) {
            if (preg_match('/^oauth_/', $key)) {
                $header .= ($header === '' ? ' ' : ', ') . $this->urlEncodeRfc3986($key) . '="'
                    . $this->urlEncodeRfc3986($value) . '"';
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
            'oauth_consumer_key' => $this->getConfig('twitter_consumer_key'),
            //'oauth_nonce' => md5(microtime(true) . $_SERVER['REMOTE_ADDR']),
            'oauth_nonce' => md5(microtime(true)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => self::SETTINGS['twitter']['meta']['api_version'],
        ];
    }

    /**
     * @link   http://docs.moodle.org/dev/Authentication_plugins#loginpage_hook.28.29
     *
     * Hook for overriding behaviour of login page.
     * Another auth hook. Process login if $code is defined in OAuth url.
     * Makes cURL POST/GET request to social webservice and fill response data to Moodle user.
     * We check access tokens in cookies, if the ones exists - get it from $_COOKIE, if no - setcookie
     *
     * @uses   $SESSION core global object
     * @return void or @moodle_exception if OAuth request returns error or fail
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     * @author Igor Sazonov <sovletig@gmail.com>
     */
    public function loginpage_hook()
    {
        global $SESSION;
        if (!isloggedin()) {
            if ($provider = optional_param('provider', '', PARAM_ALPHANUM)) {
                if ($code = optional_param('code', '', PARAM_RAW)) {
                    if ($this->setProvider($provider)) {
                        $accessToken = false;
                        $this->code = $code;
                        @setcookie('auth_lenauth_provider', $this->provider, time() + 604800, '/');
                        $this->fieldShortName = $this->getConfig($this->provider . '_social_id_field');
                        $this->fieldId = $this->getFieldId();

                        $params = $curlOptions = [];
                        $encodeParams = $hasCode = $redirectURI = true;
                        $curlHeader = false;
                        //if we have access_token in $_COOKIE, so do not need to make request fot the one
                        $this->sendOAuthRequest = !isset($_COOKIE[$this->provider]['access_token']);
                        //if service is not enabled, why should we make request? hack protect. maybe
                        $enabledStr = $this->provider . '_enabled';
                        if (empty($this->getConfig($enabledStr))) {
                            throw new \moodle_exception('Service not enabled in your LenAuth Settings', 'auth_lenauth');
                        }
                        switch ($this->getProvider()) {
                            case 'google':
                                $params = [
                                    'client_id' => $this->getConfig('google_client_id'),
                                    'client_secret' => $this->getConfig('google_client_secret'),
                                    'code' => $code,
                                    'grant_type' => 'authorization_code',
                                    'redirect_uri' => $this->redirectURI('google')
                                ];
                                break;
                            case 'yahoo':
                                $params['grant_type'] = self::SETTINGS[$this->provider]['settings']['grant_type'];
                                $curlOptions = [
                                    'USERPWD' => $this->getConfig('yahoo_consumer_key') . ':'
                                        . $this->getConfig('yahoo_consumer_secret')
                                ];
                                break;
                            case 'twitter':
                                if (!empty($this->getConfig('twitter_enabled'))) {
                                    if (!isset($_COOKIE[$this->provider]['access_token'])) {
                                        $params = array_merge(
                                            $this->twitterRequestArray($this->getConfig('twitter_consumer_secret') . '&'),
                                            ['oauth_callback' => $this->redirectURI()]
                                        );
                                        $hasCode = $redirectURI = false;
                                        $this->sendOAuthRequest = (isset($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'])) ? false : true;
                                        $OAuthVerifier = false;
                                        if (!$this->sendOAuthRequest && isset($_COOKIE[$this->provider]['oauth_token_secret'])) {
                                            $accessToken = $SESSION->twitter_access_token
                                                = optional_param('oauth_token', '', PARAM_TEXT);
                                            setcookie($this->provider . '[access_token]', $accessToken, time()
                                                + self::SETTINGS[$this->provider]['settings']['expire'], '/');
                                            $OAuthVerifier = $SESSION->twitter_oauth_verifier
                                                = optional_param('oauth_verifier', '', PARAM_TEXT);
                                            setcookie($this->provider . '[oauth_verifier]', $OAuthVerifier, time()
                                                + self::SETTINGS[$this->provider]['settings']['expire'], '/');
                                        } else {
                                            $curlHeader = $this->setTwitterHeader($params);
                                        }
                                        $encodeParams = false;
                                    } else {
                                        $this->sendOAuthRequest = false;
                                    }
                                }
                                break;
                        }
                        //require cURL from Moodle core
                        require_once $this->cfg->libdir . '/filelib.php';
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
                        if ($this->sendOAuthRequest) {
                            $accessTokenURL = $this->accessTokenURL();
                            if (isset(self::SETTINGS[$this->provider]['settings']['access_token_curl'])
                                && in_array(
                                    self::SETTINGS[$this->provider]['settings']['access_token_curl'],
                                    ['get', 'post']
                                )) {
                                switch (self::SETTINGS[$this->provider]['settings']['access_token_curl']) {
                                    case 'get':
                                        $curlTokensValues = $curl->get($accessTokenURL);
                                        break;
                                    case 'post':
                                        $curlTokensValues = $curl->post(
                                            $accessTokenURL,
                                            //hack for twitter
                                            $encodeParams ? $this->generateQueryData($params) : $params
                                        );
                                        break;
                                }
                            } else {
                                $curlTokensValues = $curl->get($accessTokenURL);
                            }
                        }
                        // check for token response
                        if (!empty($curlTokensValues) || !$this->sendOAuthRequest) {
                            $tokenValues = [];
                            switch ($this->provider) {
                                case 'facebook':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        $expires = $tokenValues['expires_in']; //5183999 = 2 months
                                        $accessToken = $tokenValues['access_token'];
                                        if (!empty($expires) && !empty($accessToken)) {
                                            setcookie(
                                                $this->getProvider() . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                        } else {
                                            throw new \moodle_exception('Can not get access for "access_token" '
                                                . 'or/and "expires" params after request', 'auth_lenauth');
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'google':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        $expires = $tokenValues['expires_in']; //3600 = 1 hour
                                        $accessToken = $tokenValues['access_token'];
                                        //id_token
                                        if (!empty($accessToken) && !empty($expires)) {
                                            setcookie(
                                                $this->provider . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                        } else {
                                            throw new \moodle_exception('Can not get access for "access_token" '
                                                . 'or/and "expires" params after request', 'auth_lenauth');
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'yahoo':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        $expires = $tokenValues['expires_in']; //3600 = 1 hour
                                        $accessToken = $tokenValues['access_token'];
                                        //$refresh_token = $tokenValues['refresh_token'];
                                        $userId = $tokenValues['xoauth_yahoo_guid'];
                                        if (!empty($expires) && !empty($accessToken)) {
                                            setcookie(
                                                $this->provider . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                            if (!empty($userId)) {
                                                setcookie(
                                                    $this->provider . '[user_id]',
                                                    $userId,
                                                    time() + $expires,
                                                    '/'
                                                );
                                            }
                                        } else {
                                            throw new \moodle_exception('Can not get access for "access_token" '
                                                . 'or/and "expires" params after request', 'auth_lenauth');
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'], $_COOKIE[$this->provider]['user_id'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                            $userId = $_COOKIE[$this->provider]['user_id'];
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'twitter':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['oauth_token_secret'])) {
                                        parse_str($curlTokensValues, $tokenValues);
                                        $accessToken = $SESSION->twitter_access_token = $tokenValues['oauth_token'];
                                        setcookie(
                                            $this->provider . '[oauth_token_secret]',
                                            $tokenValues['oauth_token_secret'],
                                            time() + self::SETTINGS[$this->provider]['settings']['expire'],
                                            '/'
                                        );
                                    } else {
                                        if (isset(
                                            $_COOKIE[$this->provider]['access_token'],
                                            $_COOKIE[$this->provider]['oauth_token_secret']
                                        )
                                            || isset($SESSION->twitter_access_token, $SESSION->twitter_oauth_verifier)) {
                                            $accessToken = isset($_COOKIE[$this->provider]['access_token'])
                                                ? $_COOKIE[$this->provider]['access_token'] : $SESSION->twitter_access_token;
                                            $OAuthVerifier = (isset($_COOKIE[$this->provider]['oauth_verifier']))
                                                ? $_COOKIE[$this->provider]['oauth_verifier'] : $SESSION->twitter_oauth_verifier;
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'vk':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        if (isset($tokenValues['error'])) {
                                            throw new \moodle_exception('Native VK Error ' . $tokenValues['error']
                                                . (isset($tokenValues['error_description']) ? ' with description: '
                                                    . $tokenValues['error_description'] : ''), 'auth_lenauth');
                                        }
                                        $expires = $tokenValues['expires_in']; //86400 = 24 hours
                                        $accessToken = $tokenValues['access_token'];
                                        if (!empty($accessToken) && !empty($expires)) {
                                            setcookie(
                                                $this->provider . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                        }
                                        $userId = $tokenValues['user_id'];
                                        if (!empty($userId)) {
                                            setcookie($this->provider . '[user_id]', $userId, time() + $expires, '/');
                                        }
                                        /**
                                         * VK user may do not enter email
                                         */
                                        $userEmail = (isset($tokenValues['email'])) ? $tokenValues['email'] : false;
                                        if (!empty($userEmail)) {
                                            setcookie(
                                                $this->provider . '[user_email]',
                                                $userEmail,
                                                time() + $expires,
                                                '/'
                                            );
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'], $_COOKIE[$this->provider]['user_id'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                            $userId = $_COOKIE[$this->provider]['user_id'];
                                            if (isset($_COOKIE[$this->provider]['user_email'])) {
                                                $userEmail = $_COOKIE[$this->provider]['user_email'];
                                            }
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'yandex':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        $expires = $tokenValues['expires_in']; //31536000 = 1 year
                                        $accessToken = $tokenValues['access_token'];
                                        if (!empty($expires) && !empty($accessToken)) {
                                            setcookie(
                                                $this->provider . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                        } else {
                                            throw new \moodle_exception('Can not get access for "access_token" '
                                                . 'or/and "expires" params after request', 'auth_lenauth');
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                case 'mailru':
                                    if ($this->sendOAuthRequest || !isset($_COOKIE[$this->provider]['access_token'])) {
                                        $tokenValues = json_decode($curlTokensValues, true);
                                        $expires = $tokenValues['expires_in']; //86400 = 24 hours
                                        $accessToken = $tokenValues['access_token'];
                                        if (!empty($expires) && !empty($accessToken)) {
                                            setcookie(
                                                $this->provider . '[access_token]',
                                                $accessToken,
                                                time() + $expires,
                                                '/'
                                            );
                                        } else {
                                            //check native errors if exists
                                            if (isset($tokenValues['error'])) {
                                                switch ($tokenValues['error']) {
                                                    case 'invalid_client':
                                                        throw new \moodle_exception(
                                                            'Mail.RU invalid OAuth settings. Check your Private Key and Secret Key',
                                                            'auth_lenauth'
                                                        );
                                                    default:
                                                        throw new \moodle_exception('Mail.RU Unknown Error with code: ' . $tokenValues['error']);
                                                }
                                            }
                                            if (empty($expires) || empty($accessToken)) {
                                                throw new \moodle_exception(
                                                    'Can not get access for "access_token" or/and "expires" params after request',
                                                    'auth_lenauth'
                                                );
                                            }
                                        }
                                    } else {
                                        if (isset($_COOKIE[$this->provider]['access_token'])) {
                                            $accessToken = $_COOKIE[$this->provider]['access_token'];
                                        } else {
                                            throw new \moodle_exception(
                                                'Someting wrong, maybe expires',
                                                'auth_lenauth'
                                            );
                                        }
                                    }
                                    break;
                                default:
                                    throw new \moodle_exception('Unknown OAuth Provider', 'auth_lenauth');
                            }
                        }
                        if (!empty($accessToken)) {
                            $queryParams = []; // array to generate data for final request to get user data
                            $requestAPIURL = $this->requestAPIURL();
                            $isVerified = true;
                            $imageURL = '';
                            switch ($this->provider) {
                                case 'facebook':
                                    $queryParams['access_token'] = $accessToken;
                                    $queryParams['fields'] = 'email,name';
                                    $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                                    $curlFinalData = json_decode($curlResponse, true);print_r($curlFinalData);die;
                                    $id = $curlFinalData['id'];
                                    $name = $curlFinalData['name'];
                                    /**
                                     * https://developers.facebook.com/docs/graph-api/reference/user/
                                     * https://developers.facebook.com/docs/graph-api/using-graph-api#reading
                                     */
                                    die('rr=https://graph.facebook.com/v7.0/' . $id . '/?access_token=' . $accessToken);
                                    $r = $curl->get('https://graph.facebook.com/' . $id . '/?fields=email&access_token=' . $accessToken);
                                    print_r($r);die('eerrss');
                                    $userEmail = $curlFinalData['email'];
                                    $firstName = $curlFinalData['first_name'];
                                    $lastName = $curlFinalData['last_name'];
                                    $isVerified = $curlFinalData['verified'];
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL = 'http://graph.facebook.com/' . $socialUId . '/picture';
                                    }
                                    break;
                                /**
                                 * @link https://developers.google.com/accounts/docs/OAuth2Login#obtaininguserprofileinformation
                                 */
                                case 'google':
                                    $queryParams['access_token'] = $accessToken;
                                    $queryParams['personFields'] = 'emailAddresses,names';
                                    $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                                    $curlFinalData = json_decode($curlResponse, true);print_r($curlFinalData);die;
                                    if (isset($curlFinalData['error'])) {
                                        if (!empty($curlFinalData['error']['errors']) && is_array($curlFinalData['error']['errors'])) {
                                            foreach ($curlFinalData['error']['errors'] as $error) {
                                                throw new \moodle_exception('Native Google error. Message: '
                                                    . $error['message'], 'auth_lenauth');
                                            }
                                        } else {
                                            throw new \moodle_exception('Native Google error', 'auth_lenauth');
                                        }
                                    }
                                    $socialUId = $curlFinalData['id'];
                                    $userEmail = $curlFinalData['emails'][0]['value'];
                                    $firstName = $curlFinalData['name']['givenName'];
                                    $lastName = $curlFinalData['name']['familyName'];
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL = isset($curlFinalData['image']['url']) ? $curlFinalData['image']['url'] : '';
                                    }
                                    break;
                                case 'yahoo':
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
                                    $socialUId = $curlFinalData['profile']['guid'];
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
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL = isset($curlFinalData['profile']['image']['imageUrl'])
                                            ? $curlFinalData['profile']['image']['imageUrl'] : '';
                                    }
                                    break;
                                case 'twitter':
                                    if (!$OAuthVerifier) {
                                        header('Location: ' . self::SETTINGS[$this->provider]['settings']['request_api_url']
                                            . '?' . http_build_query(['oauth_token' => $accessToken]));
                                        die;
                                    }
                                    $queryParams = array_merge(
                                        $this->twitterRequestArray(),
                                        [
                                            'oauth_verifier' => $OAuthVerifier,
                                            'oauth_token' => $accessToken,
                                            'oauth_token_secret' => $_COOKIE[$this->provider]['oauth_token_secret']
                                        ]
                                    );
                                    $curlHeader = $this->setTwitterHeader(
                                        $queryParams,
                                        $accessToken,
                                        $_COOKIE[$this->provider]['oauth_token_secret']
                                    );
                                    $curl->setHeader($curlHeader);
                                    $curlFinalDataPre = $curl->post(
                                        self::SETTINGS[$this->provider]['settings']['token_url'],
                                        $queryParams
                                    );
                                    $json_decoded = json_decode($curlFinalDataPre, true);
                                    if (isset($json_decoded['error']) && isset($json_decoded['request'])) {
                                        throw new \moodle_exception('Native Twitter Error: ' . $json_decoded['error']
                                            . '. For request ' . $json_decoded['request'], 'auth_lenauth');
                                    }
                                    parse_str($curlFinalDataPre, $curlFinalData);
                                    $socialUId = $curlFinalData['user_id'];
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL_pre = 'https://twitter.com/' . $curlFinalData['screen_name']
                                            . '/profile_image?size=original';
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
                                    $queryParams['v'] = self::SETTINGS['vk']['meta']['api_version'];
                                    $curlResponse = $curl->post($requestAPIURL, $this->generateQueryData($queryParams));
                                    $curlFinalData = json_decode($curlResponse, true);
                                    $socialUId = $queryParams['user_id'];
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
                                        . $socialUId . '&fields=' . join(',', $fieldsArray));
                                    $additionalFields = json_decode($additionalFieldsPre, true);
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL = isset($additionalFields['response'][0][$fieldsArray['avatar']])
                                            ? $additionalFields['response'][0][$fieldsArray['avatar']] : '';
                                    }
                                    break;
                                /**
                                 * @link http://api.yandex.ru/oauth/doc/dg/reference/accessing-protected-resource.xml
                                 * @link http://api.yandex.ru/login/doc/dg/reference/request.xml
                                 */
                                case 'yandex':
                                    $queryParams['format'] = self::SETTINGS[$this->provider]['settings']['format'];
                                    $queryParams['oauth_token'] = $accessToken;
                                    $curlResponse = $curl->get($requestAPIURL . '?' . $this->generateQueryData($queryParams));
                                    $curlFinalData = json_decode($curlResponse, true);
                                    $socialUId = $curlFinalData['id'];
                                    $userEmail = $curlFinalData['default_email'];
                                    $firstName = $curlFinalData['first_name'];
                                    $lastName = $curlFinalData['last_name'];
                                    //$nickname = $curlFinalData['display_name'];
                                    if ($this->getConfig('retrieve_avatar')) {
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
                                     *
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

                                    $socialUId = $curlFinalData[0]['uid'];
                                    $userEmail = $curlFinalData[0]['email'];
                                    $firstName = $curlFinalData[0]['first_name'];
                                    $lastName = $curlFinalData[0]['last_name'];
                                    $isVerified = $curlFinalData[0]['is_verified'];
                                    //$birthday = $curlFinalData[0]['birthday']; //dd.mm.YYYY
                                    if ($this->getConfig('retrieve_avatar')) {
                                        $imageURL = isset($curlFinalData[0]['pic_big']) ? $curlFinalData[0]['pic_big'] : '';
                                    }
                                    break;
                                default:
                                    throw new \moodle_exception('Unknown OAuth Provider', 'auth_lenauth');
                            }
                            //development mode
                            if ($this->cfg->debugdeveloper == 1 && $this->getConfig('dev_mode')) {
                                throw new \moodle_exception(
                                    'lenauth_debug_info_not_error',
                                    'auth_lenauth',
                                    '',
                                    'AUTHPROVIDER: ' . $this->provider . ' >>>>>REQUEST:' . http_build_query(
                                        $queryParams,
                                        '',
                                        '<--->'
                                    ) . ' >>>>>RESPONSE: ' . http_build_query(
                                        $curlFinalData,
                                        '',
                                        ' <---> '
                                    )
                                );
                            }
                            /**
                             * Check for email returned by webservice. If exist - check for user with this email in Moodle Database
                             */
                            if (!empty($curlFinalData)) {
                                if (!empty($socialUId)) {
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
                                                $userLenAuth = $this->getUserDataBySocialId($socialUId);
                                            }
                                            /*if (empty($userLenAuth)) {
                                                $userLenAuth = $this->db->get_record('user', array('username' => $userName, 'deleted' => 0, 'mnethostid' => $this->cfg->mnet_localhost_id));
                                            }*/
                                        }
                                    } else {
                                        throw new \moodle_exception(
                                            'Your social account is not verified',
                                            'auth_lenauth'
                                        );
                                    }
                                } else {
                                    throw new \moodle_exception('Empty Social UID', 'auth_lenauth');
                                }
                            } else {
                                @setcookie($this->provider, null, time() - 3600);
                                throw new \moodle_exception('Final request returns nothing', 'auth_lenauth');
                            }
                            $lastUserNumber = intval($this->getConfig('last_user_number'));
                            $lastUserNumber = empty($lastUserNumber) ? 1 : $lastUserNumber + 1;
                            //$userName = $this->getConfig('user_prefix . $lastUserNumber; //@todo
                            /**
                             * If user with email from webservice not exists, we will create an account
                             */
                            if (empty($userLenAuth)) {
                                $userName = $this->getConfig('user_prefix') . $lastUserNumber;
                                //check for username exists in DB
                                $userLenAuthCheck = $this->db->get_record('user', ['username' => $userName]);
                                $i_check = 0;
                                while (!empty($userLenAuthCheck)) {
                                    $userName = $this->getConfig('user_prefix') . $lastUserNumber;
                                    $userLenAuthCheck = $this->db->get_record('user', ['username' => $userName]);
                                    $i_check++;
                                    if ($i_check > 20) {
                                        throw new \moodle_exception(
                                            'Something wrong with usernames of LenAuth users. Limit of 20 queries is out. Check last mdl_user table of Moodle',
                                            'auth_lenauth'
                                        );
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
                            set_config('last_user_number', $lastUserNumber, 'auth_lenauth');
                            if (!empty($socialUId)) {
                                $userSocialUIdCustomField = [
                                    'userid' => $userLenAuth->id,
                                    'fieldid' => $this->fieldId,
                                    'data' => $socialUId,
                                ];
                                if (!$this->db->record_exists(
                                    'user_info_data',
                                    ['userid' => $userLenAuth->id, 'fieldid' => $this->fieldId]
                                )) {
                                    $this->db->insert_record('user_info_data', $userSocialUIdCustomField);
                                } else {
                                    $record = $this->db->get_record(
                                        'user_info_data',
                                        ['userid' => $userLenAuth->id, 'fieldid' => $this->fieldId]
                                    );
                                    $userSocialUIdCustomField['id'] = $record->id;
                                    $this->db->update_record('user_info_data', $userSocialUIdCustomField);
                                }
                            }

                            //add_to_log(SITEID, 'auth_lenauth', '', '', $userName . '/' . $userEmail . '/' . $userid);

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
                            if (!empty($this->getConfig('default_country'))) {
                                $newUser->country = $this->getConfig('default_country');
                            }
                            if ($userLenAuth) {
                                if ($userLenAuth->suspended == 1) {
                                    throw new \moodle_exception('user_suspended', 'auth_lenauth');
                                }
                                // update user record
                                if (!empty($newUser)) {
                                    $newUser->id = $userLenAuth->id;
                                    /*require_once $this->cfg->libdir . '/gdlib.php';

                                    $fs = get_file_storage();
                                    $file_obj = $fs->create_file_from_url(array(
                                        'contextid' => context_user::instance($newUser->id, MUST_EXIST)->id,
                                        'component' => 'user',
                                        'filearea'  => 'icon',
                                        'itemid'    => 0,
                                        'filepath'  => '/',
                                        'source'    => '',
                                        'filename'  => 'f' . $newUser->id . '.' . $ext
                                   ), $imageURL);
                                    //$newUser->picture = $file_obj->get_id();*/

                                    $userLenAuth = (object)array_merge((array)$userLenAuth, (array)$newUser);
                                    $this->db->update_record('user', $userLenAuth);
                                    if ($this->getConfig('retrieve_avatar')) {
                                        //processing user avatar from social webservice
                                        if (!empty($imageURL) && intval($userLenAuth->picture) === 0) {
                                            $imageHeader = get_headers($imageURL, 1);
                                            if (isset($imageHeader['Content-Type'])
                                                && is_string($imageHeader['Content-Type'])
                                                && in_array(
                                                    $imageHeader['Content-Type'],
                                                    array_keys(self::ALLOWED_ICONS_TYPES)
                                                )) {
                                                $mime = $imageHeader['Content-Type'];
                                            } else {
                                                foreach ($imageHeader['Content-Type'] as $ct) {
                                                    if (!empty($ct)
                                                        && is_string($ct)
                                                        && in_array($ct, array_keys(self::ALLOWED_ICONS_TYPES))) {
                                                        $mime = $ct;
                                                        break;
                                                    }
                                                }
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
                                                $tempFile = $templFolder . '/' . $tempFileName;
                                                if (copy($imageURL, $tempFile)) {
                                                    require_once $this->cfg->libdir . '/gdlib.php';
                                                    $userIconId = process_new_icon(\context_user::instance(
                                                        $newUser->id,
                                                        MUST_EXIST
                                                    ), 'user', 'icon', 0, $tempFile);
                                                    if ($userIconId) {
                                                        $this->db->set_field(
                                                            'user',
                                                            'picture',
                                                            $userIconId,
                                                            ['id' => $newUser->id]
                                                        );
                                                    }
                                                    unset($tempFile);
                                                }
                                                @chmod($templFolder, $this->cfg->directorypermissions);
                                            }
                                        }
                                    }
                                }

                                complete_user_login($userLenAuth); // complete user login

                                // Redirection
                                $urlToGo = $this->cfg->wwwroot;
                                if (user_not_fully_set_up($userLenAuth)) {
                                    $urlToGo = $this->cfg->wwwroot . '/user/edit.php';
                                } elseif (isset($SESSION->wantsurl) && (strpos(
                                    $SESSION->wantsurl,
                                    $this->cfg->wwwroot
                                ) === 0)) {
                                    $urlToGo = $SESSION->wantsurl;
                                    unset($SESSION->wantsurl);
                                } else {
                                    unset($SESSION->wantsurl);
                                }
                            }
                            redirect($urlToGo);
                        } else {
                            throw new \moodle_exception('access_token_empty', 'auth_lenauth');
                        }
                    }
                }
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
        if (isset($_COOKIE['auth_lenauth_provider'])) {
            if (isset($_COOKIE[$_COOKIE['auth_lenauth_provider']])) {
                unset($_COOKIE[$_COOKIE['auth_lenauth_provider']]);
                setcookie($_COOKIE['auth_lenauth_provider'], null, -1, '/');
            }
            unset($_COOKIE['auth_lenauth_provider']);
            setcookie('auth_lenauth_provider', null, -1, '/');
        }
        return true;
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#process_config.28.24config.29
     * Processes and stores configuration data for this authentication plugin.
     *
     * @param  \stdClass $config
     */
    public function process_config($config)
    {
        if (has_capability('moodle/user:update', \context_system::instance())) {
            // set to defaults if undefined while save
            if (!isset($config->user_prefix)) {
                $config->user_prefix = 'lenauth_user_';
            }
            if (!isset($config->default_country)) {
                $config->default_country = '';
            }
            if (!isset($config->locale)) {
                $config->locale = 'en';
            }
            /*if (empty($config->can_change_password)) {
                $config->can_change_password = 0;
            } else {
                $config->can_change_password = 1;
            }*/
            if (empty($config->can_reset_password)) {
                $config->can_reset_password = 0;
            } else {
                $config->can_reset_password = 1;
            }
            if (empty($config->can_confirm)) {
                $config->can_confirm = 0;
            } else {
                $config->can_confirm = 1;
            }
            if (empty($config->retrieve_avatar)) {
                $config->retrieve_avatar = 0;
            } else {
                $config->retrieve_avatar = 1;
            }
            if (empty($config->dev_mode)) {
                $config->dev_mode = 0;
            } else {
                $config->dev_mode = 1;
            }
            if (!isset($config->display_buttons)) {
                $config->display_buttons = 'inline-block';
            }
            if (!isset($config->button_width)) {
                $config->button_width = 0;
            }
            if (!isset($config->button_margin_top)) {
                $config->button_margin_top = 10;
            }
            if (!isset($config->button_margin_right)) {
                $config->button_margin_right = 10;
            }
            if (!isset($config->button_margin_bottom)) {
                $config->button_margin_bottom = 10;
            }
            if (!isset($config->button_margin_left)) {
                $config->button_margin_left = 10;
            }
            if (!isset($config->display_div)) {
                $config->display_div = 'block';
            }
            if (!isset($config->div_width)) {
                $config->div_width = 0;
            }
            if (!isset($config->div_margin_top)) {
                $config->div_margin_top = 0;
            }
            if (!isset($config->div_margin_right)) {
                $config->div_margin_right = 0;
            }
            if (!isset($config->div_margin_bottom)) {
                $config->div_margin_bottom = 0;
            }
            if (!isset($config->div_margin_left)) {
                $config->div_margin_left = 0;
            }
            if (!isset($config->order)) {
                $config->order = json_encode($this->default_order);
            }
            foreach (self::SETTINGS as $socialName => $socialData) {
                $config->{$socialName . '_enabled'} = !empty($config->{$socialName . '_enabled'}) ? 1 : 0;
                set_config($socialName . '_enabled', intval($config->{$socialName . '_enabled'}), 'auth_lenauth');
                foreach (array_keys($socialData['fields']) as $key) {
                    if (!isset($config->{$socialName . '_' . $key})) {
                        $config->{$socialName . '_' . $key} = '';
                    }
                    set_config($socialName . '_' . $key, trim($config->{$socialName . '_' . $key}), 'auth_lenauth');
                }
                if (!isset($config->{$socialName . '_button_text'})) {
                    $config->{$socialName . '_button_text'} = get_string($socialName . '_button_text_default', 'auth_lenauth');
                }
                set_config($socialName . '_button_text', trim($config->{$socialName . '_button_text'}), 'auth_lenauth');
            }

            set_config('user_prefix', trim($config->user_prefix), 'auth_lenauth');
            set_config('default_country', trim($config->default_country), 'auth_lenauth');
            set_config('locale', trim($config->locale), 'auth_lenauth');
            //set_config('can_change_password',                  intval($config->can_change_password),              'auth_lenauth');
            set_config('can_reset_password', intval($config->can_reset_password), 'auth_lenauth');
            set_config('can_confirm', intval($config->can_confirm), 'auth_lenauth');
            set_config('retrieve_avatar', intval($config->retrieve_avatar), 'auth_lenauth');
            set_config('dev_mode', intval($config->dev_mode), 'auth_lenauth');

            set_config('display_buttons', trim($config->display_buttons), 'auth_lenauth');
            set_config('button_width', intval($config->button_width), 'auth_lenauth');
            set_config('button_margin_top', intval($config->button_margin_top), 'auth_lenauth');
            set_config('button_margin_right', intval($config->button_margin_right), 'auth_lenauth');
            set_config('button_margin_bottom', intval($config->button_margin_bottom), 'auth_lenauth');
            set_config('button_margin_left', intval($config->button_margin_left), 'auth_lenauth');

            set_config('display_div', trim($config->display_div), 'auth_lenauth');
            set_config('div_width', intval($config->div_width), 'auth_lenauth');
            set_config('div_margin_top', intval($config->div_margin_top), 'auth_lenauth');
            set_config('div_margin_right', intval($config->div_margin_right), 'auth_lenauth');
            set_config('div_margin_bottom', intval($config->div_margin_bottom), 'auth_lenauth');
            set_config('div_margin_left', intval($config->div_margin_left), 'auth_lenauth');

            $order_array = $this->makeOrder($config->order);
            set_config('order', json_encode($order_array), 'auth_lenauth');
            return true;
        }
        throw new \moodle_exception('You do not have permissions', 'auth_lenauth');
    }

    /**
     * @link http://docs.moodle.org/dev/Authentication_plugins#user_update.28.24olduser.2C_.24newuser.29
     * Called when the user record is updated. It will modify the user information in external database.
     *
     * If email updated we store it to global $USER object
     *
     * @param  object $oldUser before user update
     * @param  object $newUser new user data
     * @return boolean
     *
     */
    public function user_update($oldUser, $newUser)
    {
        if (!empty($newUser->email)) {
            $this->user->email = $newUser->email;
        }
        return true;
    }

    /**
     * This method output or not output social buttons. Use it via Singleton
     * If user is not logged in - buttons shows, otherwise buttons hidden
     *
     * @param string $style Buttons style to be output
     * @param bool   $showExample Special boolean parameter to output examples of buttons in the plugin admin screen
     * @param bool   $showHTML Special boolean parameter to output only HTML code
     * @return string
     */
    public function output(string $style, bool $showExample = false, bool $showHTML = false)
    {
        $ret = '';
        if (in_array($style, self::STYLES)) {
            if (!isloggedin() || isguestuser() || $showExample || $showHTML) {
                //$li_class = '';
                $styleButtonStr = ' style="display:' . $this->getConfig('display_buttons') . ';';
                if ($this->getConfig('button_margin_top') > 0
                    || $this->getConfig('button_margin_right') > 0
                    || $this->getConfig('button_margin_bottom') > 0
                    || $this->getConfig('button_margin_right') > 0) {
                    $styleButtonStr .= 'margin:' . $this->getConfig('button_margin_top') . 'px '
                        . $this->getConfig('button_margin_right') . 'px '
                        . $this->getConfig('button_margin_bottom') . 'px '
                        . $this->getConfig('button_margin_right') . 'px;';
                }
                $classDivStr = '';
                $styleDivStr = ' style="display:' . $this->getConfig('display_div') . ';';
                if ($this->getConfig('div_margin_top') > 0
                    || $this->getConfig('div_margin_right') > 0
                    || $this->getConfig('div_margin_bottom') > 0
                    || $this->getConfig('div_margin_right') > 0) {
                    $styleDivStr .= 'margin:' . $this->getConfig('div_margin_top') . 'px '
                        . $this->getConfig('div_margin_right') . 'px '
                        . $this->getConfig('div_margin_bottom') . 'px '
                        . $this->getConfig('div_margin_right') . 'px;';
                }
                if ($this->getConfig('div_width') > 0) {
                    $styleButtonStr .= 'width:' . $this->getConfig('div_width') . 'px;';
                }

                $facebookClass = $googleClass = $yahooClass = $twitterClass = $vkClass = $yandexClass = $mailruClass
                    = $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA = $mailruBCA = '';
                $hasText = $autoWidth = false;

                $facebookLink = (!$showExample && $this->getConfig('facebook_app_id'))
                    ? 'https://www.facebook.com/dialog/oauth?client_id='
                    . $this->getConfig('facebook_app_id') . '&redirect_uri='
                    . urlencode($this->redirectURI('facebook')) . '&scope=email' : 'javascript:;';
                $googleLink = (!$showExample && $this->getConfig('google_client_id'))
                    ? 'https://accounts.google.com/o/oauth2/auth?client_id='
                    . $this->getConfig('google_client_id')
                    . '&response_type=code&scope=openid%20profile%20email&redirect_uri='
                    . urlencode($this->redirectURI('google')) : 'javascript:;';
                $yahooLink = (!$showExample && $this->getConfig('yahoo_project_id'))
                    ? 'https://api.login.yahoo.com/oauth2/request_auth?client_id='
                    . $this->getConfig('yahoo_consumer_key')
                    . '&redirect_uri=' . urlencode($this->redirectURI('yahoo'))
                    . '&response_type=code' : 'javascript:;';
                $twitterLink = !$showExample ? $this->cfg->wwwroot
                    . '/auth/lenauth/redirect.php?provider=twitter' : 'javascript:;';
                $vkLink = (!$showExample && $this->getConfig('vk_app_id'))
                    ? 'https://oauth.vk.com/authorize?client_id='
                    . $this->getConfig('vk_app_id')
                    . '&scope=email&redirect_uri='
                    . urlencode($this->redirectURI('vk'))
                    . '&response_type=code&v=' . self::SETTINGS['vk']['meta']['api_version'] : 'javascript:;';
                if (!$showExample && $this->getConfig('yandex_app_id')) {
                    switch ($this->getConfig('locale')) {
                        case 'en':
                            $yandexLink = 'https://oauth.yandex.com/authorize?response_type=code&client_id='
                                . $this->getConfig('yandex_app_id') . '&display=popup';
                            break;
                        case 'ru':
                            $yandexLink = 'https://oauth.yandex.ru/authorize?response_type=code&client_id='
                                . $this->getConfig('yandex_app_id') . '&display=popup';
                            break;
                    }
                } else {
                    $yandexLink = 'javascript:;';
                }
                $mailruLink = (!$showExample && $this->getConfig('mailru_site_id'))
                    ? 'https://connect.mail.ru/oauth/authorize?client_id='
                    . $this->getConfig('mailru_site_id') . '&redirect_uri='
                    . urlencode($this->redirectURI('mailru')) . '&response_type=code' : 'javascript:;';
                switch ($style) {
                    case 'default':
                        $hasText = true;
                        $classDivStr = 'lenauth-default';
                        break;
                    case 'style1':
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon style1';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        break;
                    case 'style1-dark-white':
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon style1 lenauth-dark lenauth-white';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        break;
                    case 'style1-light-black':
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon style1 lenauth-light lenauth-black';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        break;
                    case 'style1-text':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon-text style1';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        $autoWidth = false;
                        break;
                    case 'style2-text':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon-text style2';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        $autoWidth = false;
                        break;
                    case 'style3-text':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon-text style3';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        $autoWidth = false;
                        break;
                    case 'style4-text':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-1-4 lenauth-icon-text style4';
                        $facebookClass = 'lenauth-ico-facebook';
                        $googleClass = 'lenauth-ico-google-plus';
                        $yahooClass = 'lenauth-ico-yahoo';
                        $twitterClass = 'lenauth-ico-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-ico-vk-en';
                                $yandexClass = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-ico-vk-ru';
                                $yandexClass = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-ico-mailru';
                        break;
                    case 'smooth-w32-button-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                                break;
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-button-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-button-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;

                    case 'smooth-w32-classic-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-classic-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-classic-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-square':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-square';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-rounded':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-rounded';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-circle':
                        $classDivStr = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-circle';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebookClass = 'lenauth-smooth-button-facebook';
                        $googleClass = 'lenauth-smooth-button-googleplus';
                        $yahooClass = 'lenauth-smooth-button-yahoo';
                        $twitterClass = 'lenauth-smooth-button-twitter-1';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-smooth-button-vk-en';
                                $yandexClass = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-smooth-button-vk-ru';
                                $yandexClass = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailruClass = 'lenauth-smooth-button-mailru';
                        break;
                    case 'simple-3d':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-5 lenauth-simple-3d';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'simple-3d-small':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-5 lenauth-simple-3d small';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case '3d-circle':
                        $classDivStr = 'lenauth-style-5 lenauth-circle-3d';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case '3d-circle-small':
                        $classDivStr = 'lenauth-style-5 lenauth-circle-3d small';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-5 lenauth-simple-flat';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-small':
                        $hasText = true;
                        $classDivStr = 'lenauth-style-5 lenauth-simple-flat small';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-circle':
                        $classDivStr = 'lenauth-style-5 lenauth-circle-flat';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-circle-small':
                        $classDivStr = 'lenauth-style-5 lenauth-circle-flat small';
                        $facebookBCA = $googleBCA = $yahooBCA = $twitterBCA = $vkBCA = $yandexBCA
                            = $mailruBCA = '<span></span>';
                        $facebookClass = 'lenauth-style5-facebook';
                        $googleClass = 'lenauth-style5-googlep';
                        $yahooClass = 'lenauth-style5-yahoo';
                        $twitterClass = 'lenauth-style5-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'lenauth-style5-vk-en';
                                $yandexClass = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'lenauth-style5-vk-ru';
                                $yandexClass = 'lenauth-style5-yandex-ru';
                        }
                        $mailruClass = 'lenauth-style5-mailru';
                        break;
                    case 'bootstrap-font-awesome':
                        $hasText = true;
                        $classDivStr = 'lenauth-bootstrap';
                        $facebookBCA = "<i class='fa fa-facebook-square'></i>&nbsp;";
                        $googleBCA = "<i class='fa fa-google-plus-square'></i>&nbsp;";
                        $yahooBCA = "<i class='fa fa-yahoo'></i>&nbsp;";
                        $twitterBCA = "<i class='fa fa-twitter-square'></i>&nbsp;";
                        $vkBCA = "<i class='fa fa-vk'></i>&nbsp;";
                        $yandexBCA = "<i class='fa fa-yandex'></i>&nbsp;";
                        $mailruBCA = "<i class='fa fa-mailru'></i>&nbsp;";
                        $facebookClass = 'btn btn-default lenauth-bootstrap-facebook';
                        $googleClass = 'btn btn-default lenauth-bootstrap-google';
                        $yahooClass = 'btn btn-default lenauth-bootstrap-yahoo';
                        $twitterClass = 'btn btn-default lenauth-bootstrap-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'btn btn-default lenauth-bootstrap-vk-en';
                                $yandexClass = 'btn btn-default lenauth-bootstrap-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'btn btn-default lenauth-bootstrap-vk-ru';
                                $yandexClass = 'btn btn-default lenauth-bootstrap-yandex-ru';
                        }
                        $mailruClass = 'btn btn-default lenauth-bootstrap-mailru';
                        break;
                    case 'bootstrap-font-awesome-simple':
                        $hasText = false;
                        $classDivStr = 'lenauth-bootstrap-simple';
                        $facebookBCA = "<i class='fa fa-facebook'></i>";
                        $googleBCA = "<i class='fa fa-google-plus'></i>";
                        $yahooBCA = "<i class='fa fa-yahoo'></i>&nbsp;";
                        $twitterBCA = "<i class='fa fa-twitter'></i>";
                        $vkBCA = "<i class='fa fa-vk'></i>";
                        $yandexBCA = "<i class='fa fa-yandex'></i>";
                        $mailruBCA = "<i class='fa fa-mailru'></i>";
                        $facebookClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-facebook';
                        $googleClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-google';
                        $yahooClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-yahoo';
                        $twitterClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-twitter';
                        switch ($this->getConfig('locale')) {
                            case 'en':
                                $vkClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-vk-en';
                                $yandexClass = 'btn btn-default lenauth-bootstrap-simple '
                                . 'lenauth-bootstrap-simple-yandex-en';
                                break;
                            case 'ru':
                                $vkClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-vk-ru';
                                $yandexClass = 'btn btn-default lenauth-bootstrap-simple '
                                . 'lenauth-bootstrap-simple-yandex-ru';
                        }
                        $mailruClass = 'btn btn-default lenauth-bootstrap-simple lenauth-bootstrap-simple-mailru';
                        break;
                }
                if (!empty($classDivStr)
                    && (
                        $this->getConfig('facebook_enabled')
                        || $this->getConfig('google_enabled')
                        || $this->getConfig('yahoo_enabled')
                        || $this->getConfig('twitter_enabled')
                        || $this->getConfig('vk_enabled')
                        || $this->getConfig('yandex_enabled')
                        || $this->getConfig('mailru_enabled')
                   ) || $showExample
                ) {
                    if (!$autoWidth && $this->getConfig('button_width') > 0) {
                        $styleButtonStr .= 'width:' . $this->getConfig('button_width') . 'px;';
                    }
                    $styleDivStr .= '"';
                    $styleButtonStr .= '"';
                    $ret .= '<div class="lenauth-buttons' . (!empty($classDivStr) ? ' ' . $classDivStr : '')
                        . '"' . $styleDivStr . '><ul>';

                    $order_array = $this->getConfig('order')
                        ? json_decode($this->getConfig('order'), true) : $this->default_order;
                    foreach ($order_array as $service_name) :
                        switch ($service_name) {
                            case 'facebook':
                                if (($this->getConfig('facebook_enabled')
                                        && !empty($this->getConfig('facebook_app_id'))
                                        && !empty($this->getConfig('facebook_app_secret'))
                                        && !$showExample) || $showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $facebookClass . '" href="' . $facebookLink . '">' . $facebookBCA . ($hasText ? $this->getConfig('facebook_button_text') : '') . '</a></li>';
                                }
                                break;
                            case 'google':
                                if ($this->getConfig('google_enabled') && !empty($this->getConfig('google_client_id')) && !empty($this->getConfig('google_client_secret')) && !$showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $googleClass . '" href="' . $googleLink . '">' . $googleBCA . ($hasText ? $this->getConfig('google_button_text') : '') . '</a></li>';
                                }
                                break;

                            case 'yahoo':
                                if ($this->getConfig('yahoo_enabled') && !empty($this->getConfig('yahoo_consumer_key')) && !empty($this->getConfig('yahoo_consumer_secret')) && !$showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $yahooClass . '" href="' . $yahooLink . '">' . $yahooBCA . ($hasText ? $this->getConfig('yahoo_button_text') : '') . '</a></li>';
                                }
                                break;
                            case 'twitter':
                                if (($this->getConfig('twitter_enabled')
                                        && !empty($this->getConfig('twitter_consumer_key'))
                                        && !empty($this->getConfig('twitter_consumer_secret'))
                                        && !$showExample) || $showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $twitterClass . '" href="' . $twitterLink . '">' . $twitterBCA . ($hasText ? $this->getConfig('twitter_button_text') : '') . '</a></li>';
                                }
                                break;
                            case 'vk':
                                if ($this->getConfig('vk_enabled')
                                    && !empty($this->getConfig('vk_app_id'))
                                    && !empty($this->getConfig('vk_app_secret')) || $showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $vkClass . '" href="' . $vkLink . '">' . $vkBCA . ($hasText ? $this->getConfig('vk_button_text') : '') . '</a></li>';
                                }
                                break;
                            case 'yandex':
                                if ($this->getConfig('yandex_enabled')
                                    && !empty($this->getConfig('yandex_app_id'))
                                    && !empty($this->getConfig('yandex_app_password'))
                                    && !$showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $yandexClass . '" href="' . $yandexLink . '">' . $yandexBCA . ($hasText ? $this->getConfig('yandex_button_text') : '') . '</a></li>';
                                }
                                break;
                            case 'mailru':
                                if ($this->getConfig('mailru_enabled')
                                    && !empty($this->getConfig('mailru_site_id'))
                                    && !empty($this->getConfig('mailru_client_private'))
                                    && !empty($this->getConfig('mailru_client_secret'))
                                    && !$showExample) {
                                    $ret .= '<li' . $styleButtonStr . '><a class="' . $mailruClass . '" href="' . $mailruLink . '">' . $mailruBCA . ($hasText ? $this->getConfig('mailru_button_text') : '') . '</a></li>';
                                }
                                break;
                        }
                    endforeach;
                    $ret .= '</ul></div>';
                }
            }
        } else {
            $ret = get_string('style_not_defined', 'auth_lenauth');
        }
        return $ret;
    }
}
