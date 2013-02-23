<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

class vnp_member
{
	public function __construct()
	{
		global $request, $template, $db, $session;
		
		if( $action = $request->get( 'action', 'get', '' ) )
		{
			switch( $action )
			{
				case 'logout':
					{
						$session->unsetss( 'session', 'AdminLogged' );
						Header( 'Location: ' . MY_ADMDIR );
						exit();
					}
					break;
					
				case 'editprofile':
					{
						if( $request->get( 'action', 'get', '' ) )
						{
							$template->content = $this->formEditProfile();
						}
						else
						{
							$this->saveProfile();
						}
					}
					break;
			}
		}
	}
	
	private function saveProfile()
	{
	}
	
	public static function adminLoginForm()
	{
		global $loginError;
		
		$xtpl = new XTemplate( 'login.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/member/' );
		$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
		$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
		$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
		
		if( !empty( $loginError ) )
		{
			foreach( $loginError as $_err )
			{
				if( !empty( $_err ) )
				{
					$xtpl->assign( 'ERR', $_err );
					$xtpl->parse( 'main.error.loop' );
				}
			}
			$xtpl->parse( 'main.error' );
		}
		$xtpl->parse( 'main' );
		echo $xtpl->out( 'main' );
	}
	
	private function formEditProfile()
	{
		$xtpl = new XTemplate( 'editprofile.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/member/' );
		$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
		$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
		$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

?>