
<?php
if(isset($_REQUEST['itemId']))
	$itemId = $_REQUEST['itemId'];

$urls = 'index.php?act='.$_REQUEST['act'];

if(isset($_REQUEST['msg']) && $_REQUEST['msg']=="success")
	echo '<div class="col-md-12 isa_success text-center">successfully updated records</div>';

if(isset($_REQUEST['pg'])):
$pg = $_REQUEST['pg'];

switch($pg)
	{

	case "up":
		echo faqsModel::orderItemUp($itemId, $urls);
		break;	

	case "down":
		echo faqsModel::orderItemDown($itemId, $urls);
		break;	
			
	case "del":
		echo faqsModel::delete($itemId,$urls);
		break;

	case "pub":
		echo faqsModel::publish($itemId, $urls);
		break;
	
	case "unpub":
		echo faqsModel::unPublish($itemId, $urls);
		break;		

	case "edit":
		include "edit".EXT;
		break;
			
	default:
		include "list".EXT;
		break;
	
	}
else:
	include "list".EXT;
endif;
?>