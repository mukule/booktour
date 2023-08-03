<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$row = bookingsModel::bookingDetails($itemId);

if(isset($_REQUEST['msg_email']))
	{
	
	if($_REQUEST['msg_email'] == "success")
		echo '<div class="col-md-12 isa_success text-center">Successfully updated records and email notification successfully sent to the applicant.</div>';
	elseif($_REQUEST['msg_email'] == "error")
		echo '<div class="col-md-12 isa_warning text-center"><p>Records have successfully been updated.</p><p>However, there was an error relaying email notification to the applicant. Please use other methods to contact the applicant.</p></div>';
	}

	$date = $row->visit_date;
	$time = $row->visit_time == 1 ? '10:00' : '14:00';
	$visitDateTime = $date . ' '.$time;

?>

<div class="col-md-12 full-row"><h4>Booking for <?php echo stationsModel::stationDetails($row->station_id)->title;  ?></h4></div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Name of Institution</label><?php echo $row->institution; ?></div>    
    <div class="col-md-4"><label>Institution Type</label><?php echo $row->institution_type==1000 ? 'Others : '.$row->institution_type_others : baseModel::institutionTypeDetails($row->institution_type)->title; ?></div>
    <div class="col-md-4"><label>Full Name</label><?php echo $row->fullname; ?></div>
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Designation</label><?php echo $row->designation ; ?></div>
    <div class="col-md-4"><label>County</label><?php echo !empty($row->county_id) ? baseModel::countyDetails($row->county_id)->title : '--'; ?></div>
    <div class="col-md-4"><label>Town</label><?php echo $row->town; ?></div>    
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Phone</label><?php echo $row->phoneno; ?></div>
    <div class="col-md-4"><label>Email</label><?php echo $row->emailadd; ?></div>
    <div class="col-md-4"><label>Number of People</label><?php echo $row->number_of_visitors; ?></div>
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Proposed Visit Date</label><?php echo baseModel::formatDate($row->visit_date); ?></div>
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
    <div class="col-md-4"><label>Ref Number</label><?php echo $row->ref_no; ?></div>  
    <div class="col-md-4"><label>Country</label><?php echo !empty($row->country_id) ? baseModel::countryDetails($row->country_id)->title : ''; ?></div>    
</div>

<div class="col-md-12 full-row">
	<div class="col-md-12"><label>Purpose of the tour</label><?php echo !empty($row->purpose_id) ? purposesModel::purposeDetails($row->purpose_id)->title : '--'; ?></div>
	<div class="col-md-12"><label>Description of the tour</label><?php echo $row->description; ?></div>
</div>


<hr class="separator" />

