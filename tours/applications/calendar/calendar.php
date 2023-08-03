<?php


if(isset($_REQUEST['pg']))
	$pg = $_REQUEST['pg'];
	
if(isset($_REQUEST['itemId']))
	$itemId = $_REQUEST['itemId'];

$urls = 'index.php?act='.$_REQUEST['act'];



	$page = isset($pg) && strlen(trim($pg)) > 0 ? $pg : 'list';
	
	include $page . EXT;

	
?>