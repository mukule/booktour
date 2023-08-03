<!--<div class="col-md-12 page-title">My Profile Details</div>-->

<?php

$urls = 'index.php?act='.$_REQUEST['act'];

$me = usersModel::userDetails(MYID);


if(isset($_POST['submitThis']) && $_POST['submitThis']=="Submit")
	{
	
	if(empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['confirmpass']) )
		echo '<div class="col-md-12 isa_error text-center">All fields are mandatory</div>';
	elseif(trim($_POST['newpass']) != trim($_POST['confirmpass']))	
		echo '<div class="col-md-12 isa_error text-center">The new and confirmed passwords are not the same</div>';
	elseif(md5($_POST['oldpass']) != $me->pwd )
		echo '<div class="col-md-12 isa_error text-center">The old password provided is incorrect</div>';
	else
		echo profileModel::changePassword($_POST);
	}


if(isset($_REQUEST['msg']) && $_REQUEST['msg']=="success")
	echo '<div class="col-md-12 isa_success text-center">successfully updated password</div>';

?>
<div class="col-md-12">
	<div class="col-md-6">
    	<h4>My Profile Details</h4>
        <div class="col-md-12"><label>Fullname</label><?php echo $me->fullname; ?></div>
        <div class="col-md-12"><label>Email Address</label><?php echo $me->emailadd; ?></div>
        <div class="col-md-12"><label>User Level</label><?php echo baseModel::userTypes($me->access_lvl); ?></div>
    
    </div>
    
	<div class="col-md-6">
    	<h4>Change your password</h4>
    	<form action="" method="post">
        
        	<div class="col-md-12"><input type="password" name="oldpass" class="form-control" placeholder="your old password" required /></div>
            
            <div class="col-md-12"><input type="password" name="newpass" class="form-control" placeholder="your new password" required /></div>
            
            <div class="col-md-12"><input type="password" name="confirmpass" class="form-control" placeholder="confirm your password" required /></div>
        
        	 <div class="col-md-12"><input type="submit" name="submitThis" class="btn" value="Submit" /></div>
        	
            <input type="hidden" name="url" value="<?php echo $urls; ?>">
            
        </form>
    
    </div>  
    


</div>