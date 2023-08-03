<div class="col-md-12"><h2 class="page-header">Settings</h2></div>

<?php

$urls = 'index.php?act='.$_REQUEST['act'];

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	echo settingsModel::submitSettings($_POST);
	
	
$settings = settingsModel::settings();

$facilitiesClosed = isset($_POST['close_all_facilities']) && $_POST['close_all_facilities']==1 ? 'checked="checked"'  : ( isset($settings->close_all_facilities) && $settings->close_all_facilities == 1 ? 'checked="checked"' : '' );

?>


<div class="col-md-12">

    <form class="form" method="post" action="">
    
    <div class="col-md-12 full-row">
        <label>All facilities closed from visiting?</label>
        <input type="checkbox" name="close_all_facilities" value="1" <?php echo $facilitiesClosed; ?>>
    </div>
    
    <div class="col-md-12 full-row">
        <input type="submit" name="submitThis" value="Submit" class="btn">
    </div>
    
    <input type="hidden" name="settingsid" value="<?php echo $settings->id; ?>" />
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
    </form>


</div>