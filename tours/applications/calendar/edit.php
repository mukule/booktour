<div class="col-md-12"><h3>Internal Booking - Add a new visit / booking</h3></div>

<?php

if(isset($_POST['submitThis']) && $_POST['submitThis']=="Submit")
	{
	
	if(empty($_POST['station_id']) || empty($_POST['fullname']) || empty($_POST['emailadd']) || empty($_POST['phoneno']) || empty($_POST['visit_date']) || empty($_POST['visit_time']) )
		echo '<div class="col-md-12 isa_error text-center">Enter all required fields</div>';
	else
		echo calendarModel::makeBooking($_POST);
	
	}
	
	$urls = 'index' . EXT .'?'.$_SERVER['QUERY_STRING'];
		
	$visit_date = isset($_POST['visit_date']) ? $_POST['visit_date'] : '';
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

	<div class="col-md-6"><label>Select Station to visit</label>
    
		<select name="station_id" required class="form-control">
			<option value="">--Select station--</option>
			<?php
			$stations = stationsModel::listStations();
			
			foreach($stations as $station)
				{
				
				$sel = isset($_POST['station_id']) && $_POST['station_id'] == $station->id ? 'selected="selected"' : '';
				
				echo '<option value="'.$station->id.'" '.$sel.'>'.$station->title.'</option>';
				
				}
			
			?>
		 </select>    
    </div>	
    <div class="col-md-6 no-padding"><label> &nbsp; &nbsp; Visit Date / Time</label>
    	<div class="col-md-6"><input type="text" name="visit_date" id="visit_date" class="form-control" readonly="readonly" required value="<?php echo $visit_date; ?>" /></div>
    
        	<div class="col-md-6">
            	<select name="visit_time" required class="form-control">
                	<option value="">--select visit time--</option>
                    <option value="1" <?php echo isset($_POST['visit_time']) && $_POST['visit_time']==1 ? 'selected="selected"' : ''; ?>>Morning (1000 hours)</option>
                    <option value="2" <?php echo isset($_POST['visit_time']) && $_POST['visit_time']==2 ? 'selected="selected"' : ''; ?>>Afternoon (1400 hours)</option>
                </select>
            </div>
    
    </div>
    
</div>   

<div class="col-md-12 full-row">

	<div class="col-md-6"><label>Your Full Name</label><input name="fullname" type="text" id="fullname" class="form-control" required value="<?php echo $fullname; ?>" /></div>
	
	<div class="col-md-6"><label>Your title / designation in the organization</label><input name="designation" type="text" id="designation" class="form-control" required value="<?php echo $designation; ?>" /></div>
	
</div>     
   
<div class="col-md-12 full-row">     
		   
	<div class="col-md-6"><label>Name of Institution</label><input name="institution" type="text" id="institution" class="form-control" required value="<?php echo $institution; ?>" /></div>

	<div class="col-md-6"><label>Institution Type</label>
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
	<div class="col-md-6"><label>Country</label>
		<select name="country_id" required class="form-control">
			<option value="">--Select country--</option>
			<?php
			$countries = baseModel::listCountries();
			
			foreach($countries as $country)
				{
				
				$sel = isset($_POST['country_id']) && $_POST['country_id'] == $country->id ? 'selected="selected"' : '';
				
				echo '<option value="'.$country->id.'" '.$sel.'>'.$country->title.'</option>';
				
				}
			
			?>
		 </select>
	</div>
	
	<div class="col-md-6"><label>Town/City</label><input name="town" type="text" id="town" class="form-control" value="<?php echo $town; ?>"  /></div>
	
</div>        
<div class="col-md-12 full-row">  
	<div class="col-md-6"><label>Telephone</label> <input name="phoneno" type="tel" id="phoneno" class="form-control" value="<?php echo $phoneno; ?>" /></div>

	<div class="col-md-6"><label>Email Address</label><input name="emailadd" type="email" id="emailadd" class="form-control" value="<?php echo $emailadd; ?>" /></div>

</div>        
<div class="col-md-12 full-row">  

	<div class="col-md-6"><label>Number of Visitors </label><input name="number_of_visitors" type="number" id="number_of_visitors" class="form-control" value="<?php echo $number_of_visitors; ?>"/></div>
    
    <div class="col-md-6"><label>Purpose of the Tour</label><textarea name="description" class="form-control" id="description"><?php echo $description; ?></textarea></div>
	
</div>        
    

<div class="col-md-12 text-center">
	<input name="submitThis" id="submitThis" type="submit" value="Submit" class="btn" /> 
	<a href="index.php?act=calendar" class="btn">Cancel</a>
</div>	

<input type="hidden" name="url" value="<?php echo $urls; ?>">


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
			minDate: "+1d",
			maxDate: "+1Y"
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
  