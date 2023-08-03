<?php

class usersModel
	{
	
	public static function userDetails($uid)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( 'users ' );	
		$query .= $sql->where( "id = ".$uid." " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		$row = &$rows[0];
		
		return $row;
		
		}


	public static function submitUser( $post ) 
		{	
		if(isset($post['userid']))
			$id = $post['userid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['userid']);
		unset($post['url']);		
		
		if(!isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
			$post['pwd'] = md5($post['pwd']);
						
			if( is_array( $post ) ) :		
				$fields	='';
				$values ='';
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' users ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//return $query;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new user - '.usersModel::userDetails($rows)->emailadd);
			}
		
		else 
			{
			$post['date_modified'] = date("Y-m-d H:i:s");
			
			$pwd = $post['pwd'];			
			$pwd_orig = usersModel::userDetails($id)->pwd; //stored pwd
			
			if($pwd == $pwd_orig )
				$post['pwd'] = $pwd;
			else
				$post['pwd'] = md5($pwd);
			
		
			$sql = new MYSQL;
			$query = $sql->update( ' users ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated user details -'.usersModel::userDetails($id)->emailadd);
			
			}
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

		public static function listStationAdmins()
		{
			$sql = new MYSQL();
			$query = $sql->select('*');
			$query .= $sql->from('users');
			$query .= $sql->where('access_lvl IN (2, 3)'); // Select users with access levels 2 or 3
			$query .= $sql->order('fullname');
		
			$rows = DBASE::mysqlRowObjects($query);
		
			return $rows;
		}
		

	public static function listUsers()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( " users " );
		$query .= $sql->order( ' fullname' );	
		
		$rows = DBASE::mysqlRowObjects( $query );
								
		return $rows;
			
		}	

	public static function publish($id, $url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' users ' );
		$query .= $sql->set( ' active=1 ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'published user -'.usersModel::userDetails($id)->emailadd);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function unPublish($id, $url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' users ' );
		$query .= $sql->set( ' active=0 ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'unpublished user - '.usersModel::userDetails($id)->emailadd);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function userDelete($id, $url)
		{
		
		$em = usersModel::userDetails($id)->emailadd;
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' users ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted user -'.$em);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
	
	
	
	}

?>