<?php 

/**
 * 
 */

class Sponsors
{
	private $table = "sponsors";
	private $table_course = "courses";
	private $table_sponsors = "sponsors";
	private $id_column = "sponsor_id";
	private $id_course_column = "course_id";

	function __construct() {
	}
	
	public function get(int $id = 0) {
		if ($id != 0) {
			$sql = "SELECT * FROM {$this->table} = $id";
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

	public function delete($id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
		$result = execute_query($sql);
		return $result;
	}

}