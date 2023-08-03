<?php
class MYSQL 
{	
	//@var select statement.
	protected $select = null;
	
	//@var from element.
	protected $from = null;
	
	//@var where element.
	protected $where = null;
	
	//@var insert statement.
	protected $insert = null;
	
	//@var columns element.
	protected $columns = null;
	
	//@var values element.
	protected $values = null;
	
	//@var update statement.
	protected $update = null;
	
	//@var set element.
	protected $set = null;
		
	//@var set element.
	protected $limit = null;
	
	//@function select statement.
	function select( $fields ) {		
		$sql = "SELECT $fields ";
		return $sql;	
	}

function selectDISTINCT( $fields ) {		
		$sql = "SELECT DISTINCT $fields ";
		return $sql;	
	}
	
	//@function from statement.
	function from( $table ) {		
		$sql = "FROM $table ";
		return $sql;	
	}
	
	//@function where statement.
	function where( $where ) {		
		$sql = "WHERE $where ";
		return $sql;	
	}
	
	//@function insert statement.
	function insert( $table ) {
		$sql = "INSERT INTO $table ";
		return $sql;	
	}
	
	//@function columns statement.
	function columns( $fields ) {
		$sql = "( $fields ) ";
		return $sql;
	}
	
	//@function values statement.
	function values( $values ) {
		$sql = "VALUES( $values ) ";
		return $sql;
	}
	
	//@function update statement.
	function update( $table ) {		
		$sql = "UPDATE $table ";
		return $sql;	
	}
	
	//@function set statement.
	function set( $fields ) {		
		$sql = "SET $fields ";
		return $sql;	
	}
	
	//@function update statement.
	function delete( ) {		
		$sql = "DELETE ";
		return $sql;	
	}
	
	//@function order statement.
	function order( $field ) {		
		$sql = " ORDER BY $field ";
		return $sql;	
	}
	
	//@function order statement.
	function group( $field ) {		
		$sql = " GROUP BY $field ";
		return $sql;	
	}
	
		//@function order statement.
	function limit( $field ) {		
		$sql = " LIMIT $field ";
		return $sql;	
	}
}
?>