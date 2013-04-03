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
	public $error		= array();
	public $ignor_err	= array();
	
	public function __construct()
	{
		global $request, $template, $db, $session;
		
		if( $action = $request->get( 'action', 'get,post', '' ) )
		{
			$validAction = array( 'list_ct_type', 'list_ct_field', 'add_ct_type', 'del_ct_type', 'view_ct_type', 'refer',  'edit_ct_type', 'Ajax_check_ct_type', 'Ajax_check_ct_field', 'Ajax_add_ct_type', 'Ajax_list_ct_type', 'Ajax_list_ct_field', 'Ajax_delete_ct_type' );
			
			if( in_array( $action, $validAction ) && method_exists( $this, $action ) )
			{
				$this->$action();
			}
		}	
	}
	
	private function Ajax_check_ct_type()
	{
		global $template, $request;
		
		if( defined( 'IS_AJAX' ) )
		{		
			$ct_typeJson	= $request->get( 'ct_typeJson', 'post' );
			$ct_typeJson	= str_replace( '\"', '"', $ct_typeJson );
			$ct_type		= ( array )json_decode( $ct_typeJson );
			
			if( $_checkrs = $this->check_ct_type( $ct_type ) )
			{
				$msg = vnpMsg( 'Content type hợp lệ, các thông tin dưới đây sẽ được lưu lại:', 'success' );
				
				$msg .= '<div class="code-block clearfix">
							<h6 class="fl">Tên content type: </h6><h5 class="fl">&nbsp;&nbsp;&nbsp;' . $_checkrs['content_type_title'] . '</h5><br />
							<h6 class="fl">Unique Id: </h6><h5 class="fl">&nbsp;&nbsp;&nbsp;' . $_checkrs['content_type_name'] . '</h5><br />
							<h6 class="fl">Miêu tả: </h6><h5 class="fl">&nbsp;&nbsp;&nbsp;' . $_checkrs['content_type_note'] . '</h5>
						</div>';
						
				$checkStatus = array('status' => 'ok', 'msg' => $msg );
				$template->content = json_encode( array_merge( $checkStatus, $_checkrs ) );
				echo $template->content;
				exit();
			}
			else
			{
				$checkStatus = array('status' => 'no', 'msg' => vnpMsg( array_merge( $this->error, $this->ignor_err ), 'error'));
				$template->content = json_encode( $checkStatus );
				echo $template->content;
				exit();
			}
		}
		else
		{
			$checkStatus = array('status' => 'no', 'msg' => vnpMsg( 'Thao tác không hợp lệ', 'error'));
			$template->content = json_encode( $checkStatus );
			echo $template->content;
			exit();
		}
	}
	
	private function Ajax_check_ct_field()
	{
		global $template, $request;
		
		if( defined( 'IS_AJAX' ) )
		{
			$this->ignor_err = array();	
			$ct_fieldJson	= $request->get( 'ct_fieldJson', 'post' );
			$ct_fieldJson	= str_replace( '\"', '"', $ct_fieldJson );
			$ct_field		= ( array )json_decode( $ct_fieldJson );
			
			if( $_checkrs = $this->check_ct_field( $ct_field ) )
			{
				$msg = 'OK&nbsp;&nbsp;-&nbsp;&nbsp;Trường dữ liệu hợp lệ';
				$checkStatus = array('status' => 'ok', 'msg' => $msg );
				$template->content = json_encode( $checkStatus );
				echo $template->content;
				exit();
			}
			else
			{
				$checkStatus = array('status' => 'no', 'msg' => implode(', ', $this->ignor_err ));
				$template->content = json_encode( $checkStatus );
				echo $template->content;
				exit();
			}
		}
	}
	
	private function Ajax_add_ct_type()
	{
		global $template;
		
		if( defined( 'IS_AJAX' ) )
		{
			//echo 'NO*';
			 $this->add_ct_type();
			//exit();
			if( empty( $this->error ) && empty( $this->ignor_err ) )
			{
				$template->content = 'OK*Thêm thành công content type!';
				echo $template->content;
				exit();
			}
			else
			{
				$template->content = 'NO*' . implode( '<br />', array_reverse( array_merge( $this->error, $this->ignor_err ) ) );
				echo $template->content;
				exit();
			}
		}
	}
	
	private function Ajax_delete_ct_type()
	{
		global $request, $db, $template, $db_info;
		if( defined( 'IS_AJAX' ) )
		{
			$ct_type = $request->get( 'ct_type', 'post,get' );
			if( $_checkrs = $this->check_ct_type( array( 'content_type_name' => $ct_type ) ) )
			{
				$template->content = $template->title = 'Không tìm thấy content type';
				$status = 'no';
			}
			else
			{
				$sql = 'DELETE FROM ' . CONTENT_TYPE . ' WHERE `content_type_name`= ' . vnp_db::SQLValue( $ct_type );
				$db->Query( $sql );
				$sql = 'DELETE FROM ' . CONTENT_FIELD . ' WHERE `content_type_name`= ' . vnp_db::SQLValue( $ct_type );
				$db->Query( $sql );
				$sql = 'DROP TABLE ' . $db_info['prefix'] . '_' . $ct_type;
				$db->Query( $sql );
				$request->vnpUnset( 'ct_type' );
				$this->list_ct_type();
				$status = 'ok';
			}
			$data = array();
			$data['content']	= $template->content;
			$data['title']		= $template->title;
			$data['status']		= $status;
			echo json_encode( $data );
			exit();
		}
	}
	
	private function Ajax_list_ct_type()
	{
		global $db;
		
		$contentType = $db->QueryArray( 'SELECT `content_type_id`, `content_type_name`, `content_type_title`, `content_type_note` FROM ' . CONTENT_TYPE, MYSQL_ASSOC, 'content_type_id');
		
		if( !empty( $contentType ) )
		{
			$option = '';
			
			foreach( $contentType as $key => $type )
			{
				$option .= '<option value="' . $key . '">' . $type['content_type_title'] . '</option>';
			}		
			echo json_encode( array( 'status' => 'OK', 'opts' => $option ) );
			exit();
		}
		else
		{
			echo json_encode( array( 'status' => 'NO', 'opts' => '' ) );
			exit();
		}
	}
	
	private function Ajax_list_ct_field()
	{
		global $db, $request;
		
		$ct_fieldJson	= $request->get( 'ct_fieldJson', 'post' );
		$ct_fieldJson	= str_replace( '\"', '"', $ct_fieldJson );
		$ct_field		= ( array )json_decode( $ct_fieldJson );
		
		$contentField = $db->QueryArray( 'SELECT `field_id`, `field_label` FROM ' . CONTENT_FIELD . ' WHERE `content_type_id`=' . vnp_db::SQLValue( $ct_field['ct_type_id'] ), MYSQL_ASSOC, 'field_id');
		
		if( !empty( $contentField ) )
		{
			$option = '';
			
			foreach( $contentField as $key => $field )
			{
				$option .= '<option value="' . $key . '">' . $field['field_label'] . '</option>';
			}		
			echo json_encode( array( 'status' => 'OK', 'opts' => $option ) );
			exit();
		}
		else
		{
			echo json_encode( array( 'status' => 'NO', 'opts' => '' ) );
			exit();
		}
	}
	
	private function check_ct_type( $ct_type, $ct_typeJson = '' )
	{
		global $db;
		
		if( empty($ct_type['content_type_title']) )
		{
			$this->error[] = 'Empty content type title!';
		}
		elseif( empty($ct_type['content_type_name']) )
		{
			$ct_type['content_type_name'] = get_alias( $ct_type['content_type_title'] );
		}
		else
		{
			$ct_type['content_type_name'] = get_alias( $ct_type['content_type_name'] );
		}
		
		if( empty( $this->error ) )
		{
			$check_ct_type = array( 'content_type_name' => vnp_db::SQLValue( $ct_type['content_type_name'] ) );	
			$db->SelectRows( CONTENT_TYPE, $check_ct_type );
			if( $db->RowCount() > 0 )
			{
				//$this->error[] = $db->GetLastSQL();
				$this->error[] = 'Content type đã tồn tại!';
				return '';
			}
			else
			{
				return $ct_type;
			}
		}
		else return '';
	}
	
	private function check_ct_field( $ct_field )
	{
		global $db;
		
		$err = array();
		
		$fieldType = array(
							'number-int',
							'number-float',
							'short-text',
							'long-text',
							'text',
							'date',
							'image',
							'file',
							'radio',
							'checkbox',
							'select',
							'radio'
						);
		if( empty( $ct_field['field_name'] ) || empty( $ct_field['field_label'] ) )
		{
			$err[] = 'Tên trường và tiêu đề không thể trống!';			
		}
		//if( !in_array( $ct_field['field_type'], $fieldType ) )
		{
			//$err[] = 'Loại dữ liệu không hợp lệ!';
		}
		if( $ct_field['field_length'] < 0 )
		{
			$err[] = 'Độ dài không hợp lệ!';
		}
		
		if( !empty( $err ) )
		{
			$this->ignor_err = $err;
			return '';
		}
		else
		{	
			$ct_field['field_name'] = get_alias( $ct_field['field_name'] );
			$check_ct_field = array( 'field_name' => vnp_db::SQLValue( $ct_field['field_name'] ), 'content_type_name' => vnp_db::SQLValue( $ct_field['content_type_name'] ) );	
			$db->SelectRows( CONTENT_FIELD, $check_ct_field );
			if( $db->RowCount() > 0 )
			{
				$this->ignor_err[] = 'Trường: <u>' . $ct_field['field_name'] . '</u> đã tồn tại!';
				return '';
			}
			else
			{
				return $ct_field;
			}
		}
	}
	
	private function list_ct_type()
	{
		global $template, $db, $request, $db_info;
		
		if( $ct_type = $request->get( 'ct_type', 'get,post' ) )
		{
			$check_ct_type = array( 'content_type_name' => vnp_db::SQLValue( $ct_type ) );
		
			$db->SelectRows( CONTENT_TYPE, $check_ct_type );
			//echo $db->GetHTML();
			if( $db->RowCount() === 1 )
			{
				$ctTypeData = $db->RowArray(0, MYSQL_ASSOC);
				$template->title = 'Thêm nội dung cho content type ' . $ctTypeData['content_type_title'];
				
				$contentField = $db->QueryArray( 'SELECT * FROM ' . CONTENT_FIELD . ' WHERE `content_type_name`=' . vnp_db::SQLValue( $ctTypeData['content_type_name'] ), MYSQL_ASSOC, 'field_name');
				if( $request->get( 'submit', 'post' ) == 1 )
				{
					$data = vnp_form::getFormData( $contentField );
					
					$_result = $db->InsertRow( $db_info['prefix'] . '_' . $ctTypeData['content_type_name'], $data );
					if( !$_result )
					{
						$template->content = 'NO*Không thể thêm nội dung';
						$db->Kill();
					}
					else
					{
						$template->content = 'OK*Thêm nội dung thành công';
					}
					echo $template->content;
					exit();
				}
				else
				{
					$formData = array(
								'header' => 'Thêm nội dung ' . $ctTypeData['content_type_title'],
								'action' => MY_ADMDIR . 'index.php?ctl=ct_type&action=list_ct_type&ct_type=' . $ctTypeData['content_type_name'],
								'method' => 'post'
							);
							
					$form = new vnp_form();
							
					$template->content = $form->create( $formData, $contentField );
				}
			}
			else
			{
				$template->title = 'Không tìm thấy content type';
			}
		}
		else
		{	
			$template->title = 'Danh sách loại nội dung';
			$xtpl = new XTemplate( 'list_ct_type.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
			$xtpl->assign( 'action_link', MY_ADMDIR . 'index.php?ctl=ct_type&action=' );
			$xtpl->assign( 'MY_DIR', VNP_MYDIR );
			
			$template->title = 'Danh sách loại nội dung';
			
			$contentType = $db->QueryArray( 'SELECT `content_type_id`, `content_type_name`, `content_type_title`, `content_type_note` FROM ' . CONTENT_TYPE, MYSQL_ASSOC, 'content_type_name');
			
			if( !empty( $contentType ) )
			{
				foreach( $contentType as $ct_type )
				{
					$xtpl->assign( 'TYPE', $ct_type );
					$xtpl->parse( 'main.choose_ct_type.loop' );
				}
				$xtpl->parse( 'main.choose_ct_type' );
			}
			$xtpl->parse( 'main' );
			$template->content = $xtpl->text( 'main' );
		}
	}
	
	private function list_ct_field()
	{
		global $template, $db;
		
		$template->title = 'Danh sách trường nội dung';
		
		$contentField = $db->QueryArray( 'SELECT `field_id`, `content_type_id`, `content_type_name`, `field_name`, `field_label`, `field_type`, `field_length`, `default_value`, `require` FROM ' . CONTENT_FIELD, MYSQL_ASSOC, 'field_id');
		
		$theadData = array( 'Content Field id',
							'Content Type id',
							'Content Type name',
							'Field name',
							'Field label',
							'Field type',
							'Field length',
							'Default value',
							'Require'
						);
		$tableData = array(
							'label'	=> 'Danh sách content field',
							'menu'	=> array(
												array( 'href' => MY_ADMDIR . 'index.php?ctl=ct_type&action=add_ct_type', 'anchor' => ' Add new', 'class' => 'icon-plus' ),
												array( 'href' => '#', 'anchor' => ' Bulk Approved', 'class' => 'icon-ok' ),
												array( 'href' => '#', 'anchor' => ' Bulk Remove', 'class' => 'icon-minus-sign' )
											)
							);
		
		$template->content = $template->tableGenerator( $theadData, $contentField, $tableData );
	}
	
	private function add_ct_type()
	{
		global $request, $template, $db;
		
		$template->title = 'Thêm loại nội dung';
		
		if( $request->get( 'submit', 'post', '' ) )
		{
			$template->content = '';
			$ct_type = array(
							array( 'field_name' => 'content_type_title' ),
							array( 'field_name' => 'content_type_name' ),
							array( 'field_name' => 'content_type_note' )
						);
			
			$fieldnums = $request->get( 'field-count', 'post' );
			for( $i = 0; $i <= $fieldnums; $i++ )
			{
				$ct_type[] = array( 'field_name' => 'ct_type_field' . $i );
				$ct_type[] = array( 'field_name' => 'select_option' . $i, 'field_type' => 'number' );
			}		
			
			$formData = vnp_form::getFormData( $ct_type, false );
			
			if( $_formData = $this->check_ct_type( $formData ) )
			{
				$formData = $_formData;
				unset( $_formData );
				
				$ctTypeData = array(
									'content_type_title'	=> vnp_db::SQLValue( $formData['content_type_title'] ),
									'content_type_name'		=> vnp_db::SQLValue( $formData['content_type_name'] ),
									'content_type_note'		=> vnp_db::SQLValue( $formData['content_type_note'] )
								);
				
				$_result = $db->InsertRow( CONTENT_TYPE, $ctTypeData );
				if( !$_result )
				{
					$this->error[] = 'Can not add content type!';
					$db->Kill();
				}
				else
				{
					$ctTypeID = $db->GetLastInsertID();	
					$ct_field = array();
					$ct_field_options = array();
					for( $i = 0; $i <= $fieldnums; $i++ )
					{
						$ct_field[$i]			= $formData['ct_type_field' . $i];
						$ct_field_options[$i]	= $formData['select_option' . $i];
					}
					
					$ctTypeTable = array();
					$ctTypeTable['primary_key'] = $formData['content_type_name'] . '_id';
					$ctTypeTable['field'][0]	= array(
														'field_name'	=> $ctTypeTable['primary_key'],
														'field_type'	=> 'mediumint',
														'field_length'	=> 8,
														'is_unique'		=> 0
													);
					foreach( $ct_field as $key => $_field )
					{
						if( $__field = $this->check_ct_field( $_field ) )
						{
							$_field = $__field;
							unset( $__field );
							
							$_field['option_nums'] = (int)  $_field['option_nums'];
							if(  $_field['option_nums'] <= 0 )  $_field['option_nums'] = 1;
							 
							if( !isset( $_field['ref_field'] ) || empty( $_field['ref_field'] ) )
							{
								$_field['ref_field'] = 0;
							}
							
							if( !isset( $_field['ref_ct_type'] ) || empty( $_field['ref_ct_type'] ) )
							{
								$_field['ref_ct_type'] = 0;
							}
							
							/////////////////////
							$optsArray = array();
							foreach( $ct_field_options[$key] as $_otpValue => $_otpText )
							{
								$optsArray[] = array( 'text' => $_otpText, 'value' => $_otpValue );
							}
							/////////////////////
							
							$ctFieldData = array(
									'content_type_id'	=> vnp_db::SQLValue( $ctTypeID, 'number' ),
									'content_type_name' => vnp_db::SQLValue( $formData['content_type_name'] ),
									'field_name'		=> vnp_db::SQLValue( $_field['field_name'] ),
									'field_label'		=> vnp_db::SQLValue( $_field['field_label'] ),
									'field_type'		=> vnp_db::SQLValue( $_field['field_type'] ),
									'field_length'		=> vnp_db::SQLValue( $_field['field_length'], 'number' ),
									'default_value'		=> vnp_db::SQLValue( $_field['default_value'] ),
									'ref_ct_type'		=> vnp_db::SQLValue( $_field['ref_ct_type'], 'number' ),
									'ref_field'			=> vnp_db::SQLValue( $_field['ref_field'], 'number' ),
									'require'			=> vnp_db::SQLValue( $_field['require'], 'number' ),
									'option_nums'		=> vnp_db::SQLValue( $_field['option_nums'], 'number' ),
									'option_data'		=> vnp_db::SQLValue( serialize( $optsArray ) ),
									'is_primary'		=> 0,
									'is_unique'			=> vnp_db::SQLValue( $_field['is_unique'], 'number' )
								);
														
							$_result = $db->InsertRow( CONTENT_FIELD, $ctFieldData );
							//$db->GetLastSQL();
							if( !$_result )
							{
								$this->error[] = 'Can not add content field - ' . $_field['field_name'];
								$db->Kill();
							}
							else
							{
								$ctTypeTable['field'][]	= array(
														'field_name'	=> $_field['field_name'],
														'field_type'	=> $_field['field_type'],
														'field_length'	=> $_field['field_length'],
														'is_unique'		=> $_field['is_unique'],
														'require'		=> $_field['require'],
														'default_Value'	=> $_field['default_Value']
													);
							}
						}
					}
					
					if( !$this->createCtTypeTable( $formData['content_type_name'], $ctTypeTable ) )
					{
						$this->ignor_err[] = 'Không thể tạo bảng dữ liệu cho <u>' . $formData['content_type_name'] . '</u><br />Vui lòng kiểm tra xem bảng dữ liệu đã tồn tại hay chưa';
						
						$sql = 'DELETE FROM ' . CONTENT_TYPE . ' WHERE `content_type_name`= ' . vnp_db::SQLValue( $formData['content_type_name'] );
						$db->Query( $sql );
						/*
						$delCdts = array();
						foreach( $ctTypeTable['field'] as $field )
						{
							$delCdts[] = vnp_db::SQLValue( $field['field_name'] );
						}
						$delCdts = implode( ',', $delCdts );
						$sql = 'DELETE FROM ' . CONTENT_FIELD . ' WHERE `field_name` IN (' . $delCdts . ')';
						*/
						$sql = 'DELETE FROM ' . CONTENT_FIELD . ' WHERE `content_type_name`= ' . vnp_db::SQLValue( $formData['content_type_name'] );
						$db->Query( $sql );
					}
				}
			}
			if( empty( $this->error ) )
			{
				$template->content .= vnpMsg( 'Thêm thành công content type', 'success' );
			}
		}
		$template->content .= vnpMsg( array_merge( $this->error, $this->ignor_err ), 'error' );
		$template->content .= $this->addContentTypeForm();
	}
	
	private function edit_ct_type()
	{
		global $db, $request, $template;
		
		if( $ct_type = $request->get( 'ct_type', 'get,post' ) )
		{
			$check_ct_type = array( 'content_type_name' => vnp_db::SQLValue( $ct_type ) );
		
			$db->SelectRows( CONTENT_TYPE, $check_ct_type );
			//echo $db->GetHTML();
			if( $db->RowCount() === 1 )
			{
				if( $request->get( 'submit', 'get,post' ) == 1 )
				{
				}
				else
				{
					$ct_field_type_otps					= array();
					$ct_field_type_otps['image']		= 'Hình ảnh';
					$ct_field_type_otps['file']			= 'Upload file';
					$ct_field_type_otps['radio']		= 'Radio';
					$ct_field_type_otps['checkbox']		= 'Checkbox';
					$ct_field_type_otps['select']		= 'Select';
					$ct_field_type_otps['referer']		= 'Dữ liệu liên kết';
					$ct_field_type_otps['VARCHAR']		= 'VARCHAR';
					$ct_field_type_otps['TINYINT']		= 'TINYINT';
					$ct_field_type_otps['TEXT']			= 'TEXT';
					$ct_field_type_otps['DATE']			= 'DATE';
					$ct_field_type_otps['SMALLINT']		= 'SMALLINT';
					$ct_field_type_otps['MEDIUMINT']	= 'MEDIUMINT';
					$ct_field_type_otps['INT']			= 'INT';
					$ct_field_type_otps['BIGINT']		= 'BIGINT';
					$ct_field_type_otps['FLOAT']		= 'FLOAT';
					$ct_field_type_otps['DOUBLE']		= 'DOUBLE';
					$ct_field_type_otps['DECIMAL'] 		= 'DECIMAL';
					$ct_field_type_otps['DATETIME'] 	= 'DATETIME';
					$ct_field_type_otps['TIMESTAMP']	= 'TIMESTAMP';
					$ct_field_type_otps['TIME']		 	= 'TIME';
					$ct_field_type_otps['YEAR'] 		= 'YEAR';
					$ct_field_type_otps['CHAR'] 		= 'CHAR';
					$ct_field_type_otps['TINYBLOB'] 	= 'TINYBLOB';
					$ct_field_type_otps['TINYTEXT'] 	= 'TINYTEXT';
					$ct_field_type_otps['BLOB'] 		= 'BLOB';
					$ct_field_type_otps['MEDIUMBLOB'] 	= 'MEDIUMBLOB';
					$ct_field_type_otps['MEDIUMTEXT'] 	= 'MEDIUMTEXT';
					$ct_field_type_otps['LONGBLOB']	 	= 'LONGBLOB';
					$ct_field_type_otps['LONGTEXT'] 	= 'LONGTEXT';
					$ct_field_type_otps['ENUM']	 		= 'ENUM';
					$ct_field_type_otps['SET'] 			= 'SET';
					$ct_field_type_otps['BOOL'] 		= 'BOOL';
					$ct_field_type_otps['BINARY'] 		= 'BINARY';
					$ct_field_type_otps['VARBINARY'] 	= 'VARBINARY';
					
					
					$ctTypeData = $db->RowArray(0, MYSQL_ASSOC);
					$template->title = 'Sửa content type ' . $ctTypeData['content_type_title'];
					
					$contentField = $db->QueryArray( 'SELECT * FROM ' . CONTENT_FIELD . ' WHERE `content_type_name`=' . vnp_db::SQLValue( $ctTypeData['content_type_name'] ), MYSQL_ASSOC, 'field_name');
					
					$xtpl = new XTemplate( 'edit_ct_type.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
					$xtpl->assign( 'ACTION', MY_ADMDIR . 'ajax.php?ajax=1&ctl=ct_type&action=Ajax_edit_ct_type' );
					$xtpl->assign( 'MY_DIR', VNP_MYDIR );
					
					foreach( $contentField as $key => $_field )
					{
						foreach( $ct_field_type_otps as $fkey => $otp )
						{
							$_field['field_type'] = str_replace( '-', '', $_field['field_type'] );
							if( strtolower($fkey) == strtolower($_field['field_type']) )
							{
								$slt = ' selected="selected"';
							}
							else
							{
								$slt = '';
							}
							$xtpl->assign( 'OTPS', array( 'value' => $fkey, 'text' => $otp, 'slted' => $slt ) );
							$xtpl->parse( 'main.field.ct_field_type_otps' );
						}
						( $_field['require'] == 1 ) ? $_field['require'] = ' selected="selected"' : $_field['require'] = '';
						( $_field['is_unique'] == 1 ) ? $_field['is_unique'] = ' checked="checked"' : $_field['is_unique'] = '';
						$xtpl->assign( 'FIELD', $_field );
						$xtpl->parse( 'main.field' );
					}
					
					$xtpl->parse( 'main' );
					$template->content = $xtpl->text( 'main' );
				}
			}
			else
			{
				$template->content = $template->title = 'Không tìm thấy content type';
			}
		}
	}
	
	private function addContentTypeForm()
	{
		$xtpl = new XTemplate( 'extendable.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
		$xtpl->assign( 'ACTION', MY_ADMDIR . 'ajax.php?ajax=1&ctl=ct_type&action=Ajax_add_ct_type' );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	private function createCtTypeTable( $tableName = '', $ctTypeTable = array() )
	{
		global $db, $db_info;
		
		if( !empty( $ctTypeTable ) && is_array( $ctTypeTable ) )
		{
			$uniqueKey = array();
			$sql = 'CREATE TABLE `' . $db_info['prefix'] . '_' . $tableName . '` (
					  `' . $ctTypeTable['field'][0]['field_name'] . '` ' . $ctTypeTable['field'][0]['field_type'] . '(' . $ctTypeTable['field'][0]['field_length'] . ') unsigned NOT NULL auto_increment,';
					  
			unset( $ctTypeTable['field'][0] );
			foreach( $ctTypeTable['field'] as $_field )
			{
				if( $_field['require'] == 1 ) $rq = ' NOT NULL ';
				else $rq = '';
				
				$numberType = array('TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT', 'FLOAT', 'DOUBLE', 'DECIMAL');
				$specialType = array('select', 'checkbox', 'radio', 'image');
				if( in_array( strtolower( $_field['field_type'] ), $specialType ) )
				{
					$_field['field_type'] = 'varchar';
				}
				
				if( $_field['field_type'] == 'referer' )
				{
					$_field['field_type'] = 'MEDIUMINT';
				}
				
				if( in_array( strtoupper( $_field['field_type'] ), $numberType ) )
				{
					if( $_field['default_value'] == '' )
					{
						$_field['default_value'] = 0;
					}
				}
				elseif( strtoupper( $_field['field_type'] ) == 'MEDIUMTEXT' || strtoupper( $_field['field_type'] ) == 'LONGTEXT' )
				{
					$length = '';
				}
				else
				{
					if( empty( $_field['field_length'] ) )
					{
						$length = '(255)';
					}
					else
					{
						$length = '(' . $_field['field_length'] . ')';
					}
				}
				
				$sql .= '`' . $_field['field_name'] . '` ' . $_field['field_type'] . $length . $rq . ' DEFAULT \'' . $_field['default_value'] . '\',';
				
				if( $_field['is_unique'] == 1 )
				{
					$uniqueKey[] = 'UNIQUE KEY `' . $_field['field_name'] . '` (`' . $_field['field_name'] . '`)';
				}
			}
			$sql .= 'PRIMARY KEY (`' . $ctTypeTable['primary_key'] . '`)';
			if( !empty( $uniqueKey ) )
			{
				$sql .= ',' . implode( ',', $uniqueKey );
			}
			$sql .= ') ENGINE=MyISAM';
		}
		if( $db->Query( $sql ) )
		{
			return true;
		}
		else
		{
			$this->ignor_err[] = $sql;
			return false;
		}
	}
}

class vnp_form
{
	public $formField	= array();
	private $fieldOpts	= array();
	
	public function __construct()
	{
		$this->formField = array();
	}
	
	/*	
	$fieldData = array(
							'type'		=> 'input_field_type',
							'name'		=> 'input_field_name',
							'value'		=> 'input_field_default_value',
							'id'		=> 'input_field_id',
							'label'		=> 'Input label',
							'tooltip'	=> 'Help text data by tooltip',
							'help'		=> 'Normal help text',
							'even'		=> 'Javascript even: onclick, onblur, onchange, onkeydown, onfocus...',
							'callback'	=> 'javascript callback function'
							
							'options'	=> array(
													array(
															'value' => 'Option value',
															'text'	=> 'Option text'
														),
													array(
															'value' => 'Option value',
															'text'	=> 'Option text'
														),
													array(
															'value' => 'Option value',
															'text'	=> 'Option text'
														)
												)
						);
					
	*/
	
	private function CreateField( $fieldData = array() )
	{
		$xtpl = new XTemplate( 'form_field.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
		
		if( isset( $fieldData['even'] ) && !empty( $fieldData['even'] ) )
		{
			if( isset( $fieldData['callback'] ) && !empty( $fieldData['callback'] ) )
			{
				$fieldData['evenmethod'] = $fieldData['even'] . '="' . $fieldData['callback'] . ';"';
			}
		}
		$xtpl->assign( 'FIELD', $fieldData );
		if( isset( $fieldData['help'] ) && !empty( $fieldData['help'] ) )
		{
			$xtpl->parse( 'main.help' );
		}
		switch( strtolower($fieldData['field_type']))
		{
			case 'textbox':
			case 'varc-har':
			case 'referer':
				{
					$xtpl->parse( 'main.textbox' );
				}
				break;
			case 'file':
				{
					$xtpl->parse( 'main.file' );
				}
				break;
			case 'image':
				{
					$xtpl->parse( 'main.image' );
				}
				break;
			case 'date':
				{
					$xtpl->parse( 'main.date' );
				}
				break;
			case 'textarea':
			case 'mediumtext':
			case 'longtext':
				{
					editor::registerEditor( $fieldData['field_name'] );
					$xtpl->parse( 'main.textarea' );
				}
				break;
			case 'radio':
				{
					if( isset( $fieldData['options'] ) && !empty( $fieldData['options'] ) )
					{
						if( is_array( $fieldData['options'] ) )
						{
							foreach( $fieldData['options'] as $_opt )
							{
								if( $fieldData['value'] == $_opt['value'] )
								{
									$_opt['checked'] = ' checked="checked"';
								}
								else
								{
									$_opt['checked'] = '';
								}
								$xtpl->assign( 'OPTION', $_opt );
								$xtpl->parse( 'main.radio.options' );
							}
						}
					}
					$xtpl->parse( 'main.radio' );
				}
				break;
			case 'checkbox':
				{
					if( isset( $fieldData['options'] ) && !empty( $fieldData['options'] ) )
					{
						if( is_array( $fieldData['options'] ) )
						{
							foreach( $fieldData['options'] as $_opt )
							{
								if( $fieldData['value'] == $_opt['value'] )
								{
									$_opt['checked'] = ' checked="checked"';
								}
								else
								{
									$_opt['checked'] = '';
								}
								$xtpl->assign( 'OPTION', $_opt );
								$xtpl->parse( 'main.checkbox.options' );
							}
						}
					}
					$xtpl->parse( 'main.checkbox' );
				}
				break;
			case 'selectbox':
				{
					if( isset( $fieldData['options'] ) && !empty( $fieldData['options'] ) )
					{
						if( is_array( $fieldData['options'] ) )
						{
							$i = 1;
							foreach( $fieldData['options'] as $_opt )
							{
								if( $fieldData['value'] == $_opt['value'] )
								{
									$_opt['selected'] = ' selected="selected"';
								}
								else
								{
									$_opt['selected'] = '';
								}
								$_opt['index'] = $i;
								$xtpl->assign( 'OPTION', $_opt );
								$xtpl->parse( 'main.selectbox.options' );
								$xtpl->parse( 'main.selectbox.options2' );
								$i++;
							}
						}
					}
					$xtpl->parse( 'main.selectbox' );
				}
				break;
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	/*
	$formData = array(
						'header' => 'Form header',
						'action' => 'Form action onsubmit',
						'method' => 'Form submit methd'
					);
	*/
	
	public function create( $formData = array(), $fieldData = array(), $extended = '' )
	{
		global $template;
		require( DOC_ROOT . MY_ADMDIR . 'controllers/editor/editor.class.php' );
		$xtpl = new XTemplate( 'myform.tpl', DOC_ROOT . MY_ADMDIR . 'controllers/ct_type/' );
		$xtpl->assign( 'INSTALL_DIR', INSTALL_DIR );
		$xtpl->assign( 'ADMIN_DIR', ADMIN_DIR );
		$xtpl->assign( 'MY_DOMAIN', VNP_DOMAIN );
		$xtpl->assign( 'MY_DIR', VNP_MYDIR );
		$xtpl->assign( 'FORM_DATA', $formData );
		
		foreach( $fieldData as $field )
		{
			$xtpl->assign( 'FIELD_DATA', $this->CreateField( $field ) );
			$xtpl->parse( 'main.field' );
		}
		
		if( !empty( $extended ) )
		{
			$xtpl->assign( 'EXT', $extended );
		}
		
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
	
	/*
	type: number, text
	$nameArray = array(
						array(
								'name' => 'Name of input field to get value',
								'field_type' => 'Type of value'
							),
						array(
								'input_field_name' => 'Name of input field to get value',
								'input_value_type' => 'Type of value'
							),
						array(
								'input_field_name' => 'Name of input field to get value',
								'input_value_type' => 'Type of value'
							),
					);
	*/
	
	public static function getFormData( $nameArray = array(), $insertDb = true )
	{
		global $request;
		
		$return = array();
		
		if( $insertDb )
		{
			foreach( $nameArray as $_name )
			{
				$textField = array( 'varc-har', 'mediumtext', 'longtext' );
				if( empty( $_name['field_type'] ) || in_array( strtolower($_name['field_type']), $textField ) )
				{
					$_name['field_type'] = 'text';
				}
				$return[$_name['field_name']] = vnp_db::SQLValue( $request->get( $_name['field_name'], 'post' ), $_name['field_type'] );
			}
		}
		else
		{
			foreach( $nameArray as $_name )
			{
				$return[$_name['field_name']] = $request->get( $_name['field_name'], 'post' );
			}
		}
		
		return $return;
	}
}

?>