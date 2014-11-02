<?php require_once('out.php'); ?>

<table cellspacing="0" cellpadding="5" border="0">
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'main_settings', 'auth_lenauth' ); ?></h3></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="lenauthuserprefix"><?php echo get_string( 'user_prefix_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'lenauthuserprefix',
                                            'name'    => 'lenauthuserprefix',
                                            'class'   => 'lenauthuserprefix',
                                            'value'   => $config->lenauthuserprefix,
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['lenauthuserprefix'] ) ) {
            echo $OUTPUT->error_text( $err['lenauthuserprefix'] );
        } ?>
        </td>
        <td width="50%"><?php echo get_string( 'user_prefix_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="default_country"><?php echo get_string( 'default_country_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php
            echo html_writer::select(
                get_string_manager()->get_list_of_countries(),
                'default_country',
                $config->default_country,
                get_string('selectacountry') . '...',
                array(
                    'id'    => 'default_country',
                    'class' => 'default_country'
                )
            );
            if ( isset( $err['default_country'] ) ) {
                echo $OUTPUT->error_text( $err['default_country'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'default_country_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td width="50%" colspan="2">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="7%">
                        <input type="radio" name="lenauth_locale" id="lenauth_locale_en" class="lenauth_locale_en" value="en"<?php echo ( $config->lenauth_locale == 'en' || empty( $config->lenauth_locale ) ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['lenauth_locale'] ) ) {
                            echo $OUTPUT->error_text( $err['lenauth_locale'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="lenauth_locale_en"><?php echo get_string( 'locale_en_key', 'auth_lenauth' ); ?></label>
                    </td>
                    <td width="7%">
                        <input type="radio" name="lenauth_locale" id="lenauth_locale_ru" class="lenauth_locale_ru" value="ru"<?php echo ( $config->lenauth_locale == 'ru' ) ? ' checked="checked"' : ''; ?> />
                        <?php
                        if ( isset( $err['lenauth_locale'] ) ) {
                            echo $OUTPUT->error_text( $err['lenauth_locale'] );
                        } ?>
                    </td>
                    <td width="43%">
                        <label for="lenauth_locale_ru"><?php echo get_string( 'locale_ru_key', 'auth_lenauth' ); ?></label>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%"><?php echo get_string( 'locale_desc', 'auth_lenauth' ); ?></td>
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
                    'can_reset_password', 1, 
                    $config->can_reset_password, 
                    get_string( 'can_reset_password_key', 'auth_lenauth' ), array( 'id' => 'can_reset_password' )
            );
            if ( isset( $err['can_reset_password'] ) ) {
                echo $OUTPUT->error_text( $err['can_reset_password'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'can_reset_password_desc', 'auth_lenauth' ); ?></td>
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
                    'can_confirm', 1, 
                    isset( $config->can_confirm ) ? $config->can_confirm : 0, 
                    get_string( 'can_confirm_key', 'auth_lenauth' ), array( 'id' => 'can_confirm' )
            );
            if ( isset( $err['can_confirm'] ) ) {
                echo $OUTPUT->error_text( $err['can_confirm'] );
            } ?>
        </td>
        <td width="50%"><?php echo get_string( 'can_confirm_desc', 'auth_lenauth' ); ?></td>
    </tr>
    
    <!----------FACEBOOK---------->
    <tr>
        <td colspan="3">
            <h3>
                <?php echo get_string( 'facebook_settings', 'auth_lenauth' );
                if ( !empty( $config->facebook_app_id ) ) :
                    echo ' ( ' . html_writer::link( new moodle_url( 'https://developers.facebook.com/apps/' . $config->facebook_app_id . '/dashboard/' ), get_string( 'facebook_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
                endif; ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'facebook_enabled', 1, 
                    $config->facebook_enabled, 
                    get_string( 'enabled_key', 'auth_lenauth' ) ); ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="facebook_app_id"><?php echo get_string( 'facebook_app_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'facebook_app_id',
                                            'name'    => 'facebook_app_id',
                                            'class'   => 'facebook_app_id',
                                            'value'   => !empty( $config->facebook_app_id ) ? $config->facebook_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['facebook_app_id'] ) ) {
                echo $OUTPUT->error_text( $err['facebook_app_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="4" valign="top"><?php echo get_string( 'facebook_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="facebook_app_secret"><?php echo get_string( 'facebook_app_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'facebook_app_secret',
                                            'name'    => 'facebook_app_secret',
                                            'class'   => 'facebook_app_secret',
                                            'value'   => !empty( $config->facebook_app_secret ) ? $config->facebook_app_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['facebook_app_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['facebook_app_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="facebook_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'facebook_button_text',
                                            'name'    => 'facebook_button_text',
                                            'class'   => 'facebook_button_text',
                                            'value'   => !empty( $config->facebook_button_text ) ? $config->facebook_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['facebook_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['facebook_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="facebook_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'facebook_social_id_field_disabled',
                        $config->facebook_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'facebook_social_id_field',
                            'class' => 'facebook_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['facebook_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['facebook_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="facebook_social_id_field" value="<?php echo $config->facebook_social_id_field; ?>" /-->
        </td>
    </tr>
    
    <!----------GOOGLE---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'google_settings', 'auth_lenauth' );
            if ( !empty( $config->google_project_id ) ) {
                echo ' ( <strong><a href="https://console.developers.google.com/project/' . $config->google_project_id . '/apiui/credential" target="_blank">' . get_string( 'google_dashboard', 'auth_lenauth' ) . '</a></strong> )';
            } ?>

            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3"><?php echo html_writer::checkbox( 'google_enabled', 1, 
                    $config->google_enabled, 
                    get_string( 'enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['google_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['google_enabled'] );
        } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="google_client_id"><?php echo get_string( 'google_client_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'google_client_id',
                                            'name'    => 'google_client_id',
                                            'class'   => 'google_client_id',
                                            'value'   => !empty( $config->google_client_id ) ? $config->google_client_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['google_client_id'] ) ) {
                echo $OUTPUT->error_text( $err['google_client_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'google_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="google_client_secret"><?php echo get_string( 'google_client_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'google_client_secret',
                                            'name'    => 'google_client_secret',
                                            'class'   => 'google_client_secret',
                                            'value'   => !empty( $config->google_client_secret ) ? $config->google_client_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['google_client_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['google_client_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="google_project_id"><?php echo get_string( 'google_project_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'google_project_id',
                                            'name'    => 'google_project_id',
                                            'class'   => 'google_project_id',
                                            'value'   => !empty( $config->google_project_id ) ? $config->google_project_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['google_project_id'] ) ) {
                    echo $OUTPUT->error_text( $err['google_project_id'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="google_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'google_button_text',
                                            'name'    => 'google_button_text',
                                            'class'   => 'google_button_text',
                                            'value'   => !empty( $config->google_button_text ) ? $config->google_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['google_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['google_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="google_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'google_social_id_field_disabled',
                        $config->google_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'google_social_id_field',
                            'class' => 'google_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['google_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['google_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="google_social_id_field" value="<?php echo $config->google_social_id_field; ?>" /-->
        </td>
    </tr>
    
    <!----------YAHOO---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'yahoo_settings', 'auth_lenauth' ); ?></h3></td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'yahoo_enabled', 1, 
                                    $config->yahoo_enabled, 
                                    get_string( 'enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['yahoo_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['yahoo_enabled'] );
        } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="yahoo_application_id"> 
                <?php echo get_string( 'yahoo_application_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yahoo_application_id',
                                            'name'    => 'yahoo_application_id',
                                            'class'   => 'yahoo_application_id',
                                            'value'   => !empty( $config->yahoo_application_id ) ? $config->yahoo_application_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['yahoo_application_id'] ) ) {
                echo $OUTPUT->error_text( $err['yahoo_application_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'yahoo_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yahoo_consumer_key"><?php echo get_string( 'yahoo_consumer_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yahoo_consumer_key',
                                            'name'    => 'yahoo_consumer_key',
                                            'class'   => 'yahoo_consumer_key',
                                            'value'   => !empty( $config->yahoo_consumer_key ) ? $config->yahoo_consumer_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['yahoo_consumer_key'] ) ) {
                echo $OUTPUT->error_text( $err['yahoo_consumer_key'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yahoo_consumer_secret"><?php echo get_string( 'yahoo_consumer_secret', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yahoo_consumer_secret',
                                            'name'    => 'yahoo_consumer_secret',
                                            'class'   => 'yahoo_consumer_secret',
                                            'value'   => !empty( $config->yahoo_consumer_secret ) ? $config->yahoo_consumer_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['yahoo_consumer_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['yahoo_consumer_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yahoo_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yahoo_button_text',
                                            'name'    => 'yahoo_button_text',
                                            'class'   => 'yahoo_button_text',
                                            'value'   => !empty( $config->yahoo_button_text ) ? $config->yahoo_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['yahoo_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['yahoo_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yahoo_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'yahoo_social_id_field_disabled',
                        $config->yahoo_social_id_field,
                        get_string('select') . '...', 
                        array(
                            'id' => 'yahoo_social_id_field',
                            'class' => 'yahoo_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['yahoo_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['yahoo_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="yahoo_social_id_field" value="<?php echo $config->yahoo_social_id_field; ?>" /-->
        </td>
    </tr>
    
    <!----------TWITTER---------->
    <tr>
        <td colspan="3">
            <h3>
                <?php echo get_string( 'twitter_settings', 'auth_lenauth' ); ?>
                <?php if ( !empty( $config->twitter_application_id ) ) {
                    echo ' ( <strong><a href="https://apps.twitter.com/app/' . $config->twitter_application_id . '" target="_blank">' . get_string( 'twitter_dashboard', 'auth_lenauth' ) . '</a></strong> )';                
                } ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'twitter_enabled', 1, 
                        $config->twitter_enabled, 
                        get_string( 'enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['twitter_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['twitter_enabled'] );
        } ?>
        </td>
    </tr>
    <tr>
        <td colspan="3"><?php 
                            html_writer::checkbox( 'twitter_enabled', 1, 
                                    $config->twitter_enabled, 
                                    get_string( 'enabled_key', 'auth_lenauth' ) );
        if ( isset( $err['twitter_enabled'] ) ) {
            echo $OUTPUT->error_text( $err['twitter_enabled'] );
        } ?>
        </td>
    </tr>
    
    <tr>
        <td align="right" width="15%"><label for="twitter_application_id"> 
                <?php echo get_string( 'twitter_application_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'twitter_application_id',
                                            'name'    => 'twitter_application_id',
                                            'class'   => 'twitter_application_id',
                                            'value'   => !empty( $config->twitter_application_id ) ? $config->twitter_application_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['twitter_application_id'] ) ) {
                echo $OUTPUT->error_text( $err['twitter_application_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'twitter_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="twitter_consumer_key"><?php echo get_string( 'twitter_consumer_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'twitter_consumer_key',
                                            'name'    => 'twitter_consumer_key',
                                            'class'   => 'twitter_consumer_key',
                                            'value'   => !empty( $config->twitter_consumer_key ) ? $config->twitter_consumer_key : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['twitter_consumer_key'] ) ) {
                echo $OUTPUT->error_text( $err['twitter_consumer_key'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="twitter_consumer_secret"><?php echo get_string( 'twitter_consumer_secret', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'twitter_consumer_secret',
                                            'name'    => 'twitter_consumer_secret',
                                            'class'   => 'twitter_consumer_secret',
                                            'value'   => !empty( $config->twitter_consumer_secret ) ? $config->twitter_consumer_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['twitter_consumer_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['twitter_consumer_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="twitter_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'twitter_button_text',
                                            'name'    => 'twitter_button_text',
                                            'class'   => 'twitter_button_text',
                                            'value'   => !empty( $config->twitter_button_text ) ? $config->twitter_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['twitter_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['twitter_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="twitter_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'twitter_social_id_field_disabled',
                        $config->twitter_social_id_field,
                        get_string('select') . '...', 
                        array(
                            'id' => 'twitter_social_id_field',
                            'class' => 'twitter_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['twitter_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['twitter_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="twitter_social_id_field" value="<?php echo $config->twitter_social_id_field; ?>" /-->
        </td>
    </tr>
    
    <!----------VK.COM---------->
    <tr>
        <td colspan="3">
            <h3><?php echo get_string( 'vk_settings', 'auth_lenauth' );
            if ( !empty( $config->vk_app_id ) ) :
                echo ' ( ' . html_writer::link( new moodle_url( 'http://vk.com/editapp?id=' . $config->vk_app_id . '&section=options' ), get_string( 'vk_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
            endif; ?>
            </h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'vk_enabled', 1, 
                    $config->vk_enabled, 
                    get_string( 'enabled_key', 'auth_lenauth' ) );
                    if ( isset( $err['vk_enabled'] ) ) {
                        echo $OUTPUT->error_text( $err['vk_enabled'] );
                    } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="vk_app_id"><?php echo get_string( 'vk_app_id_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'vk_app_id',
                                            'name'    => 'vk_app_id',
                                            'class'   => 'vk_app_id',
                                            'value'   => !empty( $config->vk_app_id ) ? $config->vk_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['vk_app_id'] ) ) {
                echo $OUTPUT->error_text( $err['vk_app_id'] );
            } ?>
        </td>
        <td width="50%" rowspan="4" valign="top"><?php echo get_string( 'vk_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="vk_app_secret"><?php echo get_string( 'vk_app_secret_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'vk_app_secret',
                                            'name'    => 'vk_app_secret',
                                            'class'   => 'vk_app_secret',
                                            'value'   => !empty( $config->vk_app_secret ) ? $config->vk_app_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['vk_app_secret'] ) ) {
                echo $OUTPUT->error_text( $err['vk_app_secret'] );
            } ?>
            </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="vk_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'vk_button_text',
                                            'name'    => 'vk_button_text',
                                            'class'   => 'vk_button_text',
                                            'value'   => !empty( $config->vk_button_text ) ? $config->vk_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['vk_button_text'] ) ) {
                echo $OUTPUT->error_text( $err['vk_button_text'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="vk_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'vk_social_id_field_disabled',
                        $config->vk_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'vk_social_id_field',
                            'class' => 'vk_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['vk_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['vk_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="vk_social_id_field" value="<?php echo $config->vk_social_id_field; ?>" /-->
        </td>
    </tr>
    
    <!----------YANDEX.RU---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'yandex_settings', 'auth_lenauth' );
        if ( !empty( $config->yandex_app_id ) ) :
            echo ' ( ' . html_writer::link( new moodle_url( 'https://oauth.yandex.ru/client/' . $config->yandex_app_id ), get_string( 'yandex_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) );
            echo ' | ' . html_writer::link( new moodle_url( 'https://oauth.yandex.com/client/' . $config->yandex_app_id ), 'eng', array( 'target' => '_blank' ) ) . ' )';
        endif;
        ?>
        </h3></td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'yandex_enabled', 1, 
                    $config->yandex_enabled, 
                    get_string( 'enabled_key', 'auth_lenauth' ) );
            if ( isset( $err['yandex_enabled'] ) ) {
                echo $OUTPUT->error_text( $err['yandex_enabled'] );
            } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="yandex_app_id"><?php echo get_string( 'yandex_app_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yandex_app_id',
                                            'name'    => 'yandex_app_id',
                                            'class'   => 'yandex_app_id',
                                            'value'   => !empty( $config->yandex_app_id ) ? $config->yandex_app_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['yandex_app_id'] ) ) {
            echo $OUTPUT->error_text( $err['yandex_app_id'] );
        }
        ?>
        </td>
        <td width="50%" rowspan="4" valign="top"><?php echo get_string( 'yandex_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yandex_app_password"><?php echo get_string( 'yandex_app_password_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yandex_app_password',
                                            'name'    => 'yandex_app_password',
                                            'class'   => 'yandex_app_password',
                                            'value'   => !empty( $config->yandex_app_password ) ? $config->yandex_app_password : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['yandex_app_password'] ) ) {
            echo $OUTPUT->error_text( $err['yandex_app_password'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yandex_button_text"><?php echo get_string( 'buttontext_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'yandex_button_text',
                                            'name'    => 'yandex_button_text',
                                            'class'   => 'yandex_button_text',
                                            'value'   => !empty( $config->yandex_button_text ) ? $config->yandex_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['yandex_button_text'] ) ) {
            echo $OUTPUT->error_text( $err['yandex_button_text'] );
        }
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="yandex_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'yandex_social_id_field_disabled',
                        $config->yandex_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'yandex_social_id_field',
                            'class' => 'yandex_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['yandex_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['yandex_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="yandex_social_id_field" value="<?php echo $config->yandex_social_id_field; ?>" /-->
        </td>
    </tr>


    <!----------MAIL.RU---------->
    <tr>
        <td colspan="3"><h3><?php echo get_string( 'mailru_settings', 'auth_lenauth' );
        if ( !empty( $config->mailru_site_id ) ) :
            echo ' ( ' . html_writer::link( new moodle_url( 'http://api.mail.ru/sites/my/' . $config->mailru_site_id ), get_string( 'mailru_dashboard', 'auth_lenauth' ), array( 'target' => '_blank' ) ) . ' )';
        endif; ?>
        </h3></td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo html_writer::checkbox( 'mailru_enabled', 1, 
                    $config->mailru_enabled, 
                    get_string( 'enabled_key', 'auth_lenauth' ) );
            if ( isset( $err['mailru_enabled'] ) ) {
                echo $OUTPUT->error_text( $err['mailru_enabled'] );
            } ?>
        </td>
    </tr>
                
    <tr>
        <td align="right" width="15%"><label for="mailru_site_id"><?php echo get_string( 'mailru_site_id', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'mailru_site_id',
                                            'name'    => 'mailru_site_id',
                                            'class'   => 'mailru_site_id',
                                            'value'   => !empty( $config->mailru_site_id ) ? $config->mailru_site_id : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
        if ( isset( $err['mailru_site_id'] ) ) {
            echo $OUTPUT->error_text( $err['mailru_site_id'] );
        } ?>
        </td>
        <td width="50%" rowspan="5" valign="top"><?php echo get_string( 'mailru_desc', 'auth_lenauth' ); ?></td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="mailru_client_private"><?php echo get_string('mailru_client_private_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'mailru_client_private',
                                            'name'    => 'mailru_client_private',
                                            'class'   => 'mailru_client_private',
                                            'value'   => !empty( $config->mailru_client_private ) ? $config->mailru_client_private : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
            if ( isset( $err['mailru_client_private'] ) ) {
                echo $OUTPUT->error_text( $err['mailru_client_private'] );
            } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="mailru_client_secret"><?php echo get_string('mailru_client_secret_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'mailru_client_secret',
                                            'name'    => 'mailru_client_secret',
                                            'class'   => 'mailru_client_secret',
                                            'value'   => !empty( $config->mailru_client_secret ) ? $config->mailru_client_secret : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['mailru_client_secret'] ) ) {
                    echo $OUTPUT->error_text( $err['mailru_client_secret'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="mailru_button_text"><?php echo get_string('buttontext_key', 'auth_lenauth'); ?></label></td>
        <td width="35%"><?php echo html_writer::empty_tag( 'input',
                                        array( 'type' => 'text',
                                            'id'      => 'mailru_button_text',
                                            'name'    => 'mailru_button_text',
                                            'class'   => 'mailru_button_text',
                                            'value'   => !empty( $config->mailru_button_text ) ? $config->mailru_button_text : '',
                                            'size'    => 50,
                                            'autocomplete' => 'off' )
                                        );
                if ( isset( $err['mailru_button_text'] ) ) {
                    echo $OUTPUT->error_text( $err['mailru_button_text'] );
                } ?>
        </td>
    </tr>
    <tr>
        <td align="right" width="15%"><label for="mailru_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'mailru_social_id_field_disabled',
                        $config->mailru_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'mailru_social_id_field',
                            'class' => 'mailru_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['mailru_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['mailru_social_id_field'] );
        }
        ?>
            <!--input type="hidden" name="mailru_social_id_field" value="<?php echo $config->mailru_social_id_field; ?>" /-->
        </td>
    </tr>

    <!----------ODNOKLASSNIKI---------->
    <!--tr>
        <td colspan="3"><h3><?php echo get_string( 'auth_ok_settings', 'auth_lenauth' ); ?></h3></td>
    </tr>
    <tr>
        <td colspan="3"><?php echo html_writer::checkbox( 'ok_enabled', 1, 
                        $config->ok_enabled, 
                        get_string( 'enabled_key', 'auth_lenauth' ) );
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
        <td align="right" width="15%"><label for="ok_button_text"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
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
        <td align="right" width="15%"><label for="ok_social_id_field"><?php echo get_string( 'binding_key', 'auth_lenauth' ); ?></label></td>
        <td width="35%"><?php 
                echo html_writer::select(
                        $this->_get_user_info_fields_array(), 
                        'ok_social_id_field', 
                        $config->ok_social_id_field, 
                        get_string('select') . '...', 
                        array(
                            'id' => 'ok_social_id_field',
                            'class' => 'ok_social_id_field',
                            'disabled' => 'disabled'
                        )
                );
        if ( isset( $err['ok_social_id_field'] ) ) {
            echo $OUTPUT->error_text( $err['ok_social_id_field'] );
        }
        ?>
        </td>
    </tr-->
    
    <!--BUTTONS/DIVS SETTINGS-->
    <tr>
        <td colspan="3">
            <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                    <td width="50%" colspan="2"><h3><?php echo get_string( 'buttons_settings', 'auth_lenauth' ); ?></h3></td>
                    <td width="50%" colspan="2"><h3><?php echo get_string( 'div_settings', 'auth_lenauth' ); ?></h3></td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="display_buttons"><?php echo get_string( 'buttons_location', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php
                        echo html_writer::select(
                                array(
                                    'inline-block' => get_string( 'display_inline', 'auth_lenauth' ),
                                    'block' => get_string( 'display_block', 'auth_lenauth' ),
                                ),
                                'display_buttons', $config->display_buttons, false, array( 'id' => 'display_buttons' )
                        );
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="display_div"><?php echo get_string( 'div_location', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php
                        echo html_writer::select(
                                array(
                                    'inline-block' => get_string( 'display_inline', 'auth_lenauth' ),
                                    'block' => get_string( 'display_block', 'auth_lenauth' ),
                                ),
                                'display_div', $config->display_div, false, array( 'id' => 'display_div' )
                        );
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="button_width"><?php echo get_string( 'button_div_width', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'button_width',
                                'name'    => 'button_width',
                                'class'   => 'button_width',
                                'value'   => !empty( $config->button_width ) ? $config->button_width : 0,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['button_width'] ) ) {
                            echo $OUTPUT->error_text( $err['button_width'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="div_width"><?php echo get_string( 'button_div_width', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'div_width',
                                'name'    => 'div_width',
                                'class'   => 'div_width',
                                'value'   => !empty( $config->div_width ) ? $config->div_width : 0,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['div_width'] ) ) {
                            echo $OUTPUT->error_text( $err['div_width'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="button_margin_top"><?php echo get_string( 'margin_top_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'button_margin_top',
                                'name'    => 'button_margin_top',
                                'class'   => 'button_margin_top',
                                'value'   => $config->button_margin_top,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['button_margin_top'] ) ) {
                            echo $OUTPUT->error_text( $err['button_margin_top'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="div_margin_top"><?php echo get_string( 'margin_top_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'div_margin_top',
                                'name'    => 'div_margin_top',
                                'class'   => 'div_margin_top',
                                'value'   => $config->div_margin_top,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['div_margin_top'] ) ) {
                            echo $OUTPUT->error_text( $err['div_margin_top'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="button_margin_right"><?php echo get_string( 'margin_right_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'button_margin_right',
                                'name'    => 'button_margin_right',
                                'class'   => 'button_margin_right',
                                'value'   => $config->button_margin_right,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['button_margin_right'] ) ) {
                            echo $OUTPUT->error_text( $err['button_margin_right'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="div_margin_right"><?php echo get_string( 'margin_right_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'div_margin_right',
                                'name'    => 'div_margin_right',
                                'class'   => 'div_margin_right',
                                'value'   => $config->div_margin_right,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['div_margin_right'] ) ) {
                            echo $OUTPUT->error_text( $err['div_margin_right'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="15%"><label for="button_margin_bottom"><?php echo get_string( 'margin_bottom_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'button_margin_bottom',
                                'name'    => 'button_margin_bottom',
                                'class'   => 'button_margin_bottom',
                                'value'   => $config->button_margin_bottom,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['button_margin_bottom'] ) ) {
                            echo $OUTPUT->error_text( $err['button_margin_bottom'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="div_margin_bottom"><?php echo get_string( 'margin_bottom_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'div_margin_bottom',
                                'name'    => 'div_margin_bottom',
                                'class'   => 'div_margin_bottom',
                                'value'   => $config->div_margin_bottom,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['div_margin_bottom'] ) ) {
                            echo $OUTPUT->error_text( $err['div_margin_bottom'] );
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" align="right" width="15%"><label for="button_margin_left"><?php echo get_string( 'margin_left_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'button_margin_left',
                                'name'    => 'button_margin_left',
                                'class'   => 'button_margin_left',
                                'value'   => $config->button_margin_left,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['button_margin_left'] ) ) {
                            echo $OUTPUT->error_text( $err['button_margin_left'] );
                        }
                        ?>
                    </td>
                    <td align="right" width="15%"><label for="div_margin_left"><?php echo get_string( 'margin_left_key', 'auth_lenauth' ); ?></label></td>
                    <td width="35%">
                        <?php echo html_writer::empty_tag( 'input',
                            array( 'type' => 'text',
                                'id'      => 'div_margin_left',
                                'name'    => 'div_margin_left',
                                'class'   => 'div_margin_left',
                                'value'   => $config->div_margin_left,
                                'size'    => 5,
                                'autocomplete' => 'off' )
                        );
                        if ( isset( $err['div_margin_left'] ) ) {
                            echo $OUTPUT->error_text( $err['div_margin_left'] );
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
            <h3><?php echo get_string( 'output_settings', 'auth_lenauth' ); ?></h3>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table class="generaltable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="40%"><?php echo get_string( 'output_style_key', 'auth_lenauth' ); ?></th>
                        <th width="60%"><?php echo get_string( 'output_php_code_key', 'auth_lenauth' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ( $this->_styles_array as $style_item ) : ?>
                    <tr>
                        <td>
                            <?php echo lenauth_out::getInstance()->output($style_item, true); ?>
                            <br /><em><?php echo $style_item; ?></em>
                        </td>
                        <td>
                            <code>&lt;?php include_once $CFG->dirroot . '/auth/lenauth/out.php';<br />echo lenauth_out::getInstance()->output('<?php echo $style_item; ?>'); ?&gt;</code>
                            <br /><a href="<?php echo $CFG->wwwroot; ?>/auth/lenauth/htmlcode.php?style=<?php echo $style_item; ?>" target="_blank"><?php echo get_string( 'static_html', 'auth_lenauth' ); ?></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>