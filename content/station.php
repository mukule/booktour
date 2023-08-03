<?php

if(isset($_REQUEST['stat']))
	$itemId = baseModel::decode($_REQUEST['stat']);

if(!isset($itemId) || $itemId < 1)
	{
	echo '<div class="col-md-12 isa_warning text-center">Please select a station to view its details</div>';
	return;
	}

$station = stationsModel::stationDetails($itemId);

?>

<!---<h3 class="page-title"><?php echo $station->title; ?></h3> -->

    <div class="col-md-7 station">
    
    
    <div class="col-md-12 station-description full-row"><?php echo $station->description; ?></div>
    
    <?php if(strlen($station->special_terms)): ?>
    
    <div class="col-md-12 station-description full-row">
        <h4>Special Terms and Conditions</h4>
        <?php echo $station->special_terms; ?>
    </div>
    <?php endif; ?>
    
    <?php if(strlen($station->other_areas)): ?>
    
    <div class="col-md-12 station-description full-row">
        <h4>Other Areas you can visit while at <?php echo $station->title; ?></h4>
        <?php echo $station->other_areas; ?>
    </div>
    <?php endif; ?>    

</div>

<div class="col-md-5">

	<div class="station-calendar">
    	<?php
		
		$settings = settingsModel::settings();
		
		if ($settings !== null && property_exists($settings, 'close_all_facilities') && $settings->close_all_facilities == 1) {
            echo '<div class="col-md-12 text-center isa_error"><h4>Booking to all our facilities is currently closed</h4></div>';
        }
        
		else
			include "calendar".EXT;
		?>
    
    </div>
    
    
    <?php include 'content' . DS . 'plants'.EXT; ?>

    
</div>

<?php
if(strlen(trim($station->gmap)) > 0 ) :
?>
<div class="col-md-12 gmap full-row">
<iframe src="<?php echo $station->gmap; ?>" width="100%" height="auto" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<?php
endif;
?>


