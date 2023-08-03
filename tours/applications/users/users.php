<?php

if(ACCESS_LVL != 1)
	{
	echo '<div class="col-md-12 text-center isa_error">You have no permissions for accessing this resource</div>';
	return;
	}

if(isset($_REQUEST['pg']))
	$pg = $_REQUEST['pg'];
	
if(isset($_REQUEST['itemId']))
	$itemId = $_REQUEST['itemId'];

$urls = 'index.php?act='.$_REQUEST['act'];

if(isset($pg) && $pg == "pub")
	echo usersModel::publish($itemId, $urls);
elseif(isset($pg) && $pg == "unpub")
	echo usersModel::unpublish($itemId, $urls);
elseif(isset($pg) && $pg == "del")
	echo usersModel::userDelete($itemId, $urls);
else
	{
	$page = isset($pg) && strlen(trim($pg)) > 0 ? $pg : 'list';
	
	include $page . EXT;
	}
	
?>