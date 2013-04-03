<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VN' ) || !defined( 'VNP_INSTALL' ) ) die( 'ILN' );

require ( VNP_ROOT . '/includes/class/xtemplate.min.class.php' );

function TempOutPut( $data )
{
	global $vnp_mydir, $installError;
	$xtpl = new XTemplate( 'layout.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
	$xtpl->assign( 'MY_DIR', $vnp_mydir );
	$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
	
	if( !empty( $installError ) )
	{
		foreach( $installError as $_err )
		{
			if( !empty( $_err ) )
			{
				$xtpl->assign( 'ERR', $_err );
				$xtpl->parse( 'main.error.loop' );
			}
		}
		$xtpl->parse( 'main.error' );
	}
	$xtpl->assign( 'CONTENT', $data );
	$xtpl->parse( 'main' );
	echo $xtpl->out( 'main' );
}

function InstallStep0()
{
	global $vnp_mydir;
	$xtpl = new XTemplate( 'step0.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function InstallStep1()
{
	global $vnp_mydir;
	$xtpl = new XTemplate( 'step1.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function InstallStep2( $dbData, $delTableForm )
{
	global $vnp_mydir;
	$xtpl = new XTemplate( 'step2.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	$xtpl->assign( 'DATA', $dbData );
	
	if( $delTableForm ) $xtpl->parse( 'main.deltable' );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function InstallStep3()
{
	global $vnp_mydir;
	$xtpl = new XTemplate( 'step3.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function InstallStep4()
{
	global $vnp_mydir;
	$xtpl = new XTemplate( 'step4.tpl', DOC_ROOT . $vnp_mydir . INSTALL_DIR . '/template/' );
	
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

?>