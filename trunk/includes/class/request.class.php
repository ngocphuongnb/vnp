<?php 
/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'ILN' );

class request
{
	public $defaults = array (
								'method' => 'get',
								'blocked' => false
							);
							
	public function __construct()
	{
	}
													
	public function get( $paramName = '', $method = 'get', $defaultValue = '', $dataType = '', $encode = false )
	{
		$return = '';
		if( !empty( $paramName ) )
		{
			switch( $method )
			{
				case 'get':
					if( array_key_exists( $paramName, $_GET ) )
					{
						$return = $_GET[$paramName];
					}
					break;
				case 'post':
					if( array_key_exists( $paramName, $_POST ) )
					{
						$return = $_POST[$paramName];
					}
					break;
			}
		}
		if( !empty( $return ) )
		{
			return DataType( $return, $dataType );
		}
		else
		{
			return DataType( $defaultValue, $dataType );
		}
	}	
}

?>