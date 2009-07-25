<?php

  include_once( 'database.php' );

  /**
  * Data object to encapsulate crossword data.
  */
  class Crossword{
    private $_DBAccess;
    
  	private $_id;
  	private $_crosswordData;
  	private $_clues = array();
  	private $_grid;
  	private $_altered = false;
  	
  	/**
  	* Initialise this object.
  	*/
  	function __construct( $id ){
  	  $this->_DBAccess = new DBAccess();
  	  $this->_id = $id;
  	  $result = $this->_DBAccess->queryDB( "SELECT `id`, `gridId`, `complete`, UNIX_TIMESTAMP( `dateAdded` ) AS `dateAdded`, `user` FROM `cs_crossword` WHERE `id` = '$id'" );
  	  $this->_crosswordData = mysql_fetch_assoc( $result );
  	  $this->_crosswordData['dateAdded'] = date( "Y-m-d H:i:s", $this->_crosswordData['dateAdded'] );
  	  $result = $this->_DBAccess->queryDB( "SELECT * FROM `cs_clues` WHERE `crosswordId` = '$id' ORDER BY `id` ASC" );
  	  while( $row = mysql_fetch_assoc( $result ) ){
  	  	array_push( $this->_clues, $row );
  	  }
  	  $result = $this->_DBAccess->queryDB( "SELECT PRE.grid FROM `cs_presets` AS PRE LEFT JOIN `cs_crossword` AS CS ON CS.gridID = PRE.id WHERE CS.id = '$id'" );
  	  $row = mysql_fetch_assoc( $result );
  	  $this->_grid = $row["grid"];
  	}
  	
  	function getId(){
  	  return $this->_id;
  	}
  	
  	/**
  	* @return Array  An associative array of the data in one row of the cs_crossword table.
  	*/
  	function getCrosswordData(){
  	  return $this->_crosswordData;
  	}
  	
  	function setCrosswordData( $cwData ){
  	  $this->_crosswordData = $cwData;
  	  $this->_altered = true;
  	}
  	
  	function getClues(){
  	  return $this->_clues;
  	}
  	
  	function setClues( $clues ){
  	  $this->_clues = $clues;
  	  $this->_altered = true;
  	}
  	
  	function getGrid(){
  	  return $this->_grid;
  	}
  	
  	function setGrid( $grid ){
  	  $this->_grid = $grid;
  	  $this->_altered = true;
  	}
  	  	
  	/**
  	* Function 
  	* @return    True if the object has been updated since instantiation, False otherwise.
  	*/
  	function isAltered(){
  	  if( $this->_altered )
  	    return true;
  	  else
  	    return false;
  	}
  	
  	/**
  	* Saves the crossword object to the database. Only if the object has been altered.
  	*/
  	function persist(){
  	  if( $this->_altered ){
  	    $this->_DBAccess = new DBAccess();
  	    $this->_DBAccess->queryDB( "UPDATE `cs_crossword` SET `gridId` = '{$this->_crosswordData['gridId']}', `complete` = '{$this->_crosswordData['complete']}', `dateAdded` = '{$this->_crosswordData['dateAdded']}', `user` = '{$this->_crosswordData['user']}' WHERE `id` = {$this->_id}" );
  	    foreach( $this->_clues as $row ){
  	      $this->_DBAccess->queryDB( "UPDATE `cs_clues` SET `clue` = '{$row['clue']}', `answer` = '{$row['answer']}' WHERE `id` = '{$row['id']}'" );
  	    }
  	  }
  	}
  }
  
?>