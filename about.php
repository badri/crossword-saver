<?php

  global $query;
  if( $query == "aboutCWS" ) about();
  else header( "Location: Crosswords.php?e=001" );
  
  
  function about(){
    echo <<<HD
    <br>
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen" colspan="2">About CrosswordSaver</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle"></span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              Started in 2005, CrosswordSaver was originally intended to run on my home PC (Windows, Apache, PHP, MySQL).
              The goal was simple; a web interface for archiving and playing crosswords. Prior to this, I would do the daily
              <a href="http://www.ireland.com">Irish Times Crossword</a>. Before long however, this became a subscription
              service and they did not maintain an archive of past crosswords. We always had the print edition of The Irish
              Times at home, so I decided to come up with a process for quickly tranferring the crossword from the paper to
              CrosswordSaver. Later on I added the ability to export crosswords in XML format to make them portable.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="spaceRow" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td class="tb" align="right" colspan="2">&nbsp;</td>
        </tr>
      </table>
HD;
  }
  
?>