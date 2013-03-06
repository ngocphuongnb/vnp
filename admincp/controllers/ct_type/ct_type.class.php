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
			$validAction = array( 'list_ct_type', 'list_ct_field', 'add_ct_type', 'del_ct_type', 'view_ct_type', 'refer', 'Ajax_check_ct_type', 'Ajax_check_ct_field', 'Ajax_add_ct_type' );
			
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
			/*
			for( $i=0; $i<1000; $i++)
			{
				for( $j=0; $j<500; $j++)
				{
				}
			}*/
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
			/*
			for( $i = 0; $i < 10000000; $i++ )
			{
			}
			*/
			$this->add_ct_type();
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
			$check_ct_field = array( 'field_name' => vnp_db::SQLValue( $ct_field['field_name'] ) );	
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
		global $template, $db;
		//for( $i = 0; $i < 100000000; $i++ )
		{
			$a = 0;
		}
		
		$contentType = $db->QueryArray( 'SELECT `content_type_id`, `content_type_name`, `content_type_title`, `content_type_note` FROM ' . CONTENT_TYPE, MYSQL_ASSOC, 'content_type_name');
		
		$theadData = array( 'Content Type id',
							'Content Type name',
							'Content Type title',
							'Content Type note',
						);
		$tableData = array(
							'label'	=> 'Danh sách content type',
							'menu'	=> array(
												array( 'href' => MY_ADMDIR . 'index.php?ctl=ct_type&action=add_ct_type', 'anchor' => ' Add new', 'class' => 'icon-plus' ),
												array( 'href' => '#', 'anchor' => ' Bulk Approved', 'class' => 'icon-ok' ),
												array( 'href' => '#', 'anchor' => ' Bulk Remove', 'class' => 'icon-minus-sign' )
											)
							);
		
		$template->content = $template->tableGenerator( $theadData, $contentType, $tableData );
	}
	
	private function list_ct_field()
	{
		global $template, $db;
		
		//for( $i = 0; $i < 100000000; $i++ )
		{
			$a = 0;
		}
		
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
		
		if( $request->get( 'submit', 'post', '' ) )
		{
			$template->content = '';
			$ct_type = array(
							array( 'content_type_title' ),
							array( 'content_type_name' ),
							array( 'content_type_note' )
						);
			
			$fieldnums = $request->get( 'field-count', 'post' );
			for( $i = 0; $i <= $fieldnums; $i++ )
			{
				$ct_type[] = array( 'ct_type_field' . $i );
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
					for( $i = 0; $i <= $fieldnums; $i++ )
					{
						$ct_field[] = $formData['ct_type_field' . $i];
					}
					
					$ctTypeTable = array();
					$ctTypeTable['primary_key'] = $formData['content_type_name'] . '_id';
					$ctTypeTable['field'][0]	= array(
														'field_name'	=> $ctTypeTable['primary_key'],
														'field_type'	=> 'mediumint',
														'field_length'	=> 8,
														'is_unique'		=> 0
													);
					
					foreach( $ct_field as $_field )
					{
						if( $__field = $this->check_ct_field( $_field ) )
						{
							$_field = $__field;
							unset( $__field );
							
							$ctFieldData = array(
									'content_type_id'	=> vnp_db::SQLValue( $ctTypeID, 'number' ),
									'content_type_name' => vnp_db::SQLValue( $formData['content_type_name'] ),
									'field_name'		=> vnp_db::SQLValue( $_field['field_name'] ),
									'field_label'		=> vnp_db::SQLValue( $_field['field_label'] ),
									'field_type'		=> vnp_db::SQLValue( $_field['field_type'] ),
									'field_length'		=> vnp_db::SQLValue( $_field['field_length'], 'number' ),
									'default_value'		=> vnp_db::SQLValue( $_field['default_value'] ),
									'require'			=> vnp_db::SQLValue( $_field['require'], 'number' ),
									'is_primary'		=> 0,
									'is_unique'			=> vnp_db::SQLValue( $_field['is_unique'], 'number' )
								);
														
							$_result = $db->InsertRow( CONTENT_FIELD, $ctFieldData );
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
						$delCdts = array();
						foreach( $ctTypeTable['field'] as $field )
						{
							$delCdts[] = vnp_db::SQLValue( $field['field_name'] );
						}
						$delCdts = implode( ',', $delCdts );
						$sql = 'DELETE FROM ' . CONTENT_FIELD . ' WHERE `field_name` IN (' . $delCdts . ')';
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
				
				if( in_array( strtoupper( $_field['field_type'] ), $numberType ) )
				{
					if( $_field['default_value'] == '' )
					{
						$_field['default_value'] = 0;
					}
				}
				elseif( strtoupper( $_field['field_type'] ) == 'MEDIUMTEXT' )
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
		switch( $fieldData['type'])
		{
			case 'textbox':
				{
					$xtpl->parse( 'main.textbox' );
				}
				break;
			case 'date':
				{
					$xtpl->parse( 'main.date' );
				}
				break;
			case 'textarea':
				{
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
								'type' => 'Type of value'
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
				if( empty( $_name['1'] ) ) $_name['1'] = 'text';
				$return[$_name[0]] = vnp_db::SQLValue( $request->get( $_name['0'], 'post' ), $_name['1'] );
			}
		}
		else
		{
			foreach( $nameArray as $_name )
			{
				$return[$_name[0]] = $request->get( $_name[0], 'post' );
			}
		}
		
		return $return;
	}
}

?>