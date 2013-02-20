<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

error_reporting(E_ERROR);
if( PHP_VERSION < '5.3.0' )
{
	set_magic_quotes_runtime(0);
}
if( $sys_info['enabled_ini_set'] )
{
	// session setting
	ini_set( 'magic_quotes_runtime', 'Off' );
	ini_set( 'magic_quotes_sybase', 'Off' );

	if( ! isset( $_SESSION ) )
	{
		ini_set( 'session.save_handler', 'files' );
		ini_set( 'session.use_trans_sid', 0 );
		ini_set( 'session.auto_start', 0 );
		ini_set( 'session.use_cookies', 1 );
		ini_set( 'session.use_only_cookies', 1 );
		ini_set( 'session.cookie_httponly', 1 );
		//Kha nang chay Garbage Collection - trinh xoa session da het han truoc khi bat dau session_start();
		ini_set( 'session.gc_probability', 1 ); 
		//gc_probability / gc_divisor = phan tram (phan nghin) kha nang chay Garbage Collection
		ini_set( 'session.gc_divisor', 1000 ); 
		//thoi gian sau khi het han phien lam viec de Garbage Collection tien hanh xoa, 60 phut
		ini_set( 'session.gc_maxlifetime', 3600 ); 
	}
	
	ini_set( 'allow_url_fopen', 1 );
	ini_set( "user_agent", 'VNP' );
	ini_set( "default_charset", $global_config['site_charset'] );
	ini_set( 'sendmail_from', $global_config['site_email'] );
	ini_set( 'arg_separator.output', '&' );
	ini_set( 'auto_detect_line_endings', 0 );
}

if( $sys_info['enalbed_ini_get'] == true ) 
{
	$memorylimit = @ini_get('memory_limit');
	if( $memorylimit && byte_converter( $memorylimit ) < 33554432 && function_exists('ini_set')) 
	{
		ini_set('memory_limit', '128m');
	}
}

?>