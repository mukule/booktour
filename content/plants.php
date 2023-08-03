<?php

//$itemId already set

$plants = frontModel::listPlants($itemId);

if(count($plants) < 1):
	return;
else:
	?>
    
    <div class="col-md-12 plants">
    	<h4>Power plants within this station:</h4>
    	
		<?php
		echo '<ul>';
		foreach($plants as $plant)
			{
			echo '<li>'.$plant->title.'</li>';			
			}
		echo '</ul>';
		?>    

	</div>
	<?php	
endif;


?>