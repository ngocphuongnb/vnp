<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

define( 'VNP', true );
define( 'ADMIN_FILE', true );

$doc_root = str_replace( '\\', '/', realpath( pathinfo( __file__, PATHINFO_DIRNAME ) . '/../' ) );

require( $doc_root . '/mainfile.php');

require( VNP_ROOT . '/' . ADMIN_DIR . '/includes/admin.class.php' );
require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/admin_theme/variables.php' );

$adm = new vnp_admin();

$nmenu = new vnp_menu();

$nmenu->mainMenu( MY_ADMDIR . 'index.php?ctl=ct_type', 'Content type' );
$nmenu->subMenu( MY_ADMDIR . 'index.php?ctl=ct_type&action=list_ct_type', 'Quản lý loại nội dung' );
$nmenu->subMenu( MY_ADMDIR . 'index.php?ctl=ct_type&action=list_ct_field', 'Quản lý trường' );
$nmenu->subMenu( MY_ADMDIR . 'index.php?ctl=ct_type&action=add_ct_type', 'Thêm loại nội dung' );
$nmenu->subMenu( 'http://yahoo.com', 'Yahoo 1' );
$nmenu->subMenu( MY_ADMDIR . 'list_ct_type', 'List Content type' );
$nmenu->subMenu( MY_ADMDIR . 'list_ct_field', 'List Content field' );
$nmenu->subMenu( MY_ADMDIR . 'add_ct_type', 'Add Content type' );
$nmenu->subMenu( MY_ADMDIR . 'add_content', 'Add Content' );
$nmenu->subMenu( 'http://facebook.com', 'Facebook' );
$nmenu->menu();

admin_theme::registerMenu( 'topmenu', $nmenu->menu() );

//np($themeMenu);
//die();
//ctl->controller

if( $mod = $request->get( 'ctl', 'get', '' ) )
{
	$adm->adminAction( $mod );
}

$template->init();

?>