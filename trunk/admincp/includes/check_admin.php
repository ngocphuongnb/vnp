<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VNP_ADMIN' ) ) die( 'ILN' );

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
		$db->SelectRows( VNP_USER, array( 'username' => vnp_db::SQLValue( $adminName ) ) );
		echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$array = $db->RowArray(0, MYSQL_ASSOC);
			np( $array );
		}
		else
		{
			die('fvfvfvrgvsdfv');
		}
	}
}

?>