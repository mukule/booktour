<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$station = stationsModel::stationDetails($itemId);

?>

<div class="col-md-12 text-center">
	<h4><?php echo $station->title;  ?></h4>
	<h5>Manage Status / Closures</h5>
</div>



<div class="col-md-12">

    <div class="col-md-12 station_status">
        <h4 class="text-center">Closure Dates</h4>
    
        <?php
        $statuses = stationsModel::listStationStatuses($itemId);
        
        if(count($statuses) < 1 ):
            echo '<div class="col-md-12 text-center isa_warning">There are currently no records for this station</div>';
        else:
            echo '<div class="col-md-12 frame-400">
					<table class="table">
						<tr><th>Start Date</th><th>End Date</th><th>Description</th><th>User</th><th>Actions</th></tr>
					';
            foreach($statuses as $stat)
                {
                
				$manageUrl = $urls .'&pg='.$_REQUEST['pg'].'&itemId='.$_REQUEST['itemId'];
				
				$edit = '<a href="'.$manageUrl.'&do=edit&sid='.$stat->id.'" title="edit"><img src="'.ACTION_ICONS.'edit.png" title="edit" /></a>';
				
				$del = '<a href="'.$manageUrl.'&do=del&sid='.$stat->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\');" title="delete"><img src="images/icons/delete.png" alt="delete" title="delete"></a>';
					
				$pub = '<a href="'.$manageUrl.'&do=pub&sid='.$stat->id.'" title="unpublish" ><img src="images/icons/cross.png" alt="unpublish" title="publish"></a>';
				$unpub = '<a href="'.$manageUrl.'&do=unpub&sid='.$stat->id.'" title="publish" ><img src="images/icons/tick.png" alt="publish" title="unpublish"></a>';
				
				$publish = $stat->active ==0 ? $pub : $unpub;		
				
				if( ACCESS_LVL == 1 || ACCESS_LVL == 3) //SU or chiefs	
					$actions = $publish .  $edit . $del ;
				else
					$actions =  'No Rights' ;

                echo '<tr><td>'.baseModel::formatDate($stat->date_start).'</td><td>'.baseModel::formatDate($stat->date_end).'</td>
						  <td>'.$stat->description.'</td><td>'.usersModel::userDetails($stat->created_by)->fullname.'</td><td class="actions">'.$actions.'</td></tr>';
                
                }		
            echo '</table>
				</div>';
        endif;
        
        ?>
        
    </div>
  
  <?php include "manage-edit".EXT; ?>