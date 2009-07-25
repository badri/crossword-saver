<?php

if( LOGGING == true ){
  define( 'LOG4PHP_CONFIGURATION', './configs/LoggerAppenderRollingFile.xml' );
  require_once( LOG4PHP_DIR . 'LoggerManager.php' );
}

class CSLogger{

  var $_logger;
  
  function CSLogger( $name ){
    $this->_logger = &LoggerManager::getLogger( $name );
  }
  
  function getLogger(){
    return $this->_logger;
  }
}
?>
