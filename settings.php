<?php

global $query;
if( $query == "editSettings" ) edit();
else if( $query == "saveSettings" ) save();

function edit(){
  $cfg = readINIfile( 'configs/config.ini.php' );
  //Determine values for all checkboxes here before proceeding.
  $caCB = ( $cfg['$CONCEAL_ANS'] == 1 ) ? 'checked' : '';
  $logCB = ( $cfg['$LOGGING'] == 1 ) ? 'checked' : '';

  echo <<<HD
  <br>
  <form name="settingsForm" method="POST" action="Crosswords.php?q=saveSettings">
  <table align="center" width="500" cellspacing="1" cellpadding="0" class="forumline">
    <tr>
      <th align="center" colspan="2" class="gen">CrosswordSaver Settings</th>
    </tr>
    <tr>
      <td class="catLeft"><span class="cattitle">Database Settings</span></td>
      <td class="catRight">&nbsp;</td>
    </tr>
  	<tr>
      <td class="row1"><span class="genmed">Database Host:</span></td>
      <td class="row2" align="center"><input type="text" value="{$cfg['$CS_DB_HOST']}" name="\$CS_DB_HOST" id="CS_DB_HOST" class="answerInput"></td>
  	</tr>
  	<tr>
      <td class="row1"><span class="genmed">Database Name:</span></td>
      <td class="row2" align="center"><input type="text" value="{$cfg['$CS_DB_NAME']}" name="\$CS_DB_NAME" id="CS_DB_NAME" class="answerInput"></td>
  	</tr>
  	<tr>
      <td class="row1"><span class="genmed">Database Username:</span></td>
      <td class="row2" align="center"><input type="text" value="{$cfg['$CS_DB_UN']}" name="\$CS_DB_UN" id="CS_DB_UN" class="answerInput"></td>
  	</tr>
  	<tr>
      <td class="row1"><span class="genmed">Database Password:</span></td>
      <td class="row2" align="center"><input type="password" value="{$cfg['$CS_DB_PW']}" name="\$CS_DB_PW" id="CS_DB_PW" class="answerInput"></td>
  	</tr>
    <tr>
      <td colspan="2" class="spaceRow">&nbsp;</td>
    </tr>
    <tr>
      <td class="catLeft"><span class="cattitle">Crossword Settings</span></td>
      <td class="catRight">&nbsp;</td>
    </tr>
  	<tr>
      <td class="row1"><span class="genmed">Conceal answers when adding/editing:</span></td>
      <td class="row2" align="center"><input type="checkbox" value="1" {$caCB} name="\$CONCEAL_ANS" id="CONCEAL_ANS"></td>
  	</tr>
    <tr>
      <td colspan="2" class="spaceRow">&nbsp;</td>
    </tr>
    <tr>
      <td class="catLeft"><span class="cattitle">Logging Settings</span></td>
      <td class="catRight">&nbsp;</td>
    </tr>
  	<tr>
      <td class="row1"><span class="genmed">Turn logging on (useful for debugging):</span></td>
      <td class="row2" align="center"><input type="checkbox" value="1" {$logCB} name="\$LOGGING" id="LOGGING"></td>
  	</tr>
  	<tr>
      <td class="row1"><span class="genmed">Log4PHP working directory:</span></td>
      <td class="row2" align="center"><input type="text" value="{$cfg['$LOG4PHP_DIR']}" name="\$LOG4PHP_DIR" id="LOG4PHP_DIR" class="answerInput"></td>
  	</tr>  	
    <tr>
      <td colspan="2" class="spaceRow">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="tb" align="right">
        <input type="button" class="button" name="Cancel" value="Cancel" onclick="window.history.go( -1 )">
        <input type="submit" class="button" name="Save" value="Save">
      </td>
    </tr>
  </table>
  </form>
HD;
}

