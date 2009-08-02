/*
 *  *
 *  * Copyright (c) 2009 Lakshmi Narasimhan
 *  * adapted from Sam Collett's  jquery numeric plugin(http://www.texotela.co.uk)
 *  * Licensed under the MIT License:
 *  * http://www.opensource.org/licenses/mit-license.php
 *  *
 *  * Version 1.0
 *  * $LastChangedDate$
 *  * $Rev$
 *  */

/*
 *  * Allows only valid characters to be entered into input boxes.
 *  * Note: does not validate that the final content is valid text
 *  * (that could be done by another script, or server-side)
 *  *
 *  * @name     textonly
 *  * @author   Lakshmi Narasimhan
 *  * @example  $("#name").textonly();
 *  *
 *  */
jQuery.fn.textonly = function()
{
  this.keypress(
function(e)
{

  var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
// allow enter/return key (only when in an input box)
  if(key == 13 && this.nodeName.toLowerCase() == "input")
    {

      return true;
      }
  else if(key == 13)
  {

    return false;
    }
  var allow = false;
// allow Ctrl+A
  if((e.ctrlKey && key == 97 /* firefox */) || (e.ctrlKey && key == 65) /* opera */) return true;
  // allow Ctrl+X (cut)
  if((e.ctrlKey && key == 120 /* firefox */) || (e.ctrlKey && key == 88) /* opera */) return true;
  // allow Ctrl+C (copy)
  if((e.ctrlKey && key == 99 /* firefox */) || (e.ctrlKey && key == 67) /* opera */) return true;
  // allow Ctrl+Z (undo)
  if((e.ctrlKey && key == 122 /* firefox */) || (e.ctrlKey && key == 90) /* opera */) return true;
  // allow or deny Ctrl+V (paste), Shift+Ins
  if((e.ctrlKey && key == 118 /* firefox */) || (e.ctrlKey && key == 86) /* opera */
     || (e.shiftKey && key == 45)) return true;
  // if a number was not pressed
  if(key < 65 || key > 90)
    {

   if(
    key != 8 /* backspace */ &&
  key != 9 /* tab */ &&
    key != 13 /* enter */ &&
  key != 35 /* end */ &&
    key != 36 /* home */ &&
  key != 37 /* left */ &&
    key != 39 /* right */ &&
  key != 46 /* del */
      )
      {
	allow = false;
      }
    else
    {
  // for detecting special keys (listed above)
      // IE does not support 'charCode' and ignores them in keypress anyway
      if(typeof e.charCode != "undefined")
  {

    // special keys have 'keyCode' and 'which' the same (e.g. backspace)
    if(e.keyCode == e.which && e.which != 0)
      {

	allow = true;
	  }
	  // or keyCode != 0 and 'charCode'/'which' = 0
    else if(e.keyCode != 0 && e.charCode == 0 && e.which == 0)
    {

      allow = true;
	}
	  }
      }
      }
    else
      {

	allow = true;
      }
  return allow;
}
  )
    .blur(
  function() {
    var val = jQuery(this).val();
    if(val != "") {
    }
    }
    );
  return this;
};

