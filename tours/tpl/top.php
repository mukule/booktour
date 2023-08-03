<header class="header header-admin">
    <div class="header-wrapper">
        <div class="container">
        
            <div class="header-inner">
                <div class="col-md-2 header-logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>

                <div class="col-md-8 sitename text-center"><?php echo SITE_NAME; ?></div>
                <div class="col-md-2 profile" >
                    
                    <?php
                    if(isset($_SESSION[SESSIONID]))
                        echo baseModel::welcome($_SESSION[SESSIONID]);
                   
				   /* else
                        echo '<a href="index.php?art=login">Login</a>';
						*/
                    ?>
                    
               </div>
                                        
            </div><!-- /.header-inner -->
        </div><!-- /.container -->
    </div><!-- /.header-wrapper -->
</header><!-- /.header -->


