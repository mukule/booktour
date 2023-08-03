<?php
class DBASE 
{

	public static function dbConnect( $db_host, $db_user, $db_pass, $db_name ) {
	
		$db_conn = mysqli_connect( $db_host, $db_user, $db_pass, $db_name ) or die( '<h1 style="color:#f00; text-align:center;">The Databse Server is unreachable.</h1>' );
		
		
		return $db_conn;
	}
	
	
	public static function mysqlNumRows( $query ) {		
			
		$result = mysqli_num_rows( mysqli_query($GLOBALS['dbconn'], "$query" ) );		
		return $result;	
		
	}
	
	public static function mysqlRowObjects( $query ) {
		
		
		
		$key = '';
		
		$result = mysqli_query($GLOBALS['dbconn'], "$query" );		
		
		$array = array();
		
		while( $row = mysqli_fetch_object( $result ) ) :			
			
			if( $key ) 
				$array[$row->$key] = $row;
			
			else
				$array[] = $row;
			
		endwhile;
		
		mysqli_free_result( $result );
		
		return $array;
				
	}
	
	public static function mysqlInsert( $query ) {
		
		$result = mysqli_query( $GLOBALS['dbconn'], "$query" ) or die( mysqli_error() );
		$return = ( $result ) ? mysqli_insert_id( $GLOBALS['dbconn']) : '';
		
		return $return;
			
	}
	
	public static function mysqlUpdate( $query ) {		
		
		
		$result = mysqli_query( $GLOBALS['dbconn'], "$query" ) or die( mysqli_error() );	
		$return = ( $result ) ? 1 : 0;
		
		return $return;	
			
	}
	
	public static function mysqlDelete( $query ) {		
		
		
		$result = mysqli_query($GLOBALS['dbconn'], "$query" ) or die( mysqli_error() );	
		$return = ( $result ) ? 1 : 0;
		
		return $return;	
			
	}
	
	

}
?>