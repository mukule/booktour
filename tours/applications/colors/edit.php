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
	if(empty($_POST['title']) || empty($_POST['code']) || strlen(trim($_POST['code'])) > 6 )
		echo '<div class="col-md-12 isa_warning text-center">Enter all details needed</div>';
	else
		echo colorsModel::submitColor($_POST);

	}

	
	if(isset($itemId) && $itemId > 0)
		$color = colorsModel::colorDetails($itemId);
	
	$title = isset($_POST['title']) ? $_POST['title'] : ( isset($color->title) ? $color->title  : '' );
	$code = isset($_POST['code']) ? $_POST['code'] : ( isset($color->code) ? $color->code  : '' );

	?>
	
<form action="" method="post" class="form" >
    <div class="col-md-12">
        <label class="required">Title : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required maxlength="50" />
    </div>
     
    <div class="col-md-12">
        <label class="required">Hexa color code (without #): </label>
        <input type="text" class="form-control" name="code" value="<?php echo $code; ?>" required maxlength="6" />
    </div>
    
    
    <div class="col-md-12 text-center">
        <input type="submit" class="btn" name="submitThis" value="Submit" /> <a href="<?php echo $urls; ?>" class="btn">Cancel</a>
    </div>        
    
    <?php if(isset($itemId) && $itemId > 0): ?>
        <input type="hidden" name="colorid" value="<?php echo $itemId; ?>" />
    <?php endif; ?>
    
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
</form>

	
</div>