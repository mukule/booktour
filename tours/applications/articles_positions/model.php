<?php

class articlePositionsModel
	{
	
	public static function listPositions()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' articles_positions ' );	
		$query .= $sql->order( " position " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}	
	
	public static function articlePositionDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' articles_positions ' );	
		$query .= $sql->where( " id = ".$id );	
				
		//echo $query;
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	
	public static function submitInstitution( $post ) 
		{	
		
		if(isset($post['articlePositionid']))
			$id = $post['articlePositionid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['articlePositionid']);
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
			$query = $sql->insert( ' articles_positions ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new articlePosition - '.articlePositionsModel::articlePositionDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' articles_positions ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			//echo $query;			
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated articlePosition details -'.articlePositionsModel::articlePositionDetails($id)->title);
			
			}		
		
		echo '<script>self.position="'.$url.'&msg=success"</script>';
		
		}


	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( 'articles_positions' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated articlePositions details - '.articlePositionsModel::articlePositionDetails($id)->title);
		
		echo '<script>self.position="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( 'articles_positions' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated articlePositions details - '.articlePositionsModel::articlePositionDetails($id)->title);
		
		echo '<script>self.position="'.$url.'&msg=success"</script>';
	
		}



	public static function delete($id, $url)
		{
		
		$item = articlePositionsModel::articlePositionDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( 'articles_positions' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted articlePosition - '.$item);
		
		echo '<script>self.position="'.$url.'&msg=success"</script>';
	
		}	
	
		
} //end class

?>