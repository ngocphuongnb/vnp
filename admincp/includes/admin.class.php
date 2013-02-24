<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

define( 'ADMIN_CLASS', true );

class vnp_admin
{
	public $isAdmin		= false;
	public static $html		= '';
	
	public function __construct()
	{
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/member/member.class.php' );
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/ct_type/ct_type.class.php' );
		$this->checkAdmin();
		$this->loadTheme();
	}
	
	private function checkAdmin()
	{
		global $session, $request, $db, $pass, $adminData;
		
		if( @include( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/member/check_admin.php' ) )
		{
			// do nothing;
			member::showAdminProfile();
		}
		else
		{
			exit( 'System Error!' );
		}
	}
	
	private function loadTheme()
	{
		global $template;
		
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/admin_theme/admin_theme.class.php' );
		
		$template = new admin_theme();
	}
	
	public function adminAction( $mod )
	{
		global $request, $db, $session;

		$validMod = array( 'member' );
		if( in_array( $mod, $validMod ) )
		{
			require_once( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/' . $mod . '/' . $mod . '.class.php' );
			$iniClass = $mod;
			new $iniClass();
		}
	}
}

?>