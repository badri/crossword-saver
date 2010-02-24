/**
 * Attempts to find the text enclosed in <applet> & </applet> tags.
 * Serves two purposes, 1: ensures we have the correct input, 2: Less data to POST.
 * Note: Will only work with IE as there is no clipboardData obj elsewhere.
 */
function parseApplet( el ){
  if( !el.value )
    el = document.forms.AppletEntry.html;
  el.value = "";
  var HTML = (document.all) ? window.clipboardData.getData( "Text" ) : "";
  if( HTML == null ) HTML = "";
  var start = HTML.indexOf( "<applet" );
  var end = HTML.indexOf( "</applet>" );
  var tag = ( start != -1 && end != -1 ) ? HTML.substring( start, end + 9 ) : "";
  if( tag.length > 0 )
    el.value = tag;
  else
    el.value = "No Applet code was found!";
}

/**
 * Checks the PaperEntry form for valid data before submitting to PHP.
 * @return	True to submit the form, False otherwise.
 */
function checkPaper(){
  return checkCrossword() && checkAnswersAndClues();
}

/**
 * Simplistic validation method for the JavaScript Crossword object.
 * Concatenates the grid array into a string and checks that it is not all white (Default State).
 * Stores this string in a hidden form variable called "grid" for PHP to use it.
 * @return	True on sucess, False otherwise.
 */
function checkCrossword(){
  var grid = CW.gridToString();
  if( grid.indexOf( "0" ) == -1 ){
    alert( "You must configure the crossword grid before proceeding." );
    return false;
  }

  if( !document.getElementById( "grid" ) )
    return false;
  document.getElementById( "grid" ).value = grid;
  return true;
}

/**
 * Checks the values entered for each clue and answer.
 * Clues must be non-zero.
 * Ensures that the length of the answer (if non-zero) is correct.
 * @return	True if the validation passes, False otherwise.
 */
function checkAnswersAndClues(){
  for( var i = 0; i < CW.across.length; i++ ){
    var clue = CW.across[i][0];
    if( document.getElementById( clue + '_A' ).value == '' ){
      alert( "You must enter a clue for " + clue + " across." );
      document.getElementById( clue + '_A' ).focus();
      return false;
    }
    if( document.getElementById( clue + '_AA' ).value != '' ){
      if( document.getElementById( clue + '_AA' ).value.length != CW.across[i][1] ){
        alert( "The answer to clue " + clue + " is of incorrect length." );
        document.getElementById( clue + '_AA' ).focus();
        return false;
      }
    }
  }

  return true;
}

/**
 * Swaps the string property of an element on the page.
 * This can be useful for swaping images for mouseovers or for swapping styles.
 * Example: onmouseover="this.src = genericSwap( 'src', 'imgs/img1.gif', 'imgs/img2.gif', event )"
 * Note in the example above, because the function compares the image name against that of the currently
 * displayed image which is an absolute filename; it is sufficient to leave out the third argument.
 * E.g.: onmouseover="this.src = genericSwap( 'src', 'on.gif', '', event )"
 *       onmouseout="this.src = genericSwap( 'src', 'off.gif', '', event )"
 * @param	prop	The name of the property to be swapped.
 * @param	class1	The name of the first style.
 * @param	class2	The name of the second style.
 * @param	e	An event object required for firefox.
 */
function genericSwap( prop, style1, style2, e ){
  var el;
  if( window.event )	//Internet Explorer
    el = eval( 'window.event.srcElement.' + prop );
  else			//Mozilla
    el = eval( 'e.originalTarget.' + prop );

  if( el == style1 )
    return style2;
  else
    return style1;
}

/**
 * Debugging function to aid with JavaScript coding.
 * Pass in the object and it will print out all attributes.
 *
 * @param	el	Takes an object and prints out all of it's elements.
 */
function describeElement( el ){
  var assets = "";
  for( var i in el ){
    assets += i + "  *-*  ";
  }
  alert( assets );
}

