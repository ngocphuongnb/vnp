<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );

define( 'SESSION_LIFE_TIME', 0 );

class vnp_session
{
	
	public 	$SessionSavePath		= '';
	public 	$SessionPrefix			= 'vnp';
	public	$CookiePrefix			= 'vnp';
	private	$StartSession			= '';
	private	$CookieKey				= 'vnp';
	public	$is_register_globals	= false;
	public	$is_magic_quotes_gpc	= false;
	public 	$is_filter				= false;
	public	$is_session_start		= false;
	public	$secure					= false;
	public	$httponly				= true;
	
	private $disablecomannds 		= array( 
        "base64_decode", "cmd", "passthru", "eval", "exec", "system", "fopen", "fsockopen", "file", "file_get_contents", "readfile", "unlink" 
    );
	
	public function __construct( $SessionPrefix = '', $SessionPath = '', $CookiePrefix = '', $CookiePrefix = '' )
	{
		if( !defined( 'VNP_TIME' ) )
		{
			define( 'VNP_TIME', get_Env( 'REQUEST_TIME' ) ? get_Env( 'REQUEST_TIME' ) : time() );
		}
		if( $SessionPrefix !== '' )
		{
			$this->SessionPrefix = $SessionPrefix;
		}
		if( $CookiePrefix !== '' )
		{
			$this->CookiePrefix = $CookiePrefix;
		}
		if( ini_get( 'register_globals' ) == '1' || strtolower( ini_get( 'register_globals' ) ) == 'on' )
		{
			$this->is_register_globals = true;
		}
        if( function_exists( 'get_magic_quotes_gpc' ) )
        {
            if ( get_magic_quotes_gpc() ) $this->is_magic_quotes_gpc = true;
        }
        if( extension_loaded( 'filter' ) && filter_id( ini_get( 'filter.default' ) ) !== FILTER_UNSAFE_RAW )
		{
			$this->is_filter = true;
		}
		$this->SetCookiePath();
		$this->SetSessionPath( $SessionPath );
		$this->SessionStart();
	}	
	
    private function SetCookiePath()
    {
		$vnp_mydir = pathinfo( $_SERVER['PHP_SELF'], PATHINFO_DIRNAME );
		if ( $vnp_mydir == DIRECTORY_SEPARATOR ) $vnp_mydir = '';
		if ( ! empty( $vnp_mydir ) ) $vnp_mydir = str_replace( DIRECTORY_SEPARATOR, '/', $vnp_mydir );
		if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/[\/]+$/", '', $vnp_mydir );
		if ( ! empty( $vnp_mydir ) ) $vnp_mydir = preg_replace( "/^[\/]*(.*)$/", '/\\1', $vnp_mydir );
        $this->CookiePath = $vnp_mydir . '/';
        $cookie_domain = preg_replace( "/^([w]{3})\./", "", get_Env( 'SERVER_NAME' ) );
		$this->CookieDomain = ( preg_match( "/^([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/", $cookie_domain ) ) ? '.' . $cookie_domain : '';
    }
	
	private function SetSessionPath( $SessionPath )
	{
		global $sys_info;
		
        
        if( function_exists( 'session_save_path' ) and ! in_array( 'session_save_path', $sys_info['disable_functions'] ) )
        {
        	//if( preg_match( "/^[a-zA-Z]{1}[a-zA-Z0-9_]*$/", $SessionPath ) )
			if(1)
            {
                $save_path = VNP_ROOT . '/' . $SessionPath;
				
                if( ! is_writable( $save_path ) )
                {
	                if ( ! is_dir( $save_path ) )
	                {
	                    $oldumask = umask( 0 );
	                    $res = @mkdir( $save_path, 0755 );
	                    umask( $oldumask );
	                }
	                if ( ! @is_writable( $save_path ) )
	                {
	                    if ( ! @chmod( $save_path ) ) $save_path = '';
	                }
	                clearstatcache();
	                if ( ! is_writable( $save_path ) )
	                {
	                    trigger_error( 'session_save_path not set', 256 );
	                }
                }
                session_save_path( $save_path . '/' );
            }
            $save_path = session_save_path();
        }
        $this->SessionSavePath = $save_path;
	}
	
