<?php

class reportsModel
{

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
		
		if(!empty($post['visited']))
			{			
			$post['visited'] == 10 ? $post['visited'] = 0 : $post['visited'];
			
			$where .= " visited = '".$post['visited']."' and ";				
			}		
		
		if(!empty($post['approved']))
			{			
			$post['approved'] == 10 ? $post['approved'] = 0 : $post['approved'];
			
			$where .= " approved = '".$post['approved']."' and ";				
			}			
		
		
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


} //class

?>