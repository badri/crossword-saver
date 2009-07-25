<?php

  global $query;
  if( $query == "addX" ) add();
  else if( $query == "parseXML" ){
    $across = $down = $cwMData = array(); $lastClue = '';
    load();
  }
  else header( "Location: Crosswords.php?e=001" );
  
  function add(){
    echo <<<HD
    <br>
    <form name="fileLocate" method="POST" action="Crosswords.php?q=parseXML" enctype="multipart/form-data">
      <table align="center" width="600" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" colspan="2" class="gen">Enter the name of the XML file below.</th>
        </tr>
        <tr>
          <td class="catLeft"><span class="cattitle"></span></td>
        </tr>
      	<tr>
          <td class="row1" align="center">
            <br>
            <input type="hidden" name="MAX_FILE_SIZE" value="4096">
            <input type="file" name="xmlFile" id="file">
            <br><br>
          </td>
      	</tr>
        <tr>
          <td class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td class="tb" align="right">
            <input type="button" name="back" value="Cancel" onclick="window.history.go( -1 )" class="button">
            <input type="submit" name="submit" value="Load" onclick="return !document.getElementById('file').value==''" class="button">
          </td>
        </tr>
      </table>
    </form>
HD;
  }
  
  function load(){
  	if( !$_FILES["xmlFile"] )
  	  return false;		//Check if the file was uploaded to the server.
  	if( !$_FILES["xmlFile"]["type"] == "text/html" )
  	  return false;		//Check that the MIME type reported by the users browser is text/html.
  	if( function_exists( 'mime_content_type' ) ){
  	  if( file_exists( $_FILES["xmlFile"]["tmp_name"] ) )
  	    if( !( mime_content_type( $_FILES["xmlFile"]["tmp_name"] ) == "text/html" ) )
  	      return false;	//Check that the files MIME type is text/html based on its content.
  	}
  	if( !$_FILES["xmlFile"]["error"] == 0 )
  	  return false;		//Check that there were no errors associated with the upload.
  	
  	$handle = fopen( $_FILES["xmlFile"]["tmp_name"], "r" );
  	$contents = fread( $handle, filesize( $_FILES["xmlFile"]["tmp_name"] ) );
  	
  	$parser = xml_parser_create();
  	xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
  	xml_set_element_handler( $parser, "startElement", "endElement" );
  	xml_set_default_handler( $parser, "defaultHandler" );
  	xml_set_character_data_handler( $parser, "cdHandler" );
  	xml_parse( $parser, $contents );
  	xml_parser_free( $parser );
  	
  	global $across, $down, $cwMData, $lastClue;
    echo <<<HD
      <Br><Br>
    <form action="Crosswords.php?q=save" method="POST">
      <table align="center" width="1100" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th class="thTop" colspan="4" align="center">Review clues before proceeding</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">Across</span></td>
          <td class="catRight" colspan="2"><span class="cattitle">Down</span></td>
        </tr>
        <tr>\n
HD;
    
    $styleClass = (CONCEAL_ANS) ? "concealInput" : "answerInput";
    for( $i = 0; $i < max( count( $across ), count( $down ) ); $i++ ){
      list( $keyA, $valA ) = each( $across );
      list( $keyD, $valD ) = each( $down );
      $numA = str_replace( 'A', '', $keyA );
      $numD = str_replace( 'D', '', $keyD );
      echo <<<HD
        <tr>
          <td class="row1">
            <input type="TEXT" name="{$numA}" value="{$numA}" class="numberInput"><input type="TEXT" name="{$keyA}" value="{$valA[1]}" class="clueInput">
          </td>
          <td class="gensmall" align="center">
            <input type="TEXT" name="{$keyA}A" value="{$valA[2]}" class="{$styleClass}">
          </td>
          <td class="row1">
            <input type="TEXT" name="{$numD}" value="{$numD}" class="numberInput"><input type="TEXT" name="{$keyD}" value="{$valD[1]}" class="clueInput">
          </td>
          <td class="gensmall" align="center">
            <input type="TEXT" name="{$keyD}A" value="{$valD[2]}" class="{$styleClass}">
          </td>
        </tr>
HD;
    }

    $completeValue = $cwMData["complete"] == 'Y' ? 'CHECKED' : 'UNCHECKED';
    $formattedDateOriginal = $cwMData["dateAdded"];
    $formattedDateNow = date( "Y-m-d H:i:s" );
    echo <<<HD
        <tr>
          <td colspan="2" rowspan="3" class="row2"><br><script>drawMiniCrossword( '{$cwMData["grid"]}' );</script></td>
          <td class="row2"><span class="genmed">Complete crossword:</span></td>
          <td class="row2"><input type="checkbox" name="complete" {$completeValue} class="answerInput"></td>
        </tr>
        <tr>
          <td class="row2"><span class="genmed">User:</span></td>
          <td class="row2"><input type="text" name="user" value="{$cwMData["user"]}" class="answerInput"></td>
        </tr>
        <tr>
          <td class="row2"><span class="genmed">Date added:</span>
            <input type="button" class="button" name="Now" value="Time Now" onclick="document.getElementById('dateAdded').value = '{$formattedDateNow}'">
            <input type="button" class="button" name="Original" value="Original Time" onclick="document.getElementById('dateAdded').value = '{$formattedDateOriginal}'">
          </td>
          <td class="row2"><input type="text" name="dateAdded" value="{$formattedDateOriginal}" class="answerInput" id="dateAdded"></td>
        </tr>
        <tr>
          <td colspan="4" class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="tb" align="right">
            <input type="HIDDEN" name="Grid" value="{$cwMData["grid"]}">
            <input type="BUTTON" name="Back" value="Back" onClick="window.history.go(-1)" class="button">
            <input type="SUBMIT" name="Submit" value="Submit" class="button">
          </td>
        </tr>
      </table>
    </form>
HD;
  	
  }
  
  /**
  * Event handler for opening XML tags.
  */
  function startElement( $parser, $name, $attrs ){
  	global $across, $down, $cwMData, $lastClue;
  	if( $name == "clue" ){
  	  if( strstr( $attrs['code'], 'A' ) )
  	    $across[$attrs['code']] = array( $attrs['code'], '', $attrs['answer'] );
  	  else
  	    $down[$attrs['code']] = array( $attrs['code'], '', $attrs['answer'] );
  	  $lastClue = $attrs['code'];
  	}
  	else if( $name == "crossword" ){
  	  $cwMData = $attrs;
  	}
  }

  /**
  * Event handler for closing XML tags.
  */
  function endElement( $parser, $name ){
  }

  /**
  * Default handler.
  */
  function defaultHandler( $parser, $data ){
  	//echo $data;
  }
  
  /**
  * Character data handler.
  */
  function cdHandler( $parser, $data ){
  	global $across, $down, $lastClue;
  	$data = trim( $data );
  	if( $data != '' ){
      if( strstr( $lastClue, 'A' ) ){
        $across[$lastClue][1] .= htmlspecialchars( $data );
      }
      else
        $down[$lastClue][1] .= htmlspecialchars( $data );
  	}
  }
?>