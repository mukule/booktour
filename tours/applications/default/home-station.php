
<?php
$divisor = 3;
$dir = DASHBOARD_ICONS;

$stations = '<a href="index.php?act=stations"><img src="'.$dir.'stations.png" /></a>';
$users = '<a href="index.php?act=users"><img src="'.$dir.'users.png" /></a>';
$bookings = '<a href="index.php?act=bookings"><img src="'.$dir.'bookings.png" /></a>';
$feedback = '<a href="index.php?act=feedback"><img src="'.$dir.'feedback.png" /></a>';
//$status = '<a href="index.php?act=status"><img src="'.$dir.'stations_status.png" /></a>';


?>
<div class="col-md-12 dashboard">
	
    <div class="col-md-<?php echo $divisor; ?>"><div class="icon text-center"><?php echo $stations; ?><label>My Power Stations</label></div></div>
	
    <div class="col-md-<?php echo $divisor; ?>"><div class="icon text-center"><?php echo $bookings; ?><label>Requests</label></a></div></div> 
    
  <!--  <div class="col-md-3"><div class="icon text-center"><?php echo $status; ?><label>Stations Status</label></a></div></div>	-->
    <div class="col-md-<?php echo $divisor; ?>"><div class="icon text-center"><?php echo $feedback; ?><label>Feedback</label></a></div></div>
    
   	<div class="col-md-<?php echo $divisor; ?>"><div class="icon text-center"><?php echo $users; ?><label>Users</label></a></div></div>
       
</div>