/**
 * Function checks that at least one checkbox has been selected, before changing the forms
 * action to that supplied and submitting the form.
 * Returns at the earliest possible oppertunity when a checkbox has been selected.
 *
 * @param formName String The name of the form to be submitted.
 * @param query String The query to be tacked onto the form's action.
 * @param confMsg String The warning message to display to the user before performing action.
 * @return TRUE on success, FALSE otherwise.
 */
function checkboxAction( formName, query, confMsg ){
  var form = document.getElementById( formName );
  var action = form.action;

  var inputs = document.getElementsByTagName( "input" );

  for( var i = 0; i < inputs.length; i++ ){
    if( inputs[i].checked ){
      if( confMsg.length > 0 ){
        if( !confirm( confMsg ) )
          return false;
      }
      form.action = action + query;
      form.submit();
      return true;
    }
  }
}

/**
 * Selects/De-selects a range of checkboxes.
 * @param min The min value id to start with.
 * @param max The max value id to end with.
 */
function selectCheckBoxes( min, max ){
  for( var i = min; i < max; i++ ){
    var box = document.getElementById( 'cb' + i );
    if( box )
      box.checked = !box.checked;
  }
}


/**
 * This function is attached to a text field via the onblur() event handler.
 * When fired, it checks the current value against its original value stored
 * in a hidden form field of the same id prefixed by "h_". If the value has
 * changed, the class is altered to reflect this altered state.
 *
 * @param Textbox	The textbox to check for changes to its initial state.
 */
function detectChange( el ){
  var h_el = "h_" + el.name;
  if( document.getElementById( h_el ) ){
    if( el.value != document.getElementById( h_el ).value )
      el.style.cssText = "background-color: #000000;color: #FFFFFF;";
    else
      el.style.cssText = "";
  }
}


/**
 * Retrieves the message string and displays it in an absolutely positioned
 * DIV  for four seconds, similar to google's gmail notice.
 */
function displayMessage( errString ){
  var oDiv = domCreateElement( 'DIV', 'msgLayer', "className='msgLayer'" );
  document.body.appendChild( oDiv );
  oDiv.appendChild( document.createTextNode( errString ) );
  window.setTimeout( hideMessage, 4000 );
}


/**
 * Hides the notice DIV, called via window.timeout();
 */
function hideMessage(){
  document.getElementById( "msgLayer" ).style.display = "none";
}

/**
 * DOM function: Create a HTML node of the specified Type.
 * @param tag The HTML tag to use for the node type.
 * @return Return the created node.
 */
function domCreateElement( tag, id ){
  var n = document.createElement( tag );
  if( id ) n.setAttribute( 'id', id );
  for( var i = 2; i < arguments.length; i++ ){
    var key = arguments[i].substr( 0, arguments[i].indexOf( '=' ) );
    if( key.length >  0 )
      eval( 'n.' + arguments[i] );
  }

  return n;
}

//Crossword methods start here.
var CW;			//This variable allows global access to the crossword object.
var winTO;		//Used to keep a reference to the timeout.
var clueInputDelay = 3;	//How many seconds delay before writing the inputs for clues and answers.

/**
 * Draws a crossword grid of the specified dimensions. All the squares start off white.
 * The function draws a table with a gif of a white square, representing each crossword square, in a seperate <td> of its own.
 * Each <td> is assigned an id with the following format; "td1", "td2", "td3", ..., "tdn".
 * @param	i	The number of rows.
 * @param	j	The number of columns.
 */
