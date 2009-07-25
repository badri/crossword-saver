<?php

/**
 * Set of functions used to build XML dumps of tables
 */

/**
 * Outputs comment
 * @param   string      Text of comment
 * @return  bool        Whether it suceeded
 */
function exportComment( $text ){
  $crlf = "\n\r";
  return exportOutputHandler( '<!-- ' . $text . ' -->' . $crlf );
}

/**
 * Outputs export footer
 * @return  bool        Whether it suceeded
 * @access  public
 */
function exportFooter(){
  return TRUE;
}

/**
 * Outputs export header
 * @return  bool        Whether it suceeded
 * @access  public
 */
function exportHeader(){
  $crlf = "\n\r";
  $head  =  '<?xml version="1.0" encoding="iso-8859-1" ?>' . "$crlf";
           
  return exportOutputHandler( $head );
}

/**
 * Outputs database header
 * @param   string      Database name
 * @return  bool        Whether it suceeded
 * @access  public
 */
function exportDBHeader(){
  $crlf = "\n\r";
  $head = '<!--' . $crlf
  		  . '- CrosswordSaver XML dump' . $crlf
  		  . '- http://sourceforge.net/crosswordsaver' . $crlf
  		  . '-' . $crlf
  		  . '- Generation time: ' . date( "l dS of F Y h:i:s A" ) . $crlf
  		  . '- PHP Version: ' . phpversion() . $crlf
          . '-->' . $crlf
          . '<crosswordsaver schemaVer="1.0">' . $crlf;
  return exportOutputHandler( $head );
}

/**
 * Outputs database footer
 * @param   string      Database name
 * @return  bool        Whether it suceeded
 * @access  public
 */
function exportDBFooter(){
  $crlf = "\n\r";
  return exportOutputHandler( "</crosswordsaver>" . $crlf );
}

/**
 * Output handler for all exports, if needed buffering, it stores data into
 * $dump_buffer, otherwise it prints thems out.
 *
 * @param   string  the insert statement
 *
 * @return  bool    Whether output suceeded
 */
function exportOutputHandler( $line ){
  echo $line;
  return TRUE;
}

/**
 * Outputs the content of a table
 * @param   string      the end of line sequence
 * @return  bool        Whether it suceeded
 * @access  public
 */
function exportData( $cwObj ){
  $crlf = "\n\r";
  $cwData = $cwObj->getCrosswordData();
  exportOutputHandler( "\t<crossword id=\"" . $cwObj->getId() . "\" complete=\"" . $cwData["complete"] . "\" dateAdded=\"" . $cwData["dateAdded"] . "\" user=\"" . $cwData["user"] . "\" grid=\"" . $cwObj->getGrid() . "\">" . $crlf );
  
  $clues = $cwObj->getClues();
  for( $i = 0; $i < count( $clues ); $i++ ){
  	exportOutputHandler( "\t\t<clue code=\"" . $clues[$i]["code"] . "\" answer=\"" . $clues[$i]["answer"] . "\">" . $clues[$i]["clue"] . "</clue>" . $crlf );
  }
  
  exportOutputHandler( "\t</crossword>" . $crlf );

  return TRUE;
}
?>
