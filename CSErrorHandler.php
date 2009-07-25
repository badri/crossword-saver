<?php
require_once( 'CSErrorMessages.php' );

class CSErrorHandler{
  
  function CSErrorHandler(){
    
  }
  
  function getMessage( $code ){
    if( defined( $code ) )
      return constant( $code );
  }
}

?>