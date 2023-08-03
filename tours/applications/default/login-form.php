<?php    
	 //print_r($_SESSION);  
	if( isset($_POST['submit']) && $_POST['submit'] == 'Login' ) 
		{				

		// username and password sent from form
		$usr = $_POST['emailadd'];
		$pwd = $_POST['pwd'];
		
		// To protect MySQL injection (more detail about MySQL injection)
		$usr = stripslashes( $usr );
		$pwd = stripslashes( $pwd );
		
		
		$usr = mysqli_real_escape_string($GLOBALS['dbconn'], $usr ); 
		$pwd = mysqli_real_escape_string($GLOBALS['dbconn'], $pwd );
		
		
		// encrypt password
		$pwd = md5( $pwd );		
		
		$sql = new MYSQL;		
		$query = $sql->select( '*' );
		$query .= $sql->from( 'users ' );
		$query .= $sql->where( "emailadd='$usr' AND pwd='$pwd' and active=1" );
		
		$num = DBASE::mysqlNumRows( $query );	
		
		//echo $num; return;
		
		if( $num == 1 ) 
			{					
		
			$rows = DBASE::mysqlRowObjects( $query );
			$row = &$rows[0];			
			
			// store session data
			$_SESSION[SESSIONID] = $row->id;
			$_SESSION['userlevel'] = $row->access_lvl;	
			$_SESSION['login']=time();
			
			
			
			//update chat status
			echo baseModel::updateUserLogs($_SESSION[SESSIONID], 'login');
			echo baseModel::updateLoginAccesses();
												
			// redirect		
			echo '<script>self.location=\'index.php\'</script>';
				
				
			}
		
		else { //num
			
			echo '<script>self.location="index.php?msg=login_error"</script>';
			
			}
			
					
		} ///submit
	
	else {				
		$loginError = isset($_REQUEST['error']) ? $_REQUEST['error'] : '';
		
		?>	      

		<form action="" method="post" class="form"> 
			
            <div class="col-md-12 text-center"><h2>Login</h2></div> 
       
            <?php if(isset($_REQUEST['msg']) && $_REQUEST['msg'] == "login_error" ): ?>
                <div class="col-md-12"><p class="login_error isa_error text-center">Wrong Login Credentials. Try Again.</p></div>
            <?php endif; ?>
            
                               
            <div class="col-md-12 text-center"><input class="form-control" type="email" name="emailadd" id="emailadd" required placeholder="email address" autocomplete="on" /></div>   
            <div class="col-md-12 text-center"><input class="form-control" type="password" name="pwd" id="pwd"  required placeholder="password" /></div>
            <div class="col-md-12 text-center"><input  type="submit" name="submit" id="submit" value="Login" class="btn" /></div>
            
            <div class="col-md-12 text-center"><a href="index.php?art=login&do=pwd">Forgot Password?</a></div>

		</form>
        

		<?php 
	}
?>