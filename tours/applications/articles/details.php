<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$item = articlesModel::articleDetails($itemId);

?>

<div class="col-md-12"><h3><?php echo $item->title;  ?></h3></div>

<?php $position = !empty($item->article_position_id) ? articlePositionsModel::articlePositionDetails($item->article_position_id)->position : '--'; ?>
<div class="col-md-12"><label>Article Position</label><?php echo $position; ?></div>
<div class="col-md-12"><label>Description</label><?php echo $item->description;  ?></div>


<div class="col-md-12 text-center">
	<?php
	if(ACCESS_LVL == 1)
		echo '<a class="btn" href="'.$urls.'&pg=edit&itemId='.$itemId.'">Edit</a>';
    ?>
    
	<a href="<?php echo $urls; ?>" class="btn">Back to listing</a>

</div>