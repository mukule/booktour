
<div class="col-md-12 search-panel">
<form action="" method="post">

	<div class="col-md-12">
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
    
    
    	<div class="col-md-2">
       	<select name="approved" class="form-control" >
            <option value="">--Approval Status--</option>
            <option value="1" <?php echo !empty($_POST['approved']) && $_POST['approved'] ==1 ? 'selected="selected"' :''; ?>>Approved</option>
            <option value="2" <?php echo !empty($_POST['approved']) && $_POST['approved'] ==2 ? 'selected="selected"' :''; ?>>Rejected</option>
            <option value="10" <?php echo !empty($_POST['approved']) && $_POST['approved'] ==10 ? 'selected="selected"' :''; ?>>Pending</option>
        </select> 
        
        </div>
    </div>
    
    
    <div class="col-md-12">    
    
 		<div class="col-md-8">&nbsp;</div>
        
		<div class="col-md-2">
       	<select name="visited" class="form-control" >
            <option value="">--If Visited--</option>
            <option value="1" <?php echo !empty($_POST['visited']) && $_POST['visited'] ==1 ? 'selected="selected"' :''; ?>>Yes, Visited</option>
            <option value="2" <?php echo !empty($_POST['visited']) && $_POST['visited'] ==2 ? 'selected="selected"' :''; ?>>Not Visited</option>
            <option value="10" <?php echo !empty($_POST['visited']) && $_POST['visited'] ==10 ? 'selected="selected"' :''; ?>>Not Updated</option>
        </select> 
        
        </div>
    
   		<div class="col-md-2"><input type="submit" name="submitThis" value="Search" class="btn" /> <a href="<?php echo $urls; ?>&pg=list" class="btn">Reset</a></div>
     
	</div>
    
    
    
</form>

</div>


<?php

/*
if(isset($_POST['ExportToExcel']) && $_POST['ExportToExcel'] == "Export To Excel")
	echo '<script>self.location="'.$urls.'&pg=excel"</script>';
*/

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Search")
	$bookings = reportsModel::searchBookings($_POST);
else
	$bookings = bookingsModel::listBookings();

if(count($bookings) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no records listed</div>';
else:
	echo '<form method="post" action="excel_reports.php">
			<div class="col-md-12 frame-400">
			<table class="table font-small">
				<tr><th>Institution</th><th>#Requested</th><th>Date Applied</th>
					<th>Proposed Visit Date</th><th>Nationality</th><th>Status</th><th>Visited</th><th>#Visited</th></tr>';
				
				
	$totalRequested = 0;
	$totalVisited = 0;
	foreach($bookings as $book)
		{
		
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
			
		$visitedNumber = $book->number_visited;
		$totalVisited += $visitedNumber;
		
		$totalRequested += $book->number_of_visitors;
		
		echo '<tr><td>'.$book->institution.'</td>					
					<td>'.$book->number_of_visitors.'</td>
					<td class="font-small">'.baseModel::formatDate($book->date_created).'</td>
				  	<td class="font-small">'.baseModel::formatDate($book->visit_date).' : '.$time.'</td>
				 	<td>'.$nationality.'</td>
					<td>'.$status.'</td>
					<td>'.$visited.'</td>
					<td>'.$visitedNumber.'</td>
					</tr>';		
		
		echo '<input type="hidden" name="bookids[]" value="'.$book->bookid.'">';
		}
		
		echo '<tr class="font-bold"><td>Totals :</td><td>'.$totalRequested.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$totalVisited.'</td></tr>';
		
		$exportToExcel = count($bookings) > 0 ? '<input type="submit" name="ExportToExcel" value="Export To Excel" class="btn" />' : '';
		
		echo '</table>
				</div>
				<div class="col-md-12 font-small actions text-center print-actions">
					<div class="col-md-6 font-bold">Total Records : '.count($bookings).'</div>
					<div class="col-md-6">'.$exportToExcel.'</div>
				</div>
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
  