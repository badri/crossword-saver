<?php

include( 'Crossword.php' );

global $query;
if( $query == "editCS" ) edit();
else if( $query == "updateCS" ) update();

function edit(){  
  $id = $_GET["id"];
  $cwObj = new Crossword( $id );

  session_start();
  $_SESSION["Crossword"] = $cwObj;
  session_write_close();

  include 'header.php';
  
  $cwMData = $cwObj->getCrosswordData();
  $clues = $cwObj->getClues();
  $grid = $cwObj->getGrid();

  echo <<<HD
  <br><br>
  <form action="Crosswords.php?q=updateCS" method="POST">
    <table align="center" width="1100" cellspacing="1" cellpadding="0" class="forumline">
      <tr>
        <th class="gen" colspan="4" align="center">Editing Crossword</th>
      </tr>
      <tr>
        <td class="catLeft" colspan="2"><span class="cattitle">Across</span></td>
        <td class="catRight" colspan="2"><span class="cattitle">Down</span></td>
      </tr>
      <tr>\n
HD;

  $loop = 0;
  $complete = ( $cwMData["complete"] == 'Y' ) ? 'CHECKED' : 'UNCHECKED';
  $styleClass = (CONCEAL_ANS) ? "concealInput" : "answerInput";
  $needles = array( 'A', 'D' );
  foreach( $clues as $row ){
    $num = str_replace( $needles, '', $row['code'] );
    $row['clue'] = htmlspecialchars( $row['clue'] );
    echo <<<HD
        <td class="row1">
          <input type="TEXT" name="{$loop}" value="{$num}" class="numberInput"><input type="TEXT" name="{$row["code"]}" value="{$row["clue"]}" class="clueInput" onblur="detectChange( this )">
          <input type="HIDDEN" id="h_{$row["code"]}" value="{$row["clue"]}">
        </td>
        <td class="gensmall" align="center">
          <input type="TEXT" name="{$row["code"]}A" value="{$row["answer"]}" class="{$styleClass}" onblur="detectChange( this )">
          <input type="HIDDEN" id="h_{$row["code"]}A" value="{$row["answer"]}">
        </td>\n
HD;
    $loop++;
    if( $loop % 2 == 0 )
      echo "    </tr>\n    <tr>\n";
  }

  $dateAdded = $cwMData['dateAdded'];
  echo <<<HD
      </tr>
      <tr>
        <td colspan="2" rowspan="3" class="row2">
          <br><script>drawMiniCrossword( '{$grid}' );</script>
          <div align="center"><a href="Crosswords.php?q=editGrid&id={$id}">[Edit Grid]</a></div>
        </td>
        <td class="row2"><span class="genmed">Complete crossword:</span></td>
        <td class="row2"><input type="checkbox" name="complete" {$complete} class="answerInput"></td>
      </tr>
      <tr>
        <td class="row2"><span class="genmed">User:</span></td>
        <td class="row2"><input type="text" name="user" value="{$cwMData["user"]}" class="answerInput"></td>
      </tr>
      <tr>
        <td class="row2"><span class="genmed">Date added:</span></td>
        <td class="row2"><input type="text" name="dateAdded" value="{$dateAdded}" READONLY class="answerInput" id="dateAdded"></td>
      </tr>
      <tr>
        <td colspan="4" class="spaceRow">&nbsp;</td>
      </tr>
        <tr>
        <td colspan="4" class="tb" align="right">
          <input type="HIDDEN" name="id" value="{$id}">
          <input type="HIDDEN" name="grid" value="{$grid}">
          <input type="HIDDEN" name="dateAdded" value="{$dateAdded}">
          <input type="BUTTON" name="Cancel" value="Cancel" onclick="window.history.go(-1)" class="button">
          <input type="SUBMIT" name="Submit" value="Save Changes" class="button">
        </td>
      </tr>
    </table>
  </form>
HD;
}


/**
* Fetches the Crossword object out of the session and updates it with any changes present in
* the POST data. Then calls the persist() method on the object.
*
*/
function update(){
  session_start();
  $cwObj = $_SESSION["Crossword"];
  session_write_close();

  if( !$cwObj ){
    $cwObj = new Crossword( $_POST['id'] );
  }
  $cwMData = $cwObj->getCrosswordData();
  $clues = $cwObj->getClues();
  
  //Update the crossword object.  
  while( list( $key, $val ) = each( $clues ) ){
    $clues[$key]["clue"] = $_POST[$val["code"]];
    $clues[$key]["answer"] = $_POST[$val["code"]."A"];
  }
  if( $clues != $cwObj->getClues() )//Only update if there is new/different data.
    $cwObj->setClues( $clues );

  $cwMData["user"] = $_POST["user"];
  $cwMData["complete"] = isset( $_POST["complete"] ) ? "Y" : "N";
  //NB: No updating of the dateAdded value.
  if( $cwMData != $cwObj->getCrosswordData() )//Only update if there is new/different data.
    $cwObj->setCrosswordData( $cwMData );
  
  $cwObj->persist();
  
  header( "Location: Crosswords.php?e=003" ); /* Redirect browser */
}

?>