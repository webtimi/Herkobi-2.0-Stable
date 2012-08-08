<?php
include_once '../config.php';
	
	if((!isset($_SESSION['logged'])) || ($_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
	<script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" href="elfinder/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	
	<link rel="stylesheet" href="elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">

	<script src="elfinder/js/elFinder.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.view.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.ui.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.quickLook.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.eventsManager.js" type="text/javascript" charset="utf-8"></script>

	<script src="elfinder/js/i18n/elfinder.tr.js" type="text/javascript" charset="utf-8"></script>
	
	<style type="text/css">
		#close, #open, #dock, #undock, #destroy {
			width: 100px;
			position:relative;
			display: -moz-inline-stack;
			display: inline-block;
			vertical-align: top;
			zoom: 1;
			*display: inline;
			margin:0 3px 3px 0;
			padding:1px 0;
			text-align:center;
			border:1px solid #ccc;
			background-color:#eee;
			margin:1em .5em;
			padding:.3em .7em;
			border-radius:5px; 
			-moz-border-radius:5px; 
			-webkit-border-radius:5px;
			cursor:pointer;
		}
	</style>
	

	<script type="text/javascript" charset="utf-8">
  $().ready(function() {
 
    var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
    var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");
 
    $('#finder').elfinder({
       url : 'elfinder/connectors/php/connector.php',
       lang : langCode,
       editorCallback : function(url) {
          window.opener.CKEDITOR.tools.callFunction(funcNum, url);
          window.close();
       }
    })
  })
	</script>
  </head>
  <body>
	 <div id="finder"></div>
  </body>
</html>