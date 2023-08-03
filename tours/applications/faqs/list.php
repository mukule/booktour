<div class="col-md-12 page-title">FAQs <small>(with ordering)</small></div>


<div class="col-md-12 list">
	<?php
	$faqs = baseModel::listFAQs(0);

	if(count($faqs) == 0)
		echo '<div class="col-md-12 isa_error text-center">There are no records found. </div>';
	else
		{
		echo '
			<div class="frame-400">
			<table width="100%" class="table">
				<thead>
				<tr><th width="80%">Question / Answer</th>';
				
				if(ACCESS_LVL == 1)
					echo '<th class="actions">Ordering <img src="images/icons/arrow-up-down.png" alt="edit" title="edit"></th><th>Actions</th>';
				
			echo '</tr></thead>';
			
		$tr ='';
		$count = 1;
		foreach($faqs as $row)
			{
			
			$edit = '<a href="'.$urls.'&pg=edit&itemId='.$row->id.'" title="edit"><img src="images/icons/edit.png" alt="edit" title="edit"></a>';
			$del = '<a href="'.$urls.'&pg=del&itemId='.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
			$pub = '<a href="'.$urls.'&pg=pub&itemId='.$row->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
			$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$row->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
			
			$publish = $row->active ==0 ? $pub : $unpub;
			
			$actions = ACCESS_LVL == 1 ? $publish . $edit . $del : '';	
			
			$up = '<a href="'.$urls.'&pg=up&itemId='.$row->id.'" title="moveup" ><img src="images/icons/arrow-up.png" alt="up" title="up"></a>';
			$down = '<a href="'.$urls.'&pg=down&itemId='.$row->id.'" title="movedown" ><img src="images/icons/arrow-down.png" alt="down" title="down"></a>';
			
			
			if($row->ordering == 1)
				$ordering = $down;
			elseif($row->ordering >= count($faqs))
				$ordering = $up;
			else
				$ordering = $up . ' &nbsp; &nbsp; ' . $down;		
			
			$tr .= '<tr>
					<td>
						<div class="col-md-12"><label>Q '.$count.': '.$row->quiz .'</label></div>
						<div class="col-md-12">A : '.$row->answer .'</div>
					</td>';
					
					if(ACCESS_LVL == 1)
						$tr .= '<td class="actions">'.$ordering .'</td><td class="actions">'.$actions.'</td>';
					
				$tr .= '</tr>';
			
			$count++;
			} 
  		echo '<tbody>'.$tr.'</tbody>
			</table>
			</div>';
			
    	}
		
		
		echo ACCESS_LVL == 1 ? '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New</a></div>' : '';
		
	
	?>
</div>

