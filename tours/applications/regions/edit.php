<?php

 if(ACCESS_LVL != 1)
 	{
	echo '<div class="col-md-12 isa_error text-center"><p>Sorry, you dont have rights for this page</p>
		 <p><a href="'.$urls.'">Back to List</a></p></div>';
	return;
	}

$maxOrder =regionsModel::getHighestOrdering();
$nextOrdering = $maxOrder+1;

?>
<div class="col-md-12 form">
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['bg_color_id']) )
		echo '<div class="col-md-12 isa_warning text-center">Enter all details needed</div>';
	else
		echo regionsModel::submitRegion($_POST, $_FILES);

	}
	
	if(isset($itemId) && $itemId > 0)
		$region = regionsModel::regionDetails($itemId);
	
	$title = isset($_POST['title']) ? $_POST['title'] : ( isset($region->title) ? $region->title  : '' );
	$description = isset($_POST['description']) ? $_POST['description'] : ( isset($region->description) ? $region->description  : '' );
	$emailadd = isset($_POST['emailadd']) ? $_POST['emailadd'] : ( isset($region->emailadd) ? $region->emailadd  : '' );
	$contacts_email = isset($_POST['contacts_email']) ? $_POST['contacts_email'] : ( isset($region->contacts_email) ? $region->contacts_email  : '' );
	$contacts_address = isset($_POST['contacts_address']) ? $_POST['contacts_address'] : ( isset($region->contacts_address) ? $region->contacts_address  : '' );
	$contacts_phoneno = isset($_POST['contacts_phoneno']) ? $_POST['contacts_phoneno'] : ( isset($region->contacts_phoneno) ? $region->contacts_phoneno  : '' );
	$incharge = isset($_POST['incharge']) ? $_POST['incharge'] : ( isset($region->incharge) ? $region->incharge  : '' );
	$acting = isset($_POST['acting']) && $_POST['acting']==1 ? 'checked="checked"' : ( isset($region->acting) && $region->acting==1 ? 'checked="checked"'  : '' );
	
	?>
	
<form action="" method="post" enctype="multipart/form-data">
    <div class="col-md-12">
        <label class="required">Title : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required maxlength="50" />
    </div>
     
    <div class="col-md-12">
        <label class="required">Description : </label>
        <textarea class="mceEditor" name="description" ><?php echo $description; ?></textarea>
    </div>
    
    <div class="col-md-12">
        <label class="required">Description's Background Color : </label>
        <select name="bg_color_id" class="form-control" required>
        	<option value="">--select color--</option>
            <?php
			$colors =  colorsModel::listColors();
			
			foreach($colors as $color )
				{
				$sel = isset($_POST['bg_color_id']) && $_POST['bg_color_id'] == $color->id ? 'selected="selected"' : ( isset($region->bg_color_id) && $region->bg_color_id == $color->id ? 'selected="selected"'  : '' );
				echo '<option value="'.$color->id.'" '.$sel.'>'.$color->title.'</option>';
				}
			?>
        </select>
        
    </div>
    
    <div class="col-md-12">
        <label>Background Image (jpg|jpeg|png): <small>(NOTE: Don't select if your are not changing this)</small></label>
        <input type="file" class="form-control" name="img" accept="image/*"  />
    </div>           
    
    <div class="col-md-12">
        <label>In-Charge:</small></label>
        <input type="text" class="form-control" name="incharge" value="<?php echo $incharge; ?>" maxlength="50" />
    </div>    
    
    <div class="col-md-12">
        <label>Tick if Is In-Charge in acting capacity :</small></label>
        <input type="checkbox" class="form-control" name="acting" value="1" <?php echo $acting; ?> />
    </div>      
    
    
   	<div class="col-md-12">
        <label class="required">Chief Engineer's Email: <small>(for email notification CC)</small></label>
        <input type="email" class="form-control" name="emailadd" value="<?php echo $emailadd; ?>" required maxlength="50" />
    </div>
    
    <div class="col-md-12">
        <label>Regional manager signature: <small>(NOTE: Don't select if your are not changing this)</small></label>
        <input type="file" class="form-control" name="signature" accept="image/*"  />
    </div>           
    
    <div class="col-md-12">
    	<label>Contacts: Email Address</label>
        <input class="form-control" name="contacts_email" value="<?php echo $contacts_email ?>" maxlength="50" />
    </div>
        
    <div class="col-md-12"><label>Contacts: Phone number</label>
        <input class="form-control" name="contacts_phoneno" value="<?php echo $contacts_phoneno ?>" maxlength="50" />
    </div>
        
    <div class="col-md-12"><label>Contacts: Address</label>
        <textarea class="mceEditor" name="contacts_address"><?php echo $contacts_address ?></textarea>
    </div>
    
    <div class="col-md-12 text-center">
        <input type="submit" class="btn" name="submitThis" value="Submit" />
        
        <?php
        if(isset($itemId) && $itemId > 0 )	//superadmins              
            echo '<a href="'.$urls.'&pg=details&itemId='.$itemId.'" class="btn">Cancel</a>';
        else
            echo '<a href="'.$urls.'" class="btn">Cancel</a>';
        ?>
    </div>        
    
    <?php if(isset($itemId) && $itemId > 0): ?>
        <input type="hidden" name="regionid" value="<?php echo $itemId; ?>" />
    <?php else: ?>        
        <input type="hidden" name="ordering" value="<?php echo $nextOrdering; ?>" />
    <?php endif; ?>
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
</form>

	
</div>