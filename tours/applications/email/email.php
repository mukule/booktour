<?php

if(isset($_REQUEST['msg_email']) && $_REQUEST['msg_email'] =="success" )
	echo '<div class="col-md-12 isa_success text-center">Email sending Successfully done</div>';
elseif(isset($_REQUEST['msg_email']) && $_REQUEST['msg_email'] =="error" )
	echo '<div class="col-md-12 isa_error text-center">There was a problem sending email. Please try again or contact systems admin.</div>';	

if(isset($_REQUEST['pg']))
	$pg = $_REQUEST['pg'];
	
if(isset($_REQUEST['itemId']))
	$itemId = $_REQUEST['itemId'];

$urls = 'index.php?act='.$_REQUEST['act'];

$page = isset($pg) && strlen(trim($pg)) > 0 ? $pg : 'search';
	
include $page . EXT;	

	
?>