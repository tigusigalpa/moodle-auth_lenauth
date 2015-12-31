<?php
defined('MOODLE_INTERNAL') || die();
require_once('out.php');
global $CFG;
?>

<table cellspacing="0" cellpadding="5" border="0">
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_lenauth_main_settings', 'auth_lenauth' ); ?></h3></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_user_prefix"><?php echo get_string( 'auth_lenauth_user_prefix_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_user_prefix',
                                            'name'    => 'auth_lenauth_user_prefix',
                                            'class'   => 'auth_lenauth_user_prefix',
                                            'value'   => $config->auth_lenauth_user_prefix,
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['auth_lenauth_user_prefix'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_user_prefix'] );
        } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_user_prefix_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_default_country"><?php echo get_string( 'auth_lenauth_default_country_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php
            echo html_writer::select(
                get_string_manager()->get_list_of_countries(),
                'auth_lenauth_default_country',
                $config->auth_lenauth_default_country,
                get_string('selectacountry') . '...',
                array(
                    'id'    => 'auth_lenauth_default_country',
                    'class' => 'auth_lenauth_default_country'
                )
            );
            if ( isset( $err['auth_lenauth_default_country'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_default_country'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_default_country_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td width="50%" colspan="2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="7%">
                        <input type="radio" name="auth_lenauth_locale" id="auth_lenauth_locale_en" class="auth_lenauth_locale_en" value="en"<?php echo ( $config->auth_lenauth_locale == 'en' || empty( $config->auth_lenauth_locale ) ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['auth_lenauth_locale'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_locale'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="auth_lenauth_locale_en"><?php echo get_string( 'auth_lenauth_locale_en_key', 'auth_lenauth' ); ?></label>
                    </td>
                    <td width="7%">
                        <input type="radio" name="auth_lenauth_locale" id="auth_lenauth_locale_ru" class="auth_lenauth_locale_ru" value="ru"<?php echo ( $config->auth_lenauth_locale == 'ru' ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['auth_lenauth_locale'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_locale'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="auth_lenauth_locale_ru"><?php echo get_string( 'auth_lenauth_locale_ru_key', 'auth_lenauth' ); ?></label>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_locale_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <!--tr>
        <td width="100%" colspan="3"><?php 
            echo html_writer::checkbox( 
                    'can_change_password', 1, 
                    $config->can_change_password, 
                    get_string( 'can_change_password', 'auth_lenauth' ), array( 'id' => 'can_change_password' )
            );
            if ( isset( $err['can_change_password'] ) ) {
                echo $OUTPUT->error_text( $err['can_change_password'] );
            } ?>
        </td>
    </tr-->
    <tr>
        <td width="50%" colspan="2"><?php 
            echo html_writer::checkbox( 
                    'auth_lenauth_can_reset_password', 1,
                    $config->auth_lenauth_can_reset_password,
                    get_string( 'auth_lenauth_can_reset_password_key', 'auth_lenauth' ), array( 'id' => 'auth_lenauth_can_reset_password' )
            );
            if ( isset( $err['auth_lenauth_can_reset_password'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_can_reset_password'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_can_reset_password_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <!--tr>
        <td align="right" width="15%"><label for="password_expire"><?php echo get_string( 'password_expire_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'password_expire',
                                            'name'    => 'password_expire',
                                            'class'   => 'password_expire',
                                            'value'   => $config->password_expire,
                                            'size'    => 5,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['password_expire'] ) ) {
            echo $OUTPUT->error_text( $err['password_expire'] );
        } ?>
        </td>
        <td width="50%"><?php echo get_string( 'password_expire_desc', 'auth_lenauth' ); ?></td>
    </tr-->
    <tr>
        <td width="50%" colspan="2"><?php 
            echo html_writer::checkbox( 
                    'auth_lenauth_can_confirm', 1,
                    isset( $config->auth_lenauth_can_confirm ) ? $config->auth_lenauth_can_confirm : 0,
                    get_string( 'auth_lenauth_can_confirm_key', 'auth_lenauth' ), array( 'id' => 'auth_lenauth_can_confirm' )
            );
            if ( isset( $err['auth_lenauth_can_confirm'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_can_confirm'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_can_confirm_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td width="50%" colspan="2"><?php
            echo html_writer::checkbox(
                'auth_lenauth_retrieve_avatar', 1,
                isset( $config->auth_lenauth_retrieve_avatar ) ? $config->auth_lenauth_retrieve_avatar : 0,
                get_string( 'auth_lenauth_retrieve_avatar_key', 'auth_lenauth' ), array( 'id' => 'auth_lenauth_retrieve_avatar' )
            );
            if ( isset( $err['auth_lenauth_retrieve_avatar'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_retrieve_avatar'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_retrieve_avatar_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <?php if ( $CFG->debugdeveloper == 1 ) : ?>
    <tr>
        <td width="50%" colspan="2"><?php
            echo html_writer::checkbox(
                'auth_lenauth_dev_mode', 1,
                isset( $config->auth_lenauth_dev_mode ) ? $config->auth_lenauth_dev_mode : 0,
                get_string( 'auth_lenauth_dev_mode_key', 'auth_lenauth' ), array( 'id' => 'auth_lenauth_dev_mode' )
            );
            if ( isset( $err['auth_lenauth_dev_mode'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_dev_mode'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'auth_lenauth_dev_mode_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <?php else : ?>
    
    <?php endif; ?>
    
    <!----------FACEBOOK---------->
    <tr>
        <td colspan="3">
            <h3>
                <?php echo get_string( 'auth_lenauth_facebook_settings', 'auth_lenauth' );
                if ( !empty( $config->auth_lenauth_facebook_app_id ) ) :
                    echo ' ( ' . html_writer::link( new moodle_url( 'https://developers.facebook.com/apps/' . $config->auth_lenauth_facebook_app_id . '/dashboard/' ), get_string( 'auth_lenauth_facebook_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
                endif; ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'auth_lenauth_facebook_enabled', 1,
                    $config->auth_lenauth_facebook_enabled,
                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) ); ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_facebook_app_id"><?php echo get_string( 'auth_lenauth_facebook_app_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_facebook_app_id',
                                            'name'    => 'auth_lenauth_facebook_app_id',
                                            'class'   => 'auth_lenauth_facebook_app_id',
                                            'value'   => !empty( $config->auth_lenauth_facebook_app_id ) ? $config->auth_lenauth_facebook_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_facebook_app_id'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_facebook_app_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="4" valign="top"><?php echo get_string( 'auth_lenauth_facebook_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_facebook_app_secret"><?php echo get_string( 'auth_lenauth_facebook_app_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_facebook_app_secret',
                                            'name'    => 'auth_lenauth_facebook_app_secret',
                                            'class'   => 'auth_lenauth_facebook_app_secret',
                                            'value'   => !empty( $config->auth_lenauth_facebook_app_secret ) ? $config->auth_lenauth_facebook_app_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_facebook_app_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_facebook_app_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_facebook_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_facebook_button_text',
                                            'name'    => 'auth_lenauth_facebook_button_text',
                                            'class'   => 'auth_lenauth_facebook_button_text',
                                            'value'   => !empty( $config->auth_lenauth_facebook_button_text ) ? $config->auth_lenauth_facebook_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_facebook_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_facebook_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_facebook_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_facebook_social_id_field_disabled',
                        $config->auth_lenauth_facebook_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_facebook_social_id_field',
                            'class' => 'auth_lenauth_facebook_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_facebook_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_facebook_social_id_field'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_facebook_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_facebook_order',
                    'name'    => 'auth_lenauth_order[facebook]',
                    'class'   => 'auth_lenauth_facebook_order',
                    'value'   => array_search( 'facebook', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>
    
    <!----------GOOGLE---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_lenauth_google_settings', 'auth_lenauth' );
            if ( !empty( $config->auth_lenauth_google_project_id ) ) {
                echo ' ( <strong><a href="https://console.developers.google.com/project/' . $config->auth_lenauth_google_project_id . '/apiui/credential" target="_blank">' . get_string( 'auth_lenauth_google_dashboard', 'auth_lenauth' ) . '</a></strong> )';
            } ?>

            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3"><?php echo html_writer::checkbox( 'auth_lenauth_google_enabled', 1,
                    $config->auth_lenauth_google_enabled,
                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['auth_lenauth_google_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_google_enabled'] );
        } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_client_id"><?php echo get_string( 'auth_lenauth_google_client_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_google_client_id',
                                            'name'    => 'auth_lenauth_google_client_id',
                                            'class'   => 'auth_lenauth_google_client_id',
                                            'value'   => !empty( $config->auth_lenauth_google_client_id ) ? $config->auth_lenauth_google_client_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_google_client_id'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_google_client_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="6" valign="top"><?php echo get_string( 'auth_lenauth_google_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_client_secret"><?php echo get_string( 'auth_lenauth_google_client_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_google_client_secret',
                                            'name'    => 'auth_lenauth_google_client_secret',
                                            'class'   => 'auth_lenauth_google_client_secret',
                                            'value'   => !empty( $config->auth_lenauth_google_client_secret ) ? $config->auth_lenauth_google_client_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_google_client_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_google_client_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_project_id"><?php echo get_string( 'auth_lenauth_google_project_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_google_project_id',
                                            'name'    => 'auth_lenauth_google_project_id',
                                            'class'   => 'auth_lenauth_google_project_id',
                                            'value'   => !empty( $config->auth_lenauth_google_project_id ) ? $config->auth_lenauth_google_project_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_google_project_id'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_google_project_id'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_google_button_text',
                                            'name'    => 'auth_lenauth_google_button_text',
                                            'class'   => 'auth_lenauth_google_button_text',
                                            'value'   => !empty( $config->auth_lenauth_google_button_text ) ? $config->auth_lenauth_google_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_google_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_google_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_google_social_id_field_disabled',
                        $config->auth_lenauth_google_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_google_social_id_field',
                            'class' => 'auth_lenauth_google_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_google_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_google_social_id_field'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[google]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'google', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>
    
    <!----------YAHOO---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_lenauth_yahoo_settings', 'auth_lenauth' );
            if ( !empty( $config->auth_lenauth_yahoo_application_id ) ) {
                echo ' ( <strong><a href="https://developer.apps.yahoo.com/projects/' . $config->auth_lenauth_yahoo_application_id . '" target="_blank">' . get_string( 'auth_lenauth_google_dashboard', 'auth_lenauth' ) . '</a></strong> )';
            }
        ?></h3></td>
    </tr>
    <tr>
        <td>
            <?php echo html_writer::checkbox( 'auth_lenauth_yahoo_enabled', 1,
                                    $config->auth_lenauth_yahoo_enabled,
                                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['auth_lenauth_yahoo_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_enabled'] );
        } ?>
        </td>
        <td>
            <table border="0" width="100%">
                <tr>
                    <td width="7%">
                        <input type="radio" name="auth_lenauth_yahoo_oauth_version" id="auth_lenauth_yahoo_oauth_version_1" class="auth_lenauth_yahoo_oauth_version" value="1"<?php echo ( empty( $config->auth_lenauth_yahoo_oauth_version ) || ( !empty( $config->auth_lenauth_yahoo_oauth_version ) && $config->auth_lenauth_yahoo_oauth_version == 1 ) ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['auth_lenauth_yahoo_oauth_version'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_oauth_version'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="auth_lenauth_yahoo_oauth_version_1"><strong>OAuth 1.0</strong><br />(<em><?php echo get_string( 'auth_lenauth_yahoo_oauth_1_note', 'auth_lenauth' ); ?></em>)</label>
                    </td>
                    <td width="7%">
                        <input type="radio" name="auth_lenauth_yahoo_oauth_version" id="auth_lenauth_yahoo_oauth_version_2" class="auth_lenauth_yahoo_oauth_version" value="2"<?php echo ( !empty( $config->auth_lenauth_yahoo_oauth_version ) && $config->auth_lenauth_yahoo_oauth_version == 2 ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['auth_lenauth_yahoo_oauth_version'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_oauth_version'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="auth_lenauth_yahoo_oauth_version_2"><strong>OAuth 2.0</strong><br />(<em><?php echo get_string( 'auth_lenauth_yahoo_oauth_2_note', 'auth_lenauth' ); ?></em>)</label>
                    </td>
                </tr>
            </table>
        </td>
        <td></td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yahoo_application_id">
                <?php echo get_string( 'auth_lenauth_yahoo_application_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yahoo_application_id',
                                            'name'    => 'auth_lenauth_yahoo_application_id',
                                            'class'   => 'auth_lenauth_yahoo_application_id',
                                            'value'   => !empty( $config->auth_lenauth_yahoo_application_id ) ? $config->auth_lenauth_yahoo_application_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_yahoo_application_id'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_application_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="6" valign="top"><?php echo get_string( 'auth_lenauth_yahoo_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yahoo_consumer_key"><?php echo get_string( 'auth_lenauth_yahoo_consumer_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yahoo_consumer_key',
                                            'name'    => 'auth_lenauth_yahoo_consumer_key',
                                            'class'   => 'auth_lenauth_yahoo_consumer_key',
                                            'value'   => !empty( $config->auth_lenauth_yahoo_consumer_key ) ? $config->auth_lenauth_yahoo_consumer_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_yahoo_consumer_key'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_consumer_key'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yahoo_consumer_secret"><?php echo get_string( 'auth_lenauth_yahoo_consumer_secret', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yahoo_consumer_secret',
                                            'name'    => 'auth_lenauth_yahoo_consumer_secret',
                                            'class'   => 'auth_lenauth_yahoo_consumer_secret',
                                            'value'   => !empty( $config->auth_lenauth_yahoo_consumer_secret ) ? $config->auth_lenauth_yahoo_consumer_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_yahoo_consumer_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_consumer_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yahoo_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yahoo_button_text',
                                            'name'    => 'auth_lenauth_yahoo_button_text',
                                            'class'   => 'auth_lenauth_yahoo_button_text',
                                            'value'   => !empty( $config->auth_lenauth_yahoo_button_text ) ? $config->auth_lenauth_yahoo_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_yahoo_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yahoo_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_yahoo_social_id_field_disabled',
                        $config->auth_lenauth_yahoo_social_id_field,
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_yahoo_social_id_field',
                            'class' => 'auth_lenauth_yahoo_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_yahoo_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yahoo_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="auth_lenauth_yahoo_social_id_field" value="<?php echo $config->auth_lenauth_yahoo_social_id_field; ?>" /-->
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[yahoo]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'yahoo', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>
    
    <!----------TWITTER---------->
    <tr>
        <td colspan="3">
            <h3>
                <?php echo get_string( 'auth_lenauth_twitter_settings', 'auth_lenauth' ); ?>
                <?php if ( !empty( $config->auth_lenauth_twitter_application_id ) ) {
                    echo ' ( <strong><a href="https://apps.twitter.com/app/' . $config->auth_lenauth_twitter_application_id . '" target="_blank">' . get_string( 'auth_lenauth_twitter_dashboard', 'auth_lenauth' ) . '</a></strong> )';
                } ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'auth_lenauth_twitter_enabled', 1,
                        $config->auth_lenauth_twitter_enabled,
                        get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['auth_lenauth_twitter_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_twitter_enabled'] );
        } ?>
        </td>
    </tr>
    <tr>
        <td colspan="3"><?php 
                            html_writer::checkbox( 'auth_lenauth_twitter_enabled', 1,
                                    $config->auth_lenauth_twitter_enabled,
                                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['auth_lenauth_twitter_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_twitter_enabled'] );
        } ?>
        </td>
    </tr>
    
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_twitter_application_id">
                <?php echo get_string( 'auth_lenauth_twitter_application_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_twitter_application_id',
                                            'name'    => 'auth_lenauth_twitter_application_id',
                                            'class'   => 'auth_lenauth_twitter_application_id',
                                            'value'   => !empty( $config->auth_lenauth_twitter_application_id ) ? $config->auth_lenauth_twitter_application_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_twitter_application_id'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_twitter_application_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="6" valign="top"><?php echo get_string( 'auth_lenauth_twitter_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_twitter_consumer_key"><?php echo get_string( 'auth_lenauth_twitter_consumer_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_twitter_consumer_key',
                                            'name'    => 'auth_lenauth_twitter_consumer_key',
                                            'class'   => 'auth_lenauth_twitter_consumer_key',
                                            'value'   => !empty( $config->auth_lenauth_twitter_consumer_key ) ? $config->auth_lenauth_twitter_consumer_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_twitter_consumer_key'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_twitter_consumer_key'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_twitter_consumer_secret"><?php echo get_string( 'auth_lenauth_twitter_consumer_secret', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_twitter_consumer_secret',
                                            'name'    => 'auth_lenauth_twitter_consumer_secret',
                                            'class'   => 'auth_lenauth_twitter_consumer_secret',
                                            'value'   => !empty( $config->auth_lenauth_twitter_consumer_secret ) ? $config->auth_lenauth_twitter_consumer_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_twitter_consumer_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_twitter_consumer_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_twitter_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_twitter_button_text',
                                            'name'    => 'auth_lenauth_twitter_button_text',
                                            'class'   => 'auth_lenauth_twitter_button_text',
                                            'value'   => !empty( $config->auth_lenauth_twitter_button_text ) ? $config->auth_lenauth_twitter_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_twitter_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_twitter_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_twitter_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_twitter_social_id_field_disabled',
                        $config->auth_lenauth_twitter_social_id_field,
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_twitter_social_id_field',
                            'class' => 'auth_lenauth_twitter_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_twitter_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_twitter_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="auth_lenauth_twitter_social_id_field" value="<?php echo $config->auth_lenauth_twitter_social_id_field; ?>" /-->
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[twitter]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'twitter', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>
    
    <!----------VK.COM---------->
    <tr>
        <td colspan="3">
            <h3><?php echo get_string( 'auth_lenauth_vk_settings', 'auth_lenauth' );
            if ( !empty( $config->auth_lenauth_vk_app_id ) ) :
                echo ' ( ' . html_writer::link( new moodle_url( 'http://vk.com/editapp?id=' . $config->auth_lenauth_vk_app_id . '&section=options' ), get_string( 'auth_lenauth_vk_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
            endif; ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'auth_lenauth_vk_enabled', 1,
                    $config->auth_lenauth_vk_enabled,
                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
                    if ( isset( $err['auth_lenauth_vk_enabled'] ) ) {
                        echo $OUTPUT->error_text( $err['auth_lenauth_vk_enabled'] );
                    } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_vk_app_id"><?php echo get_string( 'auth_lenauth_vk_app_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_vk_app_id',
                                            'name'    => 'auth_lenauth_vk_app_id',
                                            'class'   => 'auth_lenauth_vk_app_id',
                                            'value'   => !empty( $config->auth_lenauth_vk_app_id ) ? $config->auth_lenauth_vk_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_vk_app_id'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_vk_app_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'auth_lenauth_vk_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_vk_app_secret"><?php echo get_string( 'auth_lenauth_vk_app_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_vk_app_secret',
                                            'name'    => 'auth_lenauth_vk_app_secret',
                                            'class'   => 'auth_lenauth_vk_app_secret',
                                            'value'   => !empty( $config->auth_lenauth_vk_app_secret ) ? $config->auth_lenauth_vk_app_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_vk_app_secret'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_vk_app_secret'] );
            } ?>
            </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_vk_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_vk_button_text',
                                            'name'    => 'auth_lenauth_vk_button_text',
                                            'class'   => 'auth_lenauth_vk_button_text',
                                            'value'   => !empty( $config->auth_lenauth_vk_button_text ) ? $config->auth_lenauth_vk_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_vk_button_text'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_vk_button_text'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_vk_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_vk_social_id_field_disabled',
                        $config->auth_lenauth_vk_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_vk_social_id_field',
                            'class' => 'auth_lenauth_vk_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_vk_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_vk_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="auth_lenauth_vk_social_id_field" value="<?php echo $config->auth_lenauth_vk_social_id_field; ?>" /-->
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[vk]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'vk', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>
    
    <!----------YANDEX.RU---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_lenauth_yandex_settings', 'auth_lenauth' );
        if ( !empty( $config->auth_lenauth_yandex_app_id ) ) :
            echo ' ( ' . html_writer::link( new moodle_url( 'https://oauth.yandex.ru/client/' . $config->auth_lenauth_yandex_app_id ), get_string( 'auth_lenauth_yandex_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) );
            echo ' | ' . html_writer::link( new moodle_url( 'https://oauth.yandex.com/client/' . $config->auth_lenauth_yandex_app_id ), 'eng', array( 'target' => '_blank' ) ) . ' )';
        endif;
        ?>
        </h3></td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'auth_lenauth_yandex_enabled', 1,
                    $config->auth_lenauth_yandex_enabled,
                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
            if ( isset( $err['auth_lenauth_yandex_enabled'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_yandex_enabled'] );
            } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yandex_app_id"><?php echo get_string( 'auth_lenauth_yandex_app_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yandex_app_id',
                                            'name'    => 'auth_lenauth_yandex_app_id',
                                            'class'   => 'auth_lenauth_yandex_app_id',
                                            'value'   => !empty( $config->auth_lenauth_yandex_app_id ) ? $config->auth_lenauth_yandex_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['auth_lenauth_yandex_app_id'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yandex_app_id'] );
        }
        ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'auth_lenauth_yandex_desc', 'auth_lenauth', $CFG ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yandex_app_password"><?php echo get_string( 'auth_lenauth_yandex_app_password_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yandex_app_password',
                                            'name'    => 'auth_lenauth_yandex_app_password',
                                            'class'   => 'auth_lenauth_yandex_app_password',
                                            'value'   => !empty( $config->auth_lenauth_yandex_app_password ) ? $config->auth_lenauth_yandex_app_password : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['auth_lenauth_yandex_app_password'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yandex_app_password'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yandex_button_text"><?php echo get_string( 'auth_lenauth_buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_yandex_button_text',
                                            'name'    => 'auth_lenauth_yandex_button_text',
                                            'class'   => 'auth_lenauth_yandex_button_text',
                                            'value'   => !empty( $config->auth_lenauth_yandex_button_text ) ? $config->auth_lenauth_yandex_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['auth_lenauth_yandex_button_text'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yandex_button_text'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_yandex_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_yandex_social_id_field_disabled',
                        $config->auth_lenauth_yandex_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_yandex_social_id_field',
                            'class' => 'auth_lenauth_yandex_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_yandex_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_yandex_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="auth_lenauth_yandex_social_id_field" value="<?php echo $config->auth_lenauth_yandex_social_id_field; ?>" /-->
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[yandex]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'yandex', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>


    <!----------MAIL.RU---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_lenauth_mailru_settings', 'auth_lenauth' );
        if ( !empty( $config->auth_lenauth_mailru_site_id ) ) :
            echo ' ( ' . html_writer::link( new moodle_url( 'http://api.mail.ru/sites/my/' . $config->auth_lenauth_mailru_site_id ), get_string( 'auth_lenauth_mailru_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
        endif; ?>
        </h3></td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'auth_lenauth_mailru_enabled', 1,
                    $config->auth_lenauth_mailru_enabled,
                    get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
            if ( isset( $err['auth_lenauth_mailru_enabled'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_mailru_enabled'] );
            } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_mailru_site_id"><?php echo get_string( 'auth_lenauth_mailru_site_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_mailru_site_id',
                                            'name'    => 'auth_lenauth_mailru_site_id',
                                            'class'   => 'auth_lenauth_mailru_site_id',
                                            'value'   => !empty( $config->auth_lenauth_mailru_site_id ) ? $config->auth_lenauth_mailru_site_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['auth_lenauth_mailru_site_id'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_mailru_site_id'] );
        } ?>
        </td>
        <td width="50%" rowspan="6" valign="top"><?php echo get_string( 'auth_lenauth_mailru_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_mailru_client_private"><?php echo get_string('auth_lenauth_mailru_client_private_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_mailru_client_private',
                                            'name'    => 'auth_lenauth_mailru_client_private',
                                            'class'   => 'auth_lenauth_mailru_client_private',
                                            'value'   => !empty( $config->auth_lenauth_mailru_client_private ) ? $config->auth_lenauth_mailru_client_private : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['auth_lenauth_mailru_client_private'] ) ) {
                echo $OUTPUT->error_text( $err['auth_lenauth_mailru_client_private'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_mailru_client_secret"><?php echo get_string('auth_lenauth_mailru_client_secret_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_mailru_client_secret',
                                            'name'    => 'auth_lenauth_mailru_client_secret',
                                            'class'   => 'auth_lenauth_mailru_client_secret',
                                            'value'   => !empty( $config->auth_lenauth_mailru_client_secret ) ? $config->auth_lenauth_mailru_client_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_mailru_client_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_mailru_client_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_mailru_button_text"><?php echo get_string('auth_lenauth_buttontext_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'auth_lenauth_mailru_button_text',
                                            'name'    => 'auth_lenauth_mailru_button_text',
                                            'class'   => 'auth_lenauth_mailru_button_text',
                                            'value'   => !empty( $config->auth_lenauth_mailru_button_text ) ? $config->auth_lenauth_mailru_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['auth_lenauth_mailru_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['auth_lenauth_mailru_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_mailru_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_mailru_social_id_field_disabled',
                        $config->auth_lenauth_mailru_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_mailru_social_id_field',
                            'class' => 'auth_lenauth_mailru_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_mailru_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_mailru_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="auth_lenauth_mailru_social_id_field" value="<?php echo $config->auth_lenauth_mailru_social_id_field; ?>" /-->
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_google_order"><?php echo get_string( 'auth_lenauth_order', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                array( 'type' => 'number',
                    'id'      => 'auth_lenauth_google_order',
                    'name'    => 'auth_lenauth_order[mailru]',
                    'class'   => 'auth_lenauth_google_order',
                    'value'   => array_search( 'mailru', $order_array ),
                    'size'    => 10,
                    'min'     => 1,
                    'max'     => 7,
                    'maxlength' => 1,
                    'autocomplete' => 'off' )
            ); ?>
        </td>
    </tr>

    <!----------ODNOKLASSNIKI---------->
    <!--tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_ok_settings', 'auth_lenauth' ); ?></h3></td>
    </tr>
    <tr>
        <td colspan="3"><?php echo html_writer::checkbox( 'ok_enabled', 1,
                        $config->ok_enabled,
                        get_string( 'auth_lenauth_enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['ok_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['ok_enabled'] );
        } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="ok_app_id"><?php echo get_string( 'auth_ok_app_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'ok_app_id',
                                            'name'    => 'ok_app_id',
                                            'class'   => 'ok_app_id',
                                            'value'   => !empty( $config->ok_app_id ) ? $config->ok_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['ok_app_id'] ) ) {
                echo $OUTPUT->error_text( $err['ok_app_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="ok_public_key"><?php echo get_string( 'auth_ok_public_key_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'ok_public_key',
                                            'name'    => 'ok_public_key',
                                            'class'   => 'ok_public_key',
                                            'value'   => !empty( $config->ok_public_key ) ? $config->ok_public_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['ok_public_key'] ) ) {
                    echo $OUTPUT->error_text( $err['ok_public_key'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="ok_secret_key"><?php echo get_string( 'auth_ok_secret_key_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'ok_secret_key',
                                            'name'    => 'ok_secret_key',
                                            'class'   => 'ok_secret_key',
                                            'value'   => !empty( $config->ok_secret_key ) ? $config->ok_secret_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                    if ( isset( $err['ok_secret_key'] ) ) {
                        echo $OUTPUT->error_text( $err['ok_secret_key'] );
                    } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="ok_button_text"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'ok_button_text',
                                            'name'    => 'ok_button_text',
                                            'class'   => 'ok_button_text',
                                            'value'   => !empty( $config->ok_button_text ) ? $config->ok_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                    if ( isset( $err['ok_button_text'] ) ) {
                        echo $OUTPUT->error_text( $err['ok_button_text'] );
                    } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="auth_lenauth_ok_social_id_field"><?php echo get_string( 'auth_lenauth_binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_lenauth_get_user_info_fields_array(),
                        'auth_lenauth_ok_social_id_field', 
                        $config->auth_lenauth_ok_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'auth_lenauth_ok_social_id_field',
                            'class' => 'auth_lenauth_ok_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['auth_lenauth_ok_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['auth_lenauth_ok_social_id_field'] );
        }
        ?>
        </td>
    </tr-->
    
    <!--BUTTONS/DIVS SETTINGS-->
    <tr>
        <td colspan="3">
            <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                    <td width="50%" colspan="2"><h3><?php echo get_string( 'auth_lenauth_buttons_settings', 'auth_lenauth' ); ?></h3></td>
                    <td width="50%" colspan="2"><h3><?php echo get_string( 'auth_lenauth_div_settings', 'auth_lenauth' ); ?></h3></td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="auth_lenauth_display_buttons"><?php echo get_string( 'auth_lenauth_buttons_location', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php
                        echo html_writer::select(
                                array(
                                    'inline-block' => get_string( 'auth_lenauth_display_inline', 'auth_lenauth' ),
                                    'block' => get_string( 'auth_lenauth_display_block', 'auth_lenauth' ),
                                ),
                                'auth_lenauth_display_buttons', $config->auth_lenauth_display_buttons, false, array( 'id' => 'auth_lenauth_display_buttons' )
                        );
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_display_div"><?php echo get_string( 'auth_lenauth_div_location', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php
                        echo html_writer::select(
                                array(
                                    'inline-block' => get_string( 'auth_lenauth_display_inline', 'auth_lenauth' ),
                                    'block' => get_string( 'auth_lenauth_display_block', 'auth_lenauth' ),
                                ),
                                'auth_lenauth_display_div', $config->auth_lenauth_display_div, false, array( 'id' => 'auth_lenauth_display_div' )
                        );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="auth_lenauth_button_width"><?php echo get_string( 'auth_lenauth_button_div_width', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_button_width',
                                'name'    => 'auth_lenauth_button_width',
                                'class'   => 'auth_lenauth_button_width',
                                'value'   => !empty( $config->auth_lenauth_button_width ) ? $config->auth_lenauth_button_width : 0,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_button_width'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_button_width'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_div_width"><?php echo get_string( 'auth_lenauth_button_div_width', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_div_width',
                                'name'    => 'auth_lenauth_div_width',
                                'class'   => 'auth_lenauth_div_width',
                                'value'   => !empty( $config->auth_lenauth_div_width ) ? $config->auth_lenauth_div_width : 0,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_div_width'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_div_width'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="auth_lenauth_button_margin_top"><?php echo get_string( 'auth_lenauth_margin_top_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_button_margin_top',
                                'name'    => 'auth_lenauth_button_margin_top',
                                'class'   => 'auth_lenauth_button_margin_top',
                                'value'   => $config->auth_lenauth_button_margin_top,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_button_margin_top'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_button_margin_top'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_div_margin_top"><?php echo get_string( 'auth_lenauth_margin_top_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_div_margin_top',
                                'name'    => 'auth_lenauth_div_margin_top',
                                'class'   => 'auth_lenauth_div_margin_top',
                                'value'   => $config->auth_lenauth_div_margin_top,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_div_margin_top'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_div_margin_top'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="auth_lenauth_button_margin_right"><?php echo get_string( 'auth_lenauth_margin_right_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_button_margin_right',
                                'name'    => 'auth_lenauth_button_margin_right',
                                'class'   => 'auth_lenauth_button_margin_right',
                                'value'   => $config->auth_lenauth_button_margin_right,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_button_margin_right'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_button_margin_right'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_div_margin_right"><?php echo get_string( 'auth_lenauth_margin_right_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_div_margin_right',
                                'name'    => 'auth_lenauth_div_margin_right',
                                'class'   => 'auth_lenauth_div_margin_right',
                                'value'   => $config->auth_lenauth_div_margin_right,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_div_margin_right'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_div_margin_right'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="auth_lenauth_button_margin_bottom"><?php echo get_string( 'auth_lenauth_margin_bottom_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_button_margin_bottom',
                                'name'    => 'auth_lenauth_button_margin_bottom',
                                'class'   => 'auth_lenauth_button_margin_bottom',
                                'value'   => $config->auth_lenauth_button_margin_bottom,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_button_margin_bottom'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_button_margin_bottom'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_div_margin_bottom"><?php echo get_string( 'auth_lenauth_margin_bottom_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_div_margin_bottom',
                                'name'    => 'auth_lenauth_div_margin_bottom',
                                'class'   => 'auth_lenauth_div_margin_bottom',
                                'value'   => $config->auth_lenauth_div_margin_bottom,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_div_margin_bottom'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_div_margin_bottom'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" align="right" width="15%"><label for="auth_lenauth_button_margin_left"><?php echo get_string( 'auth_lenauth_margin_left_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_button_margin_left',
                                'name'    => 'auth_lenauth_button_margin_left',
                                'class'   => 'auth_lenauth_button_margin_left',
                                'value'   => $config->auth_lenauth_button_margin_left,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_button_margin_left'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_button_margin_left'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="auth_lenauth_div_margin_left"><?php echo get_string( 'auth_lenauth_margin_left_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'auth_lenauth_div_margin_left',
                                'name'    => 'auth_lenauth_div_margin_left',
                                'class'   => 'auth_lenauth_div_margin_left',
                                'value'   => $config->auth_lenauth_div_margin_left,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['auth_lenauth_div_margin_left'] ) ) {
                            echo $OUTPUT->error_text( $err['auth_lenauth_div_margin_left'] );
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!--OUTPUT-->
    <tr>
        <td colspan="3">
            <h3><?php echo get_string( 'auth_lenauth_output_settings', 'auth_lenauth' ); ?></h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table class="generaltable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="40%"><?php echo get_string( 'auth_lenauth_output_style_key', 'auth_lenauth' ); ?></th>
                        <th width="60%"><?php echo get_string( 'auth_lenauth_output_php_code_key', 'auth_lenauth' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ( $this->_styles_array as $style_item ) : ?>
                    <tr>
                        <td>
                            <?php echo auth_lenauth_out::getInstance()->lenauth_output($style_item, true); ?>
                            <br /><em><?php echo $style_item; ?></em>
                            <?php
                            switch ( $style_item ) {
                                case 'bootstrap-font-awesome':
                                case 'bootstrap-font-awesome-simple':
                                    echo '<br /><small style="color:red">' . get_string( 'auth_lenauth_bootstrap_fontawesome_needle', 'auth_lenauth' ) . '</small>';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <code>&lt;?php if ( file_exists( $CFG->dirroot . '/auth/lenauth/out.php' ) ) :<br />include_once $CFG->dirroot . '/auth/lenauth/out.php';<br />echo auth_lenauth_out::getInstance()->lenauth_output('<?php echo $style_item; ?>');<br />endif; ?&gt;</code>
                            <br /><a href="<?php echo $CFG->wwwroot; ?>/auth/lenauth/htmlcode.php?style=<?php echo $style_item; ?>" target="_blank"><?php echo get_string( 'auth_lenauth_static_html', 'auth_lenauth' ); ?></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>