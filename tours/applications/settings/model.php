<?php

class settingsModel
{
public static function settings()
	{
	$sql = new MYSQL;		
	$query = $sql->select( ' * ' );
	$query .= $sql->from( ' settings ' );	
	$query .= $sql->limit( ' 0,1 ' );	
	
	$rows = DBASE::mysqlRowObjects( $query );

	return @$rows[0];	
	
	}


	public static function submitSettings( $post ) 
		{	
		
		if(isset($post['settingsid']))
			$id = $post['settingsid'];
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['settingsid']);
		unset($post['url']);		
		
		if(!isset($post['close_all_facilities']))
			$post['close_all_facilities'] = 0;
		
		$post['date_modified'] = date("Y-m-d H:i:s");

		$sql = new MYSQL;
		$query = $sql->update( ' settings ' );
		$query .= $sql->set( baseModel::createSet( $post ) );	
		$query .= $sql->where( 'id=' . $id );
		
		//echo $query;
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'updated settings');
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
}//class

?>