<div class="col-md-12 full-row"><div class="col-md-12">

        <div class="col-md-12 full-row text-center official-actions-title"><h3>Official Actions</h3></div>
        
        <div class="col-md-6">
    
            <h4>Approval Action</h4>
                
             <?php
			
			if($row->approved !=0 ):
					
				$status = $row->approved==1 ? 'Approved' : 'Rejected' ;
				$comments = isset($row->approval_comments) && strlen(trim($row->approval_comments)) > 0 ? $row->approval_comments : 'No comments';
				
				
				echo '<div class="col-md-12"><b>Status</b> : '.$status.' </div>';
				echo '<div class="col-md-12"><b>Action taken by : </b> '.usersModel::userDetails($row->approved_by)->fullname. ', <small>'.baseModel::formatDate($row->approved_date).' </small></div>';
				
				echo '<div class="col-md-12"><b>Comments</b><br /><i>'.$comments.'</i></div>';
				
				if($row->plant_id > 0):
					
					$plant = plantsModel::plantDetails($row->plant_id);
					
					$plantTitle = !empty($plant) ? $plant->title : '<i class="error">Not found</i>';
					
					echo '<div class="col-md-12"><b>Power Plant Assigned : </b> '.$plantTitle.'</div>';
				endif;
				
			else:	
			
				if(isset($_POST['SubmitThis']) && $_POST['SubmitThis']=="Submit")
					{
					if(isset($_POST['approved']) && $_POST['approved'] > 0 && !empty($_POST['approval_comments']))
						echo bookingsModel::actionRequest($_POST);	
					else
						echo '<div class="col-md-12 isa_error text-center">select action to take</div>';	
					
					}
	
				?>   
					
				<form action="" method="post">            
					
						<div class="col-md-12"><label>Select Action</label>
							<select name="approved" class="form-control" required onchange="approvalsFunc(this);">
								<option value="0">--select action--</option>
								<option value="1">--Approve--</option>
								<option value="2">--Reject--</option>
							</select>
						</div>
			
						<div class="col-md-12"><label>Write Comments on approval / rejection(if any)</label>
							<textarea name="approval_comments" class="form-control" placeholder="comments for this action" required></textarea>
						</div>
                        
                        <?php
						
						$plants = plantsModel::listPlants($row->station_id);
						
						if(count($plants) > 0 ):
							
						?>
						
						<div class="col-md-12">                            
                            <label>Assign Power Plant</label>
							<select name="plant_id" id="plant_id" class="form-control" disabled="disabled">
								<option value="">--allocate to power plant (select action first)--</option>
								<?php
								foreach($plants as $plant)
									{
									if($plant->active == 1)	//only active plants								
										echo '<option value="'.$plant->id.'" >'.$plant->title.'</option>';			
									}
								?>
							</select>
						</div>
							
						<?php	
						endif;
						
						?>
					
					<div class="col-md-12 text-center">
						<input type="submit" name="SubmitThis" value="Submit" class="btn" />
					</div> 
					
					<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
					<input type="hidden" name="url" value="<?php echo $urls; ?>&pg=details&itemId=<?php echo $itemId; ?>" />  
						 
				</form>
            <?php
			endif;
			?>
        </div>  
		
 		<div class="col-md-6">
    
            <h4>Feedback - Actual Report from the request</h4>
                
             <?php
			
			if($row->visited !=0 ):	
				
				$visited = $row->visited==1 ? 'Yes, Visted' : 'Did not visit' ;
				$number_visited = isset($row->number_visited) && strlen(trim($row->number_visited)) > 0 ? $row->number_visited : '<i>Not set</i>';            
				
				echo '<div class="col-md-12"><b>Did the group visit? : </b>'.$visited.' </div>';
				echo '<div class="col-md-12"><b>Feedback given by : </b>'.usersModel::userDetails($row->feedback_by)->fullname. ', <small>'.baseModel::formatDate($row->feedback_date).' </small></div>';
				
				//numbers only if visited
				echo $row->visited==1 ? '<div class="col-md-12"><b>Number Visited : </b>'.$number_visited.'</div>' : ''; //numbers only if visited
				
			elseif(strtotime(date("Y-m-d H:i")) < strtotime($visitDateTime) ):
				echo '<div class="col-md-12 isa_warning text-center">Feedback form will be available only after the visit date, '.baseModel::formatDate($visitDateTime).'</div>';	
			else:
			
				if(isset($_POST['SubmitThis']) && $_POST['SubmitThis']=="Submit Feedback")
					{
					
					if(isset($_POST['visited']) && $_POST['visited'] > 0)
						{
						if($_POST['visited'] == 1 && !isset($_POST['number_visited'])) //yes and no numbers
							echo '<div class="col-md-12 isa_error text-center">Enter the numbers who visited</div>';	
						else
							echo bookingsModel::actionFeedback($_POST);	
						}
					else
						echo '<div class="col-md-12 isa_error text-center">select correct choice on feedback</div>';	
					
					}
	
				?>   
					
				<form action="" method="post">            
					
						<div class="col-md-12"><label>Did the requesters visit?</label>
							<select name="visited" id="visited" class="form-control" required onchange="changeFunc(this);">
								<option value="">--select action--</option>
								<option value="1">--Yes--</option>
								<option value="2">--No--</option>
							</select>
						</div>
			
						<div class="col-md-12" id="numbers" ><label>How many persons actually visited?</label>
							<input type="number" name="number_visited" id="number_visited" class="form-control" required placeholder="How many actually visited" disabled="disabled" />
						</div>
					
					
					
					<div class="col-md-12 text-center">
						<input type="submit" name="SubmitThis" value="Submit Feedback" class="btn" />
					</div> 
					
					<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
					<input type="hidden" name="url" value="<?php echo $urls; ?>&pg=details&itemId=<?php echo $itemId; ?>" />  
						 
				</form>
            <?php
			endif;
			?>
        </div>      
    
    
</div></div>

<hr class="separator" />
<div class="col-md-12 full-row"><div class="col-md-12 text-center"><a href="<?php echo $urls; ?>" class="btn">Back to listing</a></div></div>


<script type="text/javascript">
//feedback
function changeFunc(that) 
	{
	  if (that.value == "1") 
	  	{
		document.getElementById("number_visited").disabled = false;
		}
	else 
		{
		document.getElementById("number_visited").disabled = true;
		document.getElementById("number_visited").value = false;
		}
	}
	
//action, approve/reject
function approvalsFunc(that) 
	{
	  if (that.value == "1") 
	  	{
		document.getElementById("plant_id").disabled = false;
		}
	else 
		{
		document.getElementById("plant_id").disabled = true;
		document.getElementById("plant_id").value = false;
		}
	}	
	
</script>