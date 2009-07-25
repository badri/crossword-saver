<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-ie">

<title>CrosswordSaver - by John Luke Higgins</title>

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/scrollbar-h.css" type="text/css">
<link rel="stylesheet" href="css/nav.css" type="text/css">

<script type="text/javascript" src="js/cwsJS.js"></script>
<script type="text/javascript" src="js/dmenu.js"></script>

<?php
if( $_GET['q'] == "addP" ){
    ?>
<script type="text/javascript" src="js/dw_scrollObj.js"></script>
<script type="text/javascript" src="js/dw_hoverscroll.js"></script>
<script type="text/javascript" src="js/dw_event.js"></script>
<script type="text/javascript" src="js/dw_slidebar.js"></script>
<script type="text/javascript" src="js/dw_scroll_aux.js"></script>

<script type="text/javascript">
/*************************************************************************
  This code is from Dynamic Web Coding at www.dyn-web.com
  Copyright 2001-4 by Sharon Paine 
  See Terms of Use at www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/
function initScrollLayer(){
  var wndo = new dw_scrollObj( 'wn', 'lyr1', 't1' );
  wndo.setUpScrollbar( "dragBar", "track", "h", 1, 1 );
}
</script>
<?php
}
?>

<?php
$loadString = ( $_GET['q'] == "addP" ) ? 'initScrollLayer()' : '';
if( isset( $_GET['e'] ) ){
  require_once( 'CSErrorHandler.php' );
  //Convert code to string here.
  $errorString = CSErrorHandler::getMessage( $_GET['e'] );
  $loadString .= ";displayMessage( '{$errorString}' );";
}
?>

</head>

<body topmargin="0" leftmargin="0" onload="<?php echo $loadString; ?>">

<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" height="100%">
    <tr>
      <td rowspan="3" class="CWSLeft"></td>
      <td class="CWSHeader"><div id="NavMenu"><script type="text/javascript" src="js/dmenu-data-index.js"></script></div></td>
      <td rowspan="3" class="CWSRight"></td>
    </tr>
    <tr>
      <td>
        <table align="center" cellspacing="0" cellpadding="0" width="100%" height="100%">
          <tr>
            <td class="CapTopLeft"></td>
            <td class="CapTopMiddle"></td>
            <td class="CapTopRight"></td>
          </tr>
          <tr>
            <td class="CapLeft"></td>
            <td>