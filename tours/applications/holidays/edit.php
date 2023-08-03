<?php
 if(ACCESS_LVL != 1)
 	{
	echo '<div class="col-md-12 isa_error text-center"><p>Sorry, you dont have rights for this page</p>
		 <p><a href="'.$urls.'">Back to List</a></p></div>';
	return;
	}
?>

<div class="col-md-12 form">

<div class="page-title">Add / Edit Holiday</div>
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	echo holidaysModel::submitHoliday($_POST);
	}


if(isset($itemId) && $itemId > 0)
	$holiday = holidaysModel::holidayDetails($itemId);
	
$title = isset($_POST['title']) ? $_POST['title'] : ( isset($holiday->title) ? $holiday->title  : '' );
$date_holiday = isset($_POST['date_holiday']) ? date("d/m/Y", strtotime($_POST['date_holiday'])) : ( isset($holiday->date_holiday) ? date("d/m/Y", strtotime($holiday->date_holiday))  : '' );

	?>
	
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="col-md-12">
        <label>Title : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required />
    </div>
     
    <div class="col-md-12">
        <label>Holiday Date : </label>
        <input type="text" class="form-control" id="date_holiday" name="date_holiday" value="<?php echo $date_holiday; ?>" required />
    </div>
    
    <div class="col-md-12">
        <label>Select type of a holiday : </label>
        <select class="form-control" name="annual" required>
            <option value="">-- select --</option>
            <option value="1" <?php echo isset($holiday->annual) && $holiday->annual ==1 ? 'selected="selected"' : (isset($_POST['annual']) && $_POST['annual'] ==1 ? 'selected="selected"' : ''); ?>>Fixed Date All Years</option>
            <option value="0" <?php echo isset($holiday->annual) && $holiday->annual ==0 ? 'selected="selected"' : (isset($_POST['annual']) && $_POST['annual'] ==0 ? 'selected="selected"' : ''); ?>>Date Changes Every Year</option>
        </select>
    </div> 		 
    
    <div class="col-md-12 text-center">
        <input type="submit" class="btn" name="submitThis" value="Submit" />
        
        <?php
        if(isset($itemId) && $itemId > 0)	                
            echo '<a href="'.$urls.'" class="btn">Cancel</a>';
        else
            echo '<a href="'.$urls.'" class="btn">Cancel</a>';
        ?>
    </div>        
    
    <?php
    if(isset($itemId) && $itemId > 0):
        ?>
        <input type="hidden" name="holidayid" value="<?php echo $itemId; ?>" />
        <?php
        endif;
        
        ?>
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
</form>

	
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>

$(function() {
	$( "#date_holiday" ).datepicker({
		//beforeShowDay: $.datepicker.noWeekends,
		dateFormat: 'dd/mm/yy',
		changeMonth: true, 
		changeYear: true,  
		//yearRange: "+1:", 
		minDate: "0",
		maxDate: "+2Y"
	});
});

</script>