/**
* Parses the .ini file to an associative array just to get the names of all the settings.
* Loops over this array and uses the keys to extract the pertinent data from the POST.
* Special case for checkboxes which do not get passed if they aren't checked.
* Writes the new settings back to the same .ini file and redirects to the main page.
*/
function save(){
  $cfg = readINIfile( 'configs/config.ini.php' );
  foreach( $cfg as $key => $val ){
    if( isset( $_POST[$key] ) )
      $cfg[$key] = $_POST[$key];
    else    //Unchecked checkboxes will not be present in the POST data.
      $cfg[$key] = 0;
  }
  if( !write_ini_file( 'configs/config.ini.php', $cfg ) )
    die( "The new settings could not be written to a file" );
    
  header( "Location: Crosswords.php?e=002" ); /* Redirect browser */
}

/**
* Custom parse_ini_file which does the same job as the PHP method, only I have modified the
* code slightly so that lines starting with white space will be ignored.
*/
function readINIfile( $filename, $commentchar = ";" ){
  $array1 = file( $filename );
  $section = '';
  foreach( $array1 as $filedata ){
    //$dataline = trim( $filedata );    //Altered this line so I could hide PHP code in lines started with a space!
    $dataline = $filedata;
    $fc = substr( $dataline, 0, 1 );
    if( $fc != $commentchar && $dataline != '' && $fc != ' ' && $fc != '<' && $fc != '?' && $fc != "\n" && $fc != "\r" ){
      //It's an entry (not a comment and not a blank line)
      if( $fc == '[' && substr( $dataline, -1, 1 ) == ']' ){
        //It's a section
        //$section = strtolower( substr( $dataline, 1, -1 ) );
      } else{
        //It's a key...
        $delimiter = strpos( $dataline, '=' );
        if( $delimiter > 0 ){
          //...with a value
          $key = trim( substr( $dataline, 0, $delimiter ) ) ;
          $value = trim( substr( $dataline, $delimiter + 1 ) );
          if( substr( $value, 0, 1 ) == '"' && substr( $value, -1, 1 ) == ';' ){
            $value = substr( $value, 1, -2 );
          }
          if( is_string( $value ) ) $value = (string) $value;
          else if( is_numeric( $value ) ) $value = (int) $value;
          $array2[$key] = str_replace( ';', '', stripcslashes( $value ) );
        } else{
          //...without a value
          $array2[trim( $dataline )] = '';
        }
      }
    } else{
      //It's a comment or blank line.  Ignore.
    }
  }
  return $array2;
}

/**
* Writes an array of key => value pairs to a file in .ini style.
* Semicolons are added at the end of each line as they are reserved for
* comments in ini files, therefore the resulting file may by used directly as
* a .php file or an .ini file.
*/
function write_ini_file( $path, $assoc_array ){
  $content = "<?php\n";
  $defines = "";
  foreach( $assoc_array as $key => $item ){
    if( is_array( $item ) ){
      $content .= "\n[{$key}]\n";
      foreach( $item as $key2 => $item2 ){
        if( is_numeric( $item2 ) || is_bool( $item2 ) )
          $content .= "{$key2} = {$item2};\n";
        else
          $content .= "{$key2} = \"{$item2}\";\n";
        $tmpVar = str_replace( '$', '', $key2 );
        $defines .= " if( !defined( '{$tmpVar}' ) ){\n  define('$tmpVar', '$item2');\n }";
      }        
    } else{
      if( is_numeric( $item ) || is_bool( $item ) )
        $content .= "{$key} = {$item};\n";
      else
        $content .= "{$key} = \"{$item}\";\n";
      $tmpVar = str_replace( '$', '', $key );
      $defines .= " if( !defined( '{$tmpVar}' ) ){\n  define('$tmpVar', '$item');\n }\n";
    }
  }
  $content .= $defines . "\n?>";
  if( !$handle = fopen( $path, 'w' ) ){
    return false;
  }
  if( !fwrite( $handle, $content ) ){
    return false;
  }
  fclose( $handle );
  return true;
}

?>