<div class="col-md-12">

	<?php
	$rows = usersModel::listUsers();
	
	if(count($rows) == 0)
		echo '<div class="col-md-12 isa_error text-center">There are no users found.</div>';
	else
		{
		echo '<div class="iframe-500">
				<table width="100%" class="table">
					<tr><th>Full Name</th><th>Email</th><th>User Level</th><th>Date Created</th><th>Actions</th></tr>';
		foreach($rows as $row)
			{			
			
			$edit = '<a href="'.$urls.'&pg=edit&itemId='.$row->id.'" title="edit"><img src="images/icons/edit.png" alt="edit" title="edit"></a>';
			$del = '<a href="'.$urls.'&pg=del&itemId='.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
			
			$add = '<a href="'.$urls.'&pg=edit" class="btn">Add New User</a>';
			
			$pub = '<a href="'.$urls.'&pg=pub&itemId='.$row->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
			$unpub = '<a href="'.$urls.'&pg=unpub&itemId='.$row->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
			
			$publish = $row->active ==0 ? $pub : $unpub;
			
			$usertype = baseModel::userTypes($row->access_lvl);
			
			if(ACCESS_LVL == 1): //super
				
				if($row->id ==  MYID || $row->id==1):
					$actions = '';
				else:
					$actions = $publish.'  '.$edit.'  '.$del;
				endif;
				
				$addnew = $add;
				
			else: //users
				$actions =  '' ;
				$addnew = '';
			endif;
			
			
			echo '<tr><td><a href="'.$urls.'&pg=details&itemId='.$row->id.'">'.$row->fullname.'</a></td>
					  <td>'.$row->emailadd.'</td>
					  <td>'.$usertype.'</td>
					  <td>'.baseModel::formatDate($row->date_created).'</td>
					  <td class="actions">'.$actions.'</td></tr>';
			
			/*
			echo '<div class="col-md-6">
					<div class="col-md-12">
						<div class="col-md-3"><label>Full Name : </label></div>
						<div class="col-md-9"><a href="'.$urls.'&pg=details&itemId='.$row->id.'">'.$row->fullname.'</a></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-3"><label>Email : </label></div>
						<div class="col-md-9">'.$row->emailadd.'</div>
					</div>					
					<div class="col-md-12">
						<div class="col-md-3"><label>User Level : </label></div>
						<div class="col-md-9">'.$usertype.'</div>
					</div>					
					<div class="col-md-12">
						<div class="col-md-3"><label>Date Created : </label></div>
						<div class="col-md-9">'.baseModel::formatDate($row->date_created).'</div>				
					</div>
				
					<div class="col-md-12 actions text-center">'.$actions.'</div>
				</div>';
				*/
			} 
			
			echo '</table></div>';
    	}
	
	
	echo '<div class="col-md-12 text-center">'.$addnew.'</div>';
	
	?>
    
</div>
