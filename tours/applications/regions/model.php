<?php

class regionsModel
	{
	
	public static function listRegions()
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' regions ' );	
		
		if(ACCESS_LVL != 1)
			$query .= $sql->where( " active = 1" );	
		
		$query .= $sql->order( " ordering ");	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows;
		
		}
		
	public static function regionDetails($id)
		{
		$sql = new MYSQL;		
		$query = $sql->select( ' * ' );
		$query .= $sql->from( ' regions ' );	
		$query .= $sql->where( " id = ".$id);	
				
		$rows = DBASE::mysqlRowObjects( $query );
	
		return $rows[0];
		
		}	
	
	public static function submitRegion( $post, $file ) 
		{	
		
		$fileName = $file['img']['name'];
		$tmpName  = $file['img']['tmp_name'];				
		$fileSize = $file['img']['size'];
		$fileType = $file['img']['type'];
		
		$uploaddir =  REGIONS_IMAGES;	
		
		$fileName_rename = time() . '_' . basename( $fileName );
				
		if( $fileName ) :
			
			$uploadfile = $uploaddir .  $fileName_rename ;
		
			//$ext = strtolower( substr( $uploadfile, strlen( $uploadfile )-3, 3 ) );
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			
			//echo '---'.$ext;
			
			if( preg_match( "/(jpg|jpeg|png)/", $ext ) ) :
						
				if( move_uploaded_file( $tmpName, $uploadfile ) ) :
					$success_msg = '<p>Successfully sent the document</p>';
				else :	//uploaded			
					echo '<div class="col-md-12 isa_error text-center">Error uploading the file</div>';
					return;
				endif;
				
			else :	//filename			
				echo '<div class="col-md-12 isa_error text-center">The file you are trying to upload is not available or incorrect format - '.$ext.'</div>';
				return;
			endif;				
			
		endif;
		
		//update db
		if( $fileName )
			$post['img'] = $fileName_rename;		
		
		//signature
		if(!empty($file['signature']['tmp_name']))
			{
			$imgData = file_get_contents($file['signature']['tmp_name']);
			$post['signature'] = $imgData;
			}
			
			//echo $post['signature']; return;
		
		if(isset($post['regionid']))
			$id = $post['regionid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['regionid']);
		unset($post['url']);		
		
		$post['date_modified'] = date("Y-m-d H:i:s");
		
		if(!isset($post['acting']) || empty($post['acting']))
			$post['acting']=0;
			
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
			$query = $sql->insert( ' regions ' );
			$query .= $sql->columns( $fields );	
			$query .= $sql->values( $values );
			
			//echo $query; return;
			
			$rows = DBASE::mysqlInsert( $query );
			
			echo baseModel::updateUserLogs(MYID, 'added new region - '.regionsModel::regionDetails($rows)->title);
			}
		
		else 
			{

			$sql = new MYSQL;
			$query = $sql->update( ' regions ' );
			$query .= $sql->set( baseModel::createSet( $post ) );	
			//$query .= $sql->set( " signature = '".$post['signature']."'" );	
			$query .= $sql->where( 'id=' . $id );
			
			//echo '<br>'.$query; return;
			
			$rows = DBASE::mysqlUpdate( $query );
			
			echo baseModel::updateUserLogs(MYID, 'updated regions details -'.regionsModel::regionDetails($id)->title);
			
			}		
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}

	public static function publish($id, $url)
		{
		$sql = new MYSQL;
		$query = $sql->update( ' regions ' );
		$query .= $sql->set( ' active = 1 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated regions details - '.regionsModel::regionDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		}
		
	public static function unPublish($id,$url)
		{
		
		$sql = new MYSQL;
		$query = $sql->update( ' regions ' );
		$query .= $sql->set( ' active = 0 ' );	
		$query .= $sql->where( 'id=' . $id );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated regions details - '.regionsModel::regionDetails($id)->title);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}

	public static function delete($id, $url)
		{
		
		$item = regionsModel::regionDetails($id)->title;
		
		
		$sql = new MYSQL;
		$query = $sql->delete( ' * ' );
		$query .= $sql->from( ' regions ' );	
		$query .= $sql->where( " id = ".$id );
		
		$rows = DBASE::mysqlDelete( $query );		
		
		echo baseModel::updateUserLogs(MYID, 'deleted regions - '.$item);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
	
		}	

	public static function getHighestOrdering()
		{
		//SELECT MAX(<numeric column>) FROM <table>;
		
		$sql = new MYSQL;
		$query = $sql->select( ' MAX(ordering) as maxi ' );
		$query .= $sql->from( ' regions ' );	
			
		$rows = DBASE::mysqlRowObjects( $query );		
		
		return $rows[0]->maxi;
		
		}			
		
	public static function orderItemUp($id, $url)
		{
		
		$item = regionsModel::regionDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder-1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered region  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}		
		
	public static function orderItemDown($id, $url)
		{
		
		$item = regionsModel::regionDetails($id);
		
		$currentOrder = $item->ordering;
		
		$targetOrder = $currentOrder+1;
		$tempOrder = 1001;
		
		//alter tartget order
		$sql = new MYSQL;
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$tempOrder );	
		$query .= $sql->where( " ordering = ".$targetOrder );
		
		$rows = DBASE::mysqlUpdate( $query );		
		
		//move item to target
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$targetOrder );	
		$query .= $sql->where( " id = ".$item->id );
		
		$rows = DBASE::mysqlUpdate( $query );			
		
		//reorder the temporary
		$sql = new MYSQL;
		$query = $sql->update( 'regions' );
		$query .= $sql->set( ' ordering = '.$currentOrder );	
		$query .= $sql->where( " ordering = ".$tempOrder );
		
		$rows = DBASE::mysqlUpdate( $query );	
		
		echo baseModel::updateUserLogs(MYID, 'ordered region  -'.$id);
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';		
		
		}	



	}


?>