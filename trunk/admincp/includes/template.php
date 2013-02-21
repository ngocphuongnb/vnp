<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

function adminLoginForm()
{
	global $loginError;
	
	$xtpl = new XTemplate( 'login.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
	$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
	$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
	$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
	$xtpl->assign( 'MY_DIR', VNP_MYDIR );
	
	if( !empty( $loginError ) )
	{
		foreach( $loginError as $_err )
		{
			if( !empty( $_err ) )
			{
				$xtpl->assign( 'ERR', $_err );
				$xtpl->parse( 'main.error.loop' );
			}
		}
		$xtpl->parse( 'main.error' );
	}
	$xtpl->parse( 'main' );
	echo $xtpl->out( 'main' );
}

function adminFullTheme( $content = '' )
{
	$xtpl = new XTemplate( 'layout.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
	$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
	$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
	$xtpl->assign( 'MY_DIR', VNP_MYDIR );
	
	$xtpl->parse( 'main' );
	echo $xtpl->out( 'main' );
}

?>