<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

define( 'VNP_INSTALL', true ); 
define( 'VNP', true ); 
define( 'VN', true ); 
if( !defined( 'VNP_ROOT' ) )
{
	define( 'VNP_ROOT', str_replace( '\\', '/', realpath( pathinfo( __file__, PATHINFO_DIRNAME ) . '/../' ) ) );
}
require ( VNP_ROOT . '/includes/constants.php');
require ( VNP_ROOT . '/includes/variables.php');
require ( VNP_ROOT . '/includes/' . FUNCTION_DIR . '/' . CORE_FUNCTION );
require ( VNP_ROOT . '/includes/' . GET_SYSINFO );
require ( VNP_ROOT . '/includes/' . SYS_INI );
require ( VNP_ROOT . '/includes/' . LOAD_ENV );
require ( VNP_ROOT . '/' . INSTALL_DIR . '/template.php' );
require ( VNP_ROOT . '/includes/class/request.class.php');
require ( VNP_ROOT . '/includes/class/db.class.php');


// url
$vnp_mydir = pathinfo( $_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
if ( $vnp_mydir == DIRECTORY_SEPARATOR ) $vnp_mydir = '';
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = str_replace( DIRECTORY_SEPARATOR, '/', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/[\/]+$/", '', $vnp_mydir );
if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/^[\/]*(.*)$/", '/\\1', $vnp_mydir );
$vnp_mydir = str_replace( INSTALL_DIR, '', $vnp_mydir );
$vnp_admindir = $vnp_mydir . ADMIN_DIR . '/';

if( file_exists( VNP_ROOT . '/' . INSTALL_DIR . '/install.lock' ) )
{
	Header( "Location: " . $vnp_mydir );
	exit();
}


$request = new request();
$installError = array();

$installStep = $request->get( 'step', 'get', 0, 'int' );

if( $installStep < 0 || $installStep > 10 )
{
	$installStep = 0;
	Header( "Location: " . $vnp_mydir . INSTALL_DIR . "/install.php?step=0" );
	exit();
}
if( $installStep == 0 )
{
	if( $request->get( 'next', 'post', '' ) )
	{
		Header( "Location: " . $vnp_mydir . INSTALL_DIR . "/install.php?step=1" );
		exit();
	}
	$content = InstallStep0();
}
elseif( $installStep == 1 )
{
	$ftpData = array(
						'ftpuname' => '',
						'ftppass' => '',
						'ftppath' => ''
					);
	if( $request->get( 'next', 'post', '' ) )
	{
		$ftpData['ftpuname'] = $request->get( 'ftpuname', 'post', '' );
		$ftpData['ftppass'] = $request->get( 'ftppass', 'post', '' );
		$ftpData['ftprepass'] = $request->get( 'ftprepass', 'post', '' );
		$ftpData['ftppath'] = $request->get( 'ftppath', 'post', '' );
		
		if( $ftpData['ftpuname'] == '' )
		{
			$installError[] = 'FTP username can not be empty';		
		}
		if( $ftpData['ftppass'] == '' )
		{
			$installError[] = 'FTP password can not be empty';		
		}
		if( empty( $installError ) )
		{
			Header( "Location: " . $vnp_mydir . INSTALL_DIR . "/install.php?step=2" );
			exit();
		}
	}
	$content = InstallStep1();
}
elseif( $installStep == 2 )
{
	$dbData = array(
					'hostname' => '',
					'dbname' => '',
					'dbuname' => '',
					'dbpass' => '',
					'dbprefix' => ''
				);
	$delTableForm = false;
	
	if( $request->get( 'next', 'post', '' ) )
	{
		$dbData['hostname'] = $request->get( 'host', 'post', '' );
		$dbData['dbname'] = $request->get( 'dbname', 'post', '' );
		$dbData['dbuname'] = $request->get( 'dbuname', 'post', '' );
		$dbData['dbpass'] = $request->get( 'dbpass', 'post', '' );
		$dbData['dbprefix'] = $request->get( 'dbprefix', 'post', '' );
		
		$delTable = $request->get( 'deltable', 'post', '' );
		//np($dbData);
		$db = new vnp_db();
		if( $db->Open( $dbData['hostname'], $dbData['dbname'], $dbData['dbuname'], $dbData['dbpass'] ) )
		{
			$authkey = substr( md5( $_SERVER['SERVER_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $dbData['hostname'] . $dbData['dbuname'] . $dbData['dbpass'] . $dbData['dbname'] . $dbData['dbuname'] . $dbData['dbpass'] . $dbData['dbname'] . substr( time(), 0, 6 ) ), 8, 6).random( 10 );
			$configContent = '<?php' . PHP_EOL . '
/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */' . PHP_EOL . '
if( !defined( \'VNP\' ) || !defined( \'VN\' ) ) die( \'Hacking!!!\' );' . PHP_EOL . '
$db_info[\'dbhost\']		= 	\'' . $dbData['hostname'] . '\';
$db_info[\'dbport\']		= 	\'\';
$db_info[\'dbname\']		= 	\'' . $dbData['dbname'] . '\';
$db_info[\'dbuname\']		= 	\'' . $dbData['dbuname'] . '\';
$db_info[\'dbpass\']		= 	\'' . $dbData['dbpass'] . '\';
$db_info[\'sitekey\']		= 	\'' . RandomString(32) . '\';
$db_info[\'prefix\']		= 	\'' . $dbData['dbprefix'] . '\';' . PHP_EOL . '
//
$nG[\'authkey\']				=	\'' . $authkey . '\';' . PHP_EOL . '
?>';
			
			if( file_exists( VNP_ROOT . '/includes/' . CONFIG_FILE ) )
			{
				if( file_put_contents( VNP_ROOT . '/includes/' . CONFIG_FILE, $configContent, LOCK_EX ) )
				{
					require( VNP_ROOT . '/includes/' . CONFIG_FILE );
				}
				else $db_info['prefix'] = $dbData['dbprefix'];
			}
			
			require ( VNP_ROOT . '/' . INSTALL_DIR . '/data.php' );
			
			$checktable = $db->QueryArray( 'SHOW TABLE STATUS LIKE \'' . $db_info['prefix'] . '\_%\'' );
			$nums = $db->RowCount();

			$_i = 0;
			if( !empty( $checktable ) )
			{
				$delTableForm = true;
			}
			if( $delTable == 1 )
			{
				while( $_i < $nums )
				{
					$db->Query( 'DROP TABLE `' . $checktable[$_i]['Name'] . '`' );
					$_i++;
				}
			}
			
			if( !empty( $sql_create_table ) )
			{
				foreach( $sql_create_table as $_sql )
				{
					$db->Query( $_sql );
					if( $db->Error() )
					{
						$installError[] = $db->Error();
					}
				}
				if( empty( $installError ) )
				{
					Header( "Location: " . $vnp_mydir . INSTALL_DIR . "/install.php?step=3" );
					exit();
				}
			}
		}
		else
		{
			if( $db->Error() )
			{
				$installError[] = $db->Error();
			}
		}
	}
	$content = InstallStep2( $dbData, $delTableForm );
}
elseif( $installStep == 3 )
{
	$content = InstallStep3();
	
	if( $request->get( 'next', 'post', '' ) )
	{
		$siteConfig['site_title'] = $request->get( 'site_title', 'post', '' );
		$siteConfig['site_description'] = $request->get( 'site_description', 'post', '' );
		$adminConfig['admin_uname'] = $request->get( 'admin_uname', 'post', '' );
		$adminConfig['admin_pass'] = $request->get( 'admin_pass', 'post', '' );
		$adminConfig['admin_repass'] = $request->get( 'admin_repass', 'post', '' );
		
		if( $adminConfig['admin_pass'] == $adminConfig['admin_repass'] )
		{
			require( VNP_ROOT . '/includes/' . CONFIG_FILE );
			
			$db = new vnp_db( true, $db_info['hostname'], $db_info['dbname'], $db_info['dbuname'], $db_info['dbpass'] );
			
			if( $db->IsConnected() )
			{		
				require ( VNP_ROOT . '/' . INSTALL_DIR . '/data.php' );
				foreach( $siteConfig as $key => $_cfvalue )
				{		
					$global_config = array(
												'config_name'	=> vnp_db::SQLValue( $key ),
												'config_key'	=> vnp_db::SQLValue( 'global' ),
												'config_value'	=> vnp_db::SQLValue( $_cfvalue )
											);
									
					$_result = $db->InsertRow( GLOBAL_CONFIG, $global_config );
					if( !$_result )
					{
						$db->Kill();
					}
				}
				
				require ( VNP_ROOT . '/includes/class/password.class.php');
				$pass = new vnp_pass();
				
				$admin_config = array(
										'username'		=> vnp_db::SQLValue( $adminConfig['admin_uname'] ),
										'password'		=> vnp_db::SQLValue( $pass->genPass( $adminConfig['admin_pass'] ) ),
										'salt'			=> vnp_db::SQLValue( $pass->salt )
									);
									
				$_result = $db->InsertRow( VNP_USER, $admin_config );
				$pass->Clear();
				
				$admin_config1 = array(
										'userid'		=> vnp_db::SQLValue( $db->GetLastInsertID() ),
										'permission'	=> vnp_db::SQLValue( '1' ),
										'title'			=> vnp_db::SQLValue( 'Admin' ),
										'status'		=> vnp_db::SQLValue( 1, 'number' ),
									);
				$_result = $db->InsertRow( VNP_ADMIN, $admin_config1 );
				if( !$_result )
				{
					$db->Kill();
				}
									
				unset( $adminConfig['admin_pass'] );
				unset( $adminConfig['admin_repass'] );
				
				Header( "Location: " . $vnp_mydir . INSTALL_DIR . "/install.php?step=4" );
				exit();
			}
			else
			{
				if( $db->Error() )
				{
					$installError[] = $db->Error();
				}
			}
		}
		else
		{
			$installError[] = 'Passwords doesn\'t match';
		}
	}
}
elseif( $installStep == 4 )
{
	if( file_exists( VNP_ROOT . '/' . INSTALL_DIR . '/install.temp.lock' ) )
	{
		rename( VNP_ROOT . '/' . INSTALL_DIR . '/install.temp.lock', VNP_ROOT . '/' . INSTALL_DIR . '/install.lock' );
	}
	$content = InstallStep4();
}

TempOutPut( $content );


/*
echo 'time:&nbsp&nbsp&nbsp&nbsp&nbsp ' . VNP_TIME . '<br />';
echo 'IP:&nbsp&nbsp&nbsp&nbsp&nbsp ' . SERVER_IP . '<br />';
echo 'SERVER NAME:&nbsp&nbsp&nbsp&nbsp&nbsp ' . SERVER_NAME . '<br />';
echo 'PROTOCOL ' . SERVER_PROTOCOL . '<br />';
echo 'PORT:&nbsp&nbsp&nbsp&nbsp ' . SERVER_PORT . '<br />';
echo 'AGENT:&nbsp&nbsp&nbsp&nbsp ' . USER_AGENT . '<br />';
echo 'DOMAIN:&nbsp&nbsp&nbsp&nbsp ' . VNP_DOMAIN . '<br />';
echo 'DIR:&nbsp&nbsp&nbsp&nbsp&nbsp ' . $vnp_mydir . '<br />';
echo 'ADMINDIR:&nbsp&nbsp&nbsp&nbsp&nbsp ' . $vnp_admindir . '<br />';
echo 'HD STATUS:&nbsp&nbsp&nbsp&nbsp&nbsp ' . HEADER_STATUS . '<br />';
echo 'ROOT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . DOC_ROOT . '<br />';
echo 'ROOT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . VNP_ROOT . '<br />';
*/

?>