	/**
     * Request::sessionStart()
     * 
     * @return
     */
    private function SessionStart()
    {
		global $client_info;
        if( headers_sent() || connection_status() != 0 || connection_aborted() )
        {
            trigger_error( 'Header sent', 256 );
        }
        
        session_set_cookie_params( SESSION_LIFE_TIME, $this->CookiePath, $this->CookieDomain, 0, 1 );
        
        session_name( $this->CookiePrefix . '_sess' );
        $session_id = isset( $_COOKIE[$this->CookiePrefix . '_sess'] ) ? $_COOKIE[$this->CookiePrefix . '_sess'] : "";
        if ( ! preg_match( "/^([a-zA-Z0-9]{32})([\d]+)$/", $session_id ) )
        {
            $session_id = md5( uniqid( rand(), true ) ) . sprintf( "%u", $client_info['ip'] );
            session_id( $session_id );
        }
        session_start();
        $session_id = session_id();
        if ( ! preg_match( "/^([a-zA-Z0-9]{32})([\d]+)$/", $session_id ) )
        {
            trigger_error( 'Incorrect session ID', 256 );
        }
        $_SESSION = ( isset( $_SESSION ) and is_array( $_SESSION ) ) ? $_SESSION : array();
        if ( sizeof( $_SESSION ) )
        {
            $array_keys = array_keys( $_SESSION );
            foreach ( $array_keys as $k )
            {
                if ( $this->is_register_globals )
                {
                    if ( in_array( $k, array( 'GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_SESSION', '_ENV', '_FILES' ) ) ) die();
                    unset( $GLOBALS[$k] );
                    unset( $GLOBALS[$k] );
                }
                if ( ! preg_match( "/^[a-zA-Z0-9\_]+$/", $k ) or is_numeric( $k ) )
                {
                    unset( $_SESSION[$k] );
                }
            }
            $this->fixQuery( $_SESSION, 'session' );
        }
        $this->is_session_start = true;
        $this->session_id = $session_id;
    }
	
	/**
     * Request::fixQuery()
     * 
     * @param mixed $var
     * @param mixed $mode
     * @return
     */
    private function fixQuery( &$var, $mode )
    {
        $array_keys = array_keys( $var );
        foreach( $array_keys as $k )
        {
            if( is_array( $var[$k] ) )
            {
                $this->fixQuery( $var[$k], $mode );
            }
            elseif ( is_string( $var[$k] ) )
            {
                if ( $this->is_magic_quotes_gpc ) $var[$k] = stripslashes( $var[$k] );
                if ( $mode == 'get' ) $var[$k] = $this->security_get( $var[$k] );
            }
        }
    }
	
	/**
     * Request::security_get()
     * 
     * @param mixed $value
     * @return
     */
    private function security_get( $value, $decode = false )
    {
        if( is_array( $value ) )
        {
            $keys = array_keys( $value );
            foreach ( $keys as $key )
            {
                $value[$key] = $this->security_get( $value[$key], $decode );
            }
        }
        else
        {
            if( ! empty( $value ) and ! is_numeric( $value ) )
            {
				if( $decode == true )
				{
					$value = urldecode( $value );
				}
				
                $value = str_replace( array( "\t", "\r", "\n", "../" ), "", $value );
                $value = $this->unhtmlentities( $value );
                unset( $matches );
                preg_match_all( '/<!\[cdata\[(.*?)\]\]>/is', $value, $matches );
                $value = str_replace( $matches[0], $matches[1], $value );
                $value = strip_tags( $value );
                $value = preg_replace( '#(' . implode( '|', $this->disablecomannds ) . ')(\s*)\((.*?)\)#si', "", $value );
                $value = str_replace( array( "'", '"', '<', '>' ), array( "&#039;", "&quot;", "&lt;", "&gt;" ), $value );
                $value = trim( $value );
            }
        }
        return $value;
    }

    /**
     * Request::security_cookie()
     * 
     * @param mixed $value
     * @return
     */
    private function security_cookie ( $value )
    {
        return $value;
    }

