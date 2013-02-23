<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

class admin_theme
{
	public $topMenu = '';
	public $sideBar = '';
	
	public function __construct( )
	{
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/admin_theme/template.php' );
		if( defined( 'LOGGED_ADMIN' ) )
		{
			$this->init();
		}
		else
		{
			return false;
		}
	}
	
	public function init()
	{		
		$topMenuArray = array();
		$sideBarArray = array();

		$this->topMenu = adminTopMenu( $topMenuArray );
		$this->sideBar = adminSideBar( $sideBarArray );
		
		admin_theme::singlePage( adminFullTheme( $this->topMenu, $this->sideBar ) );
	}
	
	public static function singlePage( $content )
	{
		$xtpl = new XTemplate( 'single_page.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
		
		$xtpl->assign( 'CONTENT', $content );
		$xtpl->parse( 'main' );
		echo $xtpl->out( 'main' );
	}
}

?>