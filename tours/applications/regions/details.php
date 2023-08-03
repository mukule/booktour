<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$region = regionsModel::regionDetails($itemId);

?>

<div class="col-md-12 full-row"><h3><?php echo $region->title;  ?></h3></div>


<div class="col-md-12 full-row"><label>Description</label><?php echo $region->description;  ?></div>

<div class="col-md-12 full-row"><label>Background image</label><img style="width:200px; height:auto;" src="<?php echo REGIONS_IMAGES . $region->img;  ?>" /></div>

<?php
	$color = !empty($region->bg_color_id) ? colorsModel::colorDetails($region->bg_color_id) : '';
	$bg = !empty($color) ? $color->code : '';
?>
<div class="col-md-12 full-row"><label>Description Background Color</label><div style="width:50px; height:50px; background-color:#<?php echo $bg;  ?>"></div></div>


<div class="col-md-12 full-row"><label>In-Charge</label><?php echo $region->incharge; ?></div>
<div class="col-md-12 full-row"><label>In-Charge Acting?</label><?php echo $region->acting == 1 ? 'Yes' : 'No'; ?></div>

<div class="col-md-12 full-row"><label>Regional Manager Signature</label>
	<?php 
	echo !empty($region->signature) ? '<p><img src="data:image/jpeg;base64,'.base64_encode( $region->signature ).'"/></p>' : '<span class="error">Not Set</span>'; ?>
</div>

<div class="col-md-12 full-row"><label>Email address</label><?php echo $region->contacts_email;  ?></div>
<div class="col-md-12 full-row"><label>Phone number</label><?php echo $region->contacts_phoneno;  ?></div>
<div class="col-md-12 full-row"><label>Address</label><?php echo $region->contacts_address;  ?></div>


<div class="col-md-12 text-center full-row">
	<?php
	if(ACCESS_LVL == 1)
		echo '<a class="btn" href="'.$urls.'&pg=edit&itemId='.$itemId.'">Edit</a>';
    ?>
    
	<a href="<?php echo $urls; ?>" class="btn">Back to listing</a>

</div>