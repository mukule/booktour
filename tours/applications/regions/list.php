<?php

$regions = regionsModel::listRegions();

if(count($regions) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no stations listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>In Charge</th><th>Color code</th><th>Image</th><th>Email</th></th><th>Sign</th>';
				
				if(ACCESS_LVL == 1) //super admin	
					echo '<th class="actions">Ordering <img src="images/icons/arrow-up-down.png" alt="edit" title="edit"></th><th>Actions</th>';
			
			echo '</tr>';
					
	foreach($regions as $reg)
		{
		
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$reg->id.'" title="manage"><img src="'.ACTION_ICONS.'edit.png" title="manage" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$reg->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$reg->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$reg->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $reg->active ==0 ? $pub : $unpub;		
		
		$actions =  $publish . $edit . $del ;
		
		$imgFile = REGIONS_IMAGES. $reg->img;
		
		if(is_file($imgFile))
			$img = '<img src="'.$imgFile.'" style=" width:50px; height:auto;" />';
		else
			$img = 'Image file not found';
			
		$up = '<a href="'.$urls.'&pg=up&itemId='.$reg->id.'" title="moveup" ><img src="images/icons/arrow-up.png" alt="up" title="up"></a>';
		$down = '<a href="'.$urls.'&pg=down&itemId='.$reg->id.'" title="movedown" ><img src="images/icons/arrow-down.png" alt="down" title="down"></a>';
				
		if($reg->ordering == 1)
			$ordering = $down;
		elseif($reg->ordering >= count($regions))
			$ordering = ' &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; ' .  $up;
		else
			$ordering = $down. ' &nbsp; &nbsp; ' .  $up;	
			
		$sign = !empty($reg->signature) ? '<img src="data:image/jpeg;base64,'.base64_encode( $reg->signature ).'" height="20" />' : '---'; 	
		
		$color = !empty($reg->bg_color_id) ? colorsModel::colorDetails($reg->bg_color_id) : '';
		$bg = !empty($color) ? $color->code : '';		
				
		$incharge = isset($reg->incharge) ? $reg->incharge . ($reg->acting ==1 ? ' (Acting)' : '') : '';		
				
		
		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$reg->id.'">'.$reg->title.'</a></td>
				<td>'.$incharge.'</td>
				 <td><div style="background-color:#'.$bg.'; width:20px; height:20px;">&nbsp;</div></td>
				 <td class="actions">'.$img.'</td>
				 <td>'.$reg->emailadd.'</td>
				 <td>'.$sign.'</td>';
				 
				 if(ACCESS_LVL == 1) //super admin	
				 	echo '<td class="actions">'.$ordering .'</td><td class="actions">'.$actions.'</td>';
		
		echo '</tr>';
		
		}
	echo '</table></div>';

endif;

 if(ACCESS_LVL == 1)
	echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New Region</a></div>';

	
?>