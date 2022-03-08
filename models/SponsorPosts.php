<?php

/**
 *
 */

class SponsorPosts
{
	private $table = "sponsor_posts";
	private $table_course = "courses";
	private $table_sponsors = "sponsors";
	private $table_course_sponsors = "course_sponsors";
	private $id_column = "sponsor_post_id";
	private $id_sponsor_column = "sponsor_id";
	private $id_course_column = "course_id";

	function __construct() {
	}

	public function get(int $id = 0) {
		if ($id != 0) {
			$sql = "SELECT sponsor_post_id, sponsor_name, website, post_url, post_image, description, SP.sponsor_id, published_at FROM {$this->table} SP INNER JOIN {$this->table_sponsors} S ON SP.sponsor_id = S.sponsor_id INNER JOIN {$this->table_course_sponsors} CS ON CS.sponsor_id = S.sponsor_id WHERE CS.{$this->id_course_column} = $id AND active = 1";
		}
		else{
			$sql = "SELECT * FROM {$this->table} ";
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
