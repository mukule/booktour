<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$row = bookingsModel::bookingDetails($itemId);

?>

<div class="col-md-12 full-row"><h4>Booking for <?php echo stationsModel::stationDetails($row->station_id)->title;  ?></h4></div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Name of Institution</label><?php echo $row->institution; ?></div>    
    <div class="col-md-4"><label>Institution Type</label>
	
		<?php 
		if($row->institution_type > 0):
			$institutionType = baseModel::institutionTypeDetails($row->institution_type);
			
			if(!empty($institutionType))
				echo $institutionType->title; 
			else
				echo '--';
		else:
			echo '--';
		endif;
		?>
    </div>
    <div class="col-md-4"><label>Full Name</label><?php echo $row->fullname; ?></div>
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Designation</label><?php echo $row->designation ; ?></div>
    <div class="col-md-4"><label>County</label><?php echo !empty($row->county_id) ? baseModel::countyDetails($row->county_id)->title : '--'; ; ?></div>
    <div class="col-md-4"><label>Town</label><?php echo $row->town; ?></div>    
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Phone</label><?php echo $row->phoneno; ?></div>
    <div class="col-md-4"><label>Email</label><?php echo $row->emailadd; ?></div>
    <div class="col-md-4"><label>Number of People</label><?php echo $row->number_of_visitors; ?></div>
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Date</label><?php echo $row->visit_date; ?></div>
    <div class="col-md-4"><label>Visit Time/Hours</label><?php echo $row->visit_time == 1 ? 'Morning' : 'Afternoon'; ?></div>    
    <div class="col-md-4"><label>Mode of Transport</label><?php echo !empty($row->transport_mode) ? transportModel::displayTransportModes($row->transport_mode) : '--';   ?></div> 
</div>

<div class="col-md-12 full-row">
     <div class="col-md-4"><label>Upload file:</label>
        <?php
        $file = DOCUMENTS_FOLDER . $row->document ;        
        echo is_file($file) ? '<a href="'.$file.'" target="_blank">Download / view file</a>' : '<span class="error">File not found</span>';
        ?>    
    </div>	    
    <div class="col-md-4"><label>Country</label><?php echo !empty($row->country_id) ? baseModel::countryDetails($row->country_id)->title : ''; ?></div>    
    <div class="col-md-4">--</div> 
</div>


<div class="col-md-12 full-row"><div class="col-md-12"><label>Description of the tour</label><?php echo $row->description; ?></div></div>

<div class="col-md-12 full-row">
<?php

	$status = $row->approved == 1 ? 'Approved' : ($row->approved==2 ?  'Rejected' : 'Pending');

	echo '<div class="col-md-6"><label>Status</label>'.$status.'</div>';


	echo '<div class="col-md-6"><label>Comments</label>';
	if(isset($row->approval_comments) && strlen(trim($row->approval_comments)) > 0)
		echo $row->approval_comments;
	else
		echo '<i>No comments</i>';
	echo '</div>';
	
	?>
    
</div>


<div class="col-md-12 full-row"><div class="col-md-12 text-center"><a href="<?php echo $urls; ?>" class="btn">Back to listing</a></div></div>
