<?php

if(isset($_REQUEST['msg']) && $_REQUEST['msg'] =="success" )
	echo '<div class="col-md-12 isa_success text-center">Successfully updated records</div>';

if(isset($_REQUEST['pg']))
	$pg = $_REQUEST['pg'];
	
if(isset($_REQUEST['itemId']))
	$itemId = $_REQUEST['itemId'];

$urls = 'index.php?act='.$_REQUEST['act'];

if(isset($pg) && $pg == "pub")
	echo regionsModel::publish($itemId, $urls);
elseif(isset($pg) && $pg == "unpub")
	echo regionsModel::unpublish($itemId, $urls);
elseif(isset($pg) && $pg == "del")
	echo regionsModel::delete($itemId, $urls);
elseif(isset($pg) && $pg == "up")
	echo regionsModel::orderItemUp($itemId, $urls);		
elseif(isset($pg) && $pg == "down")
	echo regionsModel::orderItemDown($itemId, $urls);
else
	{
	$page = isset($pg) && strlen(trim($pg)) > 0 ? $pg : 'list';
	
	include $page . EXT;
	}

?>