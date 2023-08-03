<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$row = feedbackModel::feedbackDetails($itemId);

?>


<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Full Name</label><?php echo $row->fullname; ?></div>
    <div class="col-md-4"><label>Phone</label><?php echo $row->phoneno; ?></div>
    <div class="col-md-4"><label>Email</label><?php echo $row->emailadd; ?></div>    
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Station</label><?php echo stationsModel::stationDetails($row->station_id)->title; ?></div>
    <div class="col-md-4"><label>Ref No</label><?php echo $row->ref_no; ?></div>
    <div class="col-md-4"><label>Date Sent</label><?php echo baseModel::formatDate($row->date_created); ?></div>    
</div>

<div class="col-md-12 full-row">
    <div class="col-md-4"><label>Feedback</label><?php echo $row->comments; ?></div>
</div>



<div class="col-md-12 full-row"><div class="col-md-12 text-center"><a href="<?php echo $urls; ?>" class="btn">Back to listing</a></div></div>
