<?php
class SQL 
{
	//@var    string  The query type.
	protected $type = '';
	
	//@var    object  The insert element.
	protected $insert = null;
	
	//@var    object  The select element.
	protected $select = null;
	
	//@var    object  The update element.
	protected $update = null;
	
	//@var    object  The columns element.
	protected $columns = null;	
	
	//@var    object  The values element.
	protected $values = null;
	
	//@var    object  The set element.
	protected $set = null;	
	
	//@var    object  The from element.
	protected $from = null;
	
	//@var    object  The where element.
	protected $where = null;
	
	//@var    object  The order element.
	protected $order = null;
		//@var    object  The order element.
	protected $group = null;
	//@var    object  The limit element.
	protected $limit = null;	
	
	
	public function __toString() {
		
		$query = '';
		
		switch ( $this->type ) :
			
			case 'insert' :
				
				$query .= (string) $this->insert;
				$query .= (string) $this->columns;
				$query .= (string) $this->values;
				
				break;
			
			case 'select' :
				
				$query .= (string) $this->select;
				$query .= (string) $this->from;
				
				if( $this->where )
					$query .= (string) $this->where;
					
				if( $this->order )
					$query .= (string) $this->order;
						
				if( $this->group )
					$query .= (string) $this->group;
					
				if( $this->limit )
					$query .= (string) $this->limit;
					
				break;
				
			case 'update' :
				
				$query .= (string) $this->update;
				$query .= (string) $this->set;
				
				if( $this->where )
					$query .= (string) $this->where;
					
				break;
				
			case 'delete' :
				
				$query .= (string) $this->delete;
				$query .= (string) $this->from;
				
				if( $this->where )
					$query .= (string) $this->where;
					
				break;
				
		endswitch;
		
		return $query;
	}
		
	public function insert( $table ) {
	
		$this->type = 'insert';	
		$this->insert = "INSERT INTO " . $table;	
		return $this;
		
	}
	
	public function select( $fields ) {
	
		$this->type = 'select';	
		$this->select = "SELECT " . $fields;	
		return $this;
		
	}
	
	public function update( $table ) {
	
		$this->type = 'update';	
		$this->update = "UPDATE " . $table;	
		return $this;
		
	}
	
	public function delete( $table ) {
	
		$this->type = 'delete';	
		$this->delete = "DELETE " . $table;	
		return $this;
		
	}
		
	public function columns( $columns ) {	
		
		$this->columns = "( $columns )";	
		return $this;
		
	}
	
	public function values( $values ) {	
		
		$this->values = " VALUES( $values )";	
		return $this;
		
	}
	
	public function set( $set ) {	
		
		$this->set = " SET $set";	
		return $this;
		
	}
		
	public function from( $table ) {	
		
		$this->from = " FROM " . $table;	
		return $this;
		
	}
	
	public function where( $conditions ) {	
		
		$this->where = " WHERE " . $conditions;	
		return $this;
		
	}

	public function order( $ordering ) {	
		
		$this->order = " ORDER BY " . $ordering;	
		return $this;
		
	}

public function group( $group ) {	
		
		$this->group = " GROUP BY " . $group;	
		return $this;
		
	}
	public function limit( $limits ) {	
		
		$this->limit = " LIMIT " . $limits;	
		return $this;
		
	}

}
?>