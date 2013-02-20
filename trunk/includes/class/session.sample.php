<?php

class vnp_session
{

    function vnp_session(	$session_lifetime = '', $gc_probability = '', $gc_divisor = '', 
						$security_code = 'sEcUr1tY_c0dE', $table_name = 'vnp_session', 
						$lock_timeout = 60, $link = '')
    {
        $this->link = $link;
        // continue if there is an active MySQL connection
        if( @$this->_mysql_ping() )
		{
            // make sure session cookies never expire so that session lifetime
            // will depend only on the value of $session_lifetime
            ini_set('session.cookie_lifetime', 0);
            // if $session_lifetime is specified and is an integer number
            if( $session_lifetime != '' && is_integer( $session_lifetime ) )
			{
                // set the new value
                ini_set('session.gc_maxlifetime', $session_lifetime);
            }

            // if $gc_probability is specified and is an integer number
            if( $gc_probability != '' && is_integer( $gc_probability ) )
			{
                // set the new value
                ini_set( 'session.gc_probability', $gc_probability );
            }

            // if $gc_divisor is specified and is an integer number
            if( $gc_divisor != '' && is_integer( $gc_divisor ) )
			{
                // set the new value
                ini_set( 'session.gc_divisor', $gc_divisor );
            }
            // get session lifetime
            $this->session_lifetime = ini_get( 'session.gc_maxlifetime' );
            // we'll use this later on in order to try to prevent HTTP_USER_AGENT spoofing
            $this->security_code = $security_code;
            // the table to be used by the class
            $this->table_name = $table_name;
            // the maximum amount of time (in seconds) for which a process can lock the session
            $this->lock_timeout = $lock_timeout;
            // register the new handler
            session_set_save_handler(
                array(&$this, 'open'),
                array(&$this, 'close'),
                array(&$this, 'read'),
                array(&$this, 'write'),
                array(&$this, 'destroy'),
                array(&$this, 'gc')
            );
            // start the session
            session_start();
        // if no MySQL connections could be found
        // trigger a fatal error message and stop execution
        }
		else trigger_error('<br>No MySQL connection!<br>Error', E_USER_ERROR);
    }

    /**
     *  Custom close() function
     *
     *  @access private
     */
    function close()
    {
        // release the lock associated with the current session
        $this->_mysql_query('SELECT RELEASE_LOCK("' . $this->session_lock . '")')
            // stop execution and print message on error
            or die($this->_mysql_error());
        return true;
    }

    /**
     *  Custom destroy() function
     *
     *  @access private
     */
    function destroy( $session_id )
    {
        // deletes the current session id from the database
        $result = $this->_mysql_query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_id = "' . $this->_mysql_real_escape_string($session_id) . '"

        ') or die($this->_mysql_error());

        // if anything happened
        // return true
        if( $this->_mysql_affected_rows() !== -1 ) return true;
        // if something went wrong, return false
        return false;
    }

    /**
     *  Custom gc() function (garbage collector)
     *
     *  @access private
     */
    function gc()
    {
        // deletes expired sessions from database
        $result = $this->_mysql_query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_expire < "' . $this->_mysql_real_escape_string(time()) . '"

        ') or die($this->_mysql_error());
    }

