<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

class editor
{
	public $Editor = 'ckeditor';
	public function __construct()
	{
		global $request, $template, $db, $session;
		
		//$this->$Editor();
	}
	
	static function registerEditor( $textareaID, $editor = 'ckeditor' )
	{
		global $template;
		
		if( !empty( $textareaID ) )
		{
			$template->hook['header'] .= '<script src="' . MY_ADMDIR . 'controllers/editor/' . $editor . '/' . $editor . '.js"></script>';
			$template->hook['content'] .= '<script>CKEDITOR.replace( \'' . $textareaID . '\' );</script>';
		}
	}
}

?>