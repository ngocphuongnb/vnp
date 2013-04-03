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
						if( $request->get( 'submit', 'post', '' ) )
						{
							$this->saveProfile();
						}
						$template->content = $this->formEditProfile();
					}
					break;
				case 'accsetting':
					{
						if( $request->get( 'submit', 'post', '' ) )
						{
							$this->saveAccSetting();
						}
						$template->content = $this->formEditAccSetting();
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
                        <li><a class="vnp-ajax" href="#"><i class="icon-inbox"></i> Inbox<span class="alert-noty">10</span></a></li>
                        <li><a class="vnp-ajax" href="#"><i class="icon-envelope"></i> Notifications<span class="alert-noty">15</span></a></li>
                        <li><a class="vnp-ajax" href="#"><i class="icon-briefcase"></i> My Account</a></li>
                        <li><a class="vnp-ajax" href="#"><i class="icon-file"></i> View Profile</a></li>
                        <li><a class="vnp-ajax" href="' . MY_ADMDIR  . 'index.php?ctl=member&action=editprofile"><i class="icon-pencil"></i> Edit Profile</a></li>
                        <li><a class="vnp-ajax" href="' . MY_ADMDIR  . 'index.php?ctl=member&action=accsetting"><i class="icon-cog"></i> Account Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="' . MY_ADMDIR  . 'index.php?ctl=member&action=logout"><i class="icon-off"></i><strong> Logout</strong></a></li>
          			</ul>';
					
		$customMenu['topmenu'][] = $html;
	}
	
	private function saveProfile()
	{
		global $db, $adminData;
		
		$profile = array(
							array( 'field_name' => 'realname' ),
							array( 'field_name' => 'gender', 'field_type' => 'number' ),
							array( 'field_name' => 'telephone' ),
							array( 'field_name' => 'constellation' ),
							array( 'field_name' => 'birthday', 'field_type' => 'date' ),
							array( 'field_name' => 'address' ),
							array( 'field_name' => 'company' )
						);
		$dbData = vnp_form::getFormData( $profile );

		$dbData['birthday'] = explode( '-', str_replace( "'", "", $dbData['birthday'] ) );
		$dbData['birthyear'] = $dbData['birthday'][0];
		$dbData['birthmonth'] = $dbData['birthday'][2];
		$dbData['birthday'] = $dbData['birthday'][1];
		
		$_result = $db->UpdateRows( USER_PROFILE, $dbData, array( 'userid' =>  $adminData['userid'] ) );
		$_result = $db->UpdateRows( VNP_USER, array( 'realname' => $dbData['realname'] ), array( 'userid' =>  $adminData['userid'] ) );
		if( !$_result )
		{
			$db->Kill();
		}
		else
		{
			Header( 'Location: ' . MY_ADMDIR . 'index.php?ctl=member&action=editprofile' );
		}
	}
	
	private function saveAccSetting()
	{
		global $db, $adminData;
		
		$profile = array(
							array( 'field_name' => 'email' ),
							array( 'field_name' => 'password' ),
							array( 'field_name' => 'repassword' )
						);
		$dbData = vnp_form::getFormData( $profile, false );
		
		$pass = new vnp_pass();
		
		if( $dbData['password'] == $dbData['repassword'] )
		{
			$dbData['password'] = vnp_db::SQLValue( $pass->genPass( $dbData['password'] ) );
			$dbData['salt']		= vnp_db::SQLValue( $pass->salt );
			unset( $dbData['repassword'] );
		}
		$dbData['email'] = vnp_db::SQLValue( $dbData['email'] );
		
		$_result = $db->UpdateRows( VNP_USER, $dbData, array( 'userid' =>  $adminData['userid'] ) );
		if( !$_result )
		{
			$db->Kill();
		}
		else
		{
			Header( 'Location: ' . MY_ADMDIR . 'index.php?ctl=member&action=accsetting' );
		}
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
	
	private function formEditAccSetting()
	{
		global $db, $adminData;
		
		$checkUser = array( 'userid' => vnp_db::SQLValue( $adminData['userid'], 'number' ) );
		
		$db->SelectRows( VNP_USER, $checkUser );
		if( $db->RowCount() === 1 )
		{
			$UserData = $db->RowArray(0, MYSQL_ASSOC);
			
			$form = new vnp_form();
			
			$fieldData = array();
			
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'email',
									'field_label'		=> 'Email',
									'tooltip'	=> 'Email',
									'value'		=> $UserData['email']
								);
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'password',
									'field_label'		=> 'Password',
									'tooltip'	=> 'Nhập mật khẩu',
									'value'		=> ''
								);
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'repassword',
									'field_label'		=> 'RePassword',
									'tooltip'	=> 'Nhập lại mật khẩu',
									'value'		=> ''
								);
			$formData = array(
								'header' => 'Cài đặt tài khoản',
								'action' => MY_ADMDIR . 'index.php?ctl=member&action=accsetting',
								'method' => 'post'
							);
							
			return $form->create( $formData, $fieldData );
		}
		else return 'Cannot find user!';
	}
	
	private function formEditProfile()
	{
		global $db, $adminData;
		
		$checkUser = array( 'userid' => vnp_db::SQLValue( $adminData['userid'], 'number' ) );
		
		$db->SelectRows( USER_PROFILE, $checkUser );
		//echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$UserData = $db->RowArray(0, MYSQL_ASSOC);
			
			$UserData['birthday'] = str_pad((int) $UserData['birthday'], 2, '0',STR_PAD_LEFT );
			$UserData['birthmonth'] = str_pad((int) $UserData['birthmonth'], 2, '0',STR_PAD_LEFT );
		
			$form = new vnp_form();
			
			$fieldData = array();
			
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'realname',
									'field_label'		=> 'Tên đầy đủ',
									'tooltip'	=> 'Tên đầy đủ',
									'value'		=> $UserData['realname']
								);
								
			$fieldData[] = array( 
									'field_type'		=> 'radio',
									'field_name'		=> 'gender',
									'field_label'		=> 'Giới tính',
									'tooltip'	=> 'Tên đầy đủ',
									'value'		=> $UserData['gender'],
									'options'	=> array(
														array(
																'value' => '0',
																'text'	=> 'Không xác định'
															),
														array(
																'value' => '1',
																'text'	=> 'Nam'
															),
														array(
																'value' => '2',
																'text'	=> 'Nữ'
															)
													)
								);
			
			$fieldData[] = array( 
									'field_type'		=> 'selectbox',
									'field_name'		=> 'constellation',
									'field_label'		=> 'Chòm sao',
									'tooltip'	=> 'Chòm sao cung hoàng đạo',
									'value'		=> $UserData['constellation'],
									'options'	=> array(
														array(
																'value' => '',
																'text'	=> 'Chọn chòm sao'
															),
														array(
																'value' => 'Bạch Dương',
																'text'	=> 'Bạch Dương'
															),
														array(
																'value' => 'Kim Ngưu',
																'text'	=> 'Kim Ngưu'
															),
														array(
																'value' => 'Song Tử',
																'text'	=> 'Nữ'
															),
														array(
																'value' => 'Cự Giải',
																'text'	=> 'Cự Giải'
															),
														array(
																'value' => 'Sư Tử',
																'text'	=> 'Sư Tử'
															),
														array(
																'value' => 'Xử Nữ',
																'text'	=> 'Xử Nữ'
															),
															array(
																'value' => 'Thiên Bình',
																'text'	=> 'Thiên Bình'
															),
														array(
																'value' => 'Thiên Yết',
																'text'	=> 'Thiên Yết'
															),
														array(
																'value' => 'Nhân Mã',
																'text'	=> 'Nhân Mã'
															),
														array(
																'value' => 'Ma Kết',
																'text'	=> 'Ma Kết'
															),
														array(
																'value' => 'Thủy Bình',
																'text'	=> 'Thủy Bình'
															),
														array(
																'value' => 'Song Ngư',
																'text'	=> 'Song Ngư'
															),
													)
								);
								
			$fieldData[] = array( 
									'field_type'		=> 'date',
									'field_name'		=> 'birthday',
									'field_label'		=> 'Ngày sinh',
									'tooltip'	=> 'Ngày sinh',
									'value'		=> $UserData['birthday'] . '/' . $UserData['birthmonth'] . '/' . $UserData['birthyear']
								);
			
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'telephone',
									'field_label'		=> 'Điện thoại',
									'tooltip'	=> 'Điện thoại',
									'value'		=> $UserData['telephone']
								);
			
			$fieldData[] = array( 
									'field_type'		=> 'textarea',
									'field_name'		=> 'address',
									'field_label'		=> 'Địa chỉ',
									'tooltip'	=> 'Địa chỉ',
									'value'		=> $UserData['address']
								);
			
			$fieldData[] = array( 
									'field_type'		=> 'textbox',
									'field_name'		=> 'company',
									'field_label'		=> 'Công ty',
									'tooltip'	=> 'Công ty',
									'value'		=> $UserData['company']
								);
			
			$formData = array(
								'header' => 'Sửa thông tin cá nhân',
								'action' => MY_ADMDIR . 'index.php?ctl=member&action=editprofile',
								'method' => 'post'
							);

			return $form->create( $formData, $fieldData );
		}
		else return 'Cannot find the user!';
	}
}

?>