<?php

$purposes = purposesModel::listPurposes();

if(count($purposes) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no records listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>Actions</th></tr>';
					
	foreach($purposes as $purpose)
		{
		
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$purpose->id.'" title="manage"><img src="'.ACTION_ICONS.'edit.png" title="manage" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$purpose->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$purpose->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$purpose->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $purpose->active ==0 ? $pub : $unpub;		
		
		$actions =  $publish . $edit . $del ;
		
		echo '<tr><td>'.$purpose->title.'</td>
				 <td class="actions">'.$actions.'</td>
				 </tr>';
		
		}
	echo '</table></div>';

endif;

 if(ACCESS_LVL == 1)
	echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New Purpose</a></div>';

	
?>