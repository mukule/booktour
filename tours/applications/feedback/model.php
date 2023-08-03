<?php
class feedbackModel
	{
	
	
	
	public static function listFeedback()
		{
		
		if($_SESSION['userlevel'] == 2): ///if this is station admin
			
			$myid = $_SESSION[SESSIONID];
			
			$sql = new MYSQL;		
			$query = $sql->select( ' *, f.date_created as datecreated, f.id as feedid ' );
			$query .= $sql->from( ' feedback f, stations s ' );	
			$query .= $sql->where( ' s.id = f.station_id and FIND_IN_SET('.$myid.', user_id)  ' );
				
			$query .= $sql->order( " datecreated desc ");	
			
			//echo $query;
					
			$rows = DBASE::mysqlRowObjects( $query );
		
			return $rows;			
		
		elseif($_SESSION['userlevel'] == 1): ///super admin

			$sql = new MYSQL;		
			$query = $sql->select( ' *, date_created as datecreated, id as feedid ' );
			$query .= $sql->from( ' feedback ' );	
			
			$query .= $sql->order( " datecreated desc ");	
			
			$rows = DBASE::mysqlRowObjects( $query );
		
			return $rows;			
				
		endif;	
		
		
	
		}
		
		
		
		
		
	public static function searchFeedback($post)
		{
		
		unset($post['submitThis']);
	
		$where = baseModel::createSearchSet($post);
		
		//echo $where;
		
		$sql = new MYSQL;		
	
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' feedback ' );			
		$query .= $sql->where( $where  );			
		$query .= $sql->order( " date_created desc ");	
		
		//echo $query;
	
		$rows = DBASE::mysqlRowObjects( $query );
		
		return $rows;	
		
		
		}		
		
		
	
	public static function feedbackDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' feedback ' );	
		$query .= $sql->where( ' id =  '.$id );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	

	
	
	} // end class


?>