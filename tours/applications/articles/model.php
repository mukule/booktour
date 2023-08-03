<?php

class articlesModel
	{
	
	public static function getArticle($position)
		{
		
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' articles a, articles_positions p ' );	
		$query .= $sql->where( " a.article_position_id = p.id and p.position like '%".$position."%' " );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}
	
	public static function listArticles()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' articles ' );	
		
		if(ACCESS_LVL != 1)
			$query .= $sql->where( " active = 1" );	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}
		
	public static function articleDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' articles ' );	
		$query .= $sql->where( " id = ".$id);	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	public static function submitArticle( $post ) 
		{	

		if(isset($post['articleid']))
			$id = $post['articleid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['articleid']);
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
			$query = $sql->insert( ' articles ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//echo $query; return;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new article - '.articlesModel::articleDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' articles ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated articles details -'.articlesModel::articleDetails($id)->title);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' articles ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated articles details - '.articlesModel::articleDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' articles ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated articles details - '.articlesModel::articleDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}

	public static function delete($id, $url)
		{
		
		$item = articlesModel::articleDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' articles ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted articles - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	
	}

?>