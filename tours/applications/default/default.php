<?php
if(isset($_REQUEST['do']))
	$do = $_REQUEST['do'];

if(isset($_SESSION[SESSIONID])):
	
	//$inc = $_SESSION['userlevel'] == 1 ? 'home' : 'home-station';
	$inc = 'home';
	include $inc . EXT;
	
else:

	include 'login'. EXT;
	
endif;


?>