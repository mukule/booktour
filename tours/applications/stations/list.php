<?php

$stations = stationsModel::listStations();

if(count($stations) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no stations listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>Region</th><th>In-Charge</th><th>Order</th><th>Actions</th></tr>';
	
	foreach($stations as $stat)
		{
		
		$manage = '<a href="'.$urls.'&pg=manage&itemId='.$stat->id.'" title="manage"><img src="'.ACTION_ICONS.'manage.png" title="manage" /></a>';
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$stat->id.'" title="edit"><img src="'.ACTION_ICONS.'edit.png" title="edit" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$stat->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$stat->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$stat->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $stat->active ==0 ? $pub : $unpub;		
		
		$up = '<a href="'.$urls.'&pg=up&itemId='.$stat->id.'" title="moveup" ><img src="images/icons/arrow-up.png" alt="up" title="up"></a>';
		$down = '<a href="'.$urls.'&pg=down&itemId='.$stat->id.'" title="movedown" ><img src="images/icons/arrow-down.png" alt="down" title="down"></a>';
				
		if($stat->ordering == 1)
			$ordering = $down;
		elseif($stat->ordering >= count($stations))
			$ordering = ' &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; ' .  $up;
		else
			$ordering = $down. ' &nbsp; &nbsp; ' .  $up;	
		
		if(ACCESS_LVL == 1) //super admin		
			$actions = $publish . $manage . $edit . $del ;
		else
			$actions =  $manage . $edit ;
		
		$users = '';
		if(strlen(trim($stat->user_id)) > 0)
			{	
			$uids = explode(",",$stat->user_id);
			foreach($uids as $uid)
				{
				$user = usersModel::userDetails($uid);
				
				$users .= !empty($user) ? $user->fullname.', ' : '';
				}
			if(strlen(trim($users)) > 0)	
				$users = substr(trim($users),0,-1);		
		else
			$users = "";
			
			}
			
		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$stat->id.'">'.$stat->title.'</a></td>
				  <td>'.regionsModel::regionDetails($stat->region_id)->title.'</td>
				  <td class="small">'.$users.'</td>
				  <td class="actions">'.$ordering.'</td>
				 <td class="actions">'.$actions.'</td></tr>';
		
		}
	echo '</table></div>';

endif;

if(ACCESS_LVL == 1)
	echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New Station</a></div>';

	
?>