<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

//Neu he thong khong ho tro php se bao loi
if( PHP_VERSION < 5.2 )
{
	trigger_error( "You are running an unsupported PHP version. Please upgrade to PHP 5.2 or higher before trying to install VNP CMS", 256 );
}

//Neu he thong khong ho tro MySQL se bao loi
if( ! ( extension_loaded( 'mysql' ) and function_exists( 'mysql_connect' ) ) )
{
	trigger_error( "MySQL is not supported", 256 );
}

//Neu he thong khong ho tro GD se bao loi
if( ! ( extension_loaded( 'gd' ) ) )
{
	trigger_error( "GD not installed", 256 );
}

//Neu he thong khong ho tro session se bao loi
if( ! extension_loaded( 'session' ) )
{
	trigger_error( "Session object not supported", 256 );
}

if( function_exists('ini_get') )
{
	$sys_info['enalbed_ini_get'] = true;
	
	/*$disabled_functions = ini_get( 'disable_functions' );
	if ( $disabled_functions != '' )
	{
		$sys_info['disable_functions'] = explode(',', $disabled_functions);
		sort( $sys_info['disable_functions'] );
	}*/
	$sys_info['disable_functions'] = DisabledFunction();
	
	if( ini_set('memory_limit', '64m') === true )
	{
		$sys_info['enabled_ini_set'] = true;
	}
	if( ini_get('safe_mode') ) $sys_info['safe_mode'] = 1;
	//
	$sys_info['mb_support'] = ( extension_loaded( 'mbstring' ) ) ? 1 : 0;
	$sys_info['iconv_support'] = ( extension_loaded( 'iconv' ) ) ? 1 : 0;
	
	$sys_info['enabled_set_time_limit'] = ( isset( $sys_info['safe_mode'] ) && !$sys_info['safe_mode'] and function_exists( "set_time_limit" ) and ! in_array( 'set_time_limit', $sys_info['disable_functions'] ) ) ? 1 : 0;
	
	$sys_info['os'] = strtoupper( ( function_exists( "php_uname" ) and ! in_array( 'php_uname', $sys_info['disable_functions'] ) and php_uname( 's' ) != '' ) ? php_uname( 's' ) : PHP_OS );

	$sys_info['enabled_fileuploads'] = ( ini_get( 'file_uploads' ) ) ? 1 : 0;
	$sys_info['curl_support'] = ( extension_loaded( 'curl' ) and ( empty( $sys_info['disable_functions'] ) or ( ! empty( $sys_info['disable_functions'] ) and ! preg_grep( '/^curl\_/', $sys_info['disable_functions'] ) ) ) ) ? 1 : 0;
	
	$sys_info['ftp_support'] = ( function_exists( "ftp_connect" ) and ! in_array( 'ftp_connect', $sys_info['disable_functions'] ) and function_exists( "ftp_chmod" ) and ! in_array( 'ftp_chmod', $sys_info['disable_functions'] ) and function_exists( "ftp_mkdir" ) and ! in_array( 'ftp_mkdir', $sys_info['disable_functions'] ) and function_exists( "ftp_chdir" ) and ! in_array( 'ftp_chdir', $sys_info['disable_functions'] ) and function_exists( "ftp_nlist" ) and ! in_array( 'ftp_nlist', $sys_info['disable_functions'] ) ) ? 1 : 0;
	
}

//Neu he thong khong ho tro opendir se bao loi
if( ! ( function_exists( 'opendir' ) and ! in_array( 'opendir', $sys_info['disable_functions'] ) ) )
{
	trigger_error( "Opendir function is not supported", 256 );
}

//Kiem tra ho tro rewrite

if( function_exists( 'apache_get_modules' ) )
{
	$apache_modules = apache_get_modules();
	if( in_array( "mod_rewrite", $apache_modules ) )
	{
		$sys_info['enabled_rewrite'] = "rewrite_mode_apache";
	}
}
elseif( strpos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS/7.' ) !== false )
{
	if( isset( $_SERVER['IIS_UrlRewriteModule'] ) && ( php_sapi_name() == 'cgi-fcgi' ) && class_exists( 'DOMDocument' ) )
	{
		$sys_info['enabled_rewrite'] = "rewrite_mode_iis";
	}
}
elseif( $sys_info['os'] == "LINUX" )
{
	$sys_info['enabled_rewrite'] = "rewrite_mode_apache";
}

?>