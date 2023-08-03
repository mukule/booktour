<?php

$articlePositions = articlePositionsModel::listPositions();

if(count($articlePositions) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no stations listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>Actions</th></tr>';
				
	foreach($articlePositions as $inst)
		{

		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$inst->id.'" title="manage"><img src="'.ACTION_ICONS.'edit.png" title="manage" /></a>';
		$del = '<a href="'.$urls.'&pg=del&itemId='.$inst->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$inst->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$inst->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $inst->active ==0 ? $pub : $unpub;
		
		$actions = ACCESS_LVL == 1 ? $publish  . $edit . $del : '--' ;
		
		echo '<tr><td>'.$inst->title.'</td>
				 <td class="actions">'.$actions.'</td></tr>';
		
		}
	echo '</table></div>';

endif;

echo ACCESS_LVL == 1 ? '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New</a></div>' : '';

	
?>