function drawCrossword( i, j ){
  CW = new Crossword( i, j );
  document.write( "<br><table border=\"1\" style=\"border-style: solid; border-width: 2\" bordercolor=\"#111111\" align=\"center\"><tr><td><table cellspacing=\"0\" cellpadding=\"0\">" );
  for( var x = 0; x < i; x++ ){
    document.write( "<tr>" );
    for( var y = 1; y <= j; y++ ){
      var sq = parseInt( x*i+y );
      var sq_alt = parseInt( (i-x-1)*i+j-y+1);
      if(sq_alt==113) sq_alt = 1234;
      var mod_sq = sq%15;
      var mod_sq_2 = mod_sq%2;
      if((mod_sq_2 == 0) && (mod_sq >=2) && (mod_sq <=14) && !((sq-mod_sq)%30)==0) {
      document.write( "<td id=td" + sq + "><img src=\"img/Black.gif\" id=\"" + sq + "\" onMouseOver=\"window.status=" + sq + "\" onClick=\"swap( " + sq + " );swap( " + sq_alt + " ); CW.removeNumbers(); CW.numberCrossword();\"></td>" );
      }
      else {
      document.write( "<td id=td" + sq + "><img src=\"img/White.gif\" id=\"" + sq + "\" onMouseOver=\"window.status=" + sq + "\" onClick=\"swap( " + sq + " );swap( " + sq_alt + " ); CW.removeNumbers(); CW.numberCrossword();\"></td>" );
	}
    }
    document.write( "</tr>" );
  }
  document.write( "</table></td></tr></table><br>" );
}

/**
 * Draws a thumbnail view of a crossword for a user to select as a preset.
 * NOTE: This function can only handle symetrical squares at present.
 * @param	grid	The layout string.
 */
