
<?php
$itemId = baseModel::decode($_REQUEST['stat']);

if(!isset($itemId) || $itemId < 1)
	{
	echo '<div class="col-md-12 isa_warning text-center">Please select a station to view its details</div>';
	return;
	}

$station = stationsModel::stationDetails($itemId);

?>

<h3 class="page-title text-center">Book a Tour to : <?php echo $station->title; ?></h3>

<h4 class="text-center font-bold">
<?php
$dy = $_REQUEST['dy'];

$datetime = explode("_",$dy);
$visit_date = $datetime[0];
$visit_time = $datetime[1];

$timeToDisplay = $visit_time == 1 ? '10.00am' : '2.00pm';


echo 'For Date : ' . date("jS M, Y", $visit_date).' : '.$timeToDisplay;

?>

</h4>

<?php 
if(isset($_REQUEST['cit']) && $_REQUEST['cit']=='kny')//kenyan
	include 'book-form'.EXT; 
elseif(isset($_REQUEST['cit']) && $_REQUEST['cit']=='frgn')//non-kenyan
	include 'book-foreigners'.EXT; 
else
	echo '<div class="col-md-12 isa_error text-center">You have not selected the country of residence for the visiting group</div>';

?>