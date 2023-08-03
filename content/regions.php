<?php

$itemId = baseModel::decode($_REQUEST['reg']);


if(!isset($itemId) || $itemId < 1)
	{
	echo '<div class="col-md-12 isa_warning text-center">Please select a station to view its details</div>';
	return;
	}

$region = regionsModel::RegionDetails($itemId);

?>

<h2 class="page-header"><?php echo $region->title; ?></h2>

<div class="col-md-4">
	<?php
    
    $dir = "tours/".REGIONS_IMAGES;
    $file = $dir . $region->img;
    
    $img = is_file($file) ? '<img src="'.$file.'" align="left" alt="'.$region->title.'" />' : '';
    
    echo $img;
    
    ?>
    
    <div class="col-md-12 regions-stations">
        <h3>Power Stations in this Region</h3>
        
        <?php
        $stats = frontModel::listStations($itemId);
                    
        echo '<ul class="sub-menu">';
        foreach($stats as $stat)
            {
            echo '<li><a href="index.php?art=station&stat='.baseModel::encode($stat->id).'">'.$stat->title.'</a></li>';
            
            }
        echo '</ul>';
        ?>

	</div>

</div>

<div class="col-md-8 station-description"><?php echo $region->description; ?></div>
