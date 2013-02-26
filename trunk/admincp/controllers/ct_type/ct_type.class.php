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
	
	public function create( $formData = array(), $fieldData = array() )
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