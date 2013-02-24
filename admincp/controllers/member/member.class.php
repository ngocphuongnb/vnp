<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'ADMIN_FILE' ) ) die( 'ILN' );

class member
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
	
	public static function showAdminProfile()
	{
		global $adminData, $customMenu;
		
		$html = '
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    	' . $adminData['realname'] . '
                        <span class="alert-noty">25</span>
                        <i class="white-icons admin_user"></i>
                        <b class="caret"></b>
                    </a>
					<ul class="dropdown-menu">
                        <li><a href="#"><i class="icon-inbox"></i>Inbox<span class="alert-noty">10</span></a></li>
                        <li><a href="#"><i class="icon-envelope"></i>Notifications<span class="alert-noty">15</span></a></li>
                        <li><a href="#"><i class="icon-briefcase"></i>My Account</a></li>
                        <li><a href="#"><i class="icon-file"></i>View Profile</a></li>
                        <li><a href="/vnp/admincp/index.php?ctl=member&action=editprofile"><i class="icon-pencil"></i>Edit Profile</a></li>
                        <li><a href="#"><i class="icon-cog"></i>Account Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="/vnp/admincp/index.php?ctl=member&action=logout"><i class="icon-off"></i><strong>Logout</strong></a></li>
          			</ul>';
					
		$customMenu['topmenu'][] = $html;
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