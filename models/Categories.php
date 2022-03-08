<?php 

/**
 * 
 */

class Category
{
	private $table = "course_categories";
	private $table_courses = "courses";
	private $table_course_category = "course_category";
	private $id_column = "category_id";

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

	public function get_courses() {
		$sql = "SELECT name, (SELECT COUNT(course_id) FROM {$this->table_course_category} WHERE category_id = C.category_id) courses FROM {$this->table} C";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function create($data = [], $columns = []) {
		if (empty($data)) return false;
		$columns = implode(',',$columns);
		extract($data);
		$sql = "INSERT INTO {$this->table} ($columns) VALUES('$name')";
		$result = execute_query_return_id($sql);
		return $result;
	}

	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET name = '$name' WHERE {$this->id_column} = $id";
		$result = execute_query($sql);
		return $result;
	}

	public function delete($id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id";
		$result = execute_query($sql);
		return $result;
	}

}