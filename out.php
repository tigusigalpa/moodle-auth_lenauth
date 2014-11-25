<?php
/**
 * This file outputs buttons for Moodle website
 */

defined('MOODLE_INTERNAL') || die();

if ( get_called_class() != 'auth_plugin_lenauth' ) {
    require_once 'auth.php';
}

class auth_lenauth_out extends auth_plugin_lenauth {
    
    /**
     * instance var for Singleton
     * @var void
     */
    private static $_instance;

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Singleton
     * @return object
     */
    public static function getInstance() {
        if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof auth_lenauth_out ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * This method output or not output social buttons. Use it via Singleton
     * If user is not logged in - buttons shows, otherwise buttons hidden
     * 
     * @global object $CFG
     * @param string $style Buttons style to be output
     * @param boolean $show_example Special boolean parameter to output examples of buttons in the plugin admin screen
     * @param boolean $show_html Special boolean parameter to output only HTML code
     * @return string
     * 
     * @author Igor Sazonov
     */
    public function lenauth_output($style, $show_example = false, $show_html = false) {
        $ret = '';
        
        if ( in_array( $style, $this->_styles_array ) ) {
            
            if ( !isloggedin() || $show_example || $show_html ) {
                global $CFG;

                //$li_class = '';
                $style_button_str = ' style="display:' . $this->_oauth_config->auth_lenauth_display_buttons . ';';
                if ( $this->_oauth_config->auth_lenauth_button_margin_top > 0 || $this->_oauth_config->auth_lenauth_button_margin_right > 0 || $this->_oauth_config->auth_lenauth_button_margin_bottom > 0 || $this->_oauth_config->auth_lenauth_button_margin_right > 0 ) {
                    $style_button_str .= 'margin:' . $this->_oauth_config->auth_lenauth_button_margin_top . 'px ' . $this->_oauth_config->auth_lenauth_button_margin_right . 'px ' . $this->_oauth_config->auth_lenauth_button_margin_bottom . 'px ' . $this->_oauth_config->auth_lenauth_button_margin_right . 'px;';
                }

                $class_div_str = '';
                $style_div_str = ' style="display:' . $this->_oauth_config->auth_lenauth_display_div . ';';
                if ( $this->_oauth_config->auth_lenauth_div_margin_top > 0 || $this->_oauth_config->auth_lenauth_div_margin_right > 0 || $this->_oauth_config->auth_lenauth_div_margin_bottom > 0 || $this->_oauth_config->auth_lenauth_div_margin_right > 0 ) {
                    $style_div_str .= 'margin:' . $this->_oauth_config->auth_lenauth_div_margin_top . 'px ' . $this->_oauth_config->auth_lenauth_div_margin_right . 'px ' . $this->_oauth_config->auth_lenauth_div_margin_bottom . 'px ' . $this->_oauth_config->auth_lenauth_div_margin_right . 'px;';
                }
                if ( $this->_oauth_config->auth_lenauth_div_width > 0 ) {
                    $style_button_str .= 'width:' . $this->_oauth_config->auth_lenauth_div_width . 'px;';
                }
                
                $facebook_class = '';
                $google_class = '';
                $yahoo_class = '';
                $twitter_class = '';
                $vk_class = '';
                $yandex_class = '';
                $mailru_class = '';
                
                $has_text = false;
                $auto_width = true;
                
                $facebook_bca = '';
                $google_bca = '';
                $yahoo_bca = '';
                $twitter_bca = '';
                $vk_bca = '';
                $yandex_bca = '';
                $mailru_bca = '';
                //$ok_bca = '';

                $facebook_link = ( !$show_example ) ? 'https://www.facebook.com/dialog/oauth?client_id=' . $this->_oauth_config->auth_lenauth_facebook_app_id . '&redirect_uri=' . urlencode( $this->_lenauth_redirect_uri('facebook') ) . '&scope=email' : 'javascript:;';

                $google_link = ( !$show_example ) ? 'https://accounts.google.com/o/oauth2/auth?client_id=' . $this->_oauth_config->auth_lenauth_google_client_id . '&response_type=code&scope=openid%20profile%20email&redirect_uri=' . urlencode( $this->_lenauth_redirect_uri( 'google' ) ) : 'javascript:;';

                $yahoo_link = ( !$show_example ) ? $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=yahoo' : 'javascript:;';

                $twitter_link = ( !$show_example ) ? $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=twitter' : 'javascript:;';

                $vk_link = ( !$show_example ) ? 'https://oauth.vk.com/authorize?client_id=' . $this->_oauth_config->auth_lenauth_vk_app_id . '&scope=email&redirect_uri=' . urlencode( $this->_lenauth_redirect_uri( 'vk' ) ) . '&response_type=code&v=' . parent::$vk_api_version : 'javascript:;';
                
                if ( !$show_example ) {
                    switch ($this->_oauth_config->auth_lenauth_locale) {
                        case 'en':
                            $yandex_link = 'https://oauth.yandex.com/authorize?response_type=code&client_id=' . $this->_oauth_config->auth_lenauth_yandex_app_id . '&display=popup';
                            break;
                        case 'ru':
                            $yandex_link = 'https://oauth.yandex.ru/authorize?response_type=code&client_id=' . $this->_oauth_config->auth_lenauth_yandex_app_id . '&display=popup';
                            break;
                    }
                } else {
                    $yandex_link = 'javascript:;';
                }

                $mailru_link = ( !$show_example ) ? 'https://connect.mail.ru/oauth/authorize?client_id=' . $this->_oauth_config->auth_lenauth_mailru_site_id . '&redirect_uri=' . urlencode( $this->_lenauth_redirect_uri( 'mailru' ) ) . '&response_type=code' : 'javascript:;';

                //$ok_class = 'ok';
                //$ok_link = ( !$show_example ) ? 'https://accounts.google.com/o/oauth2/auth?client_id=' . $this->_oauth_config->auth_lenauth_google_client_id . '&response_type=code&scope=openid%20profile%20email&redirect_uri=' . urlencode( $CFG->wwwroot . '/auth/lenauth/redirect.php?auth_service=google' ) : 'javascript:;';

                switch( $style ) {
                    case 'default':
                        $has_text = true;
                        $class_div_str = 'lenauth-default';
                        break;
                    case 'style1':
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon style1';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';
                        break;
                    case 'style1-dark-white':
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon style1 lenauth-dark lenauth-white';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';
                        break;
                    case 'style1-light-black':
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon style1 lenauth-light lenauth-black';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';
                        break;
                    case 'style1-text':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon-text style1';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';

                        $auto_width = false;
                        break;
                    case 'style2-text':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon-text style2';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';


                        $auto_width = false;
                        break;
                    case 'style3-text':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon-text style3';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';

                        $auto_width = false;
                        break;
                    case 'style4-text':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-1-4 lenauth-icon-text style4';
                        $facebook_class = 'lenauth-ico-facebook';
                        $google_class = 'lenauth-ico-google-plus';
                        $yahoo_class = 'lenauth-ico-yahoo';
                        $twitter_class = 'lenauth-ico-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-ico-vk-en';
                                $yandex_class = 'lenauth-ico-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-ico-vk-ru';
                                $yandex_class = 'lenauth-ico-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-ico-mailru';
                        //$ok_class = 'lenauth-ico-ok';
                        break;
                    case 'smooth-w32-button-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                                break;
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-button-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-button-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w32 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-button-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w48 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-button-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-button w64 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;

                    case 'smooth-w32-classic-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-classic-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w32-classic-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w32 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w48-classic-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w48 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-square':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-square';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-rounded':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-rounded';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'smooth-w64-classic-circle':
                        $class_div_str = 'lenauth-smooth lenauth-smooth-classic w64 lenauth-smooth-circle';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span class="link_act"><label class="img_act"></label></span>';
                        $facebook_class = 'lenauth-smooth-button-facebook';
                        $google_class = 'lenauth-smooth-button-googleplus';
                        $yahoo_class = 'lenauth-smooth-button-yahoo';
                        $twitter_class = 'lenauth-smooth-button-twitter-1';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-smooth-button-vk-en';
                                $yandex_class = 'lenauth-smooth-button-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-smooth-button-vk-ru';
                                $yandex_class = 'lenauth-smooth-button-yandex-ru';
                        }
                        $mailru_class = 'lenauth-smooth-button-mailru';
                        break;
                    case 'simple-3d':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-5 lenauth-simple-3d';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case 'simple-3d-small':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-5 lenauth-simple-3d small';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case '3d-circle':
                        $class_div_str = 'lenauth-style-5 lenauth-circle-3d';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case '3d-circle-small':
                        $class_div_str = 'lenauth-style-5 lenauth-circle-3d small';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-5 lenauth-simple-flat';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-small':
                        $has_text = true;
                        $class_div_str = 'lenauth-style-5 lenauth-simple-flat small';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-circle':
                        $class_div_str = 'lenauth-style-5 lenauth-circle-flat';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                    case 'simple-flat-circle-small':
                        $class_div_str = 'lenauth-style-5 lenauth-circle-flat small';
                        $facebook_bca = $google_bca = $yahoo_bca = $twitter_bca = $vk_bca = $yandex_bca = $mailru_bca = '<span></span>';
                        $facebook_class = 'lenauth-style5-facebook';
                        $google_class = 'lenauth-style5-googlep';
                        $yahoo_class = 'lenauth-style5-yahoo';
                        $twitter_class = 'lenauth-style5-twitter';
                        switch ($this->_oauth_config->auth_lenauth_locale) {
                            case 'en':
                                $vk_class = 'lenauth-style5-vk-en';
                                $yandex_class = 'lenauth-style5-yandex-en';
                                break;
                            case 'ru':
                                $vk_class = 'lenauth-style5-vk-ru';
                                $yandex_class = 'lenauth-style5-yandex-ru';
                        }
                        $mailru_class = 'lenauth-style5-mailru';
                        break;
                }

                if ( !empty( $class_div_str ) 
                        && ( 
                            $this->_oauth_config->auth_lenauth_facebook_enabled 
                            || $this->_oauth_config->auth_lenauth_google_enabled 
                            || $this->_oauth_config->auth_lenauth_yahoo_enabled 
                            || $this->_oauth_config->auth_lenauth_twitter_enabled 
                            || $this->_oauth_config->auth_lenauth_vk_enabled 
                            || $this->_oauth_config->auth_lenauth_yandex_enabled 
                            || $this->_oauth_config->auth_lenauth_mailru_enabled 
                        ) || $show_example
                ) {

                    if ( !$auto_width && $this->_oauth_config->auth_lenauth_button_width > 0 ) {
                        $style_button_str .= 'width:' . $this->_oauth_config->auth_lenauth_button_width . 'px;';
                    }

                    $style_div_str .= '"';
                    $style_button_str .= '"';

                    $ret .= '<div class="lenauth-buttons' . ( !empty( $class_div_str ) ? ' ' . $class_div_str : '' ) .'"' . $style_div_str . '><ul>';

                    if ( ( $this->_oauth_config->auth_lenauth_facebook_enabled && !empty( $this->_oauth_config->auth_lenauth_facebook_app_id ) && !empty( $this->_oauth_config->auth_lenauth_facebook_app_secret ) && !$show_example ) || $show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $facebook_class . '" href="' . $facebook_link . '">' . $facebook_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_facebook_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( $this->_oauth_config->auth_lenauth_google_enabled && !empty( $this->_oauth_config->auth_lenauth_google_client_id ) && !empty( $this->_oauth_config->auth_lenauth_google_client_secret ) && !$show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $google_class . '" href="' . $google_link . '">' . $google_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_google_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( $this->_oauth_config->auth_lenauth_yahoo_enabled && !empty( $this->_oauth_config->auth_lenauth_yahoo_consumer_key ) && !empty( $this->_oauth_config->auth_lenauth_yahoo_consumer_secret ) && !$show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $yahoo_class . '" href="' . $yahoo_link . '">' . $yahoo_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_yahoo_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( ( $this->_oauth_config->auth_lenauth_twitter_enabled && !empty( $this->_oauth_config->auth_lenauth_twitter_consumer_key ) && !empty( $this->_oauth_config->auth_lenauth_twitter_consumer_secret ) && !$show_example ) || $show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $twitter_class . '" href="' . $twitter_link . '">' . $twitter_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_twitter_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( $this->_oauth_config->auth_lenauth_vk_enabled && !empty( $this->_oauth_config->auth_lenauth_vk_app_id ) && !empty( $this->_oauth_config->auth_lenauth_vk_app_secret ) || $show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $vk_class . '" href="' . $vk_link . '">' . $vk_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_vk_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( $this->_oauth_config->auth_lenauth_yandex_enabled && !empty( $this->_oauth_config->auth_lenauth_yandex_app_id ) && !empty( $this->_oauth_config->auth_lenauth_yandex_app_password ) && !$show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $yandex_class . '" href="' . $yandex_link . '">' . $yandex_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_yandex_button_text : ( '' ) ) . '</a></li>';
                    }

                    if ( $this->_oauth_config->auth_lenauth_mailru_enabled && !empty( $this->_oauth_config->auth_lenauth_mailru_site_id ) && !empty( $this->_oauth_config->auth_lenauth_mailru_client_private ) && !empty( $this->_oauth_config->auth_lenauth_mailru_client_secret ) && !$show_example ) {
                        $ret .= '<li' . $style_button_str . '><a class="' . $mailru_class . '" href="' . $mailru_link . '">' . $mailru_bca . ( ( $has_text ) ? $this->_oauth_config->auth_lenauth_mailru_button_text : ( '' ) ) . '</a></li>';
                    }

                    /*if ( $this->_oauth_config->ok_enabled && !empty( $this->_oauth_config->ok_app_id ) && !empty( $this->_oauth_config->ok_public_key ) && !empty( $this->_oauth_config->ok_secret_key ) && !$show_example ) {
                        $ret .= '<a class="' . $style_class . ' ' . $ok_class . '" href="' . $ok_link . '"' . $style_button_str . '>' . $ok_bca . ( ( $has_text ) ? $this->_oauth_config->ok_button_text : ( '' ) ) . '</a>';
                    }*/

                    $ret .= '</ul></div>';

                }
            }
        } else {
            $ret = get_string( 'auth_lenauth_style_not_defined', 'auth_lenauth' );
        }

        return $ret;
    }
    
}
