<?php

class institutionsModel
	{
	
	public static function listInstitutions()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' institution_types ' );	
		$query .= $sql->order( " title " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}	
	
	public static function institutionDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' institution_types ' );	
		$query .= $sql->where( " id = ".$id );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	
	public static function submitInstitution( $post ) 
		{	
		
		if(isset($post['institutionid']))
			$id = $post['institutionid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['institutionid']);
		unset($post['url']);		
		
		if( !isset($id) || $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
						
			if( is_array( $post ) ) :	
				$fields ='';
				$values	= '';	
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' institution_types ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new institution - '.institutionsModel::institutionDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' institution_types ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			//echo $query;			
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated institution details -'.institutionsModel::institutionDetails($id)->title);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}


	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( 'institution_types' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated institutions details - '.institutionsModel::institutionDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( 'institution_types' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated institutions details - '.institutionsModel::institutionDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}



	public static function delete($id, $url)
		{
		
		$item = institutionsModel::institutionDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'institution_types' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted institution - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	
	
		
} //end class

?>