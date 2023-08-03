<?php

$plants = plantsModel::listplants(0);

if(count($plants) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no plants listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>Station</th><th>Actions</th></tr>';
	
	foreach($plants as $plant)
		{
		
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$plant->id.'" title="edit"><img src="'.ACTION_ICONS.'edit.png" title="edit" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$plant->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$plant->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$plant->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $plant->active ==0 ? $pub : $unpub;		
		
		if(ACCESS_LVL == 1) //super admin		
			$actions = $publish .  $edit . $del ;
		else
			$actions =  $edit ;
		
		
			
		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$plant->id.'">'.$plant->title.'</a></td>
				  <td>'.stationsModel::stationDetails($plant->station_id)->title.'</td>
				 <td class="actions">'.$actions.'</td></tr>';
		
		}
	echo '</table></div>';

endif;

if(ACCESS_LVL == 1)
	echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New plant</a></div>';

	
?>