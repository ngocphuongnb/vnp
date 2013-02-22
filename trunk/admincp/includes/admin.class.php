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
	public $html		= '';
	
	public function __construct()
	{
		$this->loadTemplate();
		$this->checkAdmin();
		//$this->loadControllers();
		$this->printPage();
	}
	
	private function loadTemplate()
	{
		require( VNP_ROOT . '/' . ADMIN_DIR . '/includes/template.php' );
	}
	
	private function checkAdmin()
	{
		global $session, $request, $db;
		
		if( @include( VNP_ROOT . '/' . ADMIN_DIR . '/includes/check_admin.php' ) )
		{
			if( !defined( 'LOGGED_ADMIN' ) )
			{
				$this->html = adminLoginForm();
			}
			else
			{
				include( VNP_ROOT . '/' . ADMIN_DIR . '/includes/load_theme.php' );
			}
		}
		else
		{
			exit( 'System Error!' );
		}
	}
	
	private function printPage()
	{
		echo $this->html;
	}
}

?>