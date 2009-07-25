<?php

  require_once( 'configs/config.ini.php' );
  include_once( 'CSLogger.php' );
  
  /**
  * Class that handles database connections for the crossword database.
  *
  *
  * TODO: Move all sql statements into this file, create methods of the DBAccess class
  * that return objects.
  */
  class DBAccess{

    var $link;
    var $logger;

    /**
    * Initialises the object.
    */
    function DBAccess(){
      if( !$this->link )
        $this->connectDB();
      if( LOGGING == true )
        $this->logger = new CSLogger( "DBAccess" );
    }

    /**
    * Connects to the database and saves the link identifier.
    * Global variables CS_DB_HOST, CS_DB_UN, & CS_DB_PW must be set in config.ini.php.
    */
    function connectDB(){
      $this->link = mysql_connect( CS_DB_HOST, CS_DB_UN, CS_DB_PW ) or die( "Could not connect to database: " . mysql_error() );
      mysql_select_db( CS_DB_NAME, $this->link ) or die( "Could not select database: " . mysql_error() );
    }

    /**
    * Runs an SQL query against the active database.
    * @param	$query		The SQL string to run against the database.
    * @return				The standard return values as specified by mysql_query().
    */
    function queryDB( $query ){
      if( isset( $this->logger ) )
        $this->logger->getLogger()->info( 'Executing SQL query: ' . $query );
      $result = mysql_query( $query, $this->link ) or die( "SQL error. " . mysql_error() );
      return $result;
    }
  }
  ///////////////////////////////////////////////////////////////////////////////////
?>