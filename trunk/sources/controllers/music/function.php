<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) or !defined( 'VN' ) ) die( 'Hacking' ); 

function loginForm()
{
	global $nG, $mode;
	
	$xtpl = new XTemplate( 'login.tpl', DOC_ROOT . VNP_MYDIR . 'sources/controllers/member/template/' );
	$xtpl->assign( 'ACTION', VNP_MYDIR . 'index.php?mod=member&action=login' );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function registerForm()
{
	global $nG, $mode;
	
	$xtpl = new XTemplate( 'register.tpl', DOC_ROOT . VNP_MYDIR . 'sources/controllers/member/template/' );
	$xtpl->assign( 'ACTION', VNP_MYDIR . 'index.php?mod=member&action=register' );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}