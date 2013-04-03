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
	$content = '';
	$error = array();
	$MemberAction = array( 'login', 'register', 'logout' );
	$action = $request->get( 'action', 'get', '' );
	
	if( in_array( $action, $MemberAction ) )
	{
		if( $request->get( 'mem-submit', 'post', '' ) )
		{
			$regData = array();
			$regData['username']	= $request->get( 'username', 'post', '' );
			$regData['password']	= $request->get( 'password', 'post', '' );
			$regData['repassword']	= $request->get( 'repassword', 'post', '' );
			$regData['email']		= $request->get( 'email', 'post', '' );
			
			if( empty( $regData['username'] ) )
			{
				$error[] = 'Empty Username';
			}
			if( empty( $regData['email'] ) )
			{
				$error[] = 'Empty email';
			}
			if( ( $regData['password'] != $regData['repassword'] ) || empty( $regData['password'] ) || empty( $regData['repassword'] )  )
			{
				$error[] = 'Password doesn\'t match';
			}
			
			if( !empty( $error ) )
			{
				$content .= implode( '<br />', $error );
			}
			else
			{
				$memData = array(
										'username'		=> vnp_db::SQLValue( $regData['username'] ),
										'password'		=> vnp_db::SQLValue( $pass->genPass( $regData['password'] ) ),
										'salt'			=> vnp_db::SQLValue( $pass->salt ),
										'email'			=> vnp_db::SQLValue( $regData['email'] )
									);
									
				$_result = $db->InsertRow( VNP_USER, $memData );
				$pass->Clear();
				if( !$_result )
				{
					$db->Kill();
				}
				else
				{
					$content .= 'Register Completed!';
				}
			}
		}
		else
		{
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/static/css/normalize.css">';
			$customHeading[] = '<link rel="stylesheet" href="' . VNP_MYDIR . 'sources/themes/' . $nG['theme'] . '/css/member.css">';
			if( $action == 'login' )
			{
				$content .= loginForm();
			}
			elseif( $action == 'register' )
			{
				$content .= registerForm();
			}
			
			//$content = vnpGetTheme( $action );
			$content = myTheme( $content );
		}
	}
}