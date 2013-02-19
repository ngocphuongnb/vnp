<?php 

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VN' ) ) die( 'Hacking!!!' );
 
class vnp_db
{
	private $db_host		= 'localhost'; 
	private $db_user		= '';
	private $db_pass		= '';
	private $db_dbname		= '';
	private $db_charset		= '';
	private $db_pcon		= false;
	
	private $last_insert_id;
	private $last_result;               	// last mysql query result
	private $last_sql		= ''; 			// last mysql query
	private $activeRow 		= -1;			// Current row
	private $in_transaction = false;    	// used for transactions
	private $time_diff      = 0;        	// holds the difference in time
	private $time_start     = 0;        	// start time for the timer
	private $error_desc		= '';			// last mysql error string
	private $errorNumber	= 0;			// last mysql error number
	private $db_connect		= 0;			// mysql link resource
	
	// mysql_link --> db_connect
	// active_row --> activeRow
	
	/**
	 * Determines if an error throws an exception
	 *
	 * @var boolean Set to true to throw error exceptions
	 */
	public $ThrowExceptions = false;
	public $queryArray		= array();
	
	// constants for SQLValue function
	const SQLVALUE_BIT      = 'bit';
	const SQLVALUE_BOOLEAN  = 'boolean';
	const SQLVALUE_DATE     = 'date';
	const SQLVALUE_DATETIME = 'datetime';
	const SQLVALUE_NUMBER   = 'number';
	const SQLVALUE_T_F      = 't-f';
	const SQLVALUE_TEXT     = 'text';
	const SQLVALUE_TIME     = 'time';
	const SQLVALUE_Y_N      = 'y-n';
	
	public function __construct( $connect = true, $server = NULL, $database = NULL, 
									$username = NULL, $password = NULL, $charset = NULL )
	{
		if( $server		!== NULL ) $this->db_host		= $server;
		if( $database	!== NULL ) $this->db_dbname		= $database;
		if( $username	!== NULL ) $this->db_user		= $username;
		if( $password	!== NULL ) $this->db_pass		= $password;
		if( $charset	!== NULL ) $this->db_charset	= $charset;
		
		if( strlen( $this->db_host ) > 0 && strlen( $this->db_user ) > 0 )
		{
			if( $connect )
			{
				$this->Open();
			}
		}
	}
	
	public function __destruct()
	{
		$this->Close();
	}
	
	public function Open( 	$server = NULL, $database = NULL, $username = NULL,
							$password = NULL, $charset = NULL, $pcon = false )
	{
		$this->ResetError();
		
		if( $server		!== NULL ) $this->db_host		= $server;
		if( $database	!== NULL ) $this->db_dbname		= $database;
		if( $username	!== NULL ) $this->db_user		= $username;
		if( $password	!== NULL ) $this->db_pass		= $password;
		if( $charset	!== NULL ) $this->db_charset	= $charset;
		
		if( is_bool( $pcon ) )	$this->db_pcon = $pcon;
		$this->acviteRow = -1;
		
		if( $pcon )
		{
			$this->db_connect = @mysql_pconnect( $this->db_host, $this->db_user, $this->db_pass );
		}
		else
		{
			$this->db_connect = @mysql_connect( $this->db_host, $this->db_user, $this->db_pass );
		}
		if( !$this->IsConnected() )
		{
			$this->SetError();
			return false;
		}
		else
		{
			if( strlen( $this->db_dbname ) > 0 )
			{
				if( strlen( $this->db_charset ) == 0 )
				{
					if( !$this->SelectDatabase( $this->db_dbname ) )
					{
						return false;
					}
					else
					{
						return true;
					}
				}
				else
				{
					if( !$this->SelectDatabase( $this->db_name, $this->db_charset ) )
					{
						return false;
					}
					else
					{
						return true;
					}
				}
			}
			else
			{
				return false;
			}
		}					
	}
	
