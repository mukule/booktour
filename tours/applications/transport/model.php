<?php

class transportModel
	{
	
	public static function listTransportModes()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' transport_modes ' );	
		$query .= $sql->order( " title " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}	
	
	
	public static function displayTransportModes($modes)
		{
		$array = explode(",",$modes);
		
		$mode ='';
		foreach($array as $arr)
			{
			$mode .= ' - '.transportModel::transportModeDetails($arr)->title.'<br>';
			}		
		
		return $mode;
		
		}

	public static function transportModeDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' transport_modes ' );	
		$query .= $sql->where( " id = ".$id );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	
	public static function submitTransportMode( $post ) 
		{	
		
		if(isset($_POST['modeid']))
			$id = $post['modeid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['modeid']);
		unset($post['url']);		
		
		if( !isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
						
			if( is_array( $post ) ) :
				$fields ='';
				$values = '';		
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' transport_modes ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new transportMOde - '.transportModel::transportModeDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' transport_modes ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			//echo $query;
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated station details -'.transportModel::transportModeDetails($id)->title);
			
			}
		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}


	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( 'transport_modes' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated transport mode details - '.transportModel::transportModeDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( 'transport_modes' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated transport mode details - '.transportModel::transportModeDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}



	public static function delete($id, $url)
		{
		
		$item = transportModel::transportModeDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'transport_modes' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted transport mode - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	
	
		
} //end class

?>