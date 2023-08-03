<div class="col-md-12 login-form">
	<div class="login text-center">

	<?php
	if(isset($_REQUEST['do']))
    	$do = $_REQUEST['do'];
		
    $urls = 'index.php?art=login';
    
    $inc = isset($do) && $do == "pwd" ? 'login-remind': 'login-form';
    
    include $inc . EXT;
    
    ?>

	</div>
</div>
