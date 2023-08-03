 <div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="content">
        
                <?php
				
				
				if(isset($_REQUEST['act']))			
                	$act = $_REQUEST['act'];
                
                if(isset($_SESSION[SESSIONID]))
					{
                    echo baseModel::session_checker();
					echo '<div class="col-md-12"><div class="col-md-12 admin-menu-bar">'.baseModel::adminMenuBar().'</div></div>';
					}
               
                 if(isset($act) && $act=='logout'):				 	
					
					echo baseModel::logout();	
									
				 elseif(isset($act) && !isset($_SESSION[SESSIONID])):
				 	
					echo '<script>self.location="index'.EXT.'"</script>';
				
				 else:				 	
					
					 $module = (isset($act) && strlen( $act ) > 0 ) ? $act : 'default';
							
					 include APPLIC . $module . DS . $module . EXT;
					//echo $module;
				
				 endif;
				   
                ?>

            </div><!-- /.content -->
        </div><!-- /.container -->
    </div><!-- /.main-inner -->
</div><!-- /.main -->