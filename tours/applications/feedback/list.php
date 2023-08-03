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
    

    
    <div class="col-md-4"><input type="submit" name="submitThis" value="Search" class="btn" /></div>

</form>

</div>

<?php

if(isset($_POST['submitThis']) && $_POST['submitThis']=="Search")
	$feedbacks = feedbackModel::searchFeedback($_POST);
else
	$feedbacks = feedbackModel::listFeedback();

if(count($feedbacks) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no records</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>From</th><th>Date Sent</th><th>Email</th><th>Phone</th></tr>';
				
	foreach($feedbacks as $feed)
		{

		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$feed->id.'">'.$feed->fullname.'</td>
				<td>'.baseModel::formatDate($feed->date_created).'</td>
				 <td>'.$feed->emailadd.'</td>
				 <td>'.$feed->phoneno.'</td>				
				 </tr>';
		
		}
	echo '</table></div>';

endif;


	
?>