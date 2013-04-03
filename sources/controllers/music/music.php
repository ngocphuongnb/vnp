<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) or !defined( 'VN' ) ) die( 'Hacking' ); 

class music
{
	public function __construct()
	{
		$xtpl = new XTemplate( 'album.tpl', DOC_ROOT . VNP_MYDIR . 'sources/controllers/music/template/' );
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}