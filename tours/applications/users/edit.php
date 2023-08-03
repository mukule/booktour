<div class="col-md-12 page-title text-center">Add / Edit User</div>
  
<?php

if(isset($itemId) && $itemId > 0)
	$user = usersModel::userDetails($itemId);

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(!empty($_POST['fullname']) && !empty($_POST['emailadd']) && !empty($_POST['pwd'])  && !empty($_POST['access_lvl']))
		echo usersModel::submitUser($_POST);
	else
		echo '<div class="col-md-12 text-center isa_warning">Enter all required fields</div>';
	}

$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : (isset($user->fullname) ? $user->fullname :'') ;
$emailadd = isset($_POST['emailadd']) ? $_POST['emailadd'] : (isset($user->emailadd) ? $user->emailadd :'') ;
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : (isset($user->pwd) ? $user->pwd :'') ;

?>

<div class="col-md-6">
	<form action="" method="post" class="form">
    	
        <div class="col-md-12">
            <div class="col-md-3"><label>Fullname: </label></div>
        	<div class="col-md-9"><input class="form-control" type="text" name="fullname" value="<?php echo $fullname; ?>" required /></div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-3"><label>Email address: </label></div>
        	<div class="col-md-9"><input class="form-control" type="email" name="emailadd" value="<?php echo $emailadd; ?>" required /></div>
        </div> 
           	
        <div class="col-md-12">
            <div class="col-md-3"><label>User Access: </label></div>
        	<div class="col-md-9">
            	<select name="access_lvl" class="form-control" required>
                	<option value="">--select access level--</option>
                    <option value="1" <?php echo isset($_POST['access_lvl']) && $_POST['access_lvl']==1 ? 'selected="selected"' : (isset($user->access_lvl) && $user->access_lvl ==1 ? 'selected="selected"' :'') ;?>><?php echo baseModel::userTypes(1); ?></option>
                    <option value="2" <?php echo isset($_POST['access_lvl']) && $_POST['access_lvl']==2 ? 'selected="selected"' : (isset($user->access_lvl) && $user->access_lvl ==2 ? 'selected="selected"' :'') ;?>><?php echo baseModel::userTypes(2); ?></option>
                    <option value="3" <?php echo isset($_POST['access_lvl']) && $_POST['access_lvl']==3 ? 'selected="selected"' : (isset($user->access_lvl) && $user->access_lvl ==3 ? 'selected="selected"' :'') ;?>><?php echo baseModel::userTypes(3); ?></option>                    
                </select>
            
            </div>
        </div>
        
        <?php if(isset($itemId) && $itemId > 0): ?>
       		 <div class="col-md-12 text-center small">Note : Edit below ONLY IF you are changing the password. If not, leave it as it is.</div> 
        <?php endif; ?>
        
        
        <div class="col-md-12">
            <div class="col-md-3"><label>Password: </label></div>
        	<div class="col-md-9"><input class="form-control" type="password" name="pwd" value="<?php echo $pwd; ?>" required /></div>
        </div>         
        
    	<div class="col-md-12 text-center">
        	<input type="submit" name="submitThis" value="Submit" class="btn" />
            <a href="<?php echo $urls; ?>" class="btn">Cancel</a>
        </div>
        
		<?php if(isset($itemId) && $itemId > 0): ?>
			<input type="hidden" name="userid" value="<?php echo $itemId; ?>" />
             <input type="hidden" name="url" value="<?php echo $urls; ?>&do=details&uid=<?php echo $itemId; ?>" />
        <?php
        else:
        ?>
        <input type="hidden" name="url" value="<?php echo $urls; ?>" />
		<?php endif; ?>	

       
        
    </form>
</div>

<div class="col-md-6">
	<h3 class="page-title">User Levels and roles</h3>
    <ul>
    	<li><?php echo baseModel::userTypes(1); ?> - ICT department who have the entire system's functionality</li>
        <li><?php echo baseModel::userTypes(2); ?> - Admin users who can add, edit, publish</li>
        <li><?php echo baseModel::userTypes(3); ?> - Chiefs, managing stations closure</li>
    </ul>
</div>

