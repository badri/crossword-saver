<?php

  global $query;
  if( $query == "addP" ) add();
  else if( $query == "parsePaper" ) parse();
  else header( "Location: Crosswords.php?e=001" );

  function add(){
    global $DBAccess; $DBAccess = new DBAccess();
    $result = $DBAccess->queryDB( "SELECT `grid` FROM `cs_presets`" );
    echo <<<HD
    <br>
    <form action="Crosswords.php?q=parsePaper" method="POST" name="PaperEntry">
      <table align="center" width="1100" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" colspan="2" class="gen">Input The Crossword Grid And Text</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle"></span></td>
        </tr>
        <tr>
          <td width="50%" class="row1"><script>drawCrossword( 15, 15 );</script></td>
          <td width="50%" class="row1" align="center"><div id="CABoxes"></div></td>
        </tr>
        <tr>
          <td align="center" class="row2" colspan="2">
            
		    <!-- scrollings layer here -->
		    <div id="hold">
		      <div id="wn">
			    <div id="lyr1" class="content">
			      <table id="t1">
			        <tr>
HD;
				      while( $row = mysql_fetch_array( $result ) )
				        echo "<td><script>drawMiniCrossword( '$row[grid]' );</script></td>\n";

                    echo <<<HD2
                    </tr>
                  </table>
                </div>
              </div>  <!-- end wn div -->
              <div id="scrollbar">
                <div id="left"><a href="javascript:;" onclick="return false" onmouseover="dw_scrollObj.initScroll('wn','left')" onmouseout="dw_scrollObj.stopScroll('wn')" onmousedown="dw_scrollObj.doubleSpeed('wn')" onmouseup="dw_scrollObj.resetSpeed('wn')"><img src="img/btn-lft.gif" width="11" height="11" alt="" /></a></div>
                  <div id="track">
                    <div id="dragBar"></div>
                  </div>
                <div id="right"><a href="javascript:;" onclick="return false" onmouseover="dw_scrollObj.initScroll('wn','right')" onmouseout="dw_scrollObj.stopScroll('wn')" onmousedown="dw_scrollObj.doubleSpeed('wn')" onmouseup="dw_scrollObj.resetSpeed('wn')"><img src="img/btn-rt.gif" width="11" height="11" alt="" /></a></div>
              </div>
            </div>	<!-- end hold div -->

          </td>
        </tr>
        <tr>
          <td colspan="2" class="spaceRow">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="tb" align="right">
            <input type="HIDDEN" name="grid" id="grid" value="">
            <input type="BUTTON" name="Back" value="Back" onClick="window.history.go(-1)" class="button">
            <input type="SUBMIT" name="Submit" value="Submit" onClick="return checkPaper()" class="button">
          </td>
        </tr>
      </table>
    </form>
HD2;
  }
  
  /**
   * This function is responsible for gathering all of the data input from the user for a crossword.
   * All data will be present in the $_POST array and can be accessed using the following keys:
   * Clue number:   Use a key in the format: [1-9]{1|2}_[A,D]#
   * Clue:          Use a key in the format: [1-9]{1|2}_[A,D]   or $clueNum . '_A'  or $clueNum . '_D'
   * Answer:        Use a key in the format: [1-9]{1|2}_[A,D]A  or $clueNum . '_AA' or $clueNum . '_DA'
   * Answer Length: Use a key in the format: [1-9]{1|2}_[A,D]_  or $clueNum . '_A_' or $clueNum . '_D_'
   * Grid:          Use $_POST['grid']
   */
  function parse(){
    $grid = $_POST['grid'];
    $across = $down = array();
    while( list( $key, $val ) = each( $_POST ) ){
      if( ereg( "_A#", $key ) ){        //Across clue.
        $clueNum = $val;
        $temp = array( $clueNum, ucfirst( $_POST[$clueNum . '_A'] ), strtoupper( $_POST[$clueNum . '_AA'] ), $_POST[$clueNum . '_A_N']);
        array_push( $across, $temp );
      }
      elseif( ereg( "_D#", $key ) ){    //Down clue.
        $clueNum = $val;
        $temp = array( $clueNum, $_POST[$clueNum . '_D'], $_POST[$clueNum . '_DA'], $_POST[$clueNum . '_D_N']);
        array_push( $down, $temp );        
      }
    }
    
    echo <<<HD
      <Br><Br>
    <form action="Crosswords.php?q=save" method="POST">
      <table align="center" width="1100" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th class="thTop" colspan="4" align="center">Review clues before proceeding</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="4"><span class="cattitle"></span></td>
        </tr>\n
HD;
    $complete = 'CHECKED';
    
    for( $i = 0; $i < max( count( $across ), count( $down ) ); $i++ ){
      list( $keyA, $valA) = each( $across );
      list( $keyD, $valD) = each( $down );
      
      if( $complete == 'CHECKED' ){
        if( $i < count( $across ) && ( strrpos( $valA[2], '_' ) || strlen( $valA[2] ) == 0 ) ){
          $complete = 'UNCHECKED';
        }
        elseif( $i < count( $down ) && ( strrpos( $valD[2], '_' ) || strlen( $valD[2] ) == 0 ) ){
          $complete = 'UNCHECKED';
        }
      }
      
  echo "<tr>";
    echo  "<td class=\"row1\">";
      if( $valA != null ){
      echo  "<input type=\"TEXT\" name=\"{$valA[0]}\" value=\"{$valA[0]}\" class=\"numberInput\">";
      echo  "<input type=\"TEXT\" name=\"{$valA[0]}A\" value=\"{$valA[1]}\" class=\"clueInput\">";
      echo "<p> {$valA[3]} </p>";
      }
      else
      echo  "&nbsp;";
    echo  "</td>";
    echo  "<td class=\"gensmall\" align=\"center\">";
      if( $valA != null )
      echo  "<input type=\"TEXT\" name=\"{$valA[0]}AA\" value=\"{$valA[2]}\" class=\"answerInput\">";
      else
      echo "&nbsp;";
    echo  "</td>\n";
    echo  "<td class=\"row1\">";
      if( $valD != null ){
      echo  "<input type=\"TEXT\" name=\"{$valD[0]}\" value=\"{$valD[0]}\" class=\"numberInput\">";
      echo  "<input type=\"TEXT\" name=\"{$valD[0]}D\" value=\"{$valD[1]}\" class=\"clueInput\">";
      echo "<p> {$valD[3]} </p>";
      }
      else
      echo "&nbsp;";
    echo  "</td>";
    echo  "<td class=\"gensmall\" align=\"center\">";
      if( $valD != null )
      echo  "<input type=\"TEXT\" name=\"{$valD[0]}DA\" value=\"{$valD[2]}\" class=\"answerInput\">";
      else
      echo "&nbsp;";
    echo  "</td>";
  echo  "</tr>\n";
    }

    $dateAdded = date( "Y-m-d H:i:s" );
    echo <<<HD
        <tr>
          <td colspan="2" rowspan="3" class="row2"><br><script>drawMiniCrossword( '{$grid}' );</script></td>
          <td class="row2"><span class="genmed">Complete crossword:</span></td>
          <td class="row2"><input type="checkbox" name="complete" {$complete} class="answerInput"></td>
        </tr>
        <tr>
          <td class="row2"><span class="genmed">User:</span></td>
          <td class="row2"><input type="text" name="user" value="" class="answerInput"></td>
        </tr>
        <tr>
          <td class="row2"><span class="genmed">Date added:</span></td>
          <td class="row2"><input type="text" name="dateAdded" value="{$dateAdded}" READONLY class="answerInput" id="dateAdded"></td>
        </tr>
        <tr>
          <td colspan="4" class="tb" align="right">
            <input type="HIDDEN" name="Grid" value="{$grid}">
            <input type="BUTTON" name="Back" value="Back" onClick="window.history.go(-1)" class="button">
            <input type="SUBMIT" name="Submit" value="Submit" class="button">
          </td>
        </tr>
      </table>
    </form>
HD;
  }

?>