	/**
	 * Selects a different database and character set
	 *
	 * @param string $database Database name
	 * @param string $charset (Optional) Character set (i.e. utf8)
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function SelectDatabase( $database, $charset = '' )
	{
		$return_value = true;
		if( !$charset ) $charset = $this->db_charset;
		$this->ResetError();
		if( !( mysql_select_db( $database ) ) )
		{
			$this->SetError();
			$return_value = false;
		}
		else
		{
			if( ( strlen( $charset ) > 0 ) )
			{
				if( !( mysql_query( "SET CHARACTER SET '{$charset}'", $this->db_connect ) ) )
				{
					$this->SetError();
					$return_value = false;
				}
			}
		}
		return $return_value;
	}
	
	/**
	 * Determines if a valid connection to the database exists
	 *
	 * @return boolean TRUE idf connectect or FALSE if not connected
	 */
	public function IsConnected()
	{
		if( gettype( $this->db_connect ) == 'resource' )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Executes the given SQL query and returns the records
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @return object PHP 'mysql result' resource object containing the records
	 *                on SELECT, SHOW, DESCRIBE or EXPLAIN queries and returns;
	 *                TRUE or FALSE for all others i.e. UPDATE, DELETE, DROP
	 *                AND FALSE on all errors (setting the local Error message)
	 */
	public function Query( $sql )
	{
		$this->ResetError();
		$this->last_sql = $sql;
		$this->last_result = @mysql_query( $sql, $this->db_connect );
		
		if( !$this->last_result )
		{
			$this->activeRow = -1;
			$this->SetError();
			$this->queryArray[] = array( htmlspecialchars( $sql ), false );
			return false;
		}
		else
		{
			$this->queryArray[] = array( htmlspecialchars( $sql ), true );
			if( strpos( strtolower( $sql ), 'insert') === 0 )
			{
				$this->last_insert_id = mysql_insert_id();
				if( $this->last_insert_id === false )
				{
					$this->SetError();
					return false;
				}
				else
				{
					$numrows = 0;
					$this->activeRow = -1;
					return $this->last_result;
				}
			}
			else if( strpos( strtolower( $sql ), 'select') === 0 )
			{
				$numrows = mysql_num_rows( $this->last_result );
				if( $numrows > 0 )
				{
					$this->activeRow = 0;
				}
				else
				{
					$this->activeRow = -1;
				}
				$this->last_insert_id = 0;
				return $this->last_result;
			}
			else
			{
				return $this->last_result;
			}
		}
	}
	
	public function AffectedRows()
	{
		return mysql_affected_rows();
	}
	
	/**
	 * Returns the records from the last query
	 *
	 * @return object PHP 'mysql result' resource object containing the records
	 *                for the last query executed
	 */
	public function Records()
	{
		return $this->last_result;
	}

	/**
	 * Returns all records from last query and returns contents as array
	 * or FALSE on error
	 *
	 * @param integer $resultType (Optional) The type of array
	 *                Values can be: MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
	 * @return Records in array form
	 */
	public function RecordsArray( $resultType = MYSQL_BOTH )
	{
		$this->ResetError();
		if( $this->last_result )
		{
			if( !mysql_data_seek( $this->last_result, 0 ) )
			{
				$this->SetError();
				return false;
			}
			else
			{
				//while($member = mysql_fetch_object($this->last_result)){
				while( $member = mysql_fetch_array( $this->last_result, $resultType ) )
				{
					$members[] = $member;
				}
				mysql_data_seek( $this->last_result, 0 );
				$this->active_row = 0;
				return $members;
			}
		}
		else
		{
			$this->active_row = -1;
			$this->SetError('No query results exist', -1);
			return false;
		}
	}
	
	/**
	 * Sets the internal database pointer to the
	 * specified row number and returns the result
	 *
	 * @param integer $row_number Row number
	 * @return object Fetched row as PHP object
	 */
	public function Seek( $row_number )
	{
		$this->ResetError();
		$row_count = $this->RowCount();
		if( !$row_count )
		{
			return false;
		}
		elseif( $row_number >= $row_count )
		{
			$this->SetError('Seek parameter is greater than the total number of rows', -1);
			return false;
		}
		else
		{
			$this->active_row = $row_number;
			$result = mysql_data_seek( $this->last_result, $row_number );
			if( !$result )
			{
				$this->SetError();
				return false;
			}
			else
			{
				$record = mysql_fetch_row( $this->last_result );
				if( !$record )
				{
					$this->SetError();
					return false;
				}
				else
				{
					// Go back to the record after grabbing it
					mysql_data_seek( $this->last_result, $row_number );
					return $record;
				}
			}
		}
	}

	/**
	 * Returns the current cursor row location
	 *
	 * @return integer Current row number
	 */
	public function SeekPosition()
	{
		return $this->active_row;
	}
	
	/**
	 * Reads the current row and returns contents as a
	 * PHP object or returns false on error
	 *
	 * @param integer $optional_row_number (Optional) Use to specify a row
	 * @return object PHP object or FALSE on error
	 */
	public function Row( $optional_row_number = NULL )
	{
		$this->ResetError();
		if( !$this->last_result )
		{
			$this->SetError( 'No query results exist', -1 );
			return false;
		}
		elseif( $optional_row_number === NULL )
		{
			if( ( $this->active_row ) > $this->RowCount() )
			{
				$this->SetError('Cannot read past the end of the records', -1);
				return false;
			}
			else
			{
				$this->active_row++;
			}
		}
		else
		{
			if( $optional_row_number >= $this->RowCount() )
			{
				$this->SetError('Row number is greater than the total number of rows', -1);
				return false;
			}
			else
			{
				$this->active_row = $optional_row_number;
				$this->Seek( $optional_row_number );
			}
		}
		$row = mysql_fetch_object( $this->last_result );
		if( !$row )
		{
			$this->SetError();
			return false;
		}
		else
		{
			return $row;
		}
	}
	
	/**
	 * Executes the given SQL query and returns a multi-dimensional array
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @param integer $resultType (Optional) The type of array
	 *                Values can be: MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
	 * @return array A multi-dimensional array containing all the data
	 *               returned from the query or FALSE on all errors
	 */
	public function QueryArray( $sql, $resultType = MYSQL_BOTH )
	{
		$this->Query( $sql );
		if( !$this->Error() )
		{
			return $this->RecordsArray( $resultType );
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Executes the given SQL query and returns only one (the first) row
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @return object PHP resource object containing the first row or
	 *                FALSE if no row is returned from the query
	 */
	public function QuerySingleRow( $sql )
	{
		$this->Query( $sql );
		if( $this->RowCount() > 0 )
		{
			return $this->Row();
		}
		else
		{
			return false;
		}
	}

	/**
	 * Executes the given SQL query and returns the first row as an array
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @param integer $resultType (Optional) The type of array
	 *                Values can be: MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
	 * @return array An array containing the first row or FALSE if no row
	 *               is returned from the query
	 */
	public function QuerySingleRowArray( $sql, $resultType = MYSQL_BOTH )
	{
		$this->Query( $sql );
		if( $this->RowCount() > 0 )
		{
			return $this->RowArray( NULL, $resultType );
		}
		else
		{
			return false;
		}
	}

	/**
	 * Executes a query and returns a single value. If more than one row
	 * is returned, only the first value in the first column is returned.
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @return mixed The value returned or FALSE if no value
	 */
	public function QuerySingleValue( $sql )
	{
		$this->Query( $sql );
		if( $this->RowCount() > 0 && $this->GetColumnCount() > 0 )
		{
			$row = $this->RowArray( NULL, MYSQL_NUM);
			return $row[0];
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Automatically does an INSERT or UPDATE depending if an existing record
	 * exists in a table
	 *
	 * @param string $tableName The name of the table
	 * @param array $valuesArray An associative array containing the column
	 *                            names as keys and values as data. The values
	 *                            must be SQL ready (i.e. quotes around
	 *                            strings, formatted dates, ect)
	 * @param array $whereArray An associative array containing the column
	 *                           names as keys and values as data. The values
	 *                           must be SQL ready (i.e. quotes around strings,
	 *                           formatted dates, ect).
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function AutoInsertUpdate( $tableName, $valuesArray, $whereArray )
	{
		$this->ResetError();
		$this->SelectRows( $tableName, $whereArray );
		if( !$this->Error() )
		{
			if( $this->HasRecords() )
			{
				return $this->UpdateRows( $tableName, $valuesArray, $whereArray );
			}
			else
			{
				return $this->InsertRow( $tableName, $valuesArray );
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Gets rows in a table based on a WHERE filter
	 *
	 * @param string $tableName The name of the table
	 * @param array $whereArray (Optional) An associative array containing the
	 *                          column names as keys and values as data. The
	 *                          values must be SQL ready (i.e. quotes around
	 *                          strings, formatted dates, ect)
	 * @param array/string $columns (Optional) The column or list of columns to select
	 * @param array/string $sortColumns (Optional) Column or list of columns to sort by
	 * @param boolean $sortAscending (Optional) TRUE for ascending; FALSE for descending
	 *                               This only works if $sortColumns are specified
	 * @param integer/string $limit (Optional) The limit of rows to return
	 * @return boolean Returns records on success or FALSE on error
	 */
	public function SelectRows(	$tableName, $whereArray = NULL, $columns = NULL,
							  	$sortColumns = NULL, $sortAscending = true,
							  	$limit = NULL )
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection');
			return false;
		}
		else
		{
			$sql = self::BuildSQLSelect( $tableName, $whereArray, $columns, $sortColumns, $sortAscending, $limit );
			// Execute the UPDATE
			if( !$this->Query( $sql ) )
			{
				return $this->last_result;
			}
			else
			{
				return true;
			}
		}
	}
	
	/**
	 * This function returns the last query as an HTML table
	 *
	 * @param boolean $showCount (Optional) TRUE if you want to show the row count,
	 *                           FALSE if you do not want to show the count
	 * @param string $styleTable (Optional) Style information for the table
	 * @param string $styleHeader (Optional) Style information for the header row
	 * @param string $styleData (Optional) Style information for the cells
	 * @return string HTML containing a table with all records listed
	 */
	public function GetHTML( $showCount = true, $styleTable = NULL, $styleHeader = NULL, $styleData = NULL )
	{
		if( $styleTable === NULL )
		{
			$tb = "border-collapse:collapse;empty-cells:show";
		}
		else
		{
			$tb = $styleTable;
		}
		if( $styleHeader === NULL )
		{
			$th = "border-width:1px;border-style:solid;background-color:navy;color:white";
		}
		else
		{
			$th = $styleHeader;
		}
		if( $styleData === NULL )
		{
			$td = "border-width:1px;border-style:solid";
		}
		else
		{
			$td = $styleData;
		}

		if( $this->last_result )
		{
			if( $this->RowCount() > 0 )
			{
				$html = "";
				if( $showCount ) $html = "Record Count: " . $this->RowCount() . "<br />\n";
				$html .= "<table style=\"$tb\" cellpadding=\"2\" cellspacing=\"2\">\n";
				$this->MoveFirst();
				$header = false;
				while( $member = mysql_fetch_object( $this->last_result ) )
				{
					if( !$header )
					{
						$html .= "\t<tr>\n";
						foreach( $member as $key => $value )
						{
							$html .= "\t\t<td style=\"$th\"><strong>" . htmlspecialchars( $key ) . "</strong></td>\n";
						}
						$html .= "\t</tr>\n";
						$header = true;
					}
					$html .= "\t<tr>\n";
					foreach( $member as $key => $value )
					{
						$html .= "\t\t<td style=\"$td\">" . htmlspecialchars( $value ) . "</td>\n";
					}
					$html .= "\t</tr>\n";
				}
				$this->MoveFirst();
				$html .= "</table>";
			}
			else
			{
				$html = "No records were returned.";
			}
		}
		else
		{
			$this->active_row = -1;
			$html = false;
		}
		return $html;
	}

	/**
	* Returns the last query as a JSON document
	*
	* @return string JSON containing all records listed
	*/
	public function GetJSON()
	{
		if( $this->last_result )
		{
			if( $this->RowCount() > 0 )
			{
				for( $i = 0, $il = mysql_num_fields( $this->last_result ); $i < $il; $i++ )
				{
					$types[$i] = mysql_field_type( $this->last_result, $i );
				}
				$json = '[';
				$this->MoveFirst();
				while( $member = mysql_fetch_object( $this->last_result ) )
				{
					$json .= json_encode( $member ) . ",";
				}
				$json .= ']';
				$json = str_replace("},]", "}]", $json );
			}
			else
			{
				$json = 'null';
			}
		}
		else
		{
			$this->active_row = -1;
			$json = 'null';
		}
		return $json;
	}
	
	/**
	 * Retrieves all rows in a specified table
	 *
	 * @param string $tableName The name of the table
	 * @return boolean Returns records on success or FALSE on error
	 */
	public function SelectTable( $tableName )
	{
		return $this->SelectRows( $tableName );
	}
	
	/**
	 * [STATIC] Converts a boolean into a formatted TRUE or FALSE value of choice
	 *
	 * @param mixed $value value to analyze for TRUE or FALSE
	 * @param mixed $trueValue value to use if TRUE
	 * @param mixed $falseValue value to use if FALSE
	 * @param string $datatype Use SQLVALUE constants or the strings:
	 *                          string, text, varchar, char, boolean, bool,
	 *                          Y-N, T-F, bit, date, datetime, time, integer,
	 *                          int, number, double, float
	 * @return string SQL formatted value of the specified data type
	 */
	static public function SQLBooleanValue( $value, $trueValue, $falseValue, $datatype = self::SQLVALUE_TEXT )
	{
		if( self::GetBooleanValue( $value ) )
		{
		   $return_value = self::SQLValue( $trueValue, $datatype );
		}
		else
		{
		   $return_value = self::SQLValue( $falseValue, $datatype );
		}
		return $return_value;
	}
	
	/**
	 * [STATIC] Returns string suitable for SQL
	 *
	 * @param string $value
	 * @return string SQL formatted value
	 */
	static public function SQLFix( $value )
	{
		return @addslashes( $value );
	}

	/**
	 * [STATIC] Returns MySQL string as normal string
	 *
	 * @param string $value
	 * @return string
	 */
	static public function SQLUnfix( $value )
	{
		return @stripslashes( $value );
	}

	/**
	 * [STATIC] Formats any value into a string suitable for SQL statements
	 * (NOTE: Also supports data types returned from the gettype function)
	 *
	 * @param mixed $value Any value of any type to be formatted to SQL
	 * @param string $datatype Use SQLVALUE constants or the strings:
	 *                          string, text, varchar, char, boolean, bool,
	 *                          Y-N, T-F, bit, date, datetime, time, integer,
	 *                          int, number, double, float
	 * @return string
	 */
	static public function SQLValue( $value, $datatype = self::SQLVALUE_TEXT )
	{
		$return_value = '';
		$value = mysql_real_escape_string( self::fixQuery( $value ) );

		switch( strtolower( trim( $datatype ) ) )
		{
			case 'text':
			case 'string':
			case 'varchar':
			case 'char':
				if( strlen( $value ) == 0 )
				{
					$return_value = "NULL";
				}
				else
				{
					if( get_magic_quotes_gpc() )
					{
						$value = stripslashes( $value );
					}
					$return_value = "'" . str_replace( "'", "''", $value ) . "'";
				}
				break;
			case 'number':
			case 'integer':
			case 'int':
			case 'double':
			case 'float':
				if( is_numeric( $value ) )
				{
					$return_value = $value;
				}
				else
				{
					$return_value = 'NULL';
				}
				break;
			case 'boolean':  //boolean to use this with a bit field
			case 'bool':
			case 'bit':
				if( self::GetBooleanValue( $value ) )
				{
				   $return_value = '1';
				}
				else
				{
				   $return_value = '0';
				}
				break;
			case 'y-n':  //boolean to use this with a char(1) field
				if( self::GetBooleanValue( $value ) )
				{
					$return_value = "'Y'";
				}
				else
				{
					$return_value = "'N'";
				}
				break;
			case 't-f':  //boolean to use this with a char(1) field
				if( self::GetBooleanValue( $value ) )
				{
					$return_value = "'T'";
				}
				else
				{
					$return_value = "'F'";
				}
				break;
			case 'date':
				if( self::IsDate( $value ) )
				{
					$return_value = "'" . date('Y-m-d', strtotime($value)) . "'";
				}
				else
				{
					$return_value = 'NULL';
				}
				break;
			case 'datetime':
				if( self::IsDate( $value ) )
				{
					$return_value = "'" . date('Y-m-d H:i:s', strtotime( $value ) ) . "'";
				}
				else
				{
					$return_value = 'NULL';
				}
				break;
			case 'time':
				if( self::IsDate( $value ) )
				{
					$return_value = "'" . date( 'H:i:s', strtotime( $value ) ) . "'";
				}
				else
				{
					$return_value = 'NULL';
				}
				break;
			default:
				exit('ERROR: Invalid data type specified in SQLValue method');
		}
		return $return_value;
	}
	
	/**
	 * Returns last measured duration (time between TimerStart and TimerStop)
	 *
	 * @param integer $decimals (Optional) The number of decimal places to show
	 * @return Float Microseconds elapsed
	 */
	public function TimerDuration( $decimals = 4 )
	{
		return number_format( $this->time_diff, $decimals );
	}

	/**
	 * Starts time measurement (in microseconds)
	 *
	 */
	public function TimerStart()
	{
		$parts = explode( " ", microtime() );
		$this->time_diff = 0;
		$this->time_start = $parts[1].substr( $parts[0],1 );
	}

	/**
	 * Stops time measurement (in microseconds)
	 *
	 */
	public function TimerStop()
	{
		$parts  = explode( " ", microtime() );
		$time_stop = $parts[1].substr( $parts[0],1 );
		$this->time_diff  = ( $time_stop - $this->time_start );
		$this->time_start = 0;
	}

	/**
	 * Starts a transaction
	 *
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function TransactionBegin()
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection' );
			return false;
		}
		else
		{
			if( !$this->in_transaction )
			{
				if( !mysql_query( 'START TRANSACTION', $this->db_connect ) )
				{
					$this->SetError();
					return false;
				}
				else
				{
					$this->in_transaction = true;
					return true;
				}
			}
			else
			{
				$this->SetError( 'Already in transaction', -1);
				return false;
			}
		}
	}

	/**
	 * Ends a transaction and commits the queries
	 *
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function TransactionEnd()
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection');
			return false;
		}
		else
		{
			if( $this->in_transaction )
			{
				if( !mysql_query( 'COMMIT', $this->db_connect ) )
				{
					// $this->TransactionRollback();
					$this->SetError();
					return false;
				}
				else
				{
					$this->in_transaction = false;
					return true;
				}
			}
			else
			{
				$this->SetError( 'Not in a transaction', -1);
				return false;
			}
		}
	}

	/**
	 * Rolls the transaction back
	 *
	 * @return boolean Returns TRUE on success or FALSE on failure
	 */
	public function TransactionRollback()
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError( 'No connection' );
			return false;
		}
		else
		{
			if( !mysql_query( 'ROLLBACK', $this->db_connect ) )
			{
				$this->SetError( 'Could not rollback transaction' );
				return false;
			}
			else 
			{
				$this->in_transaction = false;
				return true;
			}
		}
	}
	
	/**
	 * Determines if a query contains any rows
	 *
	 * @param string $sql [Optional] If specified, the query is first executed
	 *                    Otherwise, the last query is used for comparison
	 * @return boolean TRUE if records exist, FALSE if not or query error
	 */
	public function HasRecords( $sql = '' )
	{
		if( strlen( $sql ) > 0 )
		{
			$this->Query( $sql );
			if( $this->Error() ) return false;
		}
		if( $this->RowCount() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Returns the last query row count
	 *
	 * @return integer Row count or FALSE on error
	 */
	public function RowCount()
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection', -1);
			return false;
		}
		elseif( !$this->last_result )
		{
			$this->SetError('No query results exist', -1);
			return false;
		}
		else
		{
			$result = @mysql_num_rows( $this->last_result );
			if( !$result )
			{
				$this->SetError();
				return false;
			}
			else
			{
				return $result;
			}
		}
	}
	
	/**
	 * Reads the current row and returns contents as an
	 * array or returns false on error
	 *
	 * @param integer $optional_row_number (Optional) Use to specify a row
	 * @param integer $resultType (Optional) The type of array
	 *                Values can be: MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
	 * @return array Array that corresponds to fetched row or FALSE if no rows
	 */
	public function RowArray( $optional_row_number = NULL, $resultType = MYSQL_BOTH )
	{
		$this->ResetError();
		if( !$this->last_result )
		{
			$this->SetError( 'No query results exist', -1 );
			return false;
		}
		elseif( $optional_row_number === NULL )
		{
			if( ( $this->activeRow ) > $this->RowCount() )
			{
				$this->SetError( 'Cannot read past the end of the records', -1);
				return false;
			}
			else
			{
				$this->activeRow++;
			}
		}
		else
		{
			if( $optional_row_number >= $this->RowCount() )
			{
				$this->SetError( 'Row number is greater than the total number of rows', -1);
				return false;
			}
			else
			{
				$this->activeRow = $optional_row_number;
				$this->Seek( $optional_row_number );
			}
		}
		$row = mysql_fetch_array( $this->last_result, $resultType );
		if( !$row )
		{
			$this->SetError();
			return false;
		}
		else
		{
			return $row;
		}
	}
	
	/**
     * sql_db::fixdb()
     * 
     * @param mixed $value
     * @return
     */
    public function fixQuery( $value )
    {
        $value = str_replace( '\'', '&#039;', $value );
        $value = preg_replace( array( 
            "/(se)(lect)/i", "/(uni)(on)/i", "/(con)(cat)/i", "/(c)(har)/i", "/(out)(file)/i", "/(al)(ter)/i", "/(in)(sert)/i", "/(d)(rop)/i", "/(f)(rom)/i", "/(whe)(re)/i", "/(up)(date)/i", "/(de)(lete)/i", "/(cre)(ate)/i" 
        ), "$1-$2", $value );
        return $value;
    }
	
	/**
	 * [STATIC] Builds a comma delimited list of columns for use with SQL
	 *
	 * @param array $valuesArray An array containing the column names.
	 * @param boolean $addQuotes (Optional) TRUE to add quotes
	 * @param boolean $showAlias (Optional) TRUE to show column alias
	 * @return string Returns the SQL column list
	 */
	static private function BuildSQLColumns( $columns, $addQuotes = true, $showAlias = true )
	{
		if( $addQuotes )
		{
			$quote = '`';
		}
		else
		{
			$quote = '';
		}
		switch( gettype( $columns ) )
		{
			case 'array':
				$sql = '';
				foreach( $columns as $key => $value )
				{
					// Build the columns
					if( strlen( $sql ) == 0 )
					{
						$sql = $quote . $value . $quote;
					}
					else
					{
						$sql .= ", " . $quote . $value . $quote;
					}
					if( $showAlias && is_string( $key ) && ( !empty( $key ) ) )
					{
						$sql .= ' AS "' . $key . '"';
					}
				}
				return $sql;
				break;
				
			case 'string':
				return $quote . $columns . $quote;
				break;
				
			default:
				return false;
				break;
		}
	}
	
	/**
	 * [STATIC] Builds a SQL INSERT statement
	 *
	 * @param string $tableName The name of the table
	 * @param array $valuesArray An associative array containing the column
	 *                            names as keys and values as data. The values
	 *                            must be SQL ready (i.e. quotes around
	 *                            strings, formatted dates, ect)
	 * @return string Returns a SQL INSERT statement
	 */
	static public function BuildSQLInsert( $tableName, $valuesArray )
	{
		$columns = self::BuildSQLColumns( array_keys( $valuesArray ) );
		$values  = self::BuildSQLColumns( $valuesArray, false, false );
		$sql = 'INSERT INTO `' . $tableName . '` (' . $columns . ') VALUES (' . $values . ')';
		return $sql;
	}
	
	/**
	 * Builds a simple SQL SELECT statement
	 *
	 * @param string $tableName The name of the table
	 * @param array $whereArray (Optional) An associative array containing the
	 *                          column names as keys and values as data. The
	 *                          values must be SQL ready (i.e. quotes around
	 *                          strings, formatted dates, ect)
	 * @param array/string $columns (Optional) The column or list of columns to select
	 * @param array/string $sortColumns (Optional) Column or list of columns to sort by
	 * @param boolean $sortAscending (Optional) TRUE for ascending; FALSE for descending
	 *                               This only works if $sortColumns are specified
	 * @param integer/string $limit (Optional) The limit of rows to return
	 * @return string Returns a SQL SELECT statement
	 */
	static public function BuildSQLSelect(	$tableName, $whereArray = NULL, $columns = NULL,
										  	$sortColumns = NULL, $sortAscending = true, $limit = NULL )
	{
		if( !is_null( $columns ) )
		{
			$sql = self::BuildSQLColumns( $columns );
		}
		else
		{
			$sql = "*";
		}
		$sql = "SELECT " . $sql . " FROM `" . $tableName . "`";
		if( is_array( $whereArray ) )
		{
			$sql .= self::BuildSQLWhereClause( $whereArray );
		}
		if( !is_null( $sortColumns ) )
		{
			$sql .= " ORDER BY " . self::BuildSQLColumns( $sortColumns, true, false ) .
					" " . ( $sortAscending ? "ASC" : "DESC" );
		}
		if (! is_null($limit)) {
			$sql .= " LIMIT " . $limit;
		}
		return $sql;
	}
	
	/**
	 * [STATIC] Builds a SQL WHERE clause from an array.
	 * If a key is specified, the key is used at the field name and the value
	 * as a comparison. If a key is not used, the value is used as the clause.
	 *
	 * @param array $whereArray An associative array containing the column
	 *                           names as keys and values as data. The values
	 *                           must be SQL ready (i.e. quotes around
	 *                           strings, formatted dates, ect)
	 * @return string Returns a string containing the SQL WHERE clause
	 */
	static public function BuildSQLWhereClause( $whereArray, $customArray = array() )
	{
		$where = '';
		if( $whereArray )
		{
			foreach( $whereArray as $key => $value )
			{
				if( strlen( $where ) == 0 )
				{
					if( is_string( $key ) )
					{
						$where = " WHERE `" . $key . "` = " . $value;
					}
					else
					{
						$where = " WHERE " . $value;
					}
				}
				else
				{
					if( is_string( $key ) )
					{
						$where .= " AND `" . $key . "` = " . $value;
					}
					else
					{
						$where .= " AND " . $value;
					}
				}
			}
		}
		
		if( !empty( $customArray ) )
		{
			foreach( $customArray as $value )
			{
				if( strlen( $where ) == 0 )
				{
					$where = " WHERE " . $value;
				}
				else
				{
					$where .= " AND " . $value;
				}
			}
		}
		return $where;
	}
	
	/**
	 * [STATIC] Builds a SQL UPDATE statement
	 *
	 * @param string $tableName The name of the table
	 * @param array $valuesArray An associative array containing the column
	 *                            names as keys and values as data. The values
	 *                            must be SQL ready (i.e. quotes around
	 *                            strings, formatted dates, ect)
	 * @param array $whereArray (Optional) An associative array containing the
	 *                           column names as keys and values as data. The
	 *                           values must be SQL ready (i.e. quotes around
	 *                           strings, formatted dates, ect). If not specified
	 *                           then all values in the table are updated.
	 * @return string Returns a SQL UPDATE statement
	 */
	static public function BuildSQLUpdate( $tableName, $valuesArray, $whereArray = NULL )
	{
		$sql = "";
		foreach( $valuesArray as $key => $value )
		{
			if( strlen( $sql ) == 0 )
			{
				$sql = "`" . $key . "` = " . $value;
			}
			else
			{
				$sql .= ", `" . $key . "` = " . $value;
			}
		}
		$sql = "UPDATE `" . $tableName . "` SET " . $sql;
		if( is_array( $whereArray ) )
		{
			$sql .= self::BuildSQLWhereClause( $whereArray );
		}
		return $sql;
	}
	
	/**
	 * [STATIC] Builds a SQL DELETE statement
	 *
	 * @param string $tableName The name of the table
	 * @param array $whereArray (Optional) An associative array containing the
	 *                           column names as keys and values as data. The
	 *                           values must be SQL ready (i.e. quotes around
	 *                           strings, formatted dates, ect). If not specified
	 *                           then all values in the table are deleted.
	 * @return string Returns the SQL DELETE statement
	 */
	static public function BuildSQLDelete( $tableName, $whereArray = NULL, $customWhereArray = array() )
	{
		$sql = "DELETE FROM `" . $tableName . "`";
		if( !is_null( $whereArray ) || is_array( $customWhereArray ) )
		{
			if( is_array( $customWhereArray ) )
			{
				$sql .= self::BuildSQLWhereClause( $whereArray, $customWhereArray );
			}
			else
			{
				$sql .= self::BuildSQLWhereClause( $whereArray );
			}
		}
		return $sql;
	}
	
	/**
	 * Inserts a row into a table in the connected database
	 *
	 * @param string $tableName The name of the table
	 * @param array $valuesArray An associative array containing the column
	 *                            names as keys and values as data. The values
	 *                            must be SQL ready (i.e. quotes around
	 *                            strings, formatted dates, ect)
	 * @return integer Returns last insert ID on success or FALSE on failure
	 */
	public function InsertRow( $tableName, $valuesArray )
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError( 'No connection' );
			return false;
		}
		else
		{
			// Execute the query
			$sql = self::BuildSQLInsert( $tableName, $valuesArray );
			if( !$this->Query( $sql ) )
			{
				return false;
			}
			else
			{
				return $this->GetLastInsertID();
			}
		}
	}
	
	/**
	 * Updates rows in a table based on a WHERE filter
	 * (can be just one or many rows based on the filter)
	 *
	 * @param string $tableName The name of the table
	 * @param array $valuesArray An associative array containing the column
	 *                            names as keys and values as data. The values
	 *                            must be SQL ready (i.e. quotes around
	 *                            strings, formatted dates, ect)
	 * @param array $whereArray (Optional) An associative array containing the
	 *                           column names as keys and values as data. The
	 *                           values must be SQL ready (i.e. quotes around
	 *                           strings, formatted dates, ect). If not specified
	 *                           then all values in the table are updated.
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function UpdateRows( $tableName, $valuesArray, $whereArray = NULL )
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError( 'No connection' );
			return false;
		}
		else
		{
			$sql = self::BuildSQLUpdate( $tableName, $valuesArray, $whereArray );
			// Execute the UPDATE
			if( !$this->Query( $sql ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
	
	/**
	 * Deletes rows in a table based on a WHERE filter
	 * (can be just one or many rows based on the filter)
	 *
	 * @param string $tableName The name of the table
	 * @param array $whereArray (Optional) An associative array containing the
	 *                          column names as keys and values as data. The
	 *                          values must be SQL ready (i.e. quotes around
	 *                          strings, formatted dates, ect). If not specified
	 *                          then all values in the table are deleted.
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function DeleteRows( $tableName, $whereArray = NULL, $customWhereArray = array() )
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection');
			return false;
		}
		else
		{
			$sql = self::BuildSQLDelete( $tableName, $whereArray, $customWhereArray );
			// Execute the UPDATE
			if( !$this->Query( $sql ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
	
	/**
	 * [STATIC] Converts any value of any datatype into boolean (true or false)
	 *
	 * @param mixed $value Value to analyze for TRUE or FALSE
	 * @return boolean Returns TRUE or FALSE
	 */
	static public function GetBooleanValue( $value )
	{
		if( gettype( $value ) == 'boolean')
		{
			if( $value == true )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif( is_numeric( $value ) )
		{
			if( $value > 0 )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$cleaned = strtoupper( trim( $value ) );

			if( $cleaned == 'ON' )
			{
				return true;
			}
			elseif( $cleaned == 'SELECTED' || $cleaned == 'CHECKED' )
			{
				return true;
			}
			elseif( $cleaned == 'YES' || $cleaned == 'Y')
			{
				return true;
			}
			elseif( $cleaned == 'TRUE' || $cleaned == 'T')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	
	/**
	 * Returns the comments for fields in a table into an
	 * array or NULL if the table has not got any fields
	 *
	 * @param string $table Table name
	 * @return array An array that contains the column comments
	 */
	public function GetColumnComments( $table )
	{
		$this->ResetError();
		$records = mysql_query('SHOW FULL COLUMNS FROM ' . $table);
		if( !$records )
		{
			$this->SetError();
			return false;
		}
		else
		{
			// Get the column names
			$columnNames = $this->GetColumnNames( $table );
			if( $this->Error() )
			{
				return false;
			}
			else
			{
				$index = 0;
				// Fetchs the array to be returned (column 8 is field comment):
				while( $array_data = mysql_fetch_array( $records ) )
				{
					$columns[$index] = $array_data[8];
					$columns[$columnNames[$index++]] = $array_data[8];
				}
				return $columns;
			}
		}
	}

	/**
	 * This function returns the number of columns or returns FALSE on error
	 *
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      column count is returned from the last query
	 * @return integer The total count of columns
	 */
	public function GetColumnCount( $table = '' )
	{
		$this->ResetError();
		if( empty( $table ) )
		{
			$result = mysql_num_fields( $this->last_result );
			if( !$result ) $this->SetError();
		}
		else
		{
			$records = mysql_query('SELECT * FROM ' . $table . ' LIMIT 1');
			if( !$records )
			{
				$this->SetError();
				$result = false;
			}
			else
			{
				$result = mysql_num_fields( $records );
				$success = @mysql_free_result( $records );
				if( !$success )
				{
					$this->SetError();
					$result = false;
				}
			}
		}
		return $result;
	}

	/**
	 * This function returns the data type for a specified column. If
	 * the column does not exists or no records exist, it returns FALSE
	 *
	 * @param string $column Column name or number (first column is 0)
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      last returned records are used
	 * @return string MySQL data (field) type
	 */
	public function GetColumnDataType( $column, $table = '' )
	{
		$this->ResetError();
		if( empty( $table ) )
		{
			if( $this->RowCount() > 0 )
			{
				if( is_numeric( $column ) )
				{
					return mysql_field_type( $this->last_result, $column );
				}
				else
				{
					return mysql_field_type( $this->last_result, $this->GetColumnID( $column ) );
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			if( is_numeric( $column ) ) $column = $this->GetColumnName( $column, $table );
			$result = mysql_query( 'SELECT ' . $column . ' FROM ' . $table . ' LIMIT 1');
			if( mysql_num_fields( $result ) > 0 )
			{
				return mysql_field_type( $result, 0 );
			}
			else
			{
				$this->SetError( 'The specified column or table does not exist, or no data was returned', -1);
				return false;
			}
		}
	}

	/**
	 * This function returns the position of a column
	 *
	 * @param string $column Column name
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      last returned records are used.
	 * @return integer Column ID
	 */
	public function GetColumnID( $column, $table = '' )
	{
		$this->ResetError();
		$columnNames = $this->GetColumnNames( $table );
		if( !$columnNames )
		{
			return false;
		}
		else
		{
			$index = 0;
			$found = false;
			foreach( $columnNames as $columnName )
			{
				if( $columnName == $column )
				{
					$found = true;
					break;
				}
				$index++;
			}
			if( $found )
			{
				return $index;
			}
			else
			{
				$this->SetError('Column name not found', -1);
				return false;
			}
		}
	}

   /**
	 * This function returns the field length or returns FALSE on error
	 *
	 * @param string $column Column name
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      last returned records are used.
	 * @return integer Field length
	 */
	public function GetColumnLength( $column, $table = '' )
	{
		$this->ResetError();
		if( empty( $table ) )
		{
			if( is_numeric( $column ) )
			{
				$columnID = $column;
			}
			else
			{
				$columnID = $this->GetColumnID( $column );
			}
			if( !$columnID )
			{
				return false;
			}
			else
			{
				$result = mysql_field_len( $this->last_result, $columnID );
				if( !$result )
				{
					$this->SetError();
					return false;
				}
				else
				{
					return $result;
				}
			}
		}
		else
		{
			$records = mysql_query( 'SELECT ' . $column . ' FROM ' . $table . ' LIMIT 1' );
			if( !$records )
			{
				$this->SetError();
				return false;
			}
			$result = mysql_field_len( $records, 0 );
			if( !$result )
			{
				$this->SetError();
				return false;
			}
			else
			{
				return $result;
			}
		}
	}

   /**
	 * This function returns the name for a specified column number. If
	 * the index does not exists or no records exist, it returns FALSE
	 *
	 * @param string $columnID Column position (0 is the first column)
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      last returned records are used.
	 * @return integer Field Length
	 */
	public function GetColumnName( $columnID, $table = "" )
	{
		$this->ResetError();
		if( empty( $table ) )
		{
			if( $this->RowCount() > 0 )
			{
				$result = mysql_field_name( $this->last_result, $columnID );
				if( !$result ) $this->SetError();
			}
			else
			{
				$result = false;
			}
		}
		else
		{
			$records = mysql_query(' SELECT * FROM ' . $table . ' LIMIT 1' );
			if( !$records )
			{
				$this->SetError();
				$result = false;
			}
			else
			{
				if( mysql_num_fields( $records ) > 0 )
				{
					$result = mysql_field_name( $records, $columnID );
					if( !$result ) $this->SetError();
				}
				else
				{
					$result = false;
				}
			}
		}
		return $result;
	}

	/**
	 * Returns the field names in a table or query in an array
	 *
	 * @param string $table (Optional) If a table name is not specified, the
	 *                      last returned records are used
	 * @return array An array that contains the column names
	 */
	public function GetColumnNames( $table = '' )
	{
		$this->ResetError();
		if(empty( $table ) )
		{
			$columnCount = mysql_num_fields( $this->last_result );
			if( !$columnCount )
			{
				$this->SetError();
				$columns = false;
			}
			else
			{
				for( $column = 0; $column < $columnCount; $column++ )
				{
					$columns[] = mysql_field_name( $this->last_result, $column );
				}
			}
		}
		else
		{
			$result = mysql_query( 'SHOW COLUMNS FROM ' . $table );
			if( !$result )
			{
				$this->SetError();
				$columns = false;
			}
			else
			{
				while( $array_data = mysql_fetch_array( $result ) )
				{
					$columns[] = $array_data[0];
				}
			}
		}
		// Returns the array
		return $columns;
	}
	
	/**
	 * Returns the last autonumber ID field from a previous INSERT query
	 *
	 * @return  integer ID number from previous INSERT query
	 */
	public function GetLastInsertID()
	{
		return $this->last_insert_id;
	}

	/**
	 * Returns the last SQL statement executed
	 *
	 * @return string Current SQL query string
	 */
	public function GetLastSQL()
	{
		return $this->last_sql;
	}

	/**
	 * This function returns table names from the database
	 * into an array. If the database does not contains
	 * any tables, the returned value is FALSE
	 *
	 * @return array An array that contains the table names
	 */
	public function GetTables()
	{
		$this->ResetError();
		// Query to get the tables in the current database:
		$records = mysql_query( 'SHOW TABLES' );
		if( !$records )
		{
			$this->SetError();
			return FALSE;
		}
		else
		{
			while( $array_data = mysql_fetch_array( $records ) )
			{
				$tables[] = $array_data[0];
			}

			// Returns the array or NULL
			if( count( $tables ) > 0 )
			{
				return $tables;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	/**
	 * [STATIC] Determines if a value of any data type is a date PHP can convert
	 *
	 * @param date/string $value
	 * @return boolean Returns TRUE if value is date or FALSE if not date
	 */
	static public function IsDate( $value )
	{
		$date = date( 'Y', strtotime( $value ) );
		if( $date == "1969" || $date == '' )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * Sets the local variables with the last error information
	 *
	 * @param string $errorMessage The error description
	 * @param integer $errorNumber The error number
	 */
	private function SetError( $errorMessage = '', $errorNumber = 0 )
	{
		try
		{
			if( strlen( $errorMessage ) > 0 )
			{
				$this->error_desc = $errorMessage;
			}
			else
			{
				if( $this->IsConnected() )
				{
					$this->error_desc = mysql_error( $this->db_connect );
				}
				else
				{
					$this->error_desc = mysql_error();
				}
			}
			if( $errorNumber <> 0 )
			{
				$this->errorNumber = $errorNumber;
			}
			else
			{
				if( $this->IsConnected() )
				{
					$this->errorNumber = @mysql_errno( $this->db_connect );
				}
				else
				{
					$this->error_desc = @mysql_error();
				}
			}
		}
		catch( Exception $e )
		{
			$this->error_desc = $e->getMessage();
			$this->error_desc = -999;
		}
		if( $this->ThrowExceptions )
		{
			if( isset( $this->error_desc ) && $this->error_desc  != NULL )
			{
				throw new Exception( $this->error_desc . ' (' . __LINE__ . ')');
			}
		}
	}
	
	private function ResetError()
	{
		$this->error_desc = '';
		$this->errorNumber = 0;
	}
	
	/**
	 * Close current MySQL connection
	 *
	 * @return object Returns TRUE on success or FALSE on error
	 */
	public function Close()
	{
		$this->ResetError();
		$this->activeRow = -1;
		$success = $this->Release();
		if( $success )
		{
			$success = @mysql_close( $this->db_connect );
			if( !$success )
			{
				$this->SetError();
			}
			else
			{
				unset( $this->last_sql );
				unset( $this->last_result );
				unset( $this->db_connect );
			}
		}
		return $success;
	}
	
	/**
	 * Seeks to the beginning of the records
	 *
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function MoveFirst()
	{
		$this->ResetError();
		if( !$this->Seek(0) )
		{
			$this->SetError();
			return false;
		}
		else
		{
			$this->activeRow = 0;
			return true;
		}
	}

	/**
	 * Seeks to the end of the records
	 *
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function MoveLast()
	{
		$this->ResetError();
		$this->activeRow = $this->RowCount() - 1;
		if( !$this->Error() )
		{
			if( !$this->Seek( $this->activeRow ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Returns true if the internal pointer is at the end of the records
	 *
	 * @return boolean TRUE if at the last row or FALSE if not
	 */
	public function EndOfSeek()
	{
		$this->ResetError();
		if( $this->IsConnected() )
		{
			if( $this->activeRow >= ( $this->RowCount() ) )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->SetError( 'No connection' );
			return false;
		}
	}
	
	/**
	 * Stop executing (die/exit) and show last MySQL error message
	 *
	 */
	public function Kill( $message = '' )
	{
		if( strlen( $message ) > 0 )
		{
			exit( $message );
		} 
		else
		{
			exit( $this->Error() );
		}
	}
	
	/**
	 * Frees memory used by the query results and returns the function result
	 *
	 * @return boolean Returns TRUE on success or FALSE on failure
	 */
	public function Release()
	{
		$this->ResetError();
		if( !$this->last_result )
		{
			$success = true;
		}
		else
		{
			$success = @mysql_free_result( $this->last_result );
			if( !$success ) $this->SetError();
		}
		return $success;
	}
	
	/**
	 * Returns the last MySQL error as text
	 *
	 * @return string Error text from last known error
	 */
	public function Error()
	{
		$error = $this->error_desc;
		if( empty( $error ) )
		{
			if( $this->errorNumber <> 0 )
			{
				$error = "Unknown Error (#" . $this->errorNumber . ")";
			}
			else
			{
				$error = false;
			}
		}
		else
		{
			if( $this->errorNumber > 0 )
			{
				$error .= " (#" . $this->errorNumber . ")";
			}
		}
		return $error;
	}
	
	/**
	 * Truncates a table removing all data
	 *
	 * @param string $tableName The name of the table
	 * @return boolean Returns TRUE on success or FALSE on error
	 */
	public function TruncateTable( $tableName )
	{
		$this->ResetError();
		if( !$this->IsConnected() )
		{
			$this->SetError('No connection');
			return false;
		}
		else
		{
			$sql = 'TRUNCATE TABLE `' . $tableName . '`';
			if( !$this->Query( $sql ) )
			{
				return false;
			} 
			else
			{
				return true;
			}
		}
	}
}		