<?php

if(isset($_POST['submitThis']) && $_POST['submitThis']=="Submit")
	{
	
	//$closed = frontModel::checkIfDateClosed($_POST);

	if(!isset($_POST['terms']) || $_POST['terms'] == 0 )
		echo '<div class="col-md-12 isa_error text-center">You must accept terms and conditions</div>';
	elseif(isset($_POST['captcha']) && isset($_POST['captcha2']) && $_POST['captcha'] != $_POST['captcha2'] )
		echo '<div class="col-md-12 isa_error text-center">The security answer given is wrong</div>';
	elseif(isset($_FILES['document']['name']) && pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION) !='pdf' )
		echo '<div class="col-md-12 isa_error text-center">The file uploaded is a not a recommended file format. Re-attach the file in .pdf format</div>';
	else
		echo frontModel::submitBooking($_POST, $_FILES);
	
	}
	
	$urls = 'index' . EXT .'?'.$_SERVER['QUERY_STRING'];	
	
	$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
	$designation = isset($_POST['designation']) ? $_POST['designation'] : '';
	$institution = isset($_POST['institution']) ? $_POST['institution'] : '';
	$institution_type_others = isset($_POST['institution_type_others']) ? $_POST['institution_type_others'] : '';
	$town = isset($_POST['town']) ? $_POST['town'] : '';
	$phoneno = isset($_POST['phoneno']) ? $_POST['phoneno'] : '';
	$emailadd = isset($_POST['emailadd']) ? $_POST['emailadd'] : '';
	$idno = isset($_POST['idno']) ? $_POST['idno'] : '';
	$number_of_visitors = isset($_POST['number_of_visitors']) ? $_POST['number_of_visitors'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';

?>	



<form action="" method="post" enctype="multipart/form-data" class="form-booking">
<div class="col-md-12 full-row">

	<div class="col-md-6"><label class="required">Your Full Name</label><input name="fullname" type="text" id="fullname" class="form-control" required value="<?php echo $fullname; ?>" placeholder="your full name" /></div>
	
	<div class="col-md-6"><label class="required">Your title / designation in the organization</label><input name="designation" type="text" id="designation" class="form-control" required value="<?php echo $designation; ?>" placeholder="Your title / designation in the organization you are requesting for" /></div>
	
</div>        
<div class="col-md-12 full-row">     
		   
	<div class="col-md-6"><label class="required">Name of Institution</label><input name="institution" type="text" id="institution" class="form-control" required value="<?php echo $institution; ?>" placeholder="Name of the institution/organisation you represent" /></div>

	<div class="col-md-6"><label class="required">Institution Type</label>
		<select name="institution_type" required id="institution_type" class="form-control" onchange='CheckOthers(this.value);'>
			<option value="">--Select institution type--</option>
			
			<?php
			$types = baseModel::listInstitutionTypes();
			
			foreach($types as $type)
				{
				
				$sel = isset($_POST['institution_type']) && $_POST['institution_type'] == $type->id ? 'selected="selected"' : '';
				
				echo '<option value="'.$type->id.'" '.$sel.'>'.$type->title.'</option>';				
				}			
			?>
			<option value="1000">Others</option>
			
		 </select>
		 
		 <div class="col-md-12" id="institution_type_others" style="display:none;">
			<label>Indicate Type of Your Institution</label>
			<input type="text" name="institution_type_others" class="form-control"  placeholder="Indicate Other Type of Institution" value="<?php echo $institution_type_others; ?>" />
		 </div>
		 
	</div>

</div>        
<div class="col-md-12 full-row">  
	<div class="col-md-6"><label class="required">County</label>
		<select name="county_id" required class="form-control">
			<option value="">--Select county--</option>
			<?php
			$counties = baseModel::listCounties();
			
			foreach($counties as $county)
				{
				
				$sel = isset($_POST['county_id']) && $_POST['county_id'] == $county->id ? 'selected="selected"' : '';
				
				echo '<option value="'.$county->id.'" '.$sel.'>'.$county->title.'</option>';
				
				}
			
			?>
		 </select>
	</div>
	
	<div class="col-md-6"><label>Town</label><input name="town" type="text" id="town" class="form-control" value="<?php echo $town; ?>" placeholder="Town"  /></div>
	
</div>        
<div class="col-md-12 full-row">  
	<div class="col-md-6"><label class="required">Telephone</label><input name="phoneno" type="tel" id="phoneno" class="form-control" required value="<?php echo $phoneno; ?>" placeholder="you telephone contacts" /></div>

	<div class="col-md-6"><label>Email Address</label><input name="emailadd" type="email" id="emailadd" class="form-control" value="<?php echo $emailadd; ?>" placeholder="your active email addres" /></div>

</div>        
<div class="col-md-12 full-row">  

	<div class="col-md-6"><label class="required">ID Number</label><input type="text" name="idno" id="idno" class="form-control" required  value="<?php echo $idno; ?>" placeholder="your Identity number" /></div>
	
<?php

	$min = $station->visitors_min ;
	$max = $station->visitors_max ;	
	
	//set min
	if($min > 0)
		{
		$min_label = 'Min: '.$min .' visitors';
		$min_tag = ' min="'.$min.'"';
		}
	else
		{
		$min_label = '';
		$min_tag = '';		
		}
		
	//set max
	if($max > 0)
		{
		$max_label = 'Max: '.$max.' visitors';
		$max_tag = ' max="'.$max.'"';
		}
	else
		{
		$max_label = '';
		$max_tag = '';		
		}
	
	$label = (!empty($min) && $min > 0) || (!empty($max) && $max > 0 ) ? '('.$min_label . ' '. $max_label.')' : '';
	
	
	?>
    
	<div class="col-md-6"><label class="required">Number of Visitors <?php echo $label; ?></label><input name="number_of_visitors" <?php $min_tag . $max_tag; ?> type="number" id="number_of_visitors" class="form-control" value="<?php echo $number_of_visitors; ?>" placeholder="number of visitors" required /></div>
	
</div>        
<div class="col-md-12 full-row">  

	<div class="col-md-6"><label>Mode of Transport (Tick all that apply)</label>
			<?php
			$modes =  frontModel::listTransportModes();
			
			foreach($modes as $mode)
				{
				$checked = isset($_POST['transport_mode']) && in_array($mode->id, $_POST['transport_mode']) ? 'checked="checked"' : '';
								
				echo '<div class="col-md-6"><input type="checkbox" name="transport_mode[]" value="'.$mode->id.'" '.$checked.'> '.$mode->title.'</div>';
				
				}
			?>
		
		</div>  
	
	 <div class="col-md-6"><label class="required">Upload Scanned Signed/Stamped Application Letter(<small>in pdf format</small>)</label><input type="file" name="document" class="form-control" required placeholder="upload .pdf file" accept="application/pdf" /></div>	

</div>       
 
<div class="col-md-12 full-row">
	<div class="col-md-6"><label class="required">Purpose of the tour</label>
		<select name="purpose_id" required class="form-control">
			<option value="">--Select purpose--</option>
			<?php
			$purposes = purposesModel::listPurposes();
			
			foreach($purposes as $purpose)
				{
				
				$sel = isset($_POST['purpose_id']) && $_POST['purpose_id'] == $purpose->id ? 'selected="selected"' : '';
				
				echo '<option value="'.$purpose->id.'" '.$sel.'>'.$purpose->title.'</option>';
				
				}
			
			?>
		 </select>
	</div>
	<div class="col-md-6"><label>More Details, if any</label><textarea name="description" class="form-control" id="description" placeholder="more details/information, if any"><?php echo $description; ?></textarea></div>
</div>   
    
<div class="col-md-12 full-row">  
	<div class="col-md-6"><label>Click  to read <a href="index.php?art=terms">Terms and Conditions</a></label>
	<input name="terms" type="checkbox" id="terms" value="1" required /> Accept Terms And Conditions before proceeding
	</div>
   
	<?php
	$x = rand(11,20);
	$y = rand(1,10);
	$z = rand(1,2);
	
	if($z==1)
		{
		$quiz = $y .' + '. $x .' = ? ';
		$answer = $x+$y;
		}
	else
		{
		$quiz = $x .' - '. $y .' = ? ';
		$answer = $x-$y;	
		}
	
	?>
	
	<div class="col-md-6"><label>Confirm you are not a robot</label>
		<input name="captcha" type="text" id="captcha" class="form-control" placeholder="Answer : <?php echo $quiz; ?>" />
		<input name="captcha2" type="hidden" id="captcha2" class="form-control" value="<?php echo $answer; ?>" />
	</div>

</div>

<div class="col-md-12 text-center"><input name="submitThis" id="submitThis" type="submit" value="Submit" class="btn" /> <a href="index.php?art=station&stat=<?php echo baseModel::encode($itemId); ?>" class="btn">Cancel</a></div>	

<input type="hidden" name="station_id" value="<?php echo $itemId; ?>">
<input type="hidden" name="url" value="<?php echo $urls; ?>">

<input type="hidden" name="visit_date" value="<?php echo date("Y-m-d", $visit_date); ?>">
<input type="hidden" name="visit_time" value="<?php echo $visit_time; ?>">

</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
 
	$(function() {
		$( "#visit_date" ).datepicker({
			beforeShowDay: $.datepicker.noWeekends,
			dateFormat: 'dd/mm/yy',
			changeMonth: true, 
			changeYear: true,  
			//yearRange: "-1:", 
			minDate: "+7d",
			maxDate: "+2Y"
		});
	});
  
  </script>
  
  
<script type="text/javascript">
function CheckOthers(val){
 var element=document.getElementById('institution_type_others');
 if(val=='1000')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>  
  