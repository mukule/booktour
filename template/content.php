<div class="col-md-12 contents">
    <div class="container">    
    	<div class="content">    
       
           <div class="col-md-12 meat">
			   	<?php
				$dir = 'content'. DS ;
				
				if(isset($_REQUEST['art']))
			   		{
					$art = $_REQUEST['art'];
				
					$file = $dir . $art . EXT;
					
					if(is_file($file))
						include $file;
					else
						echo '<div class="col-md-12 text-center"><h2>Error 404</h2><p>Page not found.</p></div>';
					}
				else
					include $dir . 'home'.EXT;
			    ?>
            </div>
       
     	</div> <!--- .content ---> 
       
       
    </div>
</div>