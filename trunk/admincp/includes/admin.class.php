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
	public $adminData	= array();
	public static $html		= '';
	
	public function __construct()
	{
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/member/member.class.php' );
		$this->checkAdmin();
		$this->loadTheme();
		//$this->loadControllers();
		//$this->printPage();
	}
	
	private function checkAdmin()
	{
		global $session, $request, $db, $pass;
		
		if( @include( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/member/check_admin.php' ) )
		{
			// do nothing;
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
		$validMod = array( 'login' );
		if( in_array( $mod, $validMod ) )
		{
			require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/' . $mod . '/' . $mod . '.class.php' );
			$iniClass = 'vnp_' . $mod;
			new $iniClass();
		}
	}
}

?>