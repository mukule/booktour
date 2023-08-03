<section class="sliders">
<?php

$default_slider = '<img src="tours/images/slides/thermal.png">';

if(isset($_REQUEST['art']) && ($_REQUEST['art']=="station" || $_REQUEST['art']=="book" || $_REQUEST['art']=="book-pre" )  )
	{

	$stationid = baseModel::decode($_REQUEST['stat']);
	
	$thisStation = stationsModel::stationDetails($stationid);
	
	$stationTitle = $thisStation->title;
	
	$image_station = $thisStation->photo;
	
	$file = 'tours/'. STATIONS_IMAGES .$image_station;
	
	
	if(is_file($file))
		echo '<img src="'.$file.'">';	
	else
		echo $default_slider;
	
	}
else
	{
	echo $default_slider;
	$stationTitle = SITE_NAME;
	}
?>


<div class="col-md-12 text-center sitename"><div id="sitename">welcome to <span><?php echo $stationTitle; ?></span></div></div>

</section>