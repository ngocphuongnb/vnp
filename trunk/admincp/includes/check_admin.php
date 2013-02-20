<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

if( $request->get( 'admin-login', 'post', '' ) )
{
	$error = array();
	$adminName = $request->get( 'username', 'post', '' );
	$adminPass = $request->get( 'password', 'post', '' );
	
	if( empty( $adminName ) )
	{
		$error[] = 'Empty username';
	}
	if( empty( $adminPass ) )
	{
		$error[] = 'Empty password';
	}
	if( empty( $error ) )
	{
		$checkUser = array( 'username' => vnp_db::SQLValue( $adminName ) );
		
		$db->SelectRows( VNP_USER, $checkUser );
		echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$AdminData = $db->RowArray(0, MYSQL_ASSOC);
			if( $AdminData['userid'] > 0 )
			{
				if( $pass->authenticate( $adminPass, $AdminData['salt'], $AdminData['password'] ) )
				{
					$checkAdmin = array( 'userid' => $AdminData['userid'] );
					$db->SelectRows( VNP_ADMIN, $checkAdmin );
					if( $db->RowCount() === 1 )
					{
						die('ok');
					}
					else die('not');
				}
			}
		}
		else
		{
			die('fvfvfvrgvsdfv');
		}
	}
}

?>