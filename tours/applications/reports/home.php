<?php
$bookings = bookingsModel::listBookings();
$users = usersModel::listUsers();
$stations = stationsModel::listStations();
$regions = regionsModel::listRegions();
$plants = plantsModel::listPlants(0);


$approved = 0;
$unattended = 0;
$rejected = 0;
$kenya = 0;
$foreign = 0;
$visited = 0;
$not_visited = 0;
$visited_pending = 0;


foreach($bookings as $book)
	{
	if($book->approved == 1)
		$approved++;
	elseif($book->approved == 2)
		$rejected++;
	else
		$unattended++;	
	
	if($book->country_id == 110) //kenya
		$kenya++;
	else
		$foreign++;
		
	if($book->visited == 1)
		$visited++;
	elseif($book->visited == 2)
		$not_visited++;	
	elseif($book->visited == 0)
		$visited_pending++;			
	}

$dir = 'images/reports/';


?>

<div class="page-title">Reports</div>


<div class="col-md-12 reports">
    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'regions.png' ?>" /></p><span><?php echo count($regions); ?></span><p>Regions</p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'stations.png' ?>" /></p><span><?php echo count($stations); ?></span><p>Power Stations</p></div></div>
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'plants.png' ?>" /></p><span><?php echo count($plants); ?></span><p>Power Plants</p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'users.png' ?>" /></p><span><?php echo count($users); ?></span><p>System Users</p></div></div>
    
</div>

<div class="col-md-12 reports">
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'requests.png' ?>" /></p><span><?php echo count($bookings); ?></span><p>All Requests</p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'approved.png' ?>" /></p><span><?php echo $approved; ?></span><p>Approved Requests</p></div></div>
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'rejected.png' ?>" /></p><span><?php echo $rejected; ?></span><p>Rejected Requests </p></div></div>
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'pending.png' ?>" /></p><span><?php echo $unattended; ?></span><p>Requests Pending Approval </p></div></div>

</div>


<div class="col-md-12 reports">

    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'visits.png' ?>" /></p><span><?php echo $visited; ?></span><p>Visits Honored</p></div></div>
    
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'no_visits.png' ?>" /></p><span><?php echo $not_visited; ?></span><p>Visits Not Honored</p></div></div>
	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'waiting.png' ?>" /></p><span><?php echo $visited_pending; ?></span><p>Visits Not Updated</p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p></p><span></span><p></p></div></div>
 
</div>


<div class="col-md-12 reports">

	<div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'citizens.png' ?>" /></p><span><?php echo $kenya; ?></span><p>Citizen Requests</p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p><img src="<?php echo $dir .'foreign.png' ?>" /></p><span><?php echo $foreign; ?></span><p>Foreign Requests</p></div></div>
    
    <div class="col-md-3 text-center"><div class="report-item"><p></p><span></span><p></p></div></div>
    <div class="col-md-3 text-center"><div class="report-item"><p></p><span></span><p></p></div></div>
 
</div>


<div class="col-md-12">
	<div class="col-md-12 text-center"><a href="<?php echo $urls; ?>&pg=list" class="btn">More on Requests Details</a></div>    
</div>