<?php

class colorsModel
	{
	
	public static function listColors()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' colors ' );	
		
		if(ACCESS_LVL != 1)
			$query .= $sql->where( " active = 1" );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}
		
	public static function colorDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' colors ' );	
		$query .= $sql->where( " id = ".$id);	
		//echo $query; 
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	public static function submitColor( $post ) 
		{	
		
		if(isset($post['colorid']))
			$id = $post['colorid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['colorid']);
		unset($post['url']);		
		
		$post['date_modified'] = date("Y-m-d H:i:s");
		
		if(!isset($id) || $id < 1  ) 
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
			$query = $sql->insert( ' colors ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//echo $query; return;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new color - '.colorsModel::colorDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' colors ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated colors details -'.colorsModel::colorDetails($id)->title);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' colors ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated colors details - '.colorsModel::colorDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' colors ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated colors details - '.colorsModel::colorDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}

	public static function delete($id, $url)
		{
		
		$item = colorsModel::colorDetails($id)->title;
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' colors ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted colors - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	


	}


?>