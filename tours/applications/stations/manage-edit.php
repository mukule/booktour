
<?php

if( ACCESS_LVL != 1 && ACCESS_LVL != 3) //SU or chiefs
	{
	echo '<div class="col-md-12 isa_error text-center">Only Chiefs can access this.</div>';
	echo '<div class="col-md-12 text-center"><a href="'.$thisUrl.'" class="btn">Back</a></div>';
	return;
	}

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	
	$datesExist = stationsModel::checkIfDatesExist($_POST);
	
	if(isset($_POST['date_start']) && isset($_POST['date_end']) && strtotime($_POST['date_start']) >= strtotime($_POST['date_end']) )
		echo '<div class="col-md-12 isa_error text-center">Error : Start date cannot be greater than end date</div>';
	elseif($datesExist > 0 )
		echo '<div class="col-md-12 isa_error text-center">Error : Please select start and end dates that are not within, or overlap an existing blocked dates</div>';
	else
		echo stationsModel::submitStatus($_POST);
		
	}

if(isset($sid))
	$item = stationsModel::stationStatusDetails($sid);

$start = isset($_POST['date_start']) ? $_POST['date_start'] : ( isset($item->date_start) ? $item->date_start : '' );
$end = isset($_POST['date_end']) ? $_POST['date_end'] : ( isset($item->date_end) ? $item->date_end : '' );
$description = isset($_POST['description']) ? $_POST['description'] : ( isset($item->description) ? $item->description : '' ) ;

?>    
 
<div class="col-md-12 station_status station_status-form ">
    <h4 class="text-center">Edit status</h4>
    <form action="" method="post">
    
        <div class="col-md-12">
            <label>From Date</label>
            <input type="text" name="date_start" id="date_start" class="form-control" readonly="readonly" required value="<?php echo $start; ?>" />
        </div>

        <div class="col-md-12">
            <label>To Date</label>
            <input type="text" name="date_end" id="date_end" class="form-control" readonly="readonly" required value="<?php echo $end; ?>" />
        </div>
        
        <div class="col-md-12">
            <label>Reason / Description</label>
            <textarea name="description" class="form-control" required><?php echo $description; ?></textarea>
        </div>
        
        <div class="col-md-12 text-center"><input type="submit" name="submitThis" value="Submit" class="btn" /> <a href="<?php echo $thisUrl; ?>" class="btn">Cancel</a></div>
    
        <input type="hidden" name="stationid" value="<?php echo $itemId; ?>" />
        <input type="hidden" name="url" value="<?php echo $urls; ?>&pg=<?php echo $_REQUEST['pg']; ?>&itemId=<?php echo $itemId; ?>" />
        
        <?php if(isset($sid) && $sid > 0): ?>	
        <input type="hidden" name="statusid" value="<?php echo $sid; ?>" />
        <?php endif; ?>	
    
    </form>
</div>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!----to add timepicker ---->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

  <script>

  $(function() {
    $( "#date_start" ).datepicker(
		{
    	dateFormat: 'dd-mm-yy',
		minDate: 0
		}	
		);
  });

  
  $(function() {
    $( "#date_end" ).datepicker(
		{
    	dateFormat: 'dd-mm-yy',
		minDate: 0
		}	
		);
  });  
    
  
  </script>