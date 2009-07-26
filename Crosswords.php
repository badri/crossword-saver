<?php

  require_once( 'database.php' );
  $DBAccess = null;

  $query = $_GET["q"];
  switch( $query ){
      case "addW":
        addCrosswordWeb();
        break;
      case "addP":
        addCrosswordPaper();
        break;
      case "addX":
        addCrosswordXML();
        break;
      case "parseWeb":
        parseAppletTag();
        break;
      case "parsePaper":
        parsePaper();
        break;
      case "parseXML":
        parseXML();
        break;
      case "save":
        saveCrossword();
        break;
      case "toXML":
        exportToXML();
        break;
      case "deleteCS":
        deleteCrossword();
        break;
      case "editCS":
        editCrossword( $_GET["id"] );
        break;
      case "updateCS":
        updateCrossword();
        break;
      case "editGrid":
        editGrid( $_GET["id"] );
        break;
      case "updateGrid":
        updateGrid( $_GET["id"] );
        break;
      case "editSettings":
        editSettings();
        break;
      case "saveSettings":
        saveSettings();
        break;
      case "addNew":
        addNew();
        break;
      case "help":
        help();
        break;
      case "aboutCWS":
        aboutCWS();
        break;
      case "docs":
        docs();
        break;
      default:
        playCrossword( $_GET["id"] );
  }

  
  
  /**
  * Add a new crossword from the web.
  */
  function addCrosswordWeb(){
    include 'header.php';
    include 'addCrosswordWeb.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Parse the information in the applet tag.
  * This function will only work with the ireland.com crosswords.
  */
  function parseAppletTag(){
    include 'header.php';
    include 'addCrosswordWeb.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Add a new crossword from the paper.
  */
  function addCrosswordPaper(){
    include 'header.php';
    include 'addCrosswordPaper.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Parses the input from a manually entered crossword.
  */
  function parsePaper(){
    include 'header.php';
    include 'addCrosswordPaper.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Add a new crossword from an XML document.
  */
  function addCrosswordXML(){
    include 'header.php';
    include 'addCrosswordXML.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Parses an XML tree for crossword data.
  * This function currently only works with crosswordsaver XML docs of schemeVer 1.0.
  */
  function parseXML(){
    include 'header.php';
  	include 'addCrosswordXML.php';
  	include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////

  /**
  * Displays a page with all of the options for adding a new crossword.
  */
  function addNew(){
    include 'header.php';
    include 'addNewCrossword.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////

  /**
  * Displays an initial help page for the user with further options to select from.
  */
  function help(){
    include 'header.php';
    include 'help.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Displays a page explaining some info about CrosswordSaver.
  */
  function aboutCWS(){
    include 'header.php';
    include 'about.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Displays the CrosswordSaver Documentation.
  */
  function docs(){
    include 'header.php';
    include 'docs.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Responsible for saving an entire crossword
  * Step 1: Check if the inputted grid is already in the cs_preset table. If not, insert it and get the insert id. If so, get the id of the containing record.
  * Step 2: Insert into the cs_crossword table, using the insert id from step 1 to link cs_crossword.gridId->cs_preset.id. Get the insert id of this insert.
  * Step 3: Using the insert id from step 2, insert into the cs_clues table. Link cs_clues->cs_crossword.id.
  *
  * Redirect to the select a crossword page.
  *
  */
  function saveCrossword(){
    $DBAccess = new DBAccess();
    $id = 0; $dateAdded = $_POST["dateAdded"];
    $resultGrid = $DBAccess->queryDB( "SELECT * FROM `cs_presets` WHERE `grid` = '" . $_POST["Grid"] . "'" );
    if( mysql_num_rows( $resultGrid ) == 0 ){
      $resultGrid = $DBAccess->queryDB( "INSERT INTO `cs_presets` ( grid ) VALUES ( '" . $_POST["Grid"] . "' )" );
      $id = mysql_insert_id();
    }
    else{
      $row = mysql_fetch_assoc( $resultGrid );
      $id = $row["id"];
    }

    $complete = ( $_POST['complete'] ) ? 'Y' : 'N';
    $result = $DBAccess->queryDB( "INSERT INTO `cs_crossword` ( gridId, complete, dateAdded, user ) VALUES ( '$id', '$complete', '$dateAdded', 'user' )" );
    $id = mysql_insert_id();
    while( list( $key, $val) = each( $_POST ) ){
      if( ereg( "^[0-9]{1,2}(D|A)$", $key ) ){
        $ans = addslashes( $_POST[$key."A"] );
        $sq = (int)$_POST[$key."S"];
        $DBAccess->queryDB( "INSERT INTO `cs_clues` ( crosswordId, clue, answer, code, square) VALUES ( '$id', '$val', '$ans', '$key', '$sq' )" );
      }
    }
    
    print( "<script>window.location = 'http://{$_SERVER["HTTP_HOST"]}{$_SERVER["PHP_SELF"]}';</script>" );
  }
  ////////////////////////////////////////////////////////////////////////////////////

  
  /**
  * Saves updated/changed data for a crossword.
  */
  function updateCrossword(){
    //include 'header.php';
    include 'editCrossword.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  
  /**
  * Builds an XML document encapsulating the selected crosswords and all associated data.
  * The user can then save the file to their computer.
  */
  function exportToXML(){
    $checkboxes = findCheckboxes();
  	include 'exportToXML.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  
  /**
  * Deletes a crossword and all associated data. This includes: cs_crossword x 1 record, cs_clues x multiple records.
  * Note: There may be a record in cs_presets which is no longer used by any crossword but we must leave it there.
  */
  function deleteCrossword(){
  	global $DBAccess; $DBAccess = new DBAccess();
  	$cbs = findCheckboxes();
  	while( list( $key, $val ) = each( $cbs ) ){
  	  $DBAccess->queryDB( "DELETE FROM `cs_crossword` WHERE `id` = '$val'" );
  	  $DBAccess->queryDB( "DELETE FROM `cs_clues` WHERE `crosswordId` = '$val'" );
  	}
  	header( "Location: Crosswords.php?e=004" );
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  *
  *
  * @param String id The id of the crossword to be edited.
  */
  function editCrossword( $id ){
    //include 'header.php';
    include 'editCrossword.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  *
  *
  * @param String id The id of the crossword whose grid will be edited.
  */
  function editGrid( $id ){
    //include 'header.php';
    include 'editGrid.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  *
  *
  * @param String id The id of the crossword whose grid will be updated.
  */
  function updateGrid( $id ){
    //include 'header.php';
    include 'editGrid.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////

  /**
  * Displays a list of the application settings for the user to modify.
  */
  function editSettings(){
    include 'header.php';
    include 'settings.php';
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Saves all application settings to the config file.
  */
  function saveSettings(){
    //include 'header.php';
    include 'settings.php';
    //include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  *
  *
  *
  *
  * @return void
  * @param id
  * @desc Enter description here...
  */
  function playCrossword( $id ){
    include 'header.php';
    global $DBAccess;
    $DBAccess = new DBAccess();

    //If a selection has been made, execute this code.
    if( $id ){
      $result = $DBAccess->queryDB( "SELECT PRE.grid FROM `cs_presets` AS PRE LEFT JOIN `cs_crossword` AS CS ON CS.gridID = PRE.id WHERE CS.id = '$id'" );
      $row = mysql_fetch_array( $result );
      echo <<<HD
      <br><br><br>
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen">Solving Crossword #{$id}</th>
        </tr>
        <tr>
      	  <td class="catLeft">&nbsp;</td>
        </tr>
        <tr>
          <td class="row1" align="center">
          <APPLET CODE="Crossword.class" codebase="java/" MAYSCRIPT HEIGHT="436" WIDTH="611" name="crossword">
            <param name="Grid" value="{$row["grid"]}">\n
HD;

      $result = $DBAccess->queryDB( "SELECT * FROM `cs_clues` WHERE `crosswordId` = $id" );
      while( $row = mysql_fetch_assoc( $result ) ){
        $escClue = str_replace( "\"", "", $row["clue"] ); //Added to help with double quotes in clues
        print( "            <param name=\"{$row["code"]}\" value=\"{$escClue}\"> <param name=\"{$row["code"]}A\" value=\"{$row["answer"]}\">\n" );
      }

      echo <<<HD
            <param name="AdvertGif" value="http://127.0.0.1/JLs/img/crossword.gif"/>
            <param name="AdvertClick" value="http://127.0.0.1/JLs/"/>
          </APPLET>
        </td>
      </tr>
      <tr>
        <td class="row2" align="center"><span class="gensmall">Crossword Saver</span></td>
  	  </tr>
  	</table>
HD;
    }
    //Execute this code to give the user a choice of crosswords to play.
    else{
      $myCount = 1;
      echo <<<HD
        <br><form name="chooseCW" id="chooseCW" method="POST" action="Crosswords.php">
        <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
          <tr>
            <th align="center" colspan="3" class="gen">Select A Crossword To Play</th>
            <th align="center" colspan="3" class="gen">Options</th>
          </tr>
          <tr>
          	<td class="catLeft" colspan="3"><span class="cattitle">Complete Crosswords</span></td>
			<td class="catRight" colspan="3">&nbsp;</td>
          </tr>
HD;

      $result = $DBAccess->queryDB( "SELECT * FROM `cs_crossword` WHERE `complete` = 'Y'" );
      if( mysql_num_rows( $result ) > 0 ){
        while( $row = mysql_fetch_assoc( $result ) ){
          printRow( $row, $myCount );
		  $myCount++;
        }
      echo <<<HD
        <tr>
          <td colspan="6" class="spaceRow" align="right"><img src="img/SelectAllNone.gif" onclick="selectCheckBoxes( 1, {$myCount} )" class="selectAllImg"></td>
        </tr>
HD;
      }
      else{
      	echo "<tr><td class=\"row1\" colspan=\"6\"><span class=\"genmed\">No complete crosswords.</span></td></tr>";
      }
      
      echo <<<HD
          <tr>
          	<td class="catLeft" colspan="3"><span class="cattitle">Incomplete Crosswords</span></td>
			<td class="catRight" colspan="3">&nbsp;</td>
          </tr>      
HD;

      $result = $DBAccess->queryDB( "SELECT * FROM `cs_crossword` WHERE `complete` = 'N'" );
      if( mysql_num_rows( $result ) > 0 ){
        $prevCount = $myCount;
        while( $row = mysql_fetch_assoc( $result ) ){
          printRow( $row, $myCount );
		  $myCount++;
        }
      echo <<<HD
        <tr>
          <td colspan="6" class="spaceRow" align="right"><img src="img/SelectAllNone.gif" onclick="selectCheckBoxes( {$prevCount}, {$myCount} )" class="selectAllImg"></td>
        </tr>
HD;
      }
      else{
      	echo "<tr><td class=\"row1\" colspan=\"6\"><span class=\"genmed\">No incomplete crosswords.</span></td></tr>";
      }
      
      echo <<<HD
        <tr>
          <td colspan="6" class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6" class="tb" align="right">
            <input type="button" class="button" name="Delete" value="Delete" onclick="checkboxAction( 'chooseCW', '?q=deleteCS', 'Are you sure you want to completely delete this crossword(s)?' )">
            <input type="button" class="button" name="ExportToXML" value="Export to XML" onclick="checkboxAction( 'chooseCW', '?q=toXML', '' )">
          </td>
        </tr>
      </table>
      </form>
      <br><br>
HD;
    }
    include 'footer.php';
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  /**
  * Helper function which prints out one row in a table for the "Select a crossword to play" page.
  *
  * @param $row		An associative array of one row in the result set taken from the cs_crossword table.
  */
  function printRow( $row, $counter ){
  	global $DBAccess;
    $query = "SELECT `clue` FROM `cs_clues` WHERE `crosswordId` = " . "'" . $row["id"] . "' ORDER BY `id` ASC LIMIT 0, 6";
    $result2 = $DBAccess->queryDB( $query );
    $clue1 = mysql_fetch_row( $result2 ); $clue2 = mysql_fetch_row( $result2 );
    $moreTitle = "";
    while( $clueRow = mysql_fetch_row( $result2 ) ){
      $moreTitle .= $clueRow[0] . " ";
    }
  	echo <<<HD
  	<tr>
      <td class="row1" align="center"><span class="genmed"><a href="Crosswords.php?q=play&id={$row["id"]}"><img src="img/CrosswordIcon.gif" border="0" alt="[Play]" title="[Play]"></a>&nbsp;<a href="Crosswords.php?q=play&id={$row["id"]}"><b>{$counter}</b></a></span></td>
      <td class="row1"><span class="genmed">{$clue1[0]}</span></td>
      <td class="row1" colspan="2"><span class="genmed">{$clue2[0]}</span><span class="genbig" title="{$moreTitle}" style="cursor: help;">...</span></td>
      <td class="row2" align="center"><span class="gensmall"><a href="Crosswords.php?q=editCS&id={$row["id"]}">Edit</a></span></td>
      <td class="row2" align="center"><input type="checkbox" value="{$row["id"]}" name="cb{$counter}" id="cb{$counter}"></td>
  	</tr>
HD;
  }
  ////////////////////////////////////////////////////////////////////////////////////
  
  
  /**
  * Finds the ticked check boxes, puts their values into an array and returns it.
  *
  * @return Array   Containing all of the values of the check boxes that were ticked.
  */
  function findCheckboxes(){
    $checkboxes = array();
    while( list( $key, $val ) = each( $_POST ) ){
  	  if( ereg( "^cb", $key ) )
  	    array_push( $checkboxes, $val );
    }
    return $checkboxes;
  }
  
?>