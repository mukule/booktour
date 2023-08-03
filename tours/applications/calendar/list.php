<div class="col-md-12 search-panel">
<form action="" method="post">
	<div class="col-md-4">
    <select name="station_id" class="form-control" >
    	<option value="0">--select station--</option>
        
        <?php
		$stations =  stationsModel::listStations();
		
		foreach($stations as $stat)
			{
			$sel = isset($_POST['station_id']) && $_POST['station_id'] == $stat->id ? 'selected="selected"' : '';
			echo '<option value="'.$stat->id.'" '.$sel.'>'.$stat->title.'</option>';			
			}
		?>
    </select>    
    </div>
    
	<div class="col-md-4">
    <select name="approved" class="form-control" >
    	<option value="">--select status--</option>
        <option value="0" <?php echo isset($_POST['approved']) && $_POST['approved'] == 0 ? 'selected="selected"' : ''; ?>>Pending</option>
        <option value="1" <?php echo isset($_POST['approved']) && $_POST['approved'] == 1 ? 'selected="selected"' : ''; ?>>Approved</option>
        <option value="2" <?php echo isset($_POST['approved']) && $_POST['approved'] == 2 ? 'selected="selected"' : ''; ?>>Rejected</option>
        
	</select>    
    </div>    
    
    <div class="col-md-4"><input type="submit" name="submitThis" value="Search" class="btn" /></div>

</form>

</div>

<?php

if(isset($_POST['submitThis']) && $_POST['submitThis']=="Search")
	$calendars = calendarModel::searchCalendar($_POST);
else
	$calendars = calendarModel::listDates();

if(count($calendars) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no records</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table font-small">
				<tr><th>Institution</th><th>Date Applied</th><th>Proposed Visit Date</th><th>Ref No</th><th>Nationlity</th><th>Status</th></tr>';
				
	foreach($calendars as $cal)
		{
		$visitTime = $cal->visit_time == 1 ? ' 10.00' : ' 14.00';
		$visitDate = $cal->visit_date . $visitTime;
		
		$status = $cal->approved == 1 ? 'Approved' : ($cal->approved==2 ?  'Rejected' : 'Pending');

		$nationality = !empty($cal->country_id) && $cal->country_id == 110 ? 'Kenyan' : 'Foreign';

		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$cal->id.'">'.$cal->institution.'</td>
				<td>'.baseModel::formatDate($cal->date_created).'</td>
				 <td>'.baseModel::formatDate($visitDate).'</td>
				 <td>'.$cal->ref_no.'</td>
				 <td>'.$nationality.'</td>
				 <td>'.$status.'</td>
				 </tr>';
		
		}
	echo '</table></div>';

endif;


echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Book A Visit</a></div>';

	
?>