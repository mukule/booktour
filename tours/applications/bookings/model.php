<?php
class bookingsModel
	{
	
	public static function listBookings()
		{
	
		if($_SESSION['userlevel'] == 2): ///if this is station admin(functional users)
			
			$myid = $_SESSION[SESSIONID];
			
			$sql = new MYSQL;		
			$query = $sql->select( ' *, b.date_created as datecreated, b.id as bookid ' );
			$query .= $sql->from( ' bookings b, stations s ' );	
			$query .= $sql->where( ' s.id = b.station_id and FIND_IN_SET('.$myid.', user_id) ' );	
			$query .= $sql->order( " datecreated desc ");	
			
			//echo $query;
					
			$rows = DBASE::mysqlRowObjects( $query );
		
			return $rows;
			
		elseif($_SESSION['userlevel'] == 3): ///if this is station admin(chiefs)
			$myid = $_SESSION[SESSIONID];
				
			$sql = new MYSQL;		
			$query = $sql->select( ' *, b.date_created as datecreated, b.id as bookid ' );
			$query .= $sql->from( ' bookings b, stations s ' );	
			$query .= $sql->where( ' s.id = b.station_id and FIND_IN_SET('.$myid.', user_id) ' );	
			$query .= $sql->order( " datecreated desc ");	
				
				//echo $query;
						
			$rows = DBASE::mysqlRowObjects( $query );
			
			return $rows;			
		
		elseif($_SESSION['userlevel'] == 1): ///super admin
		
			$sql = new MYSQL;		
			$query = $sql->select( ' *, date_created as datecreated, id as bookid ' );
			$query .= $sql->from( ' bookings ' );	
			
			$query .= $sql->order( " datecreated desc ");	
					
			$rows = DBASE::mysqlRowObjects( $query );
		
			return $rows;
			
		endif;	
		}
		
		
	public static function searchBookings($post)
		{
		
		$where = ' b.country_id = ctry.id and b.station_id = s.id and ';
		
		if(!empty($post['nationality']))
			{
			if($post['nationality'] == 'ke')
				$where .= " ctry.title like '%kenya%' and ";
			elseif($post['nationality'] == 'foreign')
				$where .= " ctry.title not like '%kenya%' and ";
			}
		
		if(!empty($post['station_id']))
			$where .= ' station_id = '.$post['station_id'].' and ';
		
		if(!empty($post['date_from']))
			$where .= " visit_date >= '".date("Y-m-d", strtotime(str_replace("/","-",$post['date_from'])))."' and ";
		
		if(!empty($post['date_to']))
			$where .= " visit_date <= '".date("Y-m-d", strtotime(str_replace("/","-",$post['date_to'])))."' and ";
			
		if(!empty($post['ref_no']))
			$where .= " ref_no like '%".$post['ref_no']."%' and ";		
		
		
		if(ACCESS_LVL != 1)
			$where .= ' FIND_IN_SET('.MYID.', user_id) and ';
		
		if(strlen(trim($where)) > 0)
			$where = substr(trim($where), 0, -3) ;
		
		//echo $where;
		
		$sql = new MYSQL;		
		$query = $sql->select( ' *, b.date_created as datecreated, b.id as bookid  ' );
		$query .= $sql->from( ' bookings b, countries ctry, stations s ' );	
		
		$query .= $sql->where( $where );	
		
		$query .= $sql->order( " datecreated desc ");	
	
		$rows = DBASE::mysqlRowObjects( $query );
		
		return $rows;	
		
		}				
	
	public static function bookingDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' bookings ' );	
		$query .= $sql->where( ' id =  '.$id );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	
	public static function actionRequest($post)
		{
		
		$id = $post['itemId'];
		$url = $post['url'];
		
		$post['approved_date'] =  date("Y-m-d H:i");
		$post['approved_by'] = MYID;
		
		$action = $post['approved'];
		
		unset($post['url']);
		unset($post['itemId']);
		unset($post['SubmitThis']);
		
		if(empty($post['plant_id']) || strlen(trim($post['plant_id'])) < 1)
			unset($post['plant_id']);
		
		$book = bookingsModel::bookingDetails($id);
		//return $url;
		
		$sql = new MYSQL;
		$query = $sql->update( ' bookings ' );
		$query .= $sql->set( baseModel::createSet( $post ) );		
		$query .= $sql->where( 'id= ' . $id );
		
		//return $query;
	
		$rows = DBASE::mysqlUpdate( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'acted on request - '.$id);	
		
		$station = stationsModel::stationDetails($book->station_id);			
		
		$action ='<p>Your Request was : ';		
		$action .= $post['approved']==1 ? '<b>Approved</b>' : '<b>Rejected</b>' ;
		$action .='</p>';	
		
		if(isset($post['plant_id']) && $post['plant_id'] > 0 ):
		
			$plant = plantsModel::plantDetails($post['plant_id']);
			
			$action .= !empty($plant) ? '<p>Plant Assigned <b>: '.$plant->title.'</b></p>' : '<p>A power plant was assigned. Contant us for this information</p>';
			
		endif;
		
		if(isset($post['approval_comments']) && strlen(trim($post['approval_comments'])) > 0):			
			$action .= '<p>With the following note : <br /><blockquote>'.$post['approval_comments'].'</blockquote></p>';		
		endif;
				
		$fullname = $book->fullname;
		$time = $book->visit_time == 1 ? '10am' : '2pm';
		
		//cc regional chief engineer
		$regionEmail = regionsModel::regionDetails($station->region_id)->emailadd;
		
		$contacts = stationsModel::stationContacts($book->station_id);
		
		//send email;
		$to = $book->emailadd;
		$from = NOREPLY_EMAIL;
		$cc = $post['approved'] == 1 ? $regionEmail : ''; //cc regional chief if approved
		$bcc = BCC;
		$subj = "KenGen Tour Request Status";
		$body = '
			<p>Dear '.$fullname.',</p>
			<p>This is to inform you that the below action has been done for the booking you did for <b>'.$book->institution.'</b> for date <b>'.baseModel::formatDate($book->visit_date).', '.$time.'</b> to <b>'.$station->title.'</b></p>
			
			'.$action.'
			
			'.$contacts.'
			
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';
			
		//echo $body;
		
		
		if($post['approved'] == 1)
			{
			//check on the dompdf version .... 0.8.5 works with php 7.0 and above
			include "pdf_award_letter".EXT;
			$sent = baseModel::sendEmailWithAttachment($from, $to, $cc, $bcc, $subj, $body, $file, $filename);			
			}
		else
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subj, $body );			
			
			
		if($sent == 1)
			{
			echo '<div clas="col-md-12 isa_success">Email successffully sent</div>';
			if($post['approved']==1)
				unlink($file); //remove file after attaching.
			
			echo '<script>self.location="'.$url.'&msg_email=success"</script>';
			
			}
		else
			echo '<script>self.location="'.$url.'&msg_email=error"</script>';
		
		}
		
	public static function actionFeedback($post)
		{
		
		$id = $post['itemId'];
		$url = $post['url'];
		
		$post['feedback_date'] =  date("Y-m-d H:i");
		$post['feedback_by'] = MYID;
		
		$action = $post['visited'];
		
		unset($post['url']);
		unset($post['itemId']);
		unset($post['SubmitThis']);
		
		if(empty($post['number_visited']) || strlen(trim($post['number_visited'])) < 1)
			unset($post['number_visited']);
		
		$sql = new MYSQL;
		$query = $sql->update( ' bookings ' );
		$query .= $sql->set( baseModel::createSet( $post ) );		
		$query .= $sql->where( 'id= ' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'gave feedback on request - '.$id);	
		
		//do thank you email and invitation to give feedback, if visited
		if($action == 1):
		
			$book = bookingsModel::bookingDetails($id);
			
			$station = stationsModel::stationDetails($book->station_id);
			
			$contacts = stationsModel::stationContacts($book->station_id);
			
			$link = '<a href="'.SITE_URL.'index.php?art=feedback">Click to give feedback</a>';
		
			$to = $book->emailadd;
			$from = NOREPLY_EMAIL;
			
			$cc = '';
			$bcc = BCC;
			$subj = "KenGen Tour Visit - Feedback";
			$body = '
				<p>Dear '.$book->fullname.',</p>
				<p>This is a thank you note for visiting our facilities, <b>'.$station->title.'</b>, with <b>'.$book->institution.'</b> on date <b>'.baseModel::formatDate($book->visit_date).'</b></p>
				
				<p>We invite you to give us a feedback on your visit by clicking the link below:</p>
				<p>'.$link.'</p>
				
				'.$contacts.'				
				
				<p>Kind Regards,<br>'.SITE_NAME.'</p>';
				
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subj, $body );
				
				
			if($sent == 1)
				echo '<script>self.location="'.$url.'&msg_email=success"</script>';
			else
				echo '<script>self.location="'.$url.'&msg_email=error"</script>';
		
		endif;
	
		echo '<script>self.location="'.$url.'&msg=success"</script>';
			
		}		
		
		/*
	public static function sendEmailNotification($bid, $action)
		{
		$booking = bookingsModel::bookingDetails($bid);
		
		$fullname = $booking->fullname;
		$time = $booking->visit_time == 1 ? '10am' : '2pm';
		
		$from = SYSTEM_EMAIL;
		$to = $booking->emailadd;
		$cc = "";
		$bcc = BCC;
		$subject = $action == 1 ? 'Booking Request was Accepted' : 'Booking Request was Rejected';
		$body = '
			<p>Dear '.$fullname.',</p>
			<p>This is to inform you that the above subject applies for the booking your did for '.$booking->institution.' for date '.baseModel::formatDate($booking->visit_date).', '.$time.' </p>
			
			<p>For any concerns or more information, please contact us thorugh the details given in the '.SITE_NAME.'</p>
			
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';
		
		$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subject, $body );
		
		if($sent == 1)
			return '<div class="col-md-12 isa_success text-center">Successfully sent a notification via email</div>';
		else
			return '<div class="col-md-12 isa_error text-center">Error sending a notification via email</div>';
		
		}
		*/
	
	
	} // end class


?>