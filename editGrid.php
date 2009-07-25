<?php

include( 'Crossword.php' );

global $query;
session_start();
if( $query == "editGrid" )
  edit();
else if( $query == "updateGrid" )
  update();

session_write_close();  
  
  
function edit(){
  include( 'header.php' );
  
  $cwObj = $_SESSION[ "Crossword" ];
  if( empty( $cwObj ) ){
    $cwObj = new Crossword( $_GET['id'] );
  }
  
  echo <<<HD
    <br><form name="editGrid" id="editGrid" method="POST" action="Crosswords.php?q=updateGrid&id={$cwObj->getId()}">
    <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
      <tr>
        <th align="center" class="gen">Editing Crossword Grid</th>
      </tr>
      <tr>
      	<td class="catLeft">&nbsp;</td>
      </tr>
      <tr>
        <td class="row1"><script>drawCrossword( 15, 15 ); preset( '{$cwObj->getGrid()}' );</script></td>
      </tr>
      <tr>
        <td class="row2" align="center">
          <span class="gensmall">
            <b>Note:</b> If there is more than one crossword using this grid, any changes made will be
             saved as a new grid.<br>The current crossword will then be updated to use the new version.
          </span>
        </td>
  	  </tr>
      <tr>
        <td class="tb" align="right">
          <input type="HIDDEN" name="grid" id="grid" value="">
          <input type="button" class="button" name="Cancel" value="Cancel" onclick="window.history.go(-1)">
          <input type="submit" class="button" name="Update" value="Update" onclick="return checkCrossword();">
        </td>
      </tr>
    </table>
HD;

}

function update(){
  $cwObj = $_SESSION[ "Crossword" ];
  if( empty( $cwObj ) ){
    $cwObj = new Crossword( $_GET['id'] );
  }
  
  if( strcasecmp( $_POST['grid'], $cwObj->getGrid() ) != 0 ){
    $cwMData = $cwObj->getCrosswordData();
    $DBAccessObj = new DBAccess();
    $result = $DBAccessObj->queryDB( "SELECT COUNT( `gridId` ) FROM `cs_crossword` WHERE `gridId` = {$cwMData['gridId']}" );
    if( mysql_result( $result, 0, 0 ) == 1 ){
      //There is only one dependancy, overwrite safe.
      $DBAccessObj->queryDB( "UPDATE `cs_presets` SET `grid` = '{$_POST['grid']}' WHERE `id` = {$cwMData['gridId']}" );
    }
    else{
      //Other crosswords need this grid, save a new record and update this crossword's record.
      $DBAccessObj->queryDB( "INSERT INTO `cs_presets` ( grid ) VALUES ( '{$_POST['grid']}' )" );
      $cwMData['gridId'] = mysql_insert_id();
      $cwObj->setCrosswordData( $cwMData );
      $cwObj->persist();
    }
  }
  header( "Location: Crosswords.php" ); /* Redirect browser */
}
?>