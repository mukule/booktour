<?php

class frontModel
	{

	public static function listStations($regid)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations ' );	
		
		$where = ' active = 1 ';
		
		if($regid > 0)
			$where .= ' and region_id = '.$regid.' ';
		
		$query .= $sql->where( $where );	
		
		$query .= $sql->order( " ordering ");	
			
			//echo $query;
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		}
		
	public static function listPlants($stationid)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' plants ' );	

		$query .= $sql->where( 'active = 1  and station_id = '.$stationid );	
		
		$query .= $sql->order( " title ");	
			
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		}
		
	public static function listRegions()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' regions ' );	
		$query .= $sql->where( " active = 1" );	
		$query .= $sql->order( " ordering ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function listTransportModes()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' transport_modes ' );	
		$query .= $sql->where( " active = 1" );	
		
		$query .= $sql->order( " title ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}
		
	public static function submitBooking($post, $file)
		{
		
		$fileName = $file['document']['name'];
		$tmpName  = $file['document']['tmp_name'];				
		$fileSize = $file['document']['size'];
		$fileType = $file['document']['type'];
		
		$uploaddir = 'tours'. DS . DOCUMENTS_FOLDER;	
		
		$fileName_rename = time() . '_' . basename( $fileName );
				
		if( $fileName ) :
			
			$uploadfile = $uploaddir .  $fileName_rename ;
		
			//$ext = strtolower( substr( $uploadfile, strlen( $uploadfile )-3, 3 ) );
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			
			//echo '---'.$ext;
			
			if( preg_match( "/(pdf)/", $ext ) ) :
						
				if( move_uploaded_file( $tmpName, $uploadfile ) ) :
					$success_msg = '<p>Successfully sent the document</p>';
				else :	//uploaded			
					echo '<div class="col-md-12 isa_error text-center">Error uploading the file</div>';
					return;
				endif;
				
			else :	//filename			
				echo '<div class="col-md-12 isa_error text-center">The file you are trying to upload is not available or incorrect format - '.$ext.'</div>';
				return;
			endif;				
			
		endif;
		
		
		//update db
		if( $fileName )
			$post['document'] = $fileName_rename;		

		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['url']);		
		unset($post['terms']);
		unset($post['captcha']);	
		unset($post['captcha2']);
		
		//change phone if +254 to 07xx
		if(isset($post['phoneno']))
			{
			$phoneno = $post['phoneno'];
			
			if(substr($phoneno,0,1) == "+" )
				$phoneno = substr($phoneno,1);
			
			if(substr($phoneno,0,3) == "254" )
				$phoneno = '0'.substr($phoneno,3);
			
			$post['phoneno'] = $phoneno;
						
			}
		
		$tmodes = $post['transport_mode'];
		
		$station = stationsModel::stationDetails($post['station_id']);
		
		$url_redirect = 'index.php?art=station&stat='.baseModel::encode($post['station_id']);
		
		$stationUsers = $station->user_id;
	
		//$uids = explode(",",$stationUsers);
		
		$stationName = explode(" ", $station->title);
		
		$totalBookings = count(frontModel::listStationBookings($post['station_id']));
		
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
		
		
		if(isset($tmodes) && count($tmodes) > 0)
			{
			$modes ='';
			foreach($tmodes as $mode)
				{
				$modes .= $mode.',';				
				}
			$modes = substr(trim($modes), 0, -1);
			}
		
		unset($post['transport_mode']);
		
		$post['transport_mode'] = $modes;
		
		$post['country_id'] = 110; //Kenya
		
		$post['date_created'] = date("Y-m-d H:i:s");
		$post['visit_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $post['visit_date'])) );
					
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
		
		//echo $query; return;
		
		$rows = DBASE::mysqlInsert( $query );
		
		//send an email notification to KenGen
		$body = '
			<p>Hallo.</p>
			<p>An application for a tour to '.$station->title.' has been made. Please login to the tours portal for action.</p>			
			
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';

			$from = SYSTEM_EMAIL;
			$to = $emails;
			$cc = "";
			$bcc = BCC;
			$subject = 'An Online Tours Request Notification';			
	
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subject, $body );
			
			if($sent)
				echo '<div class="col-md-12 isa_success text-center">Email successfully submitted to KenGen for action</div>';
			else
				echo '<div class="col-md-12 isa_warning text-center">Email failed submitting to KenGen. But your details are well captured. Please contact us using other means provided.</div>';
		
			//send a notification to the applicant
			if(isset($post['institution_type']) && $post['institution_type'] != 1000 ) // not others
				$institutiontype = baseModel::institutionTypeDetails($post['institution_type'])->title;
			else
				$institutiontype = 'Others : '.$post['institution_type_others'];	
			
			$visit_time = $post['visit_time'] == 1 ? '1000hrs' : '1400hrs';			
			
			$contacts = stationsModel::stationContacts($post['station_id']);
	
			$body = '
				<p>Dear '.$post['fullname'].',</p>
				<p>Your have made application to visit KenGen facilitites, with the following details:</p>				
				
				<p>To Stations : '.$station->title.'</p>  				     
				<p>Your Full Name : '.$post['fullname'].'</p>        
				<p>Your title / designation in the institution: '.$post['designation'].'</p>
    			<p>Name of Institution: '.$post['institution'].' </p>
				<p>Institution Type: '.$institutiontype.' </p>
				<p>County: '.baseModel::countyDetails($post['county_id'])->title.' </p>
				<p>Town: '.$post['town'].' </p>
				<p>Telephone: '.$post['phoneno'].' </p>
				<p>Email Address: '.$post['emailadd'].' </p>
				<p>Proposed Date of Visit: '.baseModel::formatDateShort($post['visit_date']).' </p>
				<p>Visit Time/Hours: '.$visit_time.'</p>
				<p>Number of Visitors : '.$post['number_of_visitors'].' </p>
				<p>Mode of Transport: '.transportModel::displayTransportModes($post['transport_mode']).' </p>
				<p>Purpose of the Tour: '.$post['description'].' </p>
				
				<p>&nbsp;</p>
				
				<p>Your applicatin has been assigned the reference number : <b>'.$post['ref_no'].'</b></p>
				<p>Thank you for your interest in visiting our facilities. Once the request has been acted upon, you will be notified through this  email address.</p>
				
				'.$contacts.'
				
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
					
		
			$success_msg .= '<p>Request successfully submitted</p>';
			$success_msg .= '<p>Redirecting after 10 seconds</p>';
			
			echo '<div class="col-md-12 isa_success text-center">'.$success_msg.'</div>';
			
		echo '<meta http-equiv="refresh" content="10;'.$url_redirect.'" />';
		
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


	public static function submitFeedback($post)
		{

		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['url']);		
		unset($post['terms']);
		unset($post['captcha']);	
		unset($post['captcha2']);
		
		$station = stationsModel::stationDetails($post['station_id']);
		
		$stationUsers = $station->user_id;
	
		$uids = explode(",",$stationUsers);
				
		$emails ='';
		foreach($uids as $uid)
			{
			$emails .= usersModel::userDetails($uid)->emailadd.', ';
			}
		
		$emails = substr(trim($emails), 0, -1);
		
		$post['date_created'] = date("Y-m-d H:i:s");
					
		if( is_array( $post ) ) :			
			foreach( $post as $key => $value ) :					
				$fields .= trim( $key ) . ", ";
				$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
			endforeach;		
		endif;
			
		$fields = substr( trim( $fields ), 0, -1 );		
		$values = substr( trim( $values ), 0, -1 );
			
		$sql = new MYSQL;
		$query = $sql->insert( ' feedback ' );
		$query .= $sql->columns( $fields );	
		$query .= $sql->values( $values );
		
		$rows = DBASE::mysqlInsert( $query );
		
		$body = '
			<p>Hello.</p>
			<p>This is  a feedback from a client.</p>
			<p>You can view more details by login in via link : <a href="'.SITE_URL.'">Tours Portal Link</a></p>
			
			<hr />
			<p>Fullname : '.$post['fullname'].'</p>
			<p>Phone : '.$post['phoneno'].'</p>
			<p>Email : '.$post['emailadd'].'</p>
			<p>Station Visited : '.$station->title.'</p>
			<p>Ref No : '.$post['ref_no'].'</p>
			<hr />
			
			<p>Kind Regards,<br>'.SITE_NAME.'</p>';

			$from = $post['emailadd'];
			$to = $emails;
			$cc = "";
			$bcc = BCC;
			$subject = 'Feedback from Book A Tour';			
	
			$sent = baseModel::sendmail( $from, $to, $cc, $bcc, $subject, $body );
			
			if($sent)
				echo '<div class="col-md-12 isa_success text-center">Email successfully sent</div>';
			else
				echo '<div class="col-md-12 isa_warning text-center">Email failed submitting. But your details are well captured.</div>';
		
		echo '<div class="col-md-12 isa_success text-center">Redirecting after 10 seconds</div>';
	
		echo '<meta http-equiv="refresh" content="10" URL="index.php">';
		
		}		

	public static function checkIfDateClosed($post)
		{
		$date = $post['visit_date'];
		$time = $post['visit_time'] == 1 ? '10:00:00' : '14:00:00';
		
		$datetime = $date. ' '.$time;
		
		return $datetime;
		
		}
	
	public static function getBlockedDates($stationid)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations_status ' );	
		$query .= $sql->where( " active = 1 and station_id = " .$stationid );	
		
		$query .= $sql->order( " date_end desc ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		//return $rows;
		
		$allDays = array();
		foreach($rows as $row)
			{
		
			$range = strtotime($row->date_end) - strtotime($row->date_start);
			$days = round($range / (60 * 60 * 24));
			
			for($day = 0; $day <=$days; $day++)
				{
				$allDays[] .= strtotime($row->date_start . "+".$day." days");
				}
			}
		
		return $allDays;
		
		}

		
	public static function getHolidayDates($year)
		{
			
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' holidays ' );	
		$query .= $sql->where( " annual = 1 or date_holiday >= CURDATE() and YEAR(date_holiday)=".$year." and active=1 " );	
		
		$rows = DBASE::mysqlRowObjects( $query );
	
		$allDays = array();
		foreach($rows as $row)
			{
			
			if($row->annual == 1)
				{
				//change date to this year
				$date = date("$year-m-d",strtotime($row->date_holiday));
				$allDays[] .= strtotime($date);
				}
			else
				$allDays[] .= strtotime($row->date_holiday);
			}
		
		return $allDays;
	
		}	
	
	public static function checkIfThisDateBooked($stationid, $date, $time)
		{
					
		$station = stationsModel::stationDetails($stationid);
		$maxVisitors = $station->visitors_max;
		$maxGuides = $station->guides_per_session;
		
		$sql = new MYSQL;		
		//$query = $sql->select( ' *, sum(number_of_visitors) as total_visitors, count(*) as num_visits  ' );
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' bookings ' );	
			
		if($time > 0)
			$whereTime = ' and visit_time = '.$time ;

		$query .= $sql->where( " station_id = " .$stationid ." and visit_date = '".$date."' $whereTime " );	
		
		//echo '<br>'.$query;
		
		//$rows = DBASE::mysqlRowObjects( $query );
		$rows = DBASE::mysqlNumRows( $query );
		/*
		$row = $rows[0];
		$totalVisits = @$row->num_visits;
		$totalVisitors = @$row->total_visitors;
		*/
		
		/*
		$totalVisits = count($rows);
		$totalVisitors = 0;
		foreach($rows as $row)
			{			
			$totalVisitors += $row->number_of_visitors;
			}
		
		if($totalVisits >= $maxGuides || $totalVisitors >= $maxVisitors )
			return 1; //fully booked
		else
			return 0; //not fully booked
		*/
		
		if($rows > 0 )
			return 1; //fully booked
		else
			return 0; //not fully booked
		
		}
		




} //class

?>
