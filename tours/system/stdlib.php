<?php

class baseModel
	{

	public static function listFAQs()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' faqs ' );	

		if(ACCESS_LVL != 1)
			$query .= $sql->where( " active = 1 ");	
		
		$query .= $sql->order( " ordering ");	
					
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}	

	public static function faqDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' faqs ' );	

		$query .= $sql->where( " id =  ".$id);	
		
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	

	public static function listCounties()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' counties ' );	
		$query .= $sql->where( ' active = 1 ' );	
		$query .= $sql->order( " title " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function countyDetails($id)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' counties ' );	
		$query .= $sql->where( ' id =  '.$id );	
		
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
		
	public static function listCountries()
		{

		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' countries ' );	
		$query .= $sql->where( ' active =1 ' );	
		$query .= $sql->order( " title ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
	
		}		
		
	public static function countryDetails($id)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' countries ' );	
		$query .= $sql->where( ' id =  '.$id );	
		
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
				
	public static function listInstitutionTypes()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' institution_types ' );	
		$query .= $sql->where( ' active = 1 ' );	
		$query .= $sql->order( " title " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function institutionTypeDetails($id)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' institution_types ' );	
		$query .= $sql->where( ' id =  '.$id );	
		//echo $query;
		
		if( DBASE::mysqlNumRows( $query ) > 0)
			{
			$rows = DBASE::mysqlRowObjects( $query );
	
			return $rows[0];
			}
		}
		
		

	public static function adminMenuBar()
		{
		
		$menu = '<a href="index.php">Dashboard</a>';
		
		
		if(isset($_REQUEST['act']))
			{
			
			$act = $_REQUEST['act'];
			
			$name = str_replace('_', ' ', $act);
		
			$menu .=  ' >> <a href="index.php?act='.$act.'">'.$name .'</a>' ;
			}
		
		return $menu;
		
		
		}
	
	public static function listAllUsers()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( 'users ' );	
		$query .= $sql->order( " fullname " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function userTypes($lvl)
		{
		
		switch($lvl)
			{
			case 1:
				return 'Super Users (ICT)';
				break;

			case 2:
				return 'Functional Users';
				break;
				
			case 3:
				return 'Chiefs';
				break;

			}
		
		}


	public static function logout()
		{

		session_destroy();
		unset($_SESSION[SESSIONID]);
		
		echo '<script>self.location="index.php"</script>';
		
		}
			
	public static function welcome($uid)
		{
		$user = usersModel::userDetails($uid);
		
		$utype = baseModel::userTypes($user->access_lvl);
		
		$str = '<p>'.$user->fullname.'</p>';
		$str .= '<div class="font-smaller">['.$utype.']</div>';
		$str .= '<p><a href="index.php?act=profile">Password</a> | 
					<a href="index.php?act=logout">Logout</a></p>';
		
		return $str;
		
		}

	public static function updateLoginAccesses()
		{
		$myid = $_SESSION[SESSIONID];
		
		$sql = new MYSQL;
		$query = $sql->update( ' users ' );
		$query .= $sql->set( ' accesses = accesses+1 ' );	
		$query .= $sql->where( ' id = '.$myid );
			
		$rows = DBASE::mysqlUpdate( $query );
			
		}
		
	public static function updateUserLogs(  $user_id, $action ) {
	
		$date = date( 'Y-m-d H:i:s' );
		
		$action = baseModel::cleanContent($action);
		
		$sql = new MYSQL;
		$query = $sql->insert( 'user_logs' );
		$query .= $sql->columns( 'uid, action, date_created' );	
		$query .= $sql->values( " '$user_id', '$action', '$date' " );
		
		$rows = DBASE::mysqlInsert( $query );		
	
		}

	public static function changePassword( $post ) 
		{
		
		if( baseModel::userAuthentic( MYID )->pwd != md5( $post['opw'] ) ) :
		
			echo '<script>self.location="' . $post['url'] . '&err=1"</script>';
			
		else :			
			
			$sql = new MYSQL;
			$query = $sql->update( 'users' );
			$query .= $sql->set( "pwd='" . md5( $post['npw'] ) . "'" );	
			$query .= $sql->where( 'id=' . MYID );				
			
			$rows = DBASE::mysqlUpdate( $query );	
		
			echo '<script>self.location="' . $post['url'] . '&msg=success"</script>';
			
		endif;
	
	}
	
	public static function userAuthentic( $id ) {
	
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( 'users' );	
		$query .= $sql->where( 'id=' . $id );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		$row = &$rows[0];
		
		return $row;
	
	}
	
	public static function remindPassword( $post ) 
		{
		
		$email = $post['emailadd'];
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' users ' );	
		$query .= $sql->where( " emailadd like '".$email."'  " ); //like to take care of lower/upper	
				
		$count = DBASE::mysqlNumRows( $query );
	
		if($count > 0 ):
			
			$rows = DBASE::mysqlRowObjects( $query );	
			$row = &$rows[0];
			$uid = $row->id;
			
			$pass = uniqid(rand());
			$pwd = md5($pass);
			
			$sql2 = new MYSQL;
			$query2 = $sql2->update( 'users' );
			$query2 .= $sql2->set( " pwd = '" . $pwd . "' " );	
			$query2 .= $sql2->where( " emailadd = '" . $email ."' " );				
			
			$rows2 = DBASE::mysqlUpdate( $query2 );	
			
			///send email
			$to = $email;
			$cc ="";
			$bcc = BCC;
			$from = NOREPLY_EMAIL;
			$subject = SITE_NAME_SHORT." - Password Reminder ";
			$body = '<p>
					Dear '.$row->fullname.',</p>
					<p>This is an email after you requested for a new password through '.SITE_NAME_SHORT.'</p>
					<p>Your new password is <b>'.$pass.'</b></p>
					<p>You are advised to change the password after you login</p>
					<br>
					<p>Regards,<br>
					'.SITE_NAME_SHORT.'
					</p>';				
			
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subject, $body ) ;
			
			if($sent ==1)
				echo '<script>self.location="index.php?art=login&do=pwd&msg=success"</script>';
			else
				echo '<script>self.location="index.php?art=login&do=pwd&msg=em"</script>';
		else:
			echo '<script>self.location="index.php?art=login&do=pwd&msg=error"</script>';	
			
		endif;
		
		}


	public static function settings()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( " settings " );		
		//$query .= $sql->where( " id = ".$id );

		$rows = DBASE::mysqlRowObjects( $query );
								
		return $rows[0];
		
		}		

	public static function createSet( $array ) {
		
		if( is_array( $array ) ) :
			
			$string ='';
			foreach( $array as $key => $value ) :
					
				if( $key != 'submit' || $key != 'submitThis' ) :
						
					$string .= $key . "='" . baseModel::cleanContent($value) . "', ";
				
				endif;
				
			endforeach;
				
			$string = trim( substr( $string, 0, -2 ) );			
				
		endif;
			
		return $string;
	
	}	
	
	public static function createSearchSet( $array ) {
		
		if( is_array( $array ) ) :
			
			$string ='';
			foreach( $array as $key => $value ) :
					
				if( $key != 'submitThis' && strlen(trim($value)) > 0 ) :
						
					$string .= $key . "='" . baseModel::cleanContent($value) . "' and ";
				
				endif;
				
			endforeach;
				
			$string = trim( substr( $string, 0, -4 ) );			
				
		endif;
			
		return $string;
	
	}
	
	
		
	public static function session_checker()
		{
		
		$session = $_SESSION['login'];
		
		$now = time();
	
		$session_end = $session + SESSION_DURATION * 60;
		
		if($now > $session_end )
			echo baseModel::logout();
		else
			$_SESSION['login'] = time();
		
		//return '<br>login :'.$session . '<br>now :' .$now.'<br>end: '.$session_end.'<br>Duration :'.SESSION_DURATION;
		
		}
	
	public static function cleanContent($str)
		{
		
		$newstr = addslashes($str);
		
		return $newstr;
		
		}	
		
	public static function formatDate( $originalDate ) {
		
		$year = date("Y", strtotime($originalDate));
		
		if($year == 1999)
			return '<font color="#ff4565">No date set</font>';
		else
			{
			if(strlen($originalDate) > 10) ///if it has time element
				$newDate = date( "M jS, Y H:i", strtotime( $originalDate ) );
			else
				$newDate = date( "M jS, Y", strtotime( $originalDate ) );
				
			return $newDate;
			}
	
	}	
	
	public static function formatDateShort( $originalDate ) {
		
		$year = date("Y", strtotime($originalDate));
		
		if($year == 1970)
			return '<font color="#ff4565">No date set</font>';
		else
			{
			
			$newDate = date( "M jS, Y", strtotime( $originalDate ) );			
				
			return $newDate;
			}
	
	}
	
	public static function sendmail( $from, $to, $cc, $bcc, $subject, $body ) {
		
		$mime_boundary = "==Multipart_Boundary_x" . md5( mt_rand() ) . "x";
        // now we'll build the message headers
        $headers = "From: $from\r\n" .
        "CC: $cc\r\n" .
		"BCC: $bcc\r\n" .
        "MIME-Version: 1.0\r\n" .
        "Content-Type: multipart/mixed;\r\n" .
        " boundary=\"{$mime_boundary}\"";

        //$message = $body;
        $message = "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" .
        $body . "\n\n";

        $message .= "--{$mime_boundary}--\n";

        if( @mail( $to, $subject, $message, $headers ) ) :                               
        	return 1;
     	else :
			return 0;
		endif;
	
	}



	public static function sendEmailWithAttachment($from, $to, $cc, $bcc, $subj, $msg, $file, $fname)
		{
		
		$email_to = $to; // The email you are sending to (example)
		$email_from = $from; // The email you are sending from (example)
		$email_subject = $subj; // The Subject of the email
		$email_txt = $msg; // Message that the email has in it
		$fileatt = $file; // Path to the file (example)
			
		//$fileatt_type = mime_content_type($fileatt);//"application/pdf"; // File Type
		$fileatt_type = "application/msword";
		
		$fileatt_name = $fname;
		
		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers = "From: $from\r\n" .
		"CC: $cc\r\n" .	
		"BCC: $bcc\r\n" .
		"MIME-Version: 1.0\r\n" .
		  "Content-Type: multipart/mixed;\r\n" .
		  " boundary=\"{$mime_boundary}\"";		
		$email_message = "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" . $email_txt;
		$email_message .= "\n\n";
		$data = chunk_split(base64_encode($data));
		$email_message .= "--{$mime_boundary}\n" .
		"Content-Type: {$fileatt_type};\n" .
		" name=\"{$fileatt_name}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"--{$mime_boundary}--\n";
		
		if(@mail($email_to,$email_subject,$email_message,$headers))
			return 1;
		else
			return 0;
	
	
		}
		
	
	public static function formatNumber( $num ) 
		{
		
		$number = number_format($num, 2, '.', ',');
		
		return $number;		
	
		}	
	
	public static function paginateme2($query, $first, $second, $per_page = 10,$page = 1, $url = '&'){ 
       $sql = 'SELECT COUNT(DISTINCT '.$first.', '.$second.') as `num` FROM '.$query.'';
	 
    	$query = mysql_query( $sql );
    	$row = mysql_fetch_array($query);
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    	//	$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    	//	$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 	


	
    public static function encode($string) 
		{
	
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;

    }

	public static function decode($string) 
		{
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
	

	
	

	
}



?>