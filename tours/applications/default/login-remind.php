
<h2 class="heading text-center">Remind Password</h2>


<?php
if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Request")
	{
	
	if(empty($_POST['emailadd']))
		echo '<div class="col-md-12 isa_error text-center">Enter all required fields</div>';
	else
		echo baseModel::remindPassword($_POST);
		
	}



?>

<form action="" method="post">
  
   <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=="success" ): ?>
		<div class="col-md-12 isa_success text-center">
        	<p>Successful. The details have been sent to your inbox.</p>
            <p>Note: If the details are not in your inbox, please check in your spam/junk folder.</p>        
        </div>
        <div class="col-md-12 text-center">You can now login <a href="index.php?pg=login">Login Page</a></div>
        
    <?php 
		return;
	elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="error" ): ?>   
        <div class="col-md-12 isa_error text-center">The details you supplied are incorrect or do not match. Please try again, or contact admin.</div>
	<?php
    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="em" ): ?>   
        <div class="col-md-12 isa_error text-center">
        	<p>The password was successfully reset.</p>
        	<p>There was a problem relaying email. Please contact system admin.</p>
        </div>
   
   <?php 
   return;
   endif; ?>
   
	
	<div class="col-md-12">Please enter the below details, as used in the system</div>
    
    <div class="col-md-12"><input type="email" class="form-control" name="emailadd" required placeholder="Email address" /></div>

    <div class="col-md-12 text-center"><input class="btn" type="submit" name="submitThis" value="Request" /></div>
	
    <div class="col-md-12 text-center"><a href="<?php echo $urls; ?>">Got credentials? Login</a></div>
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>&do=pwd" />
    
</form>

