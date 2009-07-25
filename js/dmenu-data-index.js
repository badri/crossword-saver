//--- Common
var isHorizontal=1;
var smColumns=1;
var smOrientation=0;
var smViewType=0;
var dmRTL=0;
var pressedItem=-2;
var itemCursor="pointer";
var itemTarget="_self";
var statusString="link";
var blankImage="blank.gif";

//--- Dimensions
var menuWidth="";
var menuHeight="26px";
var smWidth="";
var smHeight="";

//--- Positioning
var absolutePos=0;
var posX="638";
var posY="52";
var topDX=0;
var topDY=1;
var DX=0;
var DY=0;

//--- Font
var fontStyle="normal 10px Verdana";
var fontColor=["#444444","#222222"];
var fontDecoration=["none","underline"];
var fontColorDisabled="#AAAAAA";

//--- Appearance
var menuBackColor="";
var menuBackImage="";
var menuBackRepeat="repeat";
var menuBorderColor="";
var menuBorderWidth=0;
var menuBorderStyle="none";

//--- Item Appearance
var itemBackColor=["transparent","#CCCCCC"];
var itemBackImage=["",""];
var itemBorderWidth=0;
var itemBorderColor=["#666666","#666666"];
var itemBorderStyle=["none","none"];
var itemSpacing=0;
var itemPadding="0";
var itemAlignTop="center";
var itemAlign="left";
var subMenuAlign="";

//--- Icons
var iconTopWidth=16;
var iconTopHeight=16;
var iconWidth=16;
var iconHeight=16;
var arrowWidth=7;
var arrowHeight=7;
var arrowImageMain=["arrv_black.gif","arrv_white.gif"];
var arrowImageSub=["arr_black.gif","arr_white.gif"];

//--- Separators
var separatorImage="ww_drop_seperator_tile.gif";
var separatorWidth="120px";
var separatorHeight="1";
var separatorAlignment="left";
var separatorVImage="";
var separatorVWidth="0";
var separatorVHeight="100%";
var separatorPadding="0px";

//--- Floatable Menu
var floatable=0;
var floatIterations=6;
var floatableX=1;
var floatableY=1;

//--- Movable Menu
var movable=0;
var moveWidth=12;
var moveHeight=20;
var moveColor="#AA0000";
var moveImage="";
var moveCursor="default";
var smMovable=0;
var closeBtnW=15;
var closeBtnH=15;
var closeBtn="";

//--- Transitional Effects & Filters
var transparency="100";
var transition=0;
var transOptions="";
var transDuration=300;
var transDuration2=200;
var shadowLen=0;
var shadowColor="transparent";
var shadowTop=0;

//--- CSS Support (CSS-based Menu)
var cssStyle=1;
var cssSubmenu="";
var cssItem=["mi","mi_over"];
var cssItemText=["mi_text","mi_text_over"];

//--- Advanced
var dmObjectsCheck=0;
var saveNavigationPath=1;
var showByClick=0;
var noWrap=1;
var pathPrefix_img="js/menuImages/";
var pathPrefix_link="";
var smShowPause=50;
var smHidePause=500;
var smSmartScroll=1;
var smHideOnClick=1;
var dm_writeAll=0;

//--- AJAX-like Technology
var dmAJAX=0;
var dmAJAXCount=0;

//--- Dynamic Menu
var dynamic=0;

//--- Keystrokes Support
var keystrokes=0;
var dm_focus=1;
var dm_actKey=113;

var itemStyles = [
	["CSS=mi_top,mi_top_over","CSSText=mi_top_text,mi_top_text_over"],
];

var menuItems = [
["Home","index.php", , , "Home Page", "_self", "0"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/Home.gif'><span class='miSpan'>Home</span></td><td class='r'></td></tr></table>","index.php", , , "Home Page"],

["Crosswords","Crosswords.php", , , "Crosswords", "_self", "0"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/PlayCrossword.gif'><span class='miSpan'>Play</span></td><td class='r'></td></tr></table>","Crosswords.php", , , "Crosswords"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/AddNew.gif'><span class='miSpan'>Add New ...</span></td><td class='r'></td></tr></table>","Crosswords.php?q=addNew", , , "Add New Crossword"],
		["||<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/AddPaper.gif'><span class='miSpan'>... from Newspaper</span></td><td class='r'></td></tr></table>","Crosswords.php?q=addP", , , "Add Crossword From Newspaper"],
		["||<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/AddWeb.gif'><span class='miSpan'>... from Website</span></td><td class='r'></td></tr></table>","Crosswords.php?q=addW", , , "Add Crossword From Website"],
		["||<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/AddXML.gif'><span class='miSpan'>... from XML File</span></td><td class='r'></td></tr></table>","Crosswords.php?q=addX", , , "Add Crossword From XML File"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/Settings.gif'><span class='miSpan'>Settings</span></td><td class='r'></td></tr></table>","Crosswords.php?q=editSettings", , , "Change Settings"],

["Help","Crosswords.php?q=help", , , "Help", "_self", "0"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/Documentation.gif'><span class='miSpan'>Documentation</span></td><td class='r'></td></tr></table>","Crosswords.php?q=docs", , , "Documentation"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/About.gif'><span class='miSpan'>About</span></td><td class='r'></td></tr></table>","Crosswords.php?q=aboutCWS", , , "About Crosswordsaver"],

["Sourceforge","http://sourceforge.net", , , "Sourceforge.net", "_blank", "0"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='js/menuImages/ProjectIcon.gif'><span class='miSpan'>Project Page</span></td><td class='r'></td></tr></table>","http://sourceforge.net/projects/crosswordsaver/", , , "Project Page"],
	["|<table cellspacing='0' class='icont'><tr><td class='l'></td><td class='m'><img src='http://sflogo.sourceforge.net/sflogo.php?group_id=155609&amp;type=1' width='53' height='19' border='0' alt='SourceForge.net Logo'/><span class='miSpan'>Sourceforge.net</span></td><td class='r'></td></tr></table>",'http://sourceforge.net', , , "Sourceforge.net"],
];

dm_init();