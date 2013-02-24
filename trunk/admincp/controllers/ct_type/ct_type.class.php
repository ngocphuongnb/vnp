<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

class ct_type
{
	public function __construct()
	{
		global $request, $template, $db, $session;		
	}
	
	public static function formField( $fieldata = array() )
	{
		$xtpl = new XTemplate( 'form_field.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
		$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
		$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
		$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
	}
	
	public static function formGenerator( $fieldArray = array() )
	{
		$xtpl = new XTemplate( 'myform.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
		$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
		$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
		$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

?>