<?php

class logsModel
{


	public static function listUserLogs()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( " user_logs " );	
			
		$query .= $sql->order( ' date_created desc' );

		$rows = DBASE::mysqlRowObjects( $query );
								
		return $rows;
		
		}
		
	public static function searchUserLogs($post)
		{
		
		$uid = $post['uid'];
		
		$where ='';
		if(isset($uid) && $uid > 0)
			$where .= ' uid = '.$uid .' and ';
			
		if(!empty($post['date_from']))
			$where .= " date_created >= '".date("Y-m-d", strtotime(str_replace("/","-",$post['date_from'])))."' and ";
		
		if(!empty($post['date_to']))
			$where .= " date_created <= '".date("Y-m-d", strtotime(str_replace("/","-",$post['date_to'])))."' and ";

		if(strlen(trim($where)) > 0)
			$where = substr(trim($where), 0, -3) ;

		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( " user_logs " );	
		
		if(strlen(trim($where)) > 0)
			$query .= $sql->where( $where );	
				
		$query .= $sql->order( ' date_created desc' );

		$rows = DBASE::mysqlRowObjects( $query );
								
		return $rows;
		
		}

}

?>