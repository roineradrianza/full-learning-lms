<?php 

/**
 * 
 */
class CoursesMeta
{
	private $table = "course_meta";
	private $id_column = "course_meta_id";
	private $course_column = "course_id";

	function __construct() {
	}
	public function get(int $id = 0) {
		if ($id == 0) return false;
		$sql = "SELECT * FROM {$this->table} WHERE {$this->course_column} = $id";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function get_meta(int $course_id = 0, $meta_name = '') {
		if (empty($meta_name) || $course_id == 0) return false;
		$sql = "SELECT * FROM {$this->table} WHERE {$this->course_column} = $course_id AND course_meta_name = '$meta_name'";
		$result = execute_query($sql);
		if (empty($result)) {
			return [];
		}
		return $result->fetch_assoc();
	}

	public function create($data = []) {
		if (empty($data)) return false;
		extract($data);
		$sql = "INSERT INTO {$this->table} (course_meta_name, course_meta_val, course_id) VALUES('$course_meta_name', '$course_meta_val', $course_id)";
		$result = execute_query_return_id($sql);
		return $result;
	}

	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET course_meta_val = '$course_meta_val' WHERE {$this->course_column} = $id AND course_meta_name = '$course_meta_name'";
		$result = execute_query($sql);
		return $result;
	}

	public function delete($id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
		$result = execute_query($sql);
		return $result;
	}

}