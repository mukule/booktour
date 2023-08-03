<?php
//search - station, dates, refno, nationality
//default checkboxes
//send email

$urls = 'index.php?act='.$_REQUEST['act'];
?>


<div class="col-md-12 search-panel">
<form action="" method="post">
	<div class="col-md-2">
    <select name="station_id" class="form-control" >
    	<option value="">--select station--</option>
        
        <?php
		if(ACCESS_LVL != 1)
			$stations =  stationsModel::listMyStations(MYID);
		else
			$stations =  stationsModel::listStations();
		
		foreach($stations as $stat)
			{
			$sel = isset($_POST['station_id']) && $_POST['station_id'] == $stat->id ? 'selected="selected"' : '';
			
			echo '<option value="'.$stat->id.'" '.$sel.'>'.$stat->title.'</option>';			
			}
		?>
    </select>    
    </div>
    
    <div class="col-md-2">
    <select name="nationality" class="form-control" >
    	<option value="">--Nationality--</option>
        <option value="ke" <?php echo !empty($_POST['nationality']) && $_POST['nationality'] =="ke" ? 'selected="selected"' :''; ?>>Kenyan</option>
        <option value="foreign" <?php echo !empty($_POST['nationality']) && $_POST['nationality'] =="foreign" ? 'selected="selected"' :''; ?>>Foreign</option>
    </select>    
    </div>

    <div class="col-md-2"><input type="text" name="date_from" id="date_from" class="form-control" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : ''; ?>" readonly="readonly" placeholder="Date from" /></div>
    
    <div class="col-md-2"><input type="text" name="date_to" id="date_to" class="form-control" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : ''; ?>" readonly="readonly" placeholder="Date To" /></div>
    
    <div class="col-md-2"><input type="text" name="ref_no" class="form-control" value="<?php echo isset($_POST['ref_no']) ? $_POST['ref_no'] : ''; ?>" placeholder="reference number" /></div>
    
    
    <div class="col-md-2"><input type="submit" name="submitThis" value="Search" class="btn" /></div>

</form>

</div>

<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Search")
	$bookings = bookingsModel::searchBookings($_POST);
else
	$bookings = bookingsModel::listBookings();

if(count($bookings) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no records listed</div>';
else:
	echo '<form action="'.$urls.'&pg=send" method="post">
			<div class="col-md-12 frame-400">			
			<table class="table font-small">
				<tr><th><input type="checkbox" onClick="selectall(this)" checked="checked" /> All</th>
				<th>Station</th><th>Institution</th><th>#No</th>
					<th>Proposed Visit Date</th><th>Nationality</th><th>Status</th><th>Visited</th></tr>';
				
	foreach($bookings as $book)
		{
		
		$station = stationsModel::stationDetails($book->station_id)->title;
		$station = str_replace('Power', '', $station);
		$station = str_replace('Stations', '', $station);
		$station = str_replace('Station', '', $station);
		
		$details = '<a href="'.$urls.'&pg=details&itemId='.$book->bookid.'" title="view details">'.$station.'</a>';
		
		if($book->approved == 1 )
			$status = 'Approved';
		elseif($book->approved == 2)
			$status = 'Rejected';
		else
			$status = 'Pending';
				
		$time = $book->visit_time == 1 ? '10am' : '2pm';
		
		$nationality = !empty($book->country_id) && $book->country_id == 110 ? 'Kenyan' : 'Foreign';
		
			$date = $book->visit_date;
			$time = $book->visit_time == 1 ? '10:00' : '14:00';
			$visitDateTime = $date . ' '.$time;
		
		if( strtotime(date("Y-m-d H:i")) > strtotime($visitDateTime) ) //only if the date is passed
			$visited = $book->visited == 1 ? 'Yes' : ($book->visited == 2 ? 'No' : 'Not Updated' );
		else
			$visited = 'N/A';
			
		$input = '<input type="checkbox" name="bookids[]" value="'.$book->bookid.'" checked="checked">';
		
		echo '<tr><td>'.$input.'</td>
					<td>'.$details.'</td>
					<td>'.$book->institution.'</td>					
					<td>'.$book->number_of_visitors.'</td>
				  	<td class="font-small">'.baseModel::formatDate($book->visit_date).' : '.$time.'</td>
				 	<td>'.$nationality.'</td>
					<td>'.$status.'</td>
					<td>'.$visited.'</td>
					</tr>';
		
		}
		
		echo '</table>
				</div>
				<div class="col-md-12 text-center">Total Records : '.count($bookings).'</div>
				<div class="col-md-12 text-center"><input type="submit" name="submitThis" value="Send Email" class="btn" /></div>
				
			</form>';

endif;
	
	
?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
 
	$(function() {
		$( "#date_from" ).datepicker({
			beforeShowDay: $.datepicker.noWeekends,
			dateFormat: 'dd/mm/yy',
			changeMonth: true, 
			changeYear: true,  
			//yearRange: "-1:", 
			//minDate: "+1d",
			maxDate: "+2Y"
		});
	});
  
	$(function() {
		$( "#date_to" ).datepicker({
			beforeShowDay: $.datepicker.noWeekends,
			dateFormat: 'dd/mm/yy',
			changeMonth: true, 
			changeYear: true,  
			//yearRange: "-1:", 
			//minDate: "+1d",
			maxDate: "+2Y"
		});
	});  
	
  </script>
  
<script language="JavaScript">
function selectall(source) {
  checkboxes = document.getElementsByName('bookids[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>