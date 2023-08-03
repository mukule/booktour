
<?php
$itemId = baseModel::decode($_REQUEST['stat']);

if(!isset($itemId) || $itemId < 1)
	{
	echo '<div class="col-md-12 isa_warning text-center">Please select a station to view its details</div>';
	return;
	}

$station = stationsModel::stationDetails($itemId);

?>

<h3 class="page-title text-center">Book a Tour to : <?php echo $station->title; ?></h3>

<h4 class="text-center font-bold">
<?php
$dy = $_REQUEST['dy'];

$datetime = explode("_",$dy);
$visit_date = $datetime[0];
$visit_time = $datetime[1];

$timeToDisplay = $visit_time == 1 ? '10.00am' : '2.00pm';


echo 'For Date : ' . date("jS M, Y", $visit_date).' : '.$timeToDisplay;

?>


</h4>

<?php //include 'book-form'.EXT; ?>

<?php
$url_redirect = 'index.php?art=book&stat='.$_REQUEST['stat'].'&dy='.$_REQUEST['dy'];
//$url_foreigners = 'index.php?art=book-foreigners&stat='.$_REQUEST['stat'].'&dy='.$_REQUEST['dy'];


if(isset($_POST['submitThis']) && $_POST['submitThis']=='Continue To Application Form')
	{
	
	if(isset($_POST['confirm']) && $_POST['confirm']==1)
		{
		if(isset($_REQUEST['country']) && $_REQUEST['country']=="Ke")
			echo '<script>self.location="'.$url_redirect.'&cit=kny"</script>';
		elseif(isset($_REQUEST['country']) && $_REQUEST['country']=="Others")
			echo '<script>self.location="'.$url_redirect.'&cit=frgn"</script>';
		else
			echo '<div class="col-md-12 isa_error">Please select if Kenyan or otherwise</div>';
			
		}
	else
		echo '<div class="col-md-12 isa_error">You have to accept the indicated terms to proceed</div>';
		
		
		
	}
?>


<div class="col-md-12" style="border-bottom:1px solid #eee; margin:10px auto;"></div>

<div class="col-md-12">
<form action="" method="post">

<div class="col-md-12">
	<label>Please select your country of origin</label>
	<p><input type="radio" name="country" required value="Ke" /> Kenyan</p>
    <p><input type="radio" name="country" required value="Others" /> Non-Citizen</p>    
</div>


<div class="col-md-12"><input type="checkbox" name="confirm" required onchange="document.getElementById('confirm').disabled = !this.checked;" value="1"  /> <label style="display:inline-block"> To continue, please tick to confirm you have read the above terms and conditions</label></div>


<div class="col-md-12"><input type="submit" class="btn" name="submitThis" id="confirm" value="Continue To Application Form" disabled="disabled" ></div>

</form>
</div>


    
    

