<?php 

/**
 * 
 */

class Payment
{
	
	private $table = "payment_methods";
	private $id_column = "payment_method_id";

	function __construct() {
	}
	
	public function get(int $id = 0) {
		if ($id != 0) {
			$sql = "SELECT * FROM {$this->table} WHERE {$this->id_column} = $id";
		}
		else{
			$sql = "SELECT * FROM {$this->table}";
		}
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET name = '$name' WHERE {$this->id_column} = $id";
		$result = execute_query($sql);
		return $result;
	}

}