function drawMiniCrossword( grid ){
  document.write( "<div onclick=\"preset('" + grid + "')\"><table border=\"0\" style=\"border-style: solid; border-width: 1\" bordercolor=\"#111111\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">" );
  var dimension = Math.sqrt( grid.length );
  for( var i = 0; i < dimension; i++ ){
    document.write( "<tr>" );
    for( var j = 0; j < dimension; j++ ){
      if( grid.charAt( ( i * dimension ) + j ) == "0" ){
        document.write( "<td><img src=\"img/BlackMini.gif\" border=\"0\"></td>" );
      }
      else
        document.write( "<td><img src=\"img/WhiteMini.gif\" border=\"0\"></td>" );
    }
    document.write( "</tr>" );
  }
  document.write( "</table></div><br>" );
}

/**
 * Swaps the colour of a square on the crossword grid. Either black to white, or white to black.
 * Also updates the crossword object array to reflect the new change.
 * @param	el	The number of the id of the image to swap.
 */
function swap( el ){
  if( document.getElementById( el ) ){
    if( document.getElementById( el ).src.indexOf( "Black" ) > 0 ){
      document.getElementById( el ).src = "img/White.gif";
      CW.grid[Math.floor( ( ( el - 1 ) / CW.cols ) ) + 1][( ( el - 1 ) % CW.cols ) + 1] = 1;
    }
    else{
      document.getElementById( el ).src = "img/Black.gif";
      CW.grid[Math.floor( ( ( el - 1 ) / CW.cols ) ) + 1][( ( el - 1 ) % CW.cols ) + 1] = 0;
    }
  }
}


function numberSquare( sqNum, num ){
  if( document.getElementById( "td" + sqNum ) ){
    var oDiv = domCreateElement( 'DIV', 'NumberLayer' + num, "className='cwNumber'" );
    var oSquare = document.getElementById( "td" + sqNum );
    oDiv.appendChild( document.createTextNode( num ) );
    oSquare.insertBefore( oDiv, oSquare.firstChild );
  }
}

/**
 * Arranges the crossword according to the input grid, calls the numberCrossword() function
 * and triggers the writeClueAnswerBoxes() function via window.timeout.
 * @param	grid	The preset grid to apply to the crossword.
 */
function preset( inputGrid ){
  if( CW ){
    CW.removeNumbers();
    var k = 0;
    for( var i = 1; i <= CW.rows; i++ ){
      for( var j = 1; j <= CW.cols; j++ ){
        if( inputGrid.charAt( k ) == "0" )
          swap( k + 1 );
        k++;
      }
    }
    CW.numberCrossword();
  }
}

/**
 * Writes a series of textboxes to the Document, allowing the user to enter the required clues for the selected grid.
 * This function is called using the window.timeout() function.
 * The numberCrossword() function creates an array for this function to use.
 * NB: requires a DIV with the id "CABoxes" to be present on the page.
 */
function writeclueAnswerBoxes(){
  if( document.getElementById( "CABoxes" ) ){
    var container = document.getElementById( "CABoxes" );
    if( CW.across.length > 0 ){
      container.appendChild( document.createElement( 'BR' ) );
      container.appendChild( domCreateElement( 'IMG', 'AcrossImg', "src='img/Across.gif'" ) );
      container.appendChild( document.createElement( 'BR' ) );
      for( var i = 0; i < CW.across.length; i++ ){
        var clueNum = CW.across[i][0];
        var answerLen = CW.across[i][1];
	var squareNum = CW.across[i][2];
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_A#', "type='TEXT'", "name='" + clueNum + "_A#'", "className='numberInput'", "value='" + clueNum + "'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_A', "type='TEXT'", "name='" + clueNum + "_A'", "className='clueInput'", "value=' (" + answerLen + ")'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_AA', "type='TEXT'", "name='" + clueNum + "_AA'", "className='answerInput'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_A_', "type='HIDDEN'", "name='" + clueNum + "_A_'", "value='" + answerLen + "'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_A_N', "type='TEXT'", "name='" + clueNum + "_A_N'", "value='" + squareNum + "'" ) );
        container.appendChild( document.createElement( 'BR' ) );
      }
    }
    if( CW.down.length > 0 ){
      container.appendChild( document.createElement( 'BR' ) );
      container.appendChild( domCreateElement( 'IMG', 'DownImg', "src='img/Down.gif'" ) );
      container.appendChild( document.createElement( 'BR' ) );
      for( var i = 0; i < CW.down.length; i++ ){
        var clueNum = CW.down[i][0];
        var answerLen = CW.down[i][1];
	var squareNum = CW.down[i][2];
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_D#', "type='TEXT'", "name='" + clueNum + "_D#'", "className='numberInput'", "value='" + clueNum + "'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_D', "type='TEXT'", "name='" + clueNum + "_D'", "className='clueInput'", "value=' (" + answerLen + ")'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_DA', "type='TEXT'", "name='" + clueNum + "_DA'", "className='answerInput'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_D_', "type='HIDDEN'", "name='" + clueNum + "_D_'", "value='" + answerLen + "'" ) );
        container.appendChild( domCreateElement( 'INPUT', clueNum + '_D_N', "type='TEXT'", "name='" + clueNum + "_D_N'", "value='" + squareNum + "'" ) );
        container.appendChild( document.createElement( 'BR' ) );
      }
    }
  }
  CW.numberCrosswordFix();
}

/**
 * Removes all of the form field elements created by the writeClueAnswerBoxes() function.
 * If this function gets called before the writeClueAnswerBoxes() function is fired, it cancels the timeout.
 * NB: requires a DIV with the id "CABoxes" to be present on the page.
 */
function clearClueAnswerBoxes(){
  window.clearTimeout( winTO );
  if( document.getElementById( "CABoxes" ) )
    document.getElementById( "CABoxes" ).innerHTML = "";
}




/**
 * Class to represent the crossword in memory.
 * @param	i	The number of rows.
 * @param	j	The number of columns.
 */
function Crossword( i, j ){
  this.rows = i;
  this.cols = j;
  this.across = new Array();
  this.down = new Array();
  this.grid = new Array( this.rows + 2 );
  for( var m = 0; m < this.rows + 2; m++ ){
    this.grid[m] = new Array( this.cols + 2 );
    for( var n = 0; n < this.cols + 2; n++ ){
      this.grid[m][n] = 1;
    }
  }

  for( var m = 0; m < this.rows + 2; m++ ){
    this.grid[0][m] = 0;
    this.grid[this.cols + 1][m] = 0;
    this.grid[m][0] = 0;
    this.grid[m][this.rows + 1] = 0;
  }

  //Crossword class methods.
  this.numberCrossword = numberCrossword;
  this.numberCrosswordFix = numberCrosswordFix;
  this.removeNumbers = removeNumbers;
  this.displayCrossword = displayCrossword;
  this.addClue = addClue;
  this.gridToString = gridToString;
}

function numberCrossword(){
  //Not very elegant, but ... any suggestions appreciated.
  //Loops over the viewable part of the crossword grid to check that at least one black square exists.
  //No point in numbering an all white board.
  var notBlank = false;
  for( var i = 1; i <= this.cols; i++ ){
    for( var j = 1; j <= this.rows; j++ ){
      if( this.grid[i][j] == 0 ){
        notBlank = true;
        break;
      }
    }
  }

  if( notBlank ){
    this.across = new Array(); this.down = new Array();
    var count = 1;
    for( var i = 1; i <= this.cols; i++ ){
      for( var j = 1; j <= this.rows; j++ ){
        if( this.grid[i][j] == "1" ){
          var incrementCount = false;
          if( this.grid[i][j-1] == 0 && this.grid[i][j+1] == 1 ){
            addClue( i, j, count, "_" ); incrementCount = true;
          }
          if( this.grid[i-1][j] == 0 && this.grid[i+1][j] == 1 ){
            addClue( i, j, count, "|" ); incrementCount = true;
          }
          if( incrementCount ){
            numberSquare( ( i - 1 ) * this.cols + j, count );
            count++;
          }
        }
      }
    }
    winTO = window.setTimeout( writeclueAnswerBoxes, clueInputDelay * 1000 );
  }
}

/**
 * This function fixes a display problem with the number layers.
 */
function numberCrosswordFix(){
  var count = 1;
  for( var i = 1; i <= this.cols; i++ ){
    for( var j = 1; j <= this.rows; j++ ){
      if( this.grid[i][j] == "1" ){
        var incrementCount = false;
        if( this.grid[i][j-1] == 0 && this.grid[i][j+1] == 1 ){
          incrementCount = true;
        }
        if( this.grid[i-1][j] == 0 && this.grid[i+1][j] == 1 ){
          incrementCount = true;
        }
        if( incrementCount ){
          numberSquare( ( i - 1 ) * this.cols + j, count );
          count++;
        }
      }
    }
  }
}

/**
 * Removes all number layers from the document tree.
 */
function removeNumbers(){
  var divs = document.getElementsByTagName( 'DIV' ); window.status = divs.length;
  for( var i = 0; i < divs.length; i++ ){
    if( divs[i].id.indexOf( 'NumberLayer' ) > -1 ){
      divs[i].parentNode.removeChild( divs[i] );i--;
    }
  }
  clearClueAnswerBoxes();
}

/**
 * Helper function: prints out the crossword grid in an alert box.
 */
function displayCrossword(){
  var txt = '';
  for( var i = 0; i < this.rows + 2; i++ ){
    for( var j = 0; j < this.cols + 2; j++ ){
      txt += "[" + this.grid[i][j] + "]";
    }
    txt += "\n";
  }
  alert( txt );
}

function addClue( r, c, num, orient ){
  var curSq = 1;
  var len = 0;
  while( curSq == 1 ){
    len++;
    if( orient == "_" )
      curSq = CW.grid[r][c+len];
    else
      curSq = CW.grid[r+len][c];
  }
  var square_no = ( r - 1 ) * CW.cols + c;
  if( orient == "_" )
    CW.across[CW.across.length] = new Array( num, len, square_no);
  else
    CW.down[CW.down.length] = new Array( num, len, square_no);
}

function gridToString(){
  var txt = '';
  for( var i = 1; i < this.rows + 1; i++ ){
    for( var j = 1; j < this.cols + 1; j++ ){
      txt += this.grid[i][j];
    }
  }
  return txt;
}
