<?php

  global $query;
  if( $query == "docs" ) showDocs();
  else header( "Location: Crosswords.php?e=001" );
  
  
  function showDocs(){
    echo <<<HD
    <br>
      <table align="center" width="900" cellspacing="1" cellpadding="0" class="forumline">
        <tr>
          <th align="center" class="gen" colspan="2">CrosswordSaver Documentation</th>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">1. Requirements</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left"><span class="genmed">HTTP Server</span></td>
          <td class="row2" align="center">
            <span class="genmed">
              <a href="http://httpd.apache.org/">Apache</a> /
              <a href="http://www.microsoft.com/iis">IIS</a> /
              <a href="http://www.w3.org/Jigsaw/">Jigsaw</a> /
              <a href="http://www.lighttpd.net/">LightTPD</a>
            </span>
          </td>
        </tr>
        <tr>
          <td class="row1" align="left"><span class="genmed">PHP [4.x + mysql]</span></td>
          <td class="row2" align="center"><span class="genmed"><a href="http://www.php.net">PHP Runtime</a></span></td>
        </tr>
        <tr>
          <td class="row1" align="left"><span class="genmed">MySQL [4.0+]</span></td>
          <td class="row2" align="center"><span class="genmed"><a href="http://dev.mysql.com/downloads/">MySQL Server</a></span></td>
        </tr>
        <tr>
          <td class="row1" align="left"><span class="genmed">Log4PHP [0.9+][Optional]</span></td>
          <td class="row2" align="center"><span class="genmed"><a href="http://logging.apache.org/log4php/">Log4PHP</a></span></td>
        </tr>
        <tr>
          <td class="row1" align="left"><span class="genmed">Java Runtime Environment [1.4.2+]</span></td>
          <td class="row2" align="center"><span class="genmed"><a href="http://java.sun.com/javase/downloads/index.jsp">Java Runtime</a></span></td>
        </tr>
        <tr>
          <td class="row1" align="left"><span class="genmed">JavaScript enabled browser</span></td>
          <td class="row2" align="center">
            <span class="genmed">
              <a href="http://www.microsoft.com/downloads/">Internet Explorer</a> /
              <a href="http://www.mozilla.org">Firefox</a> /
              <a href="http://www.opera.com">Opera</a> /
              <a href="http://browser.netscape.com/">Netscape</a>
            </span>
          </td>
        </tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">2. Installation</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              If you do not have AMP (Apache/MySQL/PHP) installed, take a look at this <a href="#" onclick="alert('Comming Soon');">guide</a>.
              If you already have the correct environment up and running, then you just need to unzip CrosswordSaver into your web root folder. 
              You will have configured some folder for use as the root when installing your web server.<br><br>
              Next you need to create the MySQL database. There is an SQL script included in the zip file called "sql.txt".
              Run this script on your MySQL server to create the database and tables. Finally, you need to create the following
              user: <b>cws</b>, password: <b>cws</b>. You also need to grant SELECT, INSERT, UPDATE and DELETE privileges to user
              <b>cws</b> on the 'crosswordsaver' database.<br><br>
              CrosswordSaver should now be fully installed and ready to use. If you have any problems, please contact me through
              the CrosswordSaver project page.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">3. Creating Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              There are currently three principle ways to add a new crossword to the CrosswordSaver system; from a newspaper, 
              from an &lt;applet&gt; tag or from an XML file.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2" style="padding-left: 20px;"><span class="cattitle">3.1 Newspaper Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2" style="padding-left: 25px;">
            <span class="genmed">
              Select <span class="quote">Crosswords -&gt; Add New... -&gt; ...from Newspaper</span>, from the navigation menu.<br><br>
              Firstly, you will need to configure the crossword grid as it is in the newspaper. If you have added any crosswords to
              CrosswordSaver, then these grids will be displayed underneath the main grid for you to browse through. If the grid you 
              are looking for is displayed there, then you can click on it to copy the pattern up to the main grid. If you do not 
              see the grid you are looking for, you will need to manually enter it by toggling each square on the main grid. You 
              will only need to do this once however, as CrosswordSaver will display this new grid as a preset next time.<br><br>
              As you modify the main crossword grid, the area to the right is dynamically updated with the correct number of 
              text fields for you to enter the clues and answers. You will notice that the answer length is also generated and 
              inserted (in brackets) in the clue field. You should type each clue such that the answer length appears at the end. 
              E.g. <span class="quote">This is a clue with answer length five (5)</span>. If you don't have all of the answers to 
              the clues, you can still add the crossword and edit it later to update any missing answers. Click <span class="quote">
              Submit</span> to continue.<br><br>
              On the next page, you will be presented with a full list of all of the data associated with the new crossword. Check the 
              data before clicking <span class="quote">Submit</span> to commit the crossword to the database. You will now be able to 
              play this crossword from the <a href="Crosswords.php?q=play">Crosswords</a> page.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2" style="padding-left: 20px;"><span class="cattitle">3.2 Website Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="justify" colspan="2" style="padding-left: 25px;">
            <span class="genmed" style="text-align: justify;">
              CrosswordSaver is currently only capable of parsing one web page for crossword data, namely <a href="www.ireland.com">
              The Irish Times</a>. If you would like CrosswordSaver to work with some other website, feel free to make a feature
              request through the project page.<br><br>
              If you are adding a crossword from the Irish Times website, select <span class="quote"> Crosswords -&gt; Add New ... 
              -&gt; ... from Website</span>, from the navigation menu.<br><br>
              You will then need to paste into the box the HTML source of the Irish Times web page that displays the Java version 
              of the crossword. To copy the HTML source from that page, right-click on the page, choose <span class="quote">View 
              Source</span> from the menu. Select and copy all of the text and then paste it into the box in CrosswordSaver. Click 
              <span class="quote">Submit</span> to continue.<br><br>
              The next page displays list of all of the clues and answers. Review the data before clicking <span class="quote">Submit
              </span> to continue and save the crossword to the database.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2" style="padding-left: 20px;"><span class="cattitle">3.3 XML Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="justify" colspan="2" style="padding-left: 25px;">
            <span class="genmed">
              Select <span class="quote">Crosswords -&gt; Add New... -&gt; ...from XML File</span>, from the navigation menu.<br><br>
              Click <span class="quote">Browse...</span> to locate the .xml file on your hard drive and open it. Click 
              <span class="quote">Load</span> to continue.<br><br>
              On the next page, you will be presented with a full list of all of the data associated with the new crossword. Check the 
              data before clicking <span class="quote">Submit</span> to commit the crossword to the database. You will now be able to 
              play this crossword from the <a href="Crosswords.php?q=play">Crosswords</a> page.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">4. Browsing Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              Select <span class="quote">Crosswords -&gt; Play</span>, from the navigation menu to view a full list of all crosswords 
              currently managed by CrosswordSaver.<br><br>
              Crosswords are divided into two categories; those with a complete set of data, i.e. all clues have answers, and those 
              with an incomplete set of data (one or more answers missing). For each crossword listed (of any type), two sample clues 
              are displayed. Mouse over the ellipsis at the end of the second clue to see a further selection of clues. From this page 
              you can also Edit, Delete or export crosswords to XML files.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">5. Editing Crosswords</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              See <span class="quote">Section 4 - Browsing Crosswords</span>, for a list of all saved crosswords. At the end of each 
              crossword listing, there is a link to edit that specific crossword. Click <span class="quote">Edit</span>.<br><br>
              On the next page, you can update or modify all data associated with the crossword you chose to edit. Please note: 
              <span class="quote">Date Added</span> is read-only when editing. Click <span class="quote">Save Changes</span> to 
              update the crossword or <span class="quote">Cancel</span> to discard any changes and go back. You can also edit the 
              grid by clicking <span class="quote">Edit Grid</span>.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2" style="padding-left: 20px;"><span class="cattitle">5.1 Editing a Crossword's Grid</span></td>
        </tr>
      	<tr>
          <td class="row1" align="justify" colspan="2" style="padding-left: 25px;">
            <span class="genmed">
              Follow the instructions in <span class="quote">Section 5 - Editing Crosswords</span>, choosing the crossword whose grid 
              you wish to edit. A thumbnail view of the crossword is displayed on the edit crossword page. Click the <span class="quote">
              Edit Grid</span> link under the thumbnail.<br><br>
              You should now see the edit grid page where a full size view of the crossword's grid is displayed. You can modify individual 
              squares of the grid here by clicking on them. Click <span class="quote">Update</span> to save your changes or <span class="quote">
              Cancel</span> to discard any changes and go back.<br>
              <b>N.B.</b> if you make changes to a grid which is shared by multiple crosswords, a new grid is generated for the crossword 
              being edited. All other crosswords with a dependency on this grid will be unaffected.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">6. Exporting Crosswords to XML</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              See <span class="quote">Section 4 - Browsing Crosswords</span>, for a list of all saved crosswords. Click the checkbox 
              beside each crossword you wish to export, and then click <span class="quote">Export to XML</span> at the end of the list. 
              A <span class="quote">File Download</span> dialogue will pop up asking whether to save or open; choose save and select a 
              location. You will now have the selected crosswords in XML format, so you can share them with others.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">7. CrosswordSaver Settings</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              Select <span class="quote">Crosswords -&gt; Settings</span>, from the navigation menu to view some CrosswordSaver settings.<br><br>
              <span class="quote">Database Host</span> - The hostname/ip of the server running the MySQL server. <b>localhost</b> if on same computer.<br>
              <span class="quote">Database Name</span> - The name of the CrosswordSaver database. <b>crosswordsaver</b> unless you change it.<br>
              <span class="quote">Database Username</span> - The username for accessing the database. <b>cws</b> unless you change it.<br>
              <span class="quote">Database Password</span> - The password for accessing the database. <b>cws</b> unless you change it.<br><br>
              <span class="quote">Conceal answers when adding/editing</span> - Choose whether to show/hide answers when editing crosswords.<br><br>
              <span class="quote">Turn logging on</span> - Turn on logging for database access in CrosswordSaver.<br>
              <span class="quote">Log4PHP working directory</span> - The path where Log4PHP has been installed.
            </span>
          </td>
      	</tr>
        <tr>
          <td class="catLeft" colspan="2"><span class="cattitle">8. Uninstalling CrosswordSaver</span></td>
        </tr>
      	<tr>
          <td class="row1" align="left" colspan="2">
            <span class="genmed">
              Uninstalling CrosswordSaver is very simple. Firstly, if you wish to make a backup of your crosswords; select them all and 
              export them to XML. To delete the database, type &quot;DROP DATABASE `crosswordsaver`&quot; into the MySQL monitor. The 
              application can be removed by deleting the directory where it is installed. If you also installed Log4PHP and no longer 
              require it, it can be removed also by deletion.
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