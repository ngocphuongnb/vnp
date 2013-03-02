<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) or !defined( 'VN' ) ) die( 'Hacking' ); 

function np( $array )
{
	echo '<pre>';
	print_r( $array );
	echo '</pre>';
}

function byte_converter( $value )
{
    $value = trim($value);
    $realval = strtolower( $value{strlen($value)-1} );
    switch( $realval ) 
	{
        case 'g': $value *= 1024;
        case 'm': $value *= 1024;
        case 'k': $value *= 1024;
    }
    return $value;
}

function set_timezone( $offset = 0)
{
	if( function_exists('date_default_timezone_set') ) 
	{
		@date_default_timezone_set('Etc/GMT'.($offset > 0 ? '-' : '+').(abs($offset)));
	}
}

// other function (nukeviet)
function get_Env ( $key )
{
	if ( ! is_array( $key ) )
	{
		$key = array( 
			$key 
		);
	}
	foreach ( $key as $k )
	{
		if ( isset( $_SERVER[$k] ) ) return $_SERVER[$k];
		elseif ( isset( $_ENV[$k] ) )
		{
			$_SERVER[$k] = $_ENV[$k];
			return $_ENV[$k];
		}
		elseif ( @getenv( $k ) ) 
		{
			$_SERVER[$k] = @getenv( $k );
			return @getenv( $k );
		}
		elseif ( function_exists( 'apache_getenv' ) && apache_getenv( $k, true ) ) 
		{
			$_SERVER[$k] = apache_getenv( $k, true );
			return apache_getenv( $k, true );
		}
	}
	return "";
}

function DataType( $data, $type )
{
	switch( $type )
	{
		case 'string':
			return ( string) $data;
			break;
		case 'text':
			return ( string) $data;
			break;
		case 'int':
			return ( int ) $data;
			break;
		case 'number':
			return ( int ) $data;
			break;
	}
	return $data;
}

function DisabledFunction()
{
	if( ini_get( 'disable_functions' ) != '' and ini_get( 'disable_functions' ) != false )
	{
		$disable_functions = array_map( 'trim', preg_split( "/[\s,]+/", ini_get( "disable_functions" ) ) );
	}
	else
	{
		$disable_functions = array();
	}
	if( extension_loaded( 'suhosin' ) )
	{
		$disable_functions = array_merge( $disable_functions, array_map( 'trim', preg_split( "/[\s,]+/", ini_get( "suhosin.executor.func.blacklist" ) ) ) );
	}
	return $disable_functions;
}

function random( $length, $numeric = 0 ) 
{
	$seed = base_convert( md5( microtime() . $_SERVER['DOCUMENT_ROOT'] ), 16, $numeric ? 10 : 35);
	$seed = $numeric ? ( str_replace( '0', '', $seed ) . '012340567890' ) : ( $seed . 'zZ' . strtoupper( $seed ) );
	$hash = '';
	$max = strlen( $seed ) - 1;
	for( $i = 0; $i < $length; $i++ ) 
	{
		$hash .= $seed { mt_rand( 0, $max ) };
	}
	return $hash;
}

function RandomString( $length = 10 )
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';    
	for( $n = 0; $n < $length; $n++ )
	{
		$string .= $characters[mt_rand( 0, strlen( $characters ) )];
	}
	return $string;
}

function authcode( $string, $operation = 'DECODE', $key = '', $expiry = 0 ) 
{
	$ckey_length = 4;
	$key = md5( $key != '' ? $key : getglobal( 'authkey' ) );
	$keya = md5( substr( $key, 0, 16 ) );
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ( $operation == 'DECODE' ? substr( $string, 0, $ckey_length ): substr( md5( microtime() ), -$ckey_length ) ) : '';

	$cryptkey = $keya . md5( $keya . $keyc );
	$key_length = strlen( $cryptkey );

	$string = $operation == 'DECODE' ? base64_decode( substr( $string, $ckey_length ) ) : sprintf( '%010d', $expiry ? $expiry + time() : 0) . substr( md5($string . $keyb), 0, 16 ) . $string;
	$string_length = strlen( $string );

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for( $i = 0; $i <= 255; $i++ ) 
	{
		$rndkey[$i] = ord( $cryptkey[$i % $key_length] );
	}

	for( $j = $i = 0; $i < 256; $i++ ) 
	{
		$j = ( $j + $box[$i] + $rndkey[$i] ) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for( $a = $j = $i = 0; $i < $string_length; $i++ ) 
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr( ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256] ) );
	}

	if( $operation == 'DECODE') 
	{
		if( ( substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr( $result, 10, 16 ) == substr( md5( substr( $result, 26 ) . $keyb ), 0, 16 ) ) 
		{
			return substr( $result, 26 );
		} 
		else 
		{
			return '';
		}
	} 
	else 
	{
		return $keyc . str_replace( '=', '', base64_encode( $result ) );
	}

}
function auth( $string, $mode )
{
	$value = '';
	switch( $mode )
	{
		case 'ENCODE':
			$value = base64_encode( $string );
			break;
		case 'DECODE':
			$value = base64_decode( $string );
			break;
	}
	return $value;
}
		

function getglobal( $key, $group = NULL ) 
{
	global $nG;
	$k = explode( '/', $group === NULL ? $key : $group . '/' . $key);
	switch ( count( $k ) ) 
	{
		case 1: return isset( $nG[$k[0]] ) ? $nG[$k[0]] : NULL; break;
		case 2: return isset( $nG[$k[0]][$k[1]] ) ? $nG[$k[0]][$k[1]] : NULL; break;
		case 3: return isset( $nG[$k[0]][$k[1]][$k[2]] ) ? $nG[$k[0]][$k[1]][$k[2]] : NULL; break;
		case 4: return isset( $nG[$k[0]][$k[1]][$k[2]][$k[3]] ) ? $nG[$k[0]][$k[1]][$k[2]][$k[3]] : NULL; break;
		case 5: return isset( $nG[$k[0]][$k[1]][$k[2]][$k[3]][$k[4]] ) ? $nG[$k[0]][$k[1]][$k[2]][$k[3]][$k[4]] : NULL; break;
	}
	return NULL;
}

function CheckDirect( $value, $mode )
{
	return false;
}

function vnpDirect( $url )
{
	return false;
}

function get_alias( $string )
{
	$unicode = array( 
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ', 
            'd'=>'đ', 
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
            'i'=>'í|ì|ỉ|ĩ|ị', 
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ', 
			'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ', 
            'D'=>'Đ', 
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ', 
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị', 
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ', 
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự', 
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        ); 
	foreach( $unicode as $nonUnicode=>$uni )
	{
		$string = preg_replace("/($uni)/i", $nonUnicode, $string ); 
	}
	$string = str_replace( ' ', '_', $string );
	return strtolower( $string ); 
} 

function vnpMsg( $msgArray, $type )
{
	if( !is_array( $msgArray ) )
	{
		$msgArray = array( $msgArray );
	}
	if( !empty( $msgArray ) )
	{
		$rt = '<div class="alert alert-' . $type . ' fade in"><button data-dismiss="alert" class="close" type="button">×</button>';
		foreach( $msgArray as $msg )
		{
			$rt .= '<strong>' . $msg . '</strong><br />';
		}
		return $rt . '</div>';
	}
	else return '';
}

function getHost( $Address )
{ 
	$parseUrl = parse_url( trim( $Address ) ); 
	return trim( $parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
} 