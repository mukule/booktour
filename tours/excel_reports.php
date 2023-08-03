<style>
th {text-align:left!important; }

</style>
<?php
session_start();
require_once "inc/configs.php";


if(empty($_POST['bookids']))
	{
	echo '<div class="col-md-12 text-center isa_error">There are no records selected</div>';
	return;
	}
	
	
$bookids = $_POST['bookids'];


$header = '<table width="100%" class="table">';


$header .= '<tr>
				<th>Station</th><th>Fullname</th><th>Institution</th><th>Country</th><th># Visitors</th><th>Visit Date</th><th>Visit Approval</th>
				<th>Visited?</th><th># Visited</th>				
			</tr>';

$data = '';			
foreach($bookids as $bookid)
	{
	
	$row = bookingsModel::bookingDetails($bookid);
	
	$vtime = $row->visit_time == 1 ? '10:00' : '14:000';
	$dateTime = date("d/m/Y", strtotime($row->visit_date .' '.$vtime));
	
	$approval = $row->approved==1 ? 'Approved' : ($row->approved==2 ? 'Rejected' : 'Pending');
	$visited = $row->visited==1 ? 'Visited' : ($row->visited==2 ? 'No Visited' : 'Not Updated');

	
	
	$data .= '<tr><td>'.stationsModel::stationDetails($row->station_id)->title.'</td>
					<td>'.$row->fullname.'</td>
					<td>'.$row->institution.'</td>
					<td>'.baseModel::countryDetails($row->country_id)->title.'</td>
					<td>'.$row->number_of_visitors.'</td>
					<td>'.$dateTime.'</td>
					<td>'.$approval.'</td>
					<td>'.$visited.'</td>
					<td>'.$row->number_visited.'</td>					
				</tr>';
	

	}
	
$filename = 'Kengen_Tours_Report'.date("d-m-Y_H_i").'.xls';	
	
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data"; 
exit(); 

echo '<script>self.location="index.php?act=reports&pg=list"</script>';


?>


