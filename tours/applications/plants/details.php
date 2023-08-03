<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$plant = plantsModel::plantDetails($itemId);

?>

<div class="col-md-12 full-row"><h3><?php echo $plant->title;  ?></h3></div>

<div class="col-md-12 full-row"><label>Station</label><?php echo stationsModel::stationDetails($plant->station_id)->title;  ?></div>

<div class="col-md-12 full-row"><label>Description</label><?php echo $plant->description;  ?></div>


<div class="col-md-12 text-center full-row">
	<a class="btn" href="<?php echo $urls; ?>&pg=edit&itemId=<?php echo $itemId; ?>">Edit</a> 
	<a href="<?php echo $urls; ?>" class="btn">Back to listing</a>

</div>