    function get_active_sessions()
    {
        // call the garbage collector
        $this->gc();
        // counts the rows from the database
        $result = @mysql_fetch_assoc($this->_mysql_query('

            SELECT
                COUNT(session_id) as count
            FROM ' . $this->table_name . '

        ')) or die(_mysql_error());

        // return the number of found rows
        return $result['count'];
    }

    function get_settings()
    {
        // get the settings
        $gc_maxlifetime = ini_get('session.gc_maxlifetime');
        $gc_probability = ini_get('session.gc_probability');
        $gc_divisor     = ini_get('session.gc_divisor');

        // return them as an array
        return array(
            'session.gc_maxlifetime'    =>  $gc_maxlifetime . ' seconds (' . round($gc_maxlifetime / 60) . ' minutes)',
            'session.gc_probability'    =>  $gc_probability,
            'session.gc_divisor'        =>  $gc_divisor,
            'probability'               =>  $gc_probability / $gc_divisor * 100 . '%',
        );
    }

    /**
     *  Custom open() function
     *
     *  @access private
     */
    function open($save_path, $session_name)
    {
        return true;
    }

    /**
     *  Custom read() function
     *
     *  @access private
     */
    function read($session_id)
    {
        // get the lock name, associated with the current session
        $this->session_lock = $this->_mysql_real_escape_string('session_' . $session_id);
        // try to obtain a lock with the given name and timeout
        $result = $this->_mysql_query('SELECT GET_LOCK("' . $this->session_lock . '", ' . $this->_mysql_real_escape_string($this->lock_timeout) . ')');
        // if there was an error
        // stop execution
        if (!is_resource($result) || @mysql_num_rows($result) != 1) die('Could not obtain session lock!');

        //  reads session data associated with a session id, but only if
        //  -   the session ID exists;
        //  -   the session has not expired;
        //  -   the HTTP_USER_AGENT is the same as the one who had previously been associated with this particular session;
        $result = $this->_mysql_query('

            SELECT
                session_data
            FROM
                ' . $this->table_name . '
            WHERE
                session_id = "' . $this->_mysql_real_escape_string($session_id) . '" AND
                session_expire > "' . time() . '" AND
                http_user_agent = "' . $this->_mysql_real_escape_string(md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '') . $this->security_code)) . '"
            LIMIT 1

        ') or die($this->_mysql_error());

        // if anything was found
        if( is_resource( $result ) && @mysql_num_rows( $result ) > 0 )
		{
            // return found data
            $fields = @mysql_fetch_assoc($result);
            // don't bother with the unserialization - PHP handles this automatically
            return $fields['session_data'];
        }
        // on error return an empty string - this HAS to be an empty string
        return '';
    }

    function regenerate_id()
    {
        // saves the old session's id
        $old_session_id = session_id();
        // regenerates the id
        // this function will create a new session, with a new id and containing the data from the old session
        // but will not delete the old session
        session_regenerate_id();
        // because the session_regenerate_id() function does not delete the old session,
        // we have to delete it manually
        $this->destroy($old_session_id);
    }

    function stop()
    {
        $this->regenerate_id();
        session_unset();
        session_destroy();
    }

    /**
     *  Custom write() function
     *
     *  @access private
     */
    function write($session_id, $session_data)
    {
        // insert OR update session's data - this is how it works:
        // first it tries to insert a new row in the database BUT if session_id is already in the database then just
        // update session_data and session_expire for that specific session_id
        // read more here http://dev.mysql.com/doc/refman/4.1/en/insert-on-duplicate.html
        $result = $this->_mysql_query('

            INSERT INTO
                ' . $this->table_name . ' (
                    session_id,
                    http_user_agent,
                    session_data,
                    session_expire
                )
            VALUES (
                "' . $this->_mysql_real_escape_string($session_id) . '",
                "' . $this->_mysql_real_escape_string(md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '') . $this->security_code)) . '",
                "' . $this->_mysql_real_escape_string($session_data) . '",
                "' . $this->_mysql_real_escape_string(time() + $this->session_lifetime) . '"
            )
            ON DUPLICATE KEY UPDATE
                session_data = "' . $this->_mysql_real_escape_string($session_data) . '",
                session_expire = "' . $this->_mysql_real_escape_string(time() + $this->session_lifetime) . '"

        ') or die($this->_mysql_error());

        // if anything happened
        if( $result )
		{
            // note that after this type of queries, mysql_affected_rows() returns
            // - 1 if the row was inserted
            // - 2 if the row was updated
            // if the row was updated
            // return TRUE
            if( @$this->_mysql_affected_rows() > 1 ) return true;
            // if the row was inserted
            // return an empty string
            else return '';
        }
        // if something went wrong, return false
        return false;
    }

    /**
     *  Wrapper for "mysql_affected_rows".
     *
     *  Executes "mysql_affected_rows" with or without the MySQL link identifier, depending if it was given as argument
     *  to the constructor.
     *
     *  @access private
     */
    function _mysql_affected_rows()
    {
        // if a MySQL link identifier was NOT specified, ignore it when calling the function
        if( $this->link == '' ) return mysql_affected_rows();
        // if a MySQL link identifier was specified, use it when calling the function
        else return mysql_affected_rows( $this->link );
    }

    /**
     *  Wrapper for "mysql_error".
     *
     *  Executes "mysql_error" with or without the MySQL link identifier, depending if it was given as argument to the
     *  constructor.
     *
     *  @access private
     */
    function _mysql_error()
    {
        // if a MySQL link identifier was NOT specified, ignore it when calling the function
        if( $this->link == '' ) return 'Zebra_Session: ' . mysql_error();
        // if a MySQL link identifier was specified, use it when calling the function
        else return 'Zebra_Session: ' . mysql_error( $this->link );

    }
    /**
     *  Wrapper for "mysql_query".
     *
     *  Executes "mysql_query" with or without the MySQL link identifier, depending if it was given as argument to the
     *  constructor.
     *
     *  @access private
     */
    function _mysql_query( $query )
    {
        // if a MySQL link identifier was NOT specified, ignore it when calling the function
        if ($this->link == '') return mysql_query($query);
        // if a MySQL link identifier was specified, use it when calling the function
        else return mysql_query( $query, $this->link );

    }
	
    /**
     *  Wrapper for "mysql_ping".
     *
     *  Executes "mysql_ping" with or without the MySQL link identifier, depending if it was given as argument to the
     *  constructor.
     *
     *  @access private
     */
    function _mysql_ping()
    {
        // if a MySQL link identifier was NOT specified, ignore it when calling the function
        if ($this->link == '') return mysql_ping();
        // if a MySQL link identifier was specified, use it when calling the function
        else return mysql_ping( $this->link );
    }

    /**
     *  Wrapper for "mysql_real_escape_string".
     *
     *  Executes "mysql_real_escape_string" with or without the MySQL link identifier, depending if it was given as
     *  argument to the constructor.
     *
     *  @access private
     */
    function _mysql_real_escape_string( $string )
    {
        // if a MySQL link identifier was NOT specified, ignore it when calling the function
        if ( $this->link == '' ) return mysql_real_escape_string( $string );
        // if a MySQL link identifier was specified, use it when calling the function
        else return mysql_real_escape_string( $string, $this->link );

    }

}
?>
