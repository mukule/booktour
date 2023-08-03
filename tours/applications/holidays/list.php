<div class="col-md-12">
<?php
//print_r($_POST);
?>

<form method="post" action="">
	<div class="col-md-3">
    	<select name="year" class="form-control" onchange="this.form.submit()">
        	<option value="">--select year--</option>
        	<?php
			
			$years = holidaysModel::listYearsFromHolidays();
			
			foreach($years as $yr)
				{
				
				$sel = isset($_POST['year']) && $_POST['year']==$yr->year ? 'selected="selected"' : '';
				
				echo '<option value="'.$yr->year.'" '.$sel.'>'.$yr->year.'</option>';
				}
			
			?>
        </select>
    
    </div>
</form>
</div>


<?php

if(isset($_POST['year']) && !empty($_POST['year'])  )
	$holidays = holidaysModel::listHolidays($_POST['year']);
else
	$holidays = holidaysModel::listHolidays(date("Y"));

if(count($holidays) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no holidays listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Date</th><th>Title</th><th>Fixed Annual Date?</th><th>Actions</th></tr>';
				
	foreach($holidays as $hol)
		{
		
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$hol->id.'" title="manage"><img src="'.ACTION_ICONS.'edit.png" title="manage" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$hol->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$hol->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$hol->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $hol->active ==0 ? $pub : $unpub;		
		
		$actions = ACCESS_LVL == 1 ? $publish . $edit . $del : '--';
		
		$annual = $hol->annual == 1 ? 'Yes' : 'No';
		
		$date = $hol->annual == 1 ? date( "M jS", strtotime( $hol->date_holiday ) ) : baseModel::formatDate($hol->date_holiday);
		
		
		echo '<tr><td>'.$date.'</td>
				 <td>'.$hol->title.'</div></td>
				 <td class="actions">'.$annual.'</td>
				 <td class="actions">'.$actions.'</td></tr>';
		
		}
	echo '</table></div>';

endif;

echo ACCESS_LVL == 1 ? '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New Holiday</a></div>' : '';

?>