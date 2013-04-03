<?php 
/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'ILN' );

class vnp_pass
{
	public $salt = '';
	
	public function __construct()
	{
		//echo $this->genPass( 'phuong' );
	}
	
	public function genPass( $string, $addSalt = true )
	{
		if( !empty( $string ) )
		{
			if( $addSalt )
			{
				$this->salt = RandomString();
			}
			else $this->salt = '';
			
			return hash( 'sha256', md5( $string . $this->salt ) );
		}
	}	
	
	public function authenticate( $inputString, $salt = '', $authString )
	{
		$_authTemp = hash( 'sha256', md5( $inputString . $salt ) );
		
		//echo $_authTemp; die();
		
		if( $_authTemp === $authString )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function Clear()
	{
		$this->salt = '';
	}
}

?>