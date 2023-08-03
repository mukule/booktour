<?php
class calendarModel
	{
	

	public static function makeBooking($post)
		{
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['url']);		
		
		
		$station = stationsModel::stationDetails($post['station_id']);
		
		$stationUsers = $station->user_id;
	
		//print_r($uids); echo '<br>'.$station->title ; return;
		
		$stationName = explode(" ", $station->title);
		
		$totalBookings = count(calendarModel::listStationBookings($post['station_id']));
		
		$refNo = 'KGN_TOURS_'.$stationName[0].'_'.$post['visit_date'].'_'.$post['visit_time'].'#'.($totalBookings+1);
		$post['ref_no'] = $refNo;
		
		
		
		$uids = explode(",",$stationUsers);
		
		
		if(empty($stationUsers)):
			$emails ='';
		else:		
		
			$emails ='';

			foreach($uids as $uid)
				{
				$user = usersModel::userDetails($uid);
				$emails .= !empty($user) ? $user->emailadd.', ' : '';
				}			
			$emails = substr(trim($emails), 0, -1);
		endif;
		
		
		$post['date_created'] = date("Y-m-d H:i:s");
		$post['visit_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $post['visit_date'])) );
		
		$post['approved'] = 1;
		$post['approved_by'] = MYID;
		$post['approved_date'] = date("Y-m-d H:i:s");
		$post['approval_comments'] = 'Request made by office';		
		
					
		if( is_array( $post ) ) :	
			$fields ='';
			$values ='';				
			foreach( $post as $key => $value ) :					
				$fields .= trim( $key ) . ", ";
				$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
			endforeach;		
		endif;
			
		$fields = substr( trim( $fields ), 0, -1 );		
		$values = substr( trim( $values ), 0, -1 );
			
		$sql = new MYSQL;
		$query = $sql->insert( ' bookings ' );
		$query .= $sql->columns( $fields );	
		$query .= $sql->values( $values );		
		
		$rows = DBASE::mysqlInsert( $query );
		
		//send a notification to the applicant
		if(isset($post['institution_type']) && $post['institution_type'] != 1000 ) // not others
			$institutiontype = baseModel::institutionTypeDetails($post['institution_type'])->title;
		else
			$institutiontype = 'Others : '.$post['institution_type_others'];	
		
		$visit_time = $post['visit_time'] == 1 ? '1000hrs' : '1400hrs';			
		
		$body = '
			<p>Dear '.$post['fullname'].',</p>
			<p>Your have made application to visit KenGen facilitites, with the following details:</p>				
			
			<p>To Stations : '.$station->title.'</p>  				     
			<p>Your Full Name : '.$post['fullname'].'</p>        
			<p>Your title / designation in the institution: '.$post['designation'].'</p>
			<p>Name of Institution: '.$post['institution'].' </p>
			<p>Institution Type: '.$institutiontype.' </p>
			<p>County: '.baseModel::countryDetails($post['country_id'])->title.' </p>
			<p>Town: '.$post['town'].' </p>
			<p>Telephone: '.$post['phoneno'].' </p>
			<p>Email Address: '.$post['emailadd'].' </p>
			<p>Proposed Date of Visit: '.baseModel::formatDateShort($post['visit_date']).' </p>
			<p>Visit Time/Hours: '.$visit_time.'</p>
			<p>Number of Visitors : '.$post['number_of_visitors'].' </p>				
			<p>Purpose of the Tour: '.$post['description'].' </p>
			
			<p>&nbsp;</p>
			
			<p>Your applicatin has been assigned the reference number : <b>'.$post['ref_no'].'</b></p>
			<p>Thank you for your interest in visiting our facilities. Once the request has been acted upon, you will be notified through this  email address.</p>
			<p>&nbsp;</p>
			
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';

			$from = SYSTEM_EMAIL;
			$to = $post['emailadd'];
			$cc = "";
			$bcc = BCC;
			$subject = 'Confirmation - We received your request';			
	
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subject, $body );
			
			if($sent)
				echo '<div class="col-md-12 isa_success text-center">An email has been sent to your inbox with details and reference number.(if not in inbox, please check in junk/spam folders)</div>';
			else
				echo '<div class="col-md-12 isa_warning text-center">Email failed submitting to your inbox. But your details are well captured.</div>';
				
	
		$success_msg = '<p>Request successfully submitted</p><p>Redirecting after 10 seconds</p>';
		
		echo '<div class="col-md-12 isa_success text-center">'.$success_msg.'</div>';
		
		echo '<meta http-equiv="refresh" content="10;'.$url.'" />';
		
		
		}		
	
	public static function listStationBookings($station)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' bookings ' );	
		$query .= $sql->where( ' station_id = '.$station );	
		
		
		$rows = DBASE::mysqlRowObjects( $query );
		
		return $rows;
		}
			
	public static function listDates()
		{

		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' bookings ' );	
		//$query .= $sql->where( ' ' );	
		$query .= $sql->order( " date_created desc ");	
		
		//echo $query;
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
	
		}
		
	public static function searchCalendar($post)
		{
		
		unset($post['submitThis']);
	
		$where = baseModel::createSearchSet($post);
		
		//echo $where;
		
		$sql = new MYSQL;		
	
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' bookings ' );			
		$query .= $sql->where( $where  );			
		$query .= $sql->order( " date_created desc ");	
		
		//echo $query;
	
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
	

	
	
	} // end class


?>