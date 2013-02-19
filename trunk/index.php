<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

define( 'VNP', true );

require( './mainfile.php' );
echo $vnp_url;

//np( $pass );
echo $pass->genPass( 'phuong' ) . '<br />';

echo $pass->salt . '<br />';
$a = 'fa6bccadfb998db834e5019fcc60755c7fed46d7d5529e8d750ea96e2eec485e';
$salt = 'gS9kXVC2mL';
if( $pass->authenticate( 'phuong', $salt, $a ) ) die('ok');
else die('false');
//echo $db->GetHTML();
//np( $global_config );

//np( $db->queryArray );
//$db->Close();

//np($nG);

//$session->SetCookie( 'phuong', 'ngoc', 0, true );
//$ck = $session->get( 'cookie', 'phuong', true );
echo 'ck: ' . $session->get( 'cookie', 'phuong', true );
$session->unsetss( 'cookie', 'phuong' );
//$session->SetSession( 'ngoc', 'phuong' );
//echo $session->get( 'session', 'ngoc' );


//np($client_info);

//$db->Query( 'SHOW STATUS LIKE \'Com_select\'' );
//$db->Query( "show variables like 'query%'" );

/*print_r('<pre><strong>Current session settings:</strong><br><br>');
    print_r($session->get_settings());
    print_r('</pre>');
*/
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

?>