    /**
     * Request::security_session()
     * 
     * @param mixed $value
     * @return
     */
    private function security_session ( $value )
    {
        return $value;
    }
	
	/**
     * Request::unhtmlentities()
     * 
     * @param mixed $value
     * @return
     */
    private function unhtmlentities ( $value )
    {
        $value = preg_replace( "/%3A%2F%2F/", '', $value );
        $value = preg_replace( '/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $value );
        $value = preg_replace( "/%u0([a-z0-9]{3})/i", "&#x\\1;", $value );
        $value = preg_replace( "/%([a-z0-9]{2})/i", "&#x\\1;", $value );
        $value = str_ireplace( array( 
            '&#x53;&#x43;&#x52;&#x49;&#x50;&#x54;', '&#x26;&#x23;&#x78;&#x36;&#x41;&#x3B;&#x26;&#x23;&#x78;&#x36;&#x31;&#x3B;&#x26;&#x23;&#x78;&#x37;&#x36;&#x3B;&#x26;&#x23;&#x78;&#x36;&#x31;&#x3B;&#x26;&#x23;&#x78;&#x37;&#x33;&#x3B;&#x26;&#x23;&#x78;&#x36;&#x33;&#x3B;&#x26;&#x23;&#x78;&#x37;&#x32;&#x3B;&#x26;&#x23;&#x78;&#x36;&#x39;&#x3B;&#x26;&#x23;&#x78;&#x37;&#x30;&#x3B;&#x26;&#x23;&#x78;&#x37;&#x34;&#x3B;', '/*', '*/', '<!--', '-->', '<!-- -->', '&#x0A;', '&#x0D;', '&#x09;', '' 
        ), '', $value );
        $search = '/&#[xX]0{0,8}(21|22|23|24|25|26|27|28|29|2a|2b|2d|2f|30|31|32|33|34|35|36|37|38|39|3a|3b|3d|3f|40|41|42|43|44|45|46|47|48|49|4a|4b|4c|4d|4e|4f|50|51|52|53|54|55|56|57|58|59|5a|5b|5c|5d|5e|5f|60|61|62|63|64|65|66|67|68|69|6a|6b|6c|6d|6e|6f|70|71|72|73|74|75|76|77|78|79|7a|7b|7c|7d|7e);?/ie';
        $value = preg_replace( $search, "chr(hexdec('\\1'))", $value );
        $search = '/&#0{0,8}(33|34|35|36|37|38|39|40|41|42|43|45|47|48|49|50|51|52|53|54|55|56|57|58|59|61|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126);?/ie';
        $value = preg_replace( $search, "chr('\\1')", $value );
        $search = array( 
            '&#60', '&#060', '&#0060', '&#00060', '&#000060', '&#0000060', '&#60;', '&#060;', '&#0060;', '&#00060;', '&#000060;', '&#0000060;', '&#x3c', '&#x03c', '&#x003c', '&#x0003c', '&#x00003c', '&#x000003c', '&#x3c;', '&#x03c;', '&#x003c;', '&#x0003c;', '&#x00003c;', '&#x000003c;', '&#X3c', '&#X03c', '&#X003c', '&#X0003c', '&#X00003c', '&#X000003c', '&#X3c;', '&#X03c;', '&#X003c;', '&#X0003c;', '&#X00003c;', '&#X000003c;', '&#x3C', '&#x03C', '&#x003C', '&#x0003C', '&#x00003C', '&#x000003C', '&#x3C;', '&#x03C;', '&#x003C;', '&#x0003C;', '&#x00003C;', '&#x000003C;', '&#X3C', '&#X03C', '&#X003C', '&#X0003C', '&#X00003C', '&#X000003C', '&#X3C;', '&#X03C;', '&#X003C;', '&#X0003C;', '&#X00003C;', '&#X000003C;', '\x3c', '\x3C', '\u003c', '\u003C' 
        );
        $value = str_ireplace( $search, '<', $value );
        return $value;
    }
	
	public function get( $mode, $key, $encode = false )
	{
		switch( $mode )
		{
			case 'cookie':
                    if ( array_key_exists( $this->CookiePrefix . '_' . $key, $_COOKIE ) )
                    {
                        $value = $_COOKIE[$this->CookiePrefix . '_' . $key];
						if( $encode )
						{
                        	return $this->Decode( $value );
						}
						else
						{
							return $value;
						}
                    }
                    break;
                case 'session':
                    if ( array_key_exists( $this->SessionPrefix . '_' . $key, $_SESSION ) )
                    {
                        if ( ! $this->is_session_start ) $this->SessionStart();
                        $value = $_SESSION[$this->SessionPrefix . '_' . $key];
                        return $this->Decode( $value );
                    }
                    break;
		}
	}
	
	public function unsetss( $mode, $keys )
	{
		if( !is_array( $keys ) )
		{
			$keys = array( $keys );
		}
		switch( $mode )
		{
			case 'cookie':
				foreach( $keys as $key )
                {
                    $this->SetCookie( $key, '', time() - 432000, false );      
                    unset( $_COOKIE[$this->CookiePrefix . '_' . $key] );
                }
				break;
			case 'session':
				if( !$this->is_session_start ) $this->sessionStart();
                foreach( $keys as $key )
                {
                    if( empty( $key ) ) continue;
                    $key2 = $this->SessionPrefix . '_' . $key;
                    if( !isset( $_SESSION[$key2] ) ) continue;
                    unset( $_SESSION[$key2] );
                }
				break;
		}
	}
	
	/**
     * Request::set_Cookie()
     * 
     * @param mixed $key
     * @param string $value
     * @param integer $expire
     * @param bool $encode
     * @return
     */
    public function SetCookie ( $key, $value = '', $expire = 0, $encode = false )
    {
        if( is_array( $value ) ) return false;
        if( empty( $key ) ) return false;
        $key = $this->CookiePrefix . '_' . $key;
        if( $encode )
        {
            $value = $this->Encode( $value );
        }
        $expire = intval( $expire );
		
        if( ! empty( $expire ) ) $expire += VNP_TIME;
        echo $this->CookieDomain;
        return setcookie( $key, $value, $expire, $this->CookiePath, $this->CookieDomain, $this->secure, $this->httponly );
        
    }

    /**
     * Request::set_Session()
     * 
     * @param mixed $key
     * @param string $value
     * @return
     */
    public function SetSession ( $key, $value = '' )
    {
        if ( is_array( $value ) ) return false;
        if ( empty( $key ) ) return false;
        if ( ! $this->is_session_start ) $this->SessionStart();
        $key = $this->SessionPrefix . '_' . $key;
        $value = $this->Encode( $value );
        $_SESSION[$key] = $value;
        return true;
    }
	
	/**
     * Request::base64Encode()
     * 
     * @param mixed $input
     * @return
     */
    private function base64Encode ( $input )
    {
        return strtr( base64_encode( $input ), '+/=', '-_,' );
    }

    /**
     * Request::base64Decode()
     * 
     * @param mixed $input
     * @return
     */
    private function base64Decode ( $input )
    {
        return base64_decode( strtr( $input, '-_,', '+/=' ) );
    }

    /**
     * Request::encodeCookie()
     * 
     * @param mixed $string
     * @return
     */
    private function Encode ( $string )
    {
        $result = '';
        $strlen = strlen( $string );
        for ( $i = 0; $i < $strlen; ++$i )
        {
            $char = substr( $string, $i, 1 );
            $keychar = substr( $this->CookieKey, ( $i % 32 ) - 1, 1 );
            $result .= chr( ord( $char ) + ord( $keychar ) );
        }
        return $this->base64Encode( $result );
    }

    /**
     * Request::decodeCookie()
     * 
     * @param mixed $string
     * @return
     */
    private function Decode ( $string )
    {
        $result = '';
        $string = $this->base64Decode( $string );
        $strlen = strlen( $string );
        for ( $i = 0; $i < $strlen; ++$i )
        {
            $char = substr( $string, $i, 1 );
            $keychar = substr( $this->CookieKey, ( $i % 32 ) - 1, 1 );
            $result .= chr( ord( $char ) - ord( $keychar ) );
        }
        return $result;
    }
}

?>
