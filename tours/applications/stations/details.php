<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$station = stationsModel::stationDetails($itemId);

?>

<div class="col-md-12 full-row"><h3><?php echo $station->title;  ?></h3></div>

<div class="col-md-12 full-row"><label>Region</label><?php echo regionsModel::regionDetails($station->region_id)->title;  ?></div>

<div class="col-md-12 full-row"><label>Description</label><?php echo $station->description;  ?></div>

<div class="col-md-12 full-row"><label>Special Terms and Conditions</label><?php echo !empty($station->special_terms) ? $station->special_terms : '<span class="error">--Not Set--</span>' ;  ?></div>

<div class="col-md-12 full-row"><label>Other Areas To Visit</label><?php echo $station->other_areas;  ?></div>

<div class="col-md-12 full-row"><label>Max Number of Visitors</label><?php echo $station->visitors_max;  ?></div>

<div class="col-md-12 full-row"><label>Min Number of Visitors</label><?php echo $station->visitors_min;  ?></div>

<div class="col-md-12 full-row"><label>Minimum Days Before which a request can't be made</label><?php echo $station->min_days_before_booking; ?></div>    

<div class="col-md-12 full-row"><label>Maximum Days Beyond which a request can't be made</label><?php echo $station->max_days_after_booking; ?></div> 
  
<div class="col-md-12 full-row"><label>Number of Guides Per session</label><?php echo $station->guides_per_session; ?></div>   

<?php

if(strlen(trim($station->user_id)) > 0):
		
	$uids = explode(",",$station->user_id);
	$users ='';
	foreach($uids as $uid)
		{
		$user = usersModel::userDetails($uid);
		
		$users .= !empty($user) ? $user->fullname.', ' : '';
		}
	
	$users = strlen(trim($users)) > 0 ? substr(trim($users),0,-1) : '<span class="error">No set users</span>';		
	
else:
	$users = '<span class="error">Not set users</span>';
endif;
?>

<div class="col-md-12 full-row"><label>Admin User(s)</label><?php echo $users;  ?></div>

<div class="col-md-12 full-row"><label>Banner image</label>
<?php

$image = STATIONS_IMAGES . $station->photo ;

if(is_file($image))
	echo '<img src="'.$image.'" alt ="'.$station->title.'" />';
else
	echo '<span class="error">banner image not set</span>';

?>
</div> 

<div class="col-md-12 full-row"><label>Address</label><?php echo $station->contacts;  ?></div>

<div class="col-md-12 full-row"><label>Google Map</label>
<?php
if(strlen(trim($station->gmap)) > 0):
	echo '<iframe src="'.$station->gmap.'" width="100%" height="auto" frameborder="0" style="border:0" allowfullscreen></iframe>';
else:
	echo '<span class="error">Google map is not set</span>';
endif;
?>
</div> 


<div class="col-md-12 text-center full-row">
	<a class="btn" href="<?php echo $urls; ?>&pg=edit&itemId=<?php echo $itemId; ?>">Edit</a> 
	<a href="<?php echo $urls; ?>" class="btn">Back to listing</a>

</div>