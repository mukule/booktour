
<div class="col-md-12 header-content">
    <ul class="header-nav-primary nav nav-pills collapse navbar-collapse">
            
            <?php
            $regions = frontModel::listRegions();
			
			foreach($regions as $reg)
				{
				echo '<li><a href="#">'.$reg->title.'<i class="fa fa-chevron-down"></i></a>';
				
				$stations = frontModel::listStations($reg->id);
				
				echo '<ul class="sub-menu">';
				foreach($stations as $stat)
					{
					echo '<li><a href="index.php?art=station&stat='.baseModel::encode($stat->id).'">'.$stat->title.'</a></li>';
					
					}
				echo '</ul>';
				
				echo '</li>';
				
				}
			
			?>
            
    </ul>
    
</div><!-- /.header-content -->