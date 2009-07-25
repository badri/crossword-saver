<?php

  global $query;
  if( $query == "addNew" ) add();
  else header( "Location: Crosswords.php?e=001" );
  
  
  function add(){
    echo <<<HD
    <br>
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen" colspan="2">Select the source type of your new crossword</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle"></span></td>
        </tr>
      	<tr>
          <td class="row1" align="center"><span class="genmed">Create a new crossword from a CrosswordSaver XML file:</span></td>
          <td class="row2" align="center">
            <div class="XPButtonUp" onmouseover="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );" onmouseout="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );">
              <a href="Crosswords.php?q=addX">XML</a>
            </div>
          </td>
      	</tr>
      	<tr>
          <td class="row1" align="center"><span class="genmed">Create a new crossword from a Java Applet html &lt;applet&gt; tag:</span></td>
          <td class="row2" align="center">
            <div class="XPButtonUp" onmouseover="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );" onmouseout="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );">
              <a href="Crosswords.php?q=addW">Website</a>
            </div>
          </td>
      	</tr>
      	<tr>
          <td class="row1" align="center"><span class="genmed">Create a new crossword from a printed crossword, e.g. newspaper, magazine:</span></td>
          <td class="row2" align="center">
            <div class="XPButtonUp" onmouseover="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );" onmouseout="this.className = genericSwap( 'className', 'XPButtonUp', 'XPButtonDown', event );">
              <a href="Crosswords.php?q=addP">Newspaper</a>
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