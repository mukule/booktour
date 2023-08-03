<?php
class profileModel
	{
	
	public static function changePassword($post)
		{
		
		$url = $post['url'];
		
		unset($post['submitThis']);
		unset($post['url']);		
		
		
		$date = date("Y-m-d H:i:s");
		
		$pwd = md5($post['newpass']);			
	
		$sql = new MYSQL;
		$query = $sql->update( ' users ' );
		$query .= $sql->set( "pwd = '".$pwd."', date_modified = '".$date."' ");	
		$query .= $sql->where( 'id = ' . MYID );
		
		$rows = DBASE::mysqlUpdate( $query );
		
		echo baseModel::updateUserLogs(MYID, 'changed my password');
		
		echo '<script>self.location="'.$url.'&msg=success"</script>';
		
		}
	
	}



?>