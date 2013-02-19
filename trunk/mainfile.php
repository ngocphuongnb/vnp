<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) ) die( 'Hacking!!!' ); 
define( 'VN', true );
define( 'VNP_ROOT', pathinfo( str_replace( DIRECTORY_SEPARATOR, '/', __file__ ), PATHINFO_DIRNAME ) );
require ( VNP_ROOT . '/includes/constants.php');
require ( VNP_ROOT . '/includes/variables.php');
require ( VNP_ROOT . '/includes/class/core.php');
require ( VNP_ROOT . '/includes/class/request.class.php');
require ( VNP_ROOT . '/includes/class/password.class.php');
require ( VNP_ROOT . '/includes/class/session.class.php');

//$link = mysql_connect('localhost', 'root', '123') or die('Could not connect to database!');
//$db = mysql_select_db('vnpcms', $link) or die ('Could not select database!');
$vnp = & vnp::instance();
$pass = new vnp_pass();

?>