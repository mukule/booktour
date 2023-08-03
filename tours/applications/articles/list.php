<?php

$articles = articlesModel::listArticles();

if(count($articles) < 1 ):
	echo '<div class="col-md-12 text-center isa_warning">There are currently no stations listed</div>';
else:
	echo '<div class="col-md-12 frame-400">
			<table class="table">
				<tr><th>Title</th><th>Article Position</th><th>Actions</th></tr>';
					
	foreach($articles as $item)
		{
		
		$edit = '<a href="'.$urls.'&pg=edit&itemId='.$item->id.'" title="manage"><img src="'.ACTION_ICONS.'edit.png" title="manage" /></a>';
		
		$del = '<a href="'.$urls.'&pg=del&itemId='.$item->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
		$pub = '<a href="'.$urls.'&pg=pub&itemId='.$item->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
		$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$item->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
		
		$publish = $item->active ==0 ? $pub : $unpub;		
		
		$actions =  $publish . $edit . $del ;
		
		$position = !empty($item->article_position_id) ? articlePositionsModel::articlePositionDetails($item->article_position_id)->position : '--';
		
		echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$item->id.'">'.$item->title.'</a></td><td>'.$position.'</td><td class="actions">'.$actions.'</td></tr>';
		
		}
	echo '</table></div>';

endif;

 if(ACCESS_LVL == 1)
	echo '<div class="col-md-12 text-center"><a href="'.$urls.'&pg=edit" class="btn">Add New Article</a></div>';

	
?>