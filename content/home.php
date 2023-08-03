<div class="col-md-12 home">

<h2 class="col-md-12 page-title text-center"><?php echo SITE_NAME; ?> - OPERATIONAL AREAS</h2>
<?php
            
//$regions = regionsModel::listRegions();
$dir = "tours/".REGIONS_IMAGES;

$regions = frontModel::listRegions();

$cols = 3;
$div = floor( 12 / $cols);
$chars = 130;

$col=1;
foreach($regions as $reg)
	{
	
	$file = $dir . $reg->img;
	$img = '<img src="'.$file.'" />';

	$color = !empty($reg->bg_color_id) ? colorsModel::colorDetails($reg->bg_color_id) : '';
	$bg = !empty($color) ? $color->code : '000';

	if($col == 1 || $col % $cols ==1)
		echo '<div class="row">';
	
	$descrip = strlen($reg->description) <= $chars ? $reg->description : substr($reg->description,0,$chars) .' '. '  ....';
	
	echo '
		<div class="col-md-'.$div.'">
		<a href="index.php?art=regions&reg='.baseModel::encode($reg->id).'">
			<div class="region">
				<div class="region-img">'.$img.'
					<div class="region-title">'.$reg->title.'</div>
				</div>
				
				<div class="region-description" style="background-color:#'.$bg.'">'.$descrip.'</div>
				
			</div>
		</a>
		</div>
		';
		
	if( $col % $cols == 0)
		echo '</div>'; //.row

	
	
	
	$col++;

	
	}


?>


</div>