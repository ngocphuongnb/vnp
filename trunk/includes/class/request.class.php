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
			if( $method == 'get' )
			{
				if( array_key_exists( $paramName, $_GET ) )
				{
					$return = $_GET[$paramName];
				}
			}
			elseif( $method == 'post' )
			{
				if( array_key_exists( $paramName, $_POST ) )
				{
					$return = $_POST[$paramName];
				}
			}
			else
			{
				$methodArray = explode(',', $method);
				if( sizeof( $methodArray ) == 2 && isset( $methodArray[0] ) && isset( $methodArray[1] ) )
				{
					if( in_array( trim( $methodArray[0] ), array( 'get', 'post' ) ) && in_array( trim( $methodArray[1] ), array( 'get', 'post' ) ) )
					{
						if( array_key_exists( $paramName, $_GET ) )
						{
							$return = $_GET[$paramName];
						}
						elseif( array_key_exists( $paramName, $_POST ) )
						{
							$return = $_POST[$paramName];
						}
					}
				}
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
	
	public function vnpUnset( $name, $method = '' )
	{
		if( empty( $method ) )
		{
			unset( $_POST[$name] );
			unset( $_GET[$name] );
		}
		elseif( $method == 'get' )
		{
			unset( $_GET[$name] );
		}
		elseif( $method == 'post' )
		{
			unset( $_POST[$name] );
		}
	}
}

?>