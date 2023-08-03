<?php

class faqsModel
	{

	public static function submitFAQ( $post ) 
		{	
		
		$id = isset($post['itemId']) ? $post['itemId'] : 0;
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['itemId']);
		unset($post['url']);	
		
		$post['date_modified'] = date("Y-m-d H:i:s");	
		
		if( $id < 1  ) 
			{	
			
			$post['date_created'] = date("Y-m-d H:i:s");
			$post['created_by'] = MYID;	
					
			if( is_array( $post ) ) :	
				$fields ='';
				$values ='';		
				foreach( $post as $key => $value ) :					
					$fields .= trim( $key ) . ", ";
					$values .= "'" . @trim( baseModel::cleanContent($value) ) . "', ";			
				endforeach;		
			endif;
				
			$fields = substr( trim( $fields ), 0, -1 );		
			$values = substr( trim( $values ), 0, -1 );
				
			$sql = new MYSQL;
			$query = $sql->insert( ' faqs ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//echo $query;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new faq - '.baseModel::faqDetails($rows)->quiz);
			}
		
		else 
			{
			//$post['date_modified'] = date("Y-m-d H:i:s");
			
			$sql = new MYSQL;
			$query = $sql->update( ' faqs ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			$query .= $sql->where( 'id=' . $id );
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated faq details -'.baseModel::faqDetails($id)->quiz);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
	
	
	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' faqs ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated holidays details - '.baseModel::faqDetails($id)->quiz);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' faqs ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated faqs details - '.baseModel::faqDetails($id)->quiz);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}

	public static function delete($id, $url)
		{
		
		$item = baseModel::faqDetails($id)->quiz;		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' faqs ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted faq - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	


	public static function getHighestOrdering()
		{
		//SELECT MAX(<numeric column>) FROM <table>;
		
		$sql = new MYSQL;
		$query = $sql->select( ' MAX(ordering) as maxi ' );
		$query .= $sql->from( 'faqs' );	
			
		$rows = DBASE::mysqlRowObjects( $query );		
		
		return $rows[0]->maxi;
		
		}			

	public static function orderItemUp($id, $url)
		{
		
		$item = baseModel::faqDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder-1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered faq  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}		
		
	public static function orderItemDown($id, $url)
		{
		
		$item = baseModel::faqDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder+1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'faqs' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered faq  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}	
		
		

	}


?>