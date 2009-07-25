<?php

  require( 'xml.php' );
  require( 'Crossword.php' );
  
  $filename  = "CrosswordSaver.xml";
  $mime_type = 'text/xml';
  
  //Logging needs to be unhooked for this operation as we get unwanted ouput in
  //the .xml file when Log4PHP tries to roll over the appender file and causes
  //an error during the script. We restore logging below.
  $appLogOpt = (LOGGING) ? LOGGING : 0;
  define( 'LOGGING', '0' );
  
  //Download
  header('Content-Type: ' . $mime_type);
  header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  //lem9 & loic1: IE need specific headers
  if( PMA_USR_BROWSER_AGENT == 'IE' ){
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
  } else {
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
  }
  
  if( !exportHeader() )
    break;
    
  if( !exportDBHeader() )
    break;
  
  while( list( $key, $val ) = each( $checkboxes ) ){
    $cwObj = new Crossword( $val );
    if( !exportComment( "\tCrossword ID: " . $val ) )
      break;
    
    if( !exportData( $cwObj ) )
     break;
  }

  if( !exportDBFooter() )
    break;
    
  //Restore logging to its original value.
  define( 'LOGGING', $appLogOpt );
?>