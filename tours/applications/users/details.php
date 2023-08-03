<?php
if(!isset($itemId))
	echo '<script>self.location="'.$urls.'"</script>';

$user = usersModel::userDetails($itemId);

$usertype = baseModel::userTypes($user->access_lvl)

?>

<div class="col-md-12 text-center"><h4><?php echo $user->fullname;  ?> </h4></div>

<div class="col-md-6">
	<h4>User Details</h4>
	<div class="col-md-12">User Level : <?php echo $usertype;  ?></div>
    <div class="col-md-12">Email Address : <?php echo $user->emailadd;  ?></div>
    <div class="col-md-12">Date Created : <?php echo baseModel::formatDate($user->date_created);  ?></div>
    <div class="col-md-12">Last Modified : <?php echo baseModel::formatDate($user->date_modified);  ?></div>
</div>




<div class="col-md-6">
	<h4>Stations In-Charge</h4>
	<?php
    $myStations = stationsModel::listMyStations($user->id);
    
    if(count($myStations) < 1 ):
    echo '<div class="col-md-12 isa_warning text-center">There are no stations user is in charge of</div>';
    else:
    echo '<div class="col-md-12">
            <ul>';
    foreach($myStations as $stat)
        {
        echo '<li><a href="index.php?act=stations&pg=details&itemId='.$stat->id.'">'.$stat->title.'</a></li>';
        }
    echo '</ul>
        </div>';
    endif;	
    
    ?>
    
 </div>


<div class="col-md-12 text-center"><a href="<?php echo $urls; ?>" class="btn">Back to Users list</a></div>