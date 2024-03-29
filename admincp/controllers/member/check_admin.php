<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

if( $AdminLogged = $session->get( 'session', 'AdminLogged' ) )
{
	$CheckAdmin = explode( '|', $AdminLogged );
	if( $CheckAdmin[0] == 1 )
	{
		$checkUser = array( 'userid' => vnp_db::SQLValue( $CheckAdmin[1] ) );
		
		$db->SelectRows( VNP_USER, $checkUser );
		//echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$UserData = $db->RowArray(0, MYSQL_ASSOC);
			$check = array( 'admin_id' => $CheckAdmin[2] );
			$db->SelectRows( VNP_ADMIN, $check );
			if( $db->RowCount() === 1 )
			{
				$adminData = $db->RowArray(0, MYSQL_ASSOC);
				$adminData = array_merge( $UserData, $adminData );
				define( 'LOGGED_ADMIN', true );
			}
		}
	}
}
elseif( $request->get( 'admin-login', 'post', '' ) )
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
		//echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$UserData = $db->RowArray(0, MYSQL_ASSOC);
			
			if( $UserData['userid'] > 0 )
			{
				if( $pass->authenticate( $adminPass, $UserData['salt'], $UserData['password'] ) )
				{
					$checkAdmin = array( 'userid' => $UserData['userid'] );
					$db->SelectRows( VNP_ADMIN, $checkAdmin );
					$AdminData = $db->RowArray(0, MYSQL_ASSOC);
					if( $db->RowCount() === 1 )
					{
						$session->SetSession( 'AdminLogged', '1|' . $UserData['userid'] . '|' . $AdminData['admin_id'] );
						Header( 'Location: ' . MY_ADMDIR );
						exit();
					}
					else die('Hacking!!!');
				}
				else
				{
					//echo $adminPass . '-' . $UserData['salt'] . '-' . $UserData['password'];
					//die();
				}
			}
		}
		else
		{
			echo $db->RowCount();
		}
	}
}
else
{
	member::adminLoginForm();
}

?>