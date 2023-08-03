<?php

class stationsModel
	{
	
		public static function listStations()
		{
			$sql = new MYSQL();
			$query = $sql->select('*');
			$query .= $sql->from('stations');
		
			$where = '';
		
			if (ACCESS_LVL != 1)
				$where .= " active = 1 and ";
		
			if (ACCESS_LVL == 2 || ACCESS_LVL == 3) {
				// Select stations where the user's ID (MYID) is in the user_id column
				$where .= " FIND_IN_SET(" . MYID . ", user_id) and ";
			}
		
			if (strlen(trim($where)) > 0) {
				$where = substr(trim($where), 0, -4); // Remove the last "AND" and spaces
				$query .= $sql->where($where);
			}
		
			$query .= $sql->order("ordering");
		
			//echo $query;
		
			$rows = DBASE::mysqlRowObjects($query);
		
			return $rows;
		}
		

	public static function listMyStations($uid)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations ' );	
		
		$query .= $sql->where( ' FIND_IN_SET('.$uid.', user_id) ' );			
		
		$query .= $sql->order( " title ");	
		
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function stationDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations ' );	
		$query .= $sql->where( " id = ".$id);	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	public static function stationContacts($sid)
		{
		
		$station = stationsModel::stationDetails($sid);
		$region = regionsModel::regionDetails($station->region_id);
		
		$stationContacts = $station->contacts;
		
		$regionContacts = '';
		
		$regionContacts .= !empty($region->address) ? '<p>'. $region->address . '</p>' : '';
		$regionContacts .= !empty($region->phoneno) ? '<p>'. $region->phoneno .'</p>' : '';
		$regionContacts .= !empty($region->emailadd) ? '<p>'. $region->emailadd .'</p>' : '';
		
		$contacts ='';
		if(!empty($stationContacts) )
			$contacts .= '<div class="col-md-12"><h4>Station Contacts</h4>'.$stationContacts.'</div>';
		
		if(!empty($regionContacts))
			$contacts .= '<div class="col-md-12"><h4>Regional Contacts</h4>'.$regionContacts.'</div>';
			
		return $contacts;			
			
		}		
	
	public static function submitStation( $post, $file ) 
		{	
		
		if(isset($post['stationid']))
			$id = $post['stationid'];
		
		$fileName = $file['photo']['name'];
		$tmpName  = $file['photo']['tmp_name'];				
		$fileSize = $file['photo']['size'];
		$fileType = $file['photo']['type'];
		
		$uploaddir = STATIONS_IMAGES;	
		
		$fileName_rename = basename( $fileName );
				
		if( $fileName ) :
			
			$uploadfile = $uploaddir .  $fileName_rename ;
		
			//$ext = strtolower( substr( $uploadfile, strlen( $uploadfile )-3, 3 ) );
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			
			//echo '---'.$ext;
			
			if( preg_match( "/(jpg|jpeg|png)/", $ext ) ) :
						
				if( move_uploaded_file( $tmpName, $uploadfile ) ) :
					$success_msg = '<p>Successfully sent the document</p>';
				else :	//uploaded			
					echo '<div class="col-md-12 isa_error text-center">Error uploading the image</div>';
					return;
				endif;
				
			else :	//filename			
				echo '<div class="col-md-12 isa_error text-center">The image you are trying to upload is not available or incorrect format - '.$ext.'</div>';
				return;
			endif;				
			
		endif;
		
		
		//update db
		if( $fileName )
			$post['photo'] = $fileName_rename;	
		
		//print_r($_POST);
		
		if(isset($_POST['visitors_min']) && $_POST['visitors_min'] < 1)
			unset($_POST['visitors_min']);
		if(isset($_POST['visitors_max']) && $_POST['visitors_max'] < 1)
			unset($_POST['visitors_max']);
	
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['stationid']);
		unset($post['url']);	
		
		if(isset($post['user_id']))
			{
			$userids = $post['user_id'];
			
			unset($post['user_id']);
			
			$uids ='';
			foreach($userids as $uid)
				{
				$uids .= $uid.',';
				}
			
			$uids = substr(trim($uids),0,-1);	
			
			$post['user_id'] = $uids;	
			}
			
		if( !isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
						
			if( is_array( $post ) ) :		
				$fields = '';
				$values = '';
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' stations ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//return $query;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new station - '.stationsModel::stationDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' stations ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated station details -'.stationsModel::stationDetails($id)->title);
			
			}
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' stations ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated stations details - '.stationsModel::stationDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' stations ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated station details - '.stationsModel::stationDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}

	public static function delete($id, $url)
		{
		
		$item = stationsModel::stationDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'stations' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted stations - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	

	public static function getHighestOrdering()
		{
		//SELECT MAX(<numeric column>) FROM <table>;
		
		$sql = new MYSQL;
		$query = $sql->select( ' MAX(ordering) as maxi ' );
		$query .= $sql->from( ' stations ' );	
			
		$rows = DBASE::mysqlRowObjects( $query );		
		
		return $rows[0]->maxi;
		
		}			
		
	public static function orderItemUp($id, $url)
		{
		
		$item = stationsModel::stationDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder-1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( ' stations ' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'stations' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'stations' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered station  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}		
		
	public static function orderItemDown($id, $url)
		{
		
		$item = stationsModel::stationDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder+1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( 'stations' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'stations' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'stations' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered station  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}	


		
	public static function listStationStatuses($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations_status ' );	
		$query .= $sql->where( " station_id = ".$id);
		$query .= $sql->order( " date_created desc ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}	
		
	public static function stationStatusDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations_status ' );	
		$query .= $sql->where( " id = ".$id);
	
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
		
	public static function checkIfDatesExist($post)
		{
		
		$start = date("Y-m-d", strtotime($post['date_start']));
		$end = date("Y-m-d", strtotime($post['date_end']));
		$sid = $post['stationid'];
		
		if(isset($post['statusid']))
			$id = $post['statusid'];
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' stations_status ' );	
		
		if(isset($id) && $id > 0)
			$query .= $sql->where( " id != ".$id." and station_id = ".$sid." and ( '".$start."' between date_start and date_end or '".$end."' between date_start and date_end ) ");
		else
			$query .= $sql->where( " station_id = ".$sid." and ( '".$start."' between date_start and date_end or '".$end."' between date_start and date_end ) ");
			
		//echo $query;	
		
		$rows = DBASE::mysqlNumRows( $query );
	
		return $rows;
		
		}	
	
	public static function submitStatus( $post ) 
		{
	
		if(isset($post['statusid']))
			$id = $post['statusid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['statusid']);
		
		unset($post['url']);	
		
		$post['date_start'] = date("Y-m-d", strtotime($post['date_start']) );
		$post['date_end'] = date("Y-m-d", strtotime($post['date_end']) );
		$post['date_modified'] = date( 'Y-m-d H:i:s' );
		
		if(!isset($id)):
		
			$post['date_created'] = date( 'Y-m-d H:i:s' );
			
			$sql = new MYSQL;
			$query = $sql->insert( ' stations_status ' );
			$query .= $sql->columns( 'created_by, station_id, date_start, date_end, closed, description, date_created, date_modified' );	
			$query .= $sql->values( " ".MYID.", '".$post['stationid']."', '".$post['date_start']."', '".$post['date_end']."', 1, '".$post['description']."', '".$post['date_created']."', '".$post['date_modified']."' " );
			
			$rows = DBASE::mysqlInsert( $query );		
		
		else:
			
			unset($post['stationid']);
			
			$sql = new MYSQL;
			$query = $sql->update( ' stations_status ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			echo $query;
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated station status -'.$id);
		
		endif;
		
		echo '<script>self.location="' . $url . '&msg=success"</script>';
		
		}	
	


	public static function publishStatus($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' stations_status ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'published stations status - '.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublishStatus($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' stations_status ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'unpublished station status details - '.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function deleteStatus($id, $url)
		{
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'stations_status' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted station status - '.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	



	}//class


?>