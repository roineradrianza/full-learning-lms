<?php

/**
 *
 */

class SponsorPostViews
{
	private $table = "sponsor_post_views";
	private $id_column = "sponsor_post_view_id";
	private $id_course_column = "course_id";

	public function get(int $id = 0) {
		if ($id == 0) return false;
		$sql = "SELECT * FROM {$this->table} WHERE {$this->$id_column} = $id";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function get_by_course(int $id = 0) {
		if ($id == 0) return [];
		$sql = "SELECT * FROM {$this->table} WHERE {$this->$id_course_column} = $id";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function create($data = []) {
		if (empty($data)) return false;
		extract($data);
		$sql = "INSERT INTO {$this->table} (visitor_ip, country, sponsor_post_id, course_id)
    VALUES('$ip', '$country', $sponsor_post_id, $course_id)";
		$result = execute_query_return_id($sql);
		return $result;
	}

	public function delete($id, $lesson_id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column}";
		$result = execute_query($sql);
		return $result;
	}

}
