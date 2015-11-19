<?php

require( '../../config.php' );

if ( has_capability( 'moodle/user:update', context_system::instance() ) ) {
    
    if ( required_param( 'style', PARAM_TEXT ) ) {
        
        $style = format_string( $_GET['style'] );
        
        global $CFG;
        include_once $CFG->dirroot . '/auth/lenauth/out.php';
        echo 'Static inline HTML code:<br /><pre>' . htmlspecialchars( auth_lenauth_out::getInstance()->lenauth_output( $style, false, true ), ENT_QUOTES ) . '</pre>';
        
    } else {
        throw new moodle_exception( 'style GET-parameter is not set', 'auth_lenauth' );
    }
    
} else {
    throw new moodle_exception( 'You do not have permissions', 'auth_lenauth' );
}