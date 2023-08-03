<?php

class plantsModel
	{
	
	public static function listPlants($stationid)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' plants ' );	
		
		if($stationid > 0)
			$query .= $sql->where( ' station_id = '.$stationid );	
		
		$query .= $sql->order( " title ");	
		
		//echo $query;
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}

	public static function plantDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' plants ' );	
		$query .= $sql->where( " id = ".$id);	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	
	
	public static function submitPlant( $post ) 
		{	
		if(isset($post['plantid']))
			$id = $post['plantid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['plantid']);
		unset($post['url']);	
		
		$post['date_modified'] = date("Y-m-d H:i:s");
		
		if( !isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
						
			if( is_array( $post ) ) :
				$fields ='';
				$values	='';	
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' plants ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new plant - '.plantsModel::plantDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' plants ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated plant details -'.plantsModel::plantDetails($id)->title);
			
			}
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
					
	
	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' plants ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated plants details - '.plantsModel::plantDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' plants ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated plant details - '.plantsModel::plantDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}



	public static function delete($id, $url)
		{
		
		$item = plantsModel::plantDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'plants' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted plants - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	


	}


?>