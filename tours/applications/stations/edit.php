   
    
<div class="col-md-12 form">
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(!empty($_POST['title']) && !empty($_POST['description'])  )
		echo stationsModel::submitStation($_POST, $_FILES);
	else
		echo '<div class="col-md-12 isa_warning text-center">Fill all required fields</div>';
		
		//print_r($_POST);
	}

	
if(isset($itemId) && $itemId > 0)
	$station = stationsModel::stationDetails($itemId);

$title = isset($_POST['title']) ? $_POST['title'] : ( isset($station->title) ? $station->title  : '' );
$description = isset($_POST['description']) ? $_POST['description'] : ( isset($station->description) ? $station->description  : '' );
$visitors_min = isset($_POST['visitors_min']) ? $_POST['visitors_min'] : ( isset($station->visitors_min) ? $station->visitors_min  : MIN_VISITORS );
$visitors_max = isset($_POST['visitors_max']) ? $_POST['visitors_max'] : ( isset($station->visitors_max) ? $station->visitors_max  : MAX_VISITORS );
$min_days_before_booking = isset($_POST['min_days_before_booking']) ? $_POST['min_days_before_booking'] : ( isset($station->min_days_before_booking) ? $station->min_days_before_booking  : MIN_DAYS_BEFORE_BOOKING );
$max_days_after_booking = isset($_POST['max_days_after_booking']) ? $_POST['max_days_after_booking'] : ( isset($station->max_days_after_booking) ? $station->max_days_after_booking  : MAX_DAYS_AFTER_BOOKING );
$guides_per_session = isset($_POST['guides_per_session']) ? $_POST['guides_per_session'] : ( isset($station->guides_per_session) ? $station->guides_per_session  : GUIDES_PER_SESSION );
$special_terms = isset($_POST['special_terms']) ? $_POST['special_terms'] : ( isset($station->special_terms) ? $station->special_terms  : '' );
$other_areas = isset($_POST['other_areas']) ? $_POST['other_areas'] : ( isset($station->other_areas) ? $station->other_areas  : '' );
$photo = isset($_POST['photo']) ? $_POST['photo'] : ( isset($station->photo) ? $station->photo  : '' );
$gmap = isset($_POST['gmap']) ? $_POST['gmap'] : ( isset($station->gmap) ? $station->gmap  : '' );
$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : ( isset($station->contacts) ? $station->contacts  : '' );
?>

<form action="" method="post" enctype="multipart/form-data" novalidate>
	<div class="col-md-12">
		<label>Title : </label>
		<input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required />
	</div>

	<div class="col-md-12">
		<label>Region : </label>
		<select class="form-control" name="region_id" required>
			<option value="">--select region--</option>
			<?php
			$regions = regionsModel::listRegions();
			
			foreach($regions as $reg)
				{
				$sel = isset($_POST['region_id']) && $_POST['region_id'] == $reg->id ? 'selected="selected"' : ( isset($station->region_id) && $reg->id == $station->region_id ? 'selected="selected"' :'');
				
				echo '<option value="'.$reg->id.'" '.$sel.'>'.$reg->title.'</option>';
				}						
			
			?>
		</select>
	</div>    

	<div class="col-md-12">
		<label>Description : </label>
		<textarea name="description" rows="6" class="mceEditor" required style="width:100%;" ><?php echo $description; ?></textarea>
	</div>

	<div class="col-md-12">
		<label>Address / Contact Details : <small>(Espectially if different from the region's addresses. These are the contacts sent out via notification emails)</small> </label>
		<textarea name="contacts" rows="6" style="width:100%;" ><?php echo $contacts; ?></textarea>
	</div>
    
	<div class="col-md-12">
		<label>Minimum number of visitors (ignore if no minimum) :  </label>
		<input type="number" class="form-control" name="visitors_min" value="<?php echo $visitors_min; ?>" required />
	</div>    

	<div class="col-md-12">
		<label>Maximum number of visitors : </label>
		<input type="number" class="form-control" name="visitors_max" value="<?php echo $visitors_max; ?>" required />
	</div>  
	
	<div class="col-md-12">
		<label>Minimum Days Before which a request can't be made (ignore if no minimum) :  </label>
		<input type="number" class="form-control" name="min_days_before_booking" value="<?php echo $min_days_before_booking; ?>" required />
	</div>    

	<div class="col-md-12">
		<label>Maximum Days Beyond which a request can't be made (ignore if no maximum) : </label>
		<input type="number" class="form-control" name="max_days_after_booking" value="<?php echo $max_days_after_booking; ?>" required />
	</div>             

	<div class="col-md-12">
		<label>Number of Guides Per Session : </label>
		<input type="number" class="form-control" name="guides_per_session" value="<?php echo $guides_per_session; ?>" required />
	</div>            

	<div class="col-md-12">
		<label>Special Terms and Conditions : </label>
		<textarea name="special_terms" rows="6" class="mceEditor" required style="width:100%;" ><?php echo $special_terms; ?></textarea>
	</div>   

	<div class="col-md-12">
		<label>Other Areas to visit : </label>
		<textarea name="other_areas" rows="6" class="mceEditor" required style="width:100%;" ><?php echo $other_areas; ?></textarea>
	</div>  
	
	<div class="col-md-12">
		<label>Banner Image <small>(jpg, png, jpeg), 1350 by 300 pixels</small>: </label>
		<input type="file" class="form-control" name="photo" value="<?php echo $photo; ?>" required />
	</div>                            
	
	<div class="col-md-12">
		<label>Google Location <small>(Note:embedded link)</small>: </label>
		<input type="url" class="form-control" name="gmap" value="<?php echo $gmap; ?>" required />
	</div>                
	
	
	
	<?php if(ACCESS_LVL == 1): //superadmins ?>
	
	<div class="col-md-12">
		<label>Users In Charge of station : <small>(Press Ctrl to select multiple)</small> </label>
		
		
		<select name="user_id[]" class="form-control" required multiple="multiple"> 
			<option value="">---select user---</option>
			<?php
			$users = usersModel::listStationAdmins();
			
			$uids ='';
			if(isset($itemId) && $itemId > 0)
				{
				$currentUsers = $station->user_id;
				$uids = explode(",",$currentUsers);						
				}
			elseif(isset($_POST['user_id']) )
				{
				$uids = $_POST['user_id'];
				}
			
			foreach($users as $user)
				{
				//$sel = $user->id == $station->user_id ? 'selected="selected"' : '';
				
				if(in_array( $user->id, $uids))
					$sel = 'selected="selected"';
				else
					$sel = '';
					
				echo '<option value="'.$user->id.'" '.$sel.'>'.$user->fullname.'</option>';
				
				}
			
			?>
		</select>
		
	</div>  
	
   <?php endif; //access_lvl ?>              
	
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
		<input type="hidden" name="stationid" value="<?php echo $itemId; ?>" />
		<input type="hidden" name="url" value="<?php echo $urls; ?>&pg=details&itemId=<?php echo $itemId; ?>" />
		<?php
	else:
		?>
		<input type="hidden" name="url" value="<?php echo $urls; ?>" />
		<?php
	endif;
	
	
	?>
	
</form>

	
</div> <!-----.form------>