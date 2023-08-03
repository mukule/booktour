
<?php
$divisor = 3;
$dir = DASHBOARD_ICONS;

$dashLink = 'index.php?act=';

$stations = '<a href="'.$dashLink.'stations"><img src="'.$dir.'stations.png" /></a>';
$plants = '<a href="'.$dashLink.'plants"><img src="'.$dir.'plants.png" /></a>';
$users = '<a href="'.$dashLink.'users"><img src="'.$dir.'users.png" /></a>';
$logs = '<a href="'.$dashLink.'logs"><img src="'.$dir.'logs.png" /></a>';
$settings = '<a href="'.$dashLink.'settings"><img src="'.$dir.'settings.png" /></a>';
$bookings = '<a href="'.$dashLink.'bookings"><img src="'.$dir.'bookings.png" /></a>';
$status = '<a href="'.$dashLink.'status"><img src="'.$dir.'stations_status.png" /></a>';
$transport = '<a href="'.$dashLink.'transport"><img src="'.$dir.'transport.png" /></a>';
$institutions = '<a href="'.$dashLink.'institutions"><img src="'.$dir.'institutions.png" /></a>';
$regions = '<a href="'.$dashLink.'regions"><img src="'.$dir.'regions.png" /></a>';
$holidays = '<a href="'.$dashLink.'holidays"><img src="'.$dir.'holidays.png" /></a>';
$calendar = '<a href="'.$dashLink.'calendar"><img src="'.$dir.'calendar.png" /></a>';
$feedback = '<a href="'.$dashLink.'feedback"><img src="'.$dir.'feedback.png" /></a>';
$faqs = '<a href="'.$dashLink.'faqs"><img src="'.$dir.'faqs.png" /></a>';
$reports = '<a href="'.$dashLink.'reports"><img src="'.$dir.'reports.png" /></a>';
$email = '<a href="'.$dashLink.'email"><img src="'.$dir.'email.png" /></a>';
$settings = '<a href="'.$dashLink.'settings"><img src="'.$dir.'settings.png" /></a>';
$colors = '<a href="'.$dashLink.'colors"><img src="'.$dir.'colors.png" /></a>';
$purposes = '<a href="'.$dashLink.'purposes"><img src="'.$dir.'purposes.png" /></a>';
$articles = '<a href="'.$dashLink.'articles"><img src="'.$dir.'articles.png" /></a>';

?>
<div class="col-md-12 dashboard">

	<?php
	$divStart = '<div class="col-md-'.$divisor.'"><div class="icon text-center"><div id="icon">';
	$divEnd = '</div></div></div>';
	?>
	
	<?php echo $divStart . $bookings . '<label>Requests</label>'.$divEnd; ?>
    <?php echo $divStart . $regions . '<label>Regions</label>'.$divEnd; ?> 
	<?php echo $divStart . $stations . '<label>Power Stations</label>'.$divEnd; ?>
	<?php echo $divStart . $plants . '<label>Power Plants</label>'.$divEnd; ?>  
    <?php echo $divStart . $transport . '<label>Transport Modes</label>'.$divEnd; ?>
    <?php echo $divStart . $institutions . '<label>Types of Institutions</label>'.$divEnd; ?>
    <?php echo $divStart . $calendar . '<label>Calendar</label>'.$divEnd; ?>	
    <?php echo $divStart . $holidays . '<label>Holidays</label>'.$divEnd; ?>
    <?php echo $divStart . $feedback . '<label>Feedback</label>'.$divEnd; ?>
    <?php echo $divStart . $faqs . '<label>FAQs</label>'.$divEnd; ?>
    <?php echo $divStart . $colors . '<label>Background Colors</label>'.$divEnd; ?>
    <?php echo $divStart . $email . '<label>Bulk Email</label>'.$divEnd; ?>   
    <?php echo $divStart . $purposes . '<label>purposes</label>'.$divEnd; ?>
    <?php echo $divStart . $articles . '<label>articles</label>'.$divEnd; ?>
    <?php echo $divStart . $reports . '<label>Reports</label>'.$divEnd; ?>

   
    <?php if(ACCESS_LVL == 1): ?>
    
    <?php echo $divStart . $settings . '<label>Settings</label>'.$divEnd; ?>    
    <?php echo $divStart . $users . '<label>Users</label>'.$divEnd; ?>          
   	<?php echo $divStart . $logs . '<label>User Logs</label>'.$divEnd; ?>
    
    <?php endif; ?>
   
       
</div>