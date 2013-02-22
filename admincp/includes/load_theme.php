<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'LOGGED_ADMIN' ) || !defined( 'ADMIN_CLASS' ) ) die( 'ILN' );

$topMenu = '';
$sideBar = '';

include( VNP_ROOT . '/' . ADMIN_DIR . '/includes/top_menu.php' );
include( VNP_ROOT . '/' . ADMIN_DIR . '/includes/side_bar.php' );

$this->html = adminFullTheme( $topMenu, $sideBar );

?>