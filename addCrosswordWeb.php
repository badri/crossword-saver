<?php

  global $query;
  if( $query == "addW" ) add();
  else if( $query == "parseWeb" ) parse();
  else header( "Location: Crosswords.php?e=001" );
  
  
  function add(){
    echo <<<HD
    <br>
    <form action="Crosswords.php?q=parseWeb" method="POST" name="AppletEntry" onsubmit="return( !( this.html.value == '' || this.html.value == 'No Applet code was found!' ) );">
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen">Enter the HTML source from the crossword page here</th>
        </tr>
        <tr>
          <td class="catLeft"><span class="cattitle"></span></td>
        </tr>
      	<tr>
          <td class="row1" align="center">
            <TEXTAREA name="html" rows="35" cols="120" style="scroll: true"></TEXTAREA>
          </td>
      	</tr>
        <tr>
          <td class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td class="tb" align="right">
            <input type="BUTTON" name="Paste" value="Paste" class="button" onClick="parseApplet( document.forms['AppletEntry'].html )">
            <input type="SUBMIT" name="Submit" value="Submit" class="button">
            <input type="RESET" name="Clear" value="Clear" class="button">
          </td>
        </tr>
      </table>
    </form>
    <br><br>
    <script>if( document.all ) document.forms.AppletEntry.html.attachEvent( "onpaste", parseApplet );</script>
HD;
  }
  
  
  
  
  function parse(){
    $tag = $_POST["html"];
    $tagData = ereg_replace( "\n\r\t|<applet|<param name|value|=|\"", "", stripslashes( $tag ) );
    $clues = getGCA( $tagData, "^[0-9]{1,2}(D|A)$" );
    $ansrs = getGCA( $tagData, "^[0-9]{1,2}(DA|AA)$" );
    $grid = getGCA( $tagData, "^(Grid)" );

    echo <<<HD
    <br><br>
    <form action="Crosswords.php?q=save" method="POST">
      <table align="center" width="1100" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" colspan="4" class="thTop">Review clues before proceeding</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="4"><span class="cattitle"></span></td>
        </tr>
        <tr>\n
HD;

    $loop = 0; $needles = array( 'A', 'D' );
    $styleClass = (CONCEAL_ANS) ? "concealInput" : "answerInput";
    while( list( $key, $val ) = each( $clues ) ){
      $ans = decode( $ansrs[$key."A"] );
      $num = str_replace( $needles, '', $key );
      echo <<<HD
          <td class="row2">
            <input type="TEXT" name="{$loop}" value="{$num}" class="numberInput"><input type="TEXT" name="{$key}" value="{$val}" class="clueInput">
          </td>
          <td class="gensmall" align="center">
            <input type="TEXT" name="{$key}A" value="{$ans}" class="{$styleClass}">
          </td>\n
HD;
    $loop++;
    if( $loop % 2 == 0 )
      echo "        </tr>\n        <tr>\n";
    }

    $dateAdded = date( "Y-m-d H:i:s" );
    echo <<<HD
        </tr>
        <tr>
          <td colspan="4" class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="tb" align="right">
            <input type="HIDDEN" name="dateAdded" value="{$dateAdded}">
            <input type="HIDDEN" name="Grid" value="{$grid["Grid"]}">
            <input type="BUTTON" name="Back" value="Back" onClick="window.history.go(-1)" class="button">
            <input type="SUBMIT" name="Submit" value="Submit" class="button">
          </td>
        </tr>
      </table>
    </form>
    <br><br>
HD;
  }
  
  /**
  * Retrieves substrings from the input $str string based on matches to the input regex $opt.
  *
  * @param String $str  An Applet tag and its contents.
  * @param String $opt  A regex of the info to be extracted.
  * @return Array $arr  An array containing matches to $opt.
  */
  function getGCA( $str, $opt ){
    $params = explode( ">", $str );
    $len = count( $params );
    $arr = array();
    for( $i = 0; $i < $len; $i++ ){
      $temp = explode( " ", ereg_replace( "  ", " ", trim( $params[$i] ) ) );
      if( ereg( $opt, $temp[0] ) ){
        $value = "";
        for( $j = 1; $j < count( $temp ); $j++ ){
          $value = $value . " " . $temp[$j];
        }
        $arr[$temp[0]] = trim( $value );
      }
    }
    return $arr;
  }

  function decode( $rev ){
    $str = strrev( $rev ); $strRet = "";
    for( $i = 1; $i < strlen( $str ) + 1; $i++ ){
      $asci = ord( $str[$i - 1] );
      $strRet = $strRet . chr( ( ( ( $asci - 65 - pow( $i, 3 ) - 3 * pow( $i, 2 ) - 3 * $i - 1 ) + 1352 ) % 26 ) + 65 );
    }
    return $strRet;
  }

?>