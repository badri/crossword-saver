<?php

  global $query;
  if( $query == "help" ) showHelp();
  else header( "Location: Crosswords.php?e=001" );
  
  
  function showHelp(){
    echo <<<HD
    <br>
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen" colspan="2">CrosswordSaver Help</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle"></span></td>
        </tr>
      	<tr>
          <td class="row1" align="center"><span class="genmed">About CrosswordSaver:</span></td>
          <td class="row2" align="center">
            <div class="XPButtonUp" onmouseover="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );" onmouseout="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );">
              <a href="Crosswords.php?q=aboutCWS">About</a>
            </div>
          </td>
      	</tr>
      	<tr>
          <td class="row1" align="center"><span class="genmed">CrosswordSaver documentation:</span></td>
          <td class="row2" align="center">
            <div class="XPButtonUp" onmouseover="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );" onmouseout="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );">
              <a href="Crosswords.php?q=docs">Documentation</a>
            </div>
          </td>
      	</tr>
        <tr>
          <td class="spaceRow" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td class="tb" align="right" colspan="2">&nbsp;</td>
        </tr>
      </table>
    <br><br>
HD;
  }
  
?>