<?php

 if(ACCESS_LVL != 1)
 	{
	echo '<div class="col-md-12 isa_error text-center"><p>Sorry, you dont have rights for this page</p>
		 <p><a href="'.$urls.'">Back to List</a></p></div>';
	return;
	}


?>
<div class="col-md-12 form">
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(empty($_POST['title'])  )
		echo '<div class="col-md-12 isa_warning text-center">Enter all details needed</div>';
	else
		echo purposesModel::submitPurpose($_POST);

	}

	
	if(isset($itemId) && $itemId > 0)
		$purpose = purposesModel::purposeDetails($itemId);
	
	$title = isset($_POST['title']) ? $_POST['title'] : ( isset($purpose->title) ? $purpose->title  : '' );

	?>
	
<form action="" method="post" class="form" >
    <div class="col-md-12">
        <label class="required">Purpose : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required maxlength="50" />
    </div>
     
    <div class="col-md-12 text-center">
        <input type="submit" class="btn" name="submitThis" value="Submit" /> <a href="<?php echo $urls; ?>" class="btn">Cancel</a>
    </div>        
    
    <?php if(isset($itemId) && $itemId > 0): ?>
        <input type="hidden" name="purposeid" value="<?php echo $itemId; ?>" />
    <?php endif; ?>
    
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
</form>

	
</div>