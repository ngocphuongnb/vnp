<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) or !defined( 'VN' ) ) die( 'Hacking' ); 

if( $request->get( 'action', 'get', '' ) )
{
	$MemberAction = array( 'login', 'register', 'logout' );
	$action = $request->get( 'action', 'get', '' );
	
	if( in_array( $action, $MemberAction ) )
	{
		if( $action == 'login' )
		{
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/static/css/normalize.css">';
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/themes/' . $nG['theme'] . '/css/member.css">';
		}
		elseif( $action == 'register' )
		{
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/static/css/normalize.css">';
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/themes/' . $nG['theme'] . '/css/member.css">';
		}
		
		$content = vnpGetTheme( $action );
		echo $content;
	}
}