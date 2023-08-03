<?php

class holidaysModel
	{
	
	public static function listHolidays($year)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' holidays ' );	
		
		$where = '';
		
		if(ACCESS_LVL != 1)
			$where .= " active = 1 and " ;	
		
		if($year > 0)
			$where .= " annual=1 or YEAR(date_holiday) = ".$year."  and " ;			
		
		if(strlen(trim($where)) > 0)
			{
			$where = substr(trim($where),0,-3);

			$query .= $sql->where( $where );	
			}
		
		$query .= $sql->order( " MONTH(date_holiday), DAY(date_holiday) ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}
		
	public static function holidayDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' holidays ' );	
		$query .= $sql->where( " id = ".$id);	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	
	
	public static function submitholiday( $post ) 
		{	
		
		if(isset($post['holidayid']))
			$id = $post['holidayid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['holidayid']);
		unset($post['url']);		

		$post['date_holiday'] = date("Y-m-d", strtotime(str_replace("/", "-", $post['date_holiday'])) );
		
		//return $post['date_holiday'];		
		$post['date_modified'] = date("Y-m-d H:i:s");
		
		if( !isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
			$post['created_by'] = MYID;	
					
			if( is_array( $post ) ) :	
				$fields	= '';
				$values	= '';
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' holidays ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//echo $query;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new holiday - '.holidaysModel::holidayDetails($rows)->title);
			}
		
		else 
			{			
			
			$sql = new MYSQL;
			$query = $sql->update( ' holidays ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated holidays details -'.holidaysModel::holidayDetails($id)->title);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
	
	
	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' holidays ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated holidays details - '.holidaysModel::holidayDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' holidays ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated holidays details - '.holidaysModel::holidayDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}



	public static function delete($id, $url)
		{
		
		$item = holidaysModel::holidayDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' holidays ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted holidays - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	


	public static function listYearsFromHolidays()
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' distinct YEAR(date_holiday) as year ' );
		$query .= $sql->from( ' holidays ' );	
		$query .= $sql->order( " date_holiday ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		}


	}


?>