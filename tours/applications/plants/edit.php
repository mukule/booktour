
<div class="col-md-12 form">
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(!empty($_POST['title']) && !empty($_POST['description'])  )
		echo plantsModel::submitPlant($_POST);
	else
		echo '<div class="col-md-12 isa_warning text-center">Fill all required fields</div>';
	}

	
	if(isset($itemId) && $itemId > 0)
		$plant = plantsModel::plantDetails($itemId);
	
	
	$title = isset($_POST['title']) ? $_POST['title'] : ( isset($plant->title) ? $plant->title  : '' );
	$description = isset($_POST['description']) ? $_POST['description'] : ( isset($plant->description) ? $plant->description  : '' );
	

	?>
	
		<form action="" method="post" enctype="multipart/form-data" novalidate>
			<div class="col-md-12">
				<label>Title : </label>
				<input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required />
			</div>
	
			<div class="col-md-12">
				<label>Station : </label>
				<select class="form-control" name="station_id" required>
                	<option value="">--select station--</option>
                    <?php
					$stations = stationsModel::listStations();
					
					foreach($stations as $stat)
						{
						$sel = isset($_POST['station_id']) && $_POST['station_id'] == $stat->id ? 'selected="selected"' : ( isset($plant->station_id) && $stat->id == $plant->station_id ? 'selected="selected"' :'');
						echo '<option value="'.$stat->id.'" '.$sel.'>'.$stat->title.'</option>';
						}						
					
					?>
                </select>
			</div>    
    
			<div class="col-md-12">
				<label>Description : </label>
				<textarea name="description" rows="6" class="mceEditor" required style="width:100%;" ><?php echo $description; ?></textarea>
			</div>
            
			<div class="col-md-12 text-center">
				<input type="submit" class="btn" name="submitThis" value="Submit" />
                
				<?php
                if(isset($itemId) && $itemId > 0)	                
					echo '<a href="'.$urls.'&pg=details&itemId='.$itemId.'" class="btn">Cancel</a>';
				else
					echo '<a href="'.$urls.'" class="btn">Cancel</a>';
				?>
			</div>        
			
			<?php
            if(isset($itemId) && $itemId > 0):
				?>
				<input type="hidden" name="plantid" value="<?php echo $itemId; ?>" />
				<input type="hidden" name="url" value="<?php echo $urls; ?>&pg=details&itemId=<?php echo $itemId; ?>" />
				<?php
			else:
				?>
                <input type="hidden" name="url" value="<?php echo $urls; ?>" />
                <?php
			endif;
			
			
			?>
            
		</form>

	
</div>