<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) or !defined( 'VN' ) ) die( 'Hacking' ); 

function vnpGetTheme( $page )
{
	global $nG, $singlePage;

	$content = '';
	if( in_array( $page, $singlePage ) )
	{
		$content = getSinglePage( $page );
	}
	
	return myTheme( $content );
}

function getSinglePage( $page )
{
	global $nG, $mode;
	
	$xtpl = new XTemplate( $page . '.tpl', DOC_ROOT . VNP_MYDIR . 'sources/controllers/' . $mode . '/template/' );
	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function myTheme( $content )
{
	global $nG, $customHeading;
	
	$xtpl = new XTemplate( 'layout.tpl', DOC_ROOT . VNP_MYDIR . 'sources/themes/' . $nG['theme'] . '/' );
	
	if( !empty( $customHeading ) && is_array( $customHeading ) )
	{
		foreach( $customHeading as $_heading )
		{
			$xtpl->assign( 'HEADING', $_heading );
			$xtpl->parse( 'main.heading' );
		}
	}
	
	$xtpl->assign( 'CONTENT', $content );
	$xtpl->parse( 'main' );
	return $xtpl->out( 'main' );
}