<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */
echo 'dddd';

define( 'VNP', true );

require( './mainfile.php' );

echo '123';

if( $request->get( 'mod', 'get', '' ) )
{
	$AvailableMode = array( 'member', 'blog', 'wall' );
	$mod = $request->get( 'mod', 'get', '' );
	if( in_array( $mod, $AvailableMode ) )
	{
		$vnp->Mode( $mod );
	}
	elseif( $directLink = CheckDirect( $mod, 'mode' ) )
	{
		vnpDirect( $directLink );
		exit();
	}
	else
	{
		vnpGetTheme( '404' );
	}
}
else
{
	echo myTheme();
}


/*
echo $alias_get . '<br />';
echo $vnp->SetNotice('IMN') . '<br />';
echo 'time:&nbsp&nbsp&nbsp&nbsp&nbsp ' . VNP_TIME . '<br />';
echo 'IP:&nbsp&nbsp&nbsp&nbsp&nbsp ' . SERVER_IP . '<br />';
echo 'SERVER NAME:&nbsp&nbsp&nbsp&nbsp&nbsp ' . SERVER_NAME . '<br />';
echo 'PROTOCOL ' . SERVER_PROTOCOL . '<br />';
echo 'PORT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . SERVER_PORT . '<br />';
echo 'AGENT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . USER_AGENT . '<br />';
echo 'DOMAIN:&nbsp&nbsp&nbsp&nbsp ' . VNP_DOMAIN . '<br />';
echo 'DIR:&nbsp&nbsp&nbsp&nbsp&nbsp ' . VNP_MYDIR . '<br />';
echo 'ADMINDIR:&nbsp&nbsp&nbsp&nbsp&nbsp ' . MY_ADMDIR . '<br />';
echo 'HD STATUS:&nbsp&nbsp&nbsp&nbsp&nbsp ' . HEADER_STATUS . '<br />';
echo 'ROOT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . DOC_ROOT . '<br />';
echo 'ROOT:&nbsp&nbsp&nbsp&nbsp&nbsp ' . VNP_ROOT . '<br />';
*/

?>