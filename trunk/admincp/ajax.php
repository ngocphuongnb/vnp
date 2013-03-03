<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
 
define( 'ADMIN_AJAX' , true );
define( 'VNP', true );
define( 'ADMIN_FILE', true );

$doc_root = str_replace( '\\', '/', realpath( pathinfo( __file__, PATHINFO_DIRNAME ) . '/../' ) );

require( $doc_root . '/mainfile.php');

require( VNP_ROOT . '/' . ADMIN_DIR . '/includes/admin.class.php' );
require( VNP_ROOT . '/' . ADMIN_DIR . '/controllers/admin_theme/variables.php' );

$adm = new vnp_admin();

if( $request->get( 'ajax', 'get' ) == 1 )
{
	if( getHost( $client_info['referer'] ) == SERVER_NAME )
	{
		if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
		{
			define( 'IS_AJAX', true );
			
			if( $mod = $request->get( 'ctl', 'get,post', '' ) )
			{
				$adm->adminAction( $mod );
			}
		}
	}
}

?>