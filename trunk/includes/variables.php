<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

$alias_get = '';
$session = NULL;
$db = NULL;
/* Initializing client info array */
$client_info = array(
			'ip' => 			0,
			'session_id' => 	'',
			'referer' => 		'',
			'my_referer' => 	0,
			'country' => 		'',
			'selfurl' => 		'',
			'isbot' => 			0,
			'bot_info' => 		array(),
			'browser' => 		array(
										'key' => '',
										'name' =>'' ),
			'agent' =>			'',
			'client_os' => 		'',
			'mobile_info' => 	array(),
			'starttime' => 		0 );
			
/* Initializing global var array for working session */
$G = array(
			'userid' => 		0,
			'username' => 		'',
			'adminid' => 		0,
			'groupid' => 		'',
			'gzip' => 			0,
			'authcode' => 		'',
			'lang' => 			'',
			'style' => 			'');
			
/* Initializing global system variables */
$sys_info = array(
			'enalbed_ini_get' => 	false,
			'enabled_ini_set' => 	false,
			'disable_functions' => 	array(),
			'enabled_rewrite' => 	false
			);
			
/* Initializing post infomation */
$npnode = array(
			'id' => 			0,
			'alias' => 			'',
			'parent' => 		0,
			'img' => 			'',
			'thumb' => 			'',
			'des' => 			'',
			'mt_title' => 		'',
			'mt_des' => 		'',
			'mt_keywords' => 	'',
			'rating' => 		'',
			'view' => 			'',
			'comment' => 		'',
			'sticky' => 		0,
			'author' => 		''
			);

$singlePage = array(
			'member',
			'login',
			'register',
			'blog',
			'wall'
			);
			
$nG['theme'] = 'seeuhn';

$customHeading = array();

$mode = '';
?>