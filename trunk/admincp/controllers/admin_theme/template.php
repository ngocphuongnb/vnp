<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

function adminFullTheme( $topMenu = '', $sideBar = '', $content = '' )
{
	$xtpl = new XTemplate( 'layout.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
	$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
	$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
	$xtpl->assign( 'MY_DIR', VNP_MYDIR );
	
	$xtpl->assign( 'TOP_MENU', $topMenu );
	$xtpl->assign( 'SIDE_BAR', $sideBar );
	$xtpl->assign( 'CONTENT', $content );
	
	$xtpl->parse( 'main' );
	return $xtpl->out( 'main' );
}

function adminTopMenu( $topMenuArray = array() )
{
	$xtpl = new XTemplate( 'top_menu.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function adminSideBar( $sideBarArray = array() )
{
	$xtpl = new XTemplate( 'side_bar.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

?>