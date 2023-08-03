<?php

if(isset($_REQUEST['do']))
	$do = $_REQUEST['do'];
	
if(isset($_REQUEST['sid']))
	$sid = $_REQUEST['sid'];

$thisUrl = $urls.'&pg='.$_REQUEST['pg'].'&itemId='.$itemId;

if(isset($do) && $do == "pub")
	echo stationsModel::publishStatus($sid, $thisUrl);
elseif(isset($do) && $do == "unpub")
	echo stationsModel::unpublishStatus($sid, $thisUrl);
elseif(isset($do) && $do == "del")
	echo stationsModel::deleteStatus($sid, $thisUrl);
elseif(isset($do) && $do == "edit")
	include 'manage-edit' . EXT;
else
	include 'manage-list' . EXT;

?>