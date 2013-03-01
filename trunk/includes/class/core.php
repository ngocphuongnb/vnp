<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

class vnp
{
	private $notice;
	
	public $error = array();
	
	public function __construct()
	{
		$this->_sysChecking();
		$this->_initializing();
		$this->_load_env();
		$this->_ini_global();
	}
	
	public function &instance() 
	{
		static $object;
		if( empty( $object ) ) 
		{
			$object = new vnp();
		}
		return $object;
	}
	
	protected function _parseErr( $error, $sysErr = false )
	{
		global $vG, $Glang;
		
		if( !empty( $error ) ) $this->error[] = $error;
		if( $sysErr == true )
		{
			define( 'SYSTEM_ERROR', true );
			$this->error[] = $Glang['system_error'];
			$this->error[] = array_unique( $this->error );
		}
	}
	
	protected function _sysChecking()
	{
		global $sys_info;
		
		if( file_exists( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/' . CORE_FUNCTION ) )
		{
			require_once( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/' . CORE_FUNCTION );
		}
		else
		{
			$this->_parseErr( $glang['core_function_file_notfound'], true );
		}
		
		if( file_exists( VNP_ROOT . '/includes/' . GET_SYSINFO ) )
		{
			require_once( VNP_ROOT . '/includes/' . GET_SYSINFO );
		}
		else
		{
			$this->_parseErr( $glang['sysinfo_file_notfound'], true );
		}
	}
	
	protected function _initializing()
	{
		global $glang, $sys_info, $session, $nG, $db, $pass, $request, $db_info, $template;
		
		if( file_exists( VNP_ROOT . '/includes/class/xtemplate.min.class.php' ) )
		{
			require_once( VNP_ROOT . '/includes/class/xtemplate.min.class.php' );
		}
		else
		{
			$this->_parseErr( $glang['xtemplate_file_notfound'], true );
		}
		if( file_exists( VNP_ROOT . '/' . INSTALL_DIR . '/install.lock' ) )
		{
			if( file_exists( VNP_ROOT . '/includes/' . CONFIG_FILE ) )
			{
				require_once( VNP_ROOT . '/includes/' . CONFIG_FILE );
				require ( VNP_ROOT . '/includes/class/db.' . $db_info['dbtype'] . '.class.php');
				/*********************/
				$db	= new vnp_db( true, $db_info['hostname'], $db_info['dbname'], $db_info['dbuname'], $db_info['dbpass'] );
				$session	= new vnp_session( 'sesPre', 'sources/temp/sess', 'cooPre');
				$pass		= new vnp_pass();
				$request	= new request();
				/*********************/
			}
			else
			{
				$this->_parseErr( $glang['config_file_notfound'], true );
			}
		}
		else
		{
			Header( "Location: " . VNP_MYDIR . INSTALL_DIR . '/install.php' );
			exit();
		}
		
		if( file_exists( VNP_ROOT . '/includes/' . SYS_INI ) )
		{
			require_once( VNP_ROOT . '/includes/' . SYS_INI );
		}
		else
		{
			$this->_parseErr( $glang['sysinfo_file_notfound'], true );
		}
	}
	
	protected function _load_env()
	{
		global $_vG, $glang, $client_info, $alias_get, $db_info;
		
		if( file_exists( VNP_ROOT . '/includes/' . LOAD_ENV ) )
		{
			require_once( VNP_ROOT . '/includes/' . LOAD_ENV );
		}
		else
		{
			$this->_parseErr( $glang['loadenv_file_notfound'], true );
		}
		if( file_exists( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/theme.php' ) )
		{
			require_once( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/theme.php' );
		}
		else
		{
			$this->_parseErr( $glang['loadenv_file_notfound'], true );
		}		
	}
	
	protected function _ini_global()
	{
		global $client_info, $nG, $db_info;
		
		//Ten cac table cua CSDL dung chung cho he thong
		define( 'VNP_ADMIN', $db_info['prefix'] . '_admins' );
		define( 'VNP_ADMIN_PERMISS', $db_info['prefix'] . '_admin_permiss' );
		define( 'VNP_USER', $db_info['prefix'] . '_users' );
		define( 'USER_PROFILE', $db_info['prefix'] . '_users_profile' );
		define( 'SESSION', $db_info['prefix'] . '_session' );
		define( 'GLOBAL_CONFIG', $db_info['prefix'] . '_global_config' );
		define( 'GLOBAL_URL', $db_info['prefix'] . '_global_url' );
		define( 'CONTENT_TYPE', $db_info['prefix'] . '_content_type' );
		define( 'CONTENT_FIELD', $db_info['prefix'] . '_content_field' );
	}
	
	public function Mode( $mod )
	{
		global $content, $request, $pass, $db, $customHeading, $nG, $mode;
		
		if( file_exists( VNP_ROOT . '/sources/controllers/' . $mod . '/function.php' ) && file_exists( VNP_ROOT . '/sources/controllers/' . $mod . '/' . $mod . '.php' ) )
		{
			$mode = $mod;
			include( VNP_ROOT . '/sources/controllers/' . $mode . '/function.php' );
			include( VNP_ROOT . '/sources/controllers/' . $mode . '/' . $mode . '.php' );
			ob_start();
			echo $content;
		}
	}
	
	public function urlHanderler()
	{
		global $alias_get, $db;
		
		$checkUrl = array( 'url' => vnp_db::SQLValue( $alias_get ) );		
		
		$db->SelectRows( GLOBAL_URL, $checkUrl );
		//echo $db->GetHTML();
		if( $db->RowCount() === 1 )
		{
			$UrlData = $db->RowArray(0, MYSQL_ASSOC);
			
			$availableController = array( 'music' );
			
			if( in_array( $UrlData['controller'], $availableController ) )
			{
				if( file_exists( VNP_ROOT . '/sources/controllers/' . $UrlData['controller'] . '/function.php' ) && file_exists( VNP_ROOT . '/sources/controllers/' . $UrlData['controller'] . '/' . $UrlData['controller'] . '.php' ) )
				{
					$mode = $UrlData['controller'];
					include( VNP_ROOT . '/sources/controllers/' . $UrlData['controller'] . '/function.php' );
					include( VNP_ROOT . '/sources/controllers/' . $UrlData['controller'] . '/' . $UrlData['controller'] . '.php' );
					new $UrlData['controller']();
				}
			}
		}
	}
	
	public function SetNotice( $note )
	{
		!empty( $note ) ? $this->notice = $note : $this->notice = 'Empty';
		return $this->notice;
	}
}
?>