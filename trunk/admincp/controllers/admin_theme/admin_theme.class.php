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
	public	$topMenu		= '';
	public	$sideBar		= '';
	public	$content	= '';
	public	$systemStart	= false;
	
	public function __construct( )
	{
		require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/admin_theme/template.php' );
		
		if( defined( 'LOGGED_ADMIN' ) )
		{
			//$this->init();
			$this->systemStart = true;
		}
		else
		{
			return false;
			exit('Hacking!');
		}
	}
	
	public function init()
	{
		global $themeMenu, $customMenu;
		
		if( $this->systemStart )
		{
			$this->topMenu = adminTopMenu( $themeMenu['topmenu'], $customMenu['topmenu'] );
			$this->sideBar = adminSideBar( $themeMenu['sidebar'], $customMenu['sidebar'] );
			
			admin_theme::singlePage( adminFullTheme( $this->topMenu, $this->sideBar, $this->content ) );
		}
	}
	
	public static function registerMenu( $menuName = '', $menuData )
	{		
		global $themeMenu;
		
		$menuKeys = array_keys( $themeMenu );
		
		if( !empty( $menuName ) && in_array( $menuName, $menuKeys ) && !empty( $menuData ) )
		{
			$themeMenu[$menuName][] = $menuData;
		}
	}
	
	public static function singlePage( $content )
	{
		$xtpl = new XTemplate( 'single_page.tpl', DOC_ROOT . MY_ADMDIR . '/template/' );
		
		$xtpl->assign( 'CONTENT', $content );
		$xtpl->parse( 'main' );
		//ob_start();
		echo $xtpl->out( 'main' );
	}
	
	/*
	$theadData	= array( 'thead title 1', 'thead title 2' )
	$rowData	= array(
							array( 'col 1', 'col 2', 'col 3' ),
							array( 'col 1', 'col 2', 'col 3' )
						);
						
	$tableData	= array(
				'label' => 'Table title',
				'menu'	=> array(
									array( 'href' => 'link href', 'anchor' => 'link anchor', 'class' => 'icon class' ),
									array( 'href' => 'link href', 'anchor' => 'link anchor', 'class' => 'icon class' )
						);
						
	*/
	
	public function tableGenerator( $theadData = array(), $rowData = array(), $tableData = array() )
	{
		$xtpl = new XTemplate( 'table.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/admin_theme/' );
		
		foreach( $theadData as $thead )
		{
			$xtpl->assign( 'THEAD', $thead );
			$xtpl->parse( 'main.thead' );
		}
		
		foreach( $rowData as $row )
		{
			foreach( $row as $key => $col )
			{
				$xtpl->assign( 'COL', $row[$key] );
				$xtpl->parse( 'main.row.col' );
			}
			$xtpl->parse( 'main.row' );
		}
		
		foreach( $tableData['menu'] as $menu )
		{
			$xtpl->assign( 'MENU', $menu );
			$xtpl->parse( 'main.menu' );
		}
		
		$xtpl->assign( 'LABEL', $tableData['label'] );
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

class vnp_menu
{
	private $mainMenu	= array();
	private $subMenu	= array();
	private $thisMenu;
	
	public function __construct()
	{
		$this->mainMenu = '';
		$this->subMenu	= '';
	}
	
	public function mainMenu( $href = '#', $anchor = '' )
	{
		$this->mainMenu = array( 'href' => $href, 'anchor' => $anchor );
	}
	
	public function subMenu( $href = '#', $anchor = '' )
	{
		if( $href === 'break' )
		{
			$this->subMenu[] = 'break';
		}
		else
		{
			$this->subMenu[] = array( 'href' => $href, 'anchor' => $anchor );
		}
	}
	
	public function menu()
	{		
		return array( 'link_data' => $this->mainMenu, 'sub_data' => $this->subMenu );
	}
}

?>