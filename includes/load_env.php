<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

$sv_request_time = get_Env( 'REQUEST_TIME' );

$user_agent = (string)get_Env( "HTTP_USER_AGENT" );
$user_agent = substr( htmlspecialchars($user_agent), 0, 255 );
if ( empty( $user_agent ) or $user_agent == "-" ) $user_agent = "none";
$_SERVER['HTTP_USER_AGENT'] = $user_agent;

$server_protocol = strtolower( preg_replace( '/^([^\/]+)\/*(.*)$/', '\\1', get_Env( 'SERVER_PROTOCOL' ) ) ) . ( ( get_Env( "HTTPS" ) == "on" ) ? "s" : "" );

// url
$vnp_mydir = pathinfo( $_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
if ( $vnp_mydir == DIRECTORY_SEPARATOR ) $vnp_mydir = '';
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = str_replace( DIRECTORY_SEPARATOR, '/', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/[\/]+$/", '', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/^[\/]*(.*)$/", '/\\1', $vnp_mydir );

$doc_root = isset( $_SERVER['DOCUMENT_ROOT'] ) ? $_SERVER['DOCUMENT_ROOT'] : '';
if ( ! empty( $doc_root ) ) $doc_root = str_replace( DIRECTORY_SEPARATOR, '/', $doc_root );
if ( ! empty( $doc_root ) ) $doc_root = preg_replace( "/[\/]+$/", '', $doc_root );

define( 'DOC_ROOT', isset( $_SERVER['DOCUMENT_ROOT'] ) ? $_SERVER['DOCUMENT_ROOT'] : '' );
if( !defined( 'VNP_MYDIR' ) )
{
	define( 'VNP_MYDIR', $vnp_mydir . '/' );
}
if( !defined( 'MY_ADMDIR' ) )
{
	define( 'MY_ADMDIR', $vnp_mydir . '/' . ADMIN_DIR . '/' );
}
define( 'HEADER_STATUS', ( substr( php_sapi_name(), 0, 3 ) == 'cgi' ) ? "Status:" : $_SERVER['SERVER_PROTOCOL'] );
define( 'USER_AGENT', $user_agent );
define( 'SERVER_PROTOCOL', $server_protocol );
define( 'VNP_TIME', !empty( $sv_request_time ) ? $sv_request_time : time() );
define( 'SERVER_IP', get_Env( 'SERVER_ADDR' ) );
define( 'SERVER_NAME', get_Env( 'SERVER_NAME' ) );
define( 'SERVER_PORT', get_Env( 'SERVER_PORT' ) );
( SERVER_PORT == "80" ) ? $server_port = "" : $server_port = SERVER_PORT;
if( filter_var( VNP_SERVER_NAME, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) === false )
{
	define( 'VNP_DOMAIN', SERVER_PROTOCOL . '://' . SERVER_NAME . $server_port );
}
else
{
	define( 'VNP_DOMAIN', SERVER_PROTOCOL . '://[' . SERVER_NAME . ']' . $server_port );
}
set_timezone();

// client array
$client_info['selfurl'] = ( empty( $_SERVER['REQUEST_URI'] ) ) ? $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];

if( @include( VNP_ROOT . '/includes/class/ips.class.php' ) )
{
	$ips = new ips();
	$client_info['ip'] = $ips->remote_ip;
	if( $client_info['ip'] == 'none' )
	{
		die( 'Invalid IP!' );
	}
}

$alias_get = substr( $client_info['selfurl'], strlen( VNP_MYDIR ) );

?>