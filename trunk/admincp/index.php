<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

define( 'VNP', true );
define( 'VN', true );
define( 'VNP_ADMIN', true );

if( !defined( 'VNP_ROOT' ) )
{
	define( 'VNP_ROOT', str_replace( '\\', '/', realpath( pathinfo( __file__, PATHINFO_DIRNAME ) . '/../' ) ) );
}

require( VNP_ROOT . '/includes/constants.php');
require( VNP_ROOT . '/includes/variables.php');

// url
$vnp_mydir = pathinfo( $_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
if ( $vnp_mydir == DIRECTORY_SEPARATOR ) $vnp_mydir = '';
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = str_replace( DIRECTORY_SEPARATOR, '/', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/[\/]+$/", '', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/^[\/]*(.*)$/", '/\\1', $vnp_mydir );
$vnp_mydir = str_replace( ADMIN_DIR, '', $vnp_mydir );

define( 'VNP_MYDIR', $vnp_mydir );
define( 'MY_ADMDIR', $vnp_mydir . ADMIN_DIR . '/' );

require( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/' . CORE_FUNCTION );
require( VNP_ROOT . '/includes/' . GET_SYSINFO );
require( VNP_ROOT . '/includes/' . SYS_INI );
require( VNP_ROOT . '/includes/' . LOAD_ENV );
require( VNP_ROOT . '/includes/class/xtemplate.min.class.php' );
require( VNP_ROOT . '/includes/class/request.class.php');
require( VNP_ROOT . '/includes/class/db.class.php');
require( VNP_ROOT . '/' . ADMIN_DIR . '/template.php' );

//require( VNP_ROOT . '/' . ADMIN_DIR . '/admin_auth.php' );
if( !defined( 'LOGGED_ADMIN' ) )
{
	adminLoginForm();
}

?>