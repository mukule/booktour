
<div class="col-md-12 searchform">
	<form action="" method="post">
    	<div class="col-md-3">
        	<?php
			$users = usersModel::listUsers();
			?>
        
        	<select name="uid" class="form-control">
            	<option value="">--select user--</option>
                <?php
				foreach($users as $user)
					{
					$sel = isset($_POST['uid']) && $_POST['uid'] == $user->id ? 'selected="selected"' :'';
					echo '<option value="'.$user->id.'" '.$sel.'>'.$user->fullname.'</option>';
					}
				?>
                
            </select>
        
        </div>
        
        <div class="col-md-3"><input type="text" name="date_from" id="date_from" class="form-control" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : ''; ?>" readonly="readonly" placeholder="Date from" /></div>
        
        <div class="col-md-3"><input type="text" name="date_to" id="date_to" class="form-control" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : ''; ?>" readonly="readonly" placeholder="Date To" /></div>
        
        <div class="col-md-3">
            <input type="submit" name="submitThis" value="Search" class="btn" >
        
        </div>
        
  		
                
    </form>


</div>



<div class="col-md-12 frame-400">
    <div class="col-md-12">
    
        <?php
		
		if(isset($_POST['submitThis']) && $_POST['submitThis']=="Search")
			$rows = logsModel::searchUserLogs($_POST);
		else
        	$rows = logsModel::listUserLogs();	
    
        if(count($rows) == 0)
            echo '<div class="col-md-12 isa_error text-center">There are no records.</div>';
        else
            {
            echo '<table width="100%" class="table">
                <tr><th>User</th><th>Date</th><th>Action</th></tr>';
            
			$count = 0;
			
			foreach($rows as $row)
                {			
                
				$bg = $count%2==0 ? $bg_light : $bg_dark ;
				
				$name = usersModel::userDetails($row->uid);
				
				$fullname = !empty($name) ? $name->fullname : '<span class="error"><i>Name not set</i></span>';
				
                echo '<tr bgcolor="'.$bg.'"><td>'.$fullname.'</td><td>'.baseModel::formatDate($row->date_created).'</td><td>'.$row->action.'</td></tr>';
				
				$count++;
				
                }
                
                echo '</table>'; 
            }
        
        ?>
        
    </div>
</div>




<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
 
	$(function() {
		$( "#date_from" ).datepicker({
			beforeShowDay: $.datepicker.noWeekends,
			dateFormat: 'dd/mm/yy',
			changeMonth: true, 
			changeYear: true,  
			//yearRange: "-1:", 
			//minDate: "+1d",
			maxDate: "+2Y"
		});
	});
  
	$(function() {
		$( "#date_to" ).datepicker({
			beforeShowDay: $.datepicker.noWeekends,
			dateFormat: 'dd/mm/yy',
			changeMonth: true, 
			changeYear: true,  
			//yearRange: "-1:", 
			//minDate: "+1d",
			maxDate: "+2Y"
		});
	});  
  </script>
  