<?php 

/**
 * 
 */

class LessonCommentsAnswers
{
	private $table = "lesson_comments_answers";
	private $id_column = "lesson_comment_answer_id";
	private $id_user_column = "user_id";
	private $id_lesson_comment_column = "lesson_comment_id";

	function __construct() {
	}

	public function get(int $id = 0) {
		if ($id == 0) return false;
		$sql = "SELECT lesson_comment_answer_id, comment, LC.user_id, published_at, avatar, first_name, last_name, username FROM {$this->table} LC INNER JOIN users U ON U.user_id = LC.user_id WHERE {$this->id_lesson_comment_column} = $id";
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
		$sql = "INSERT INTO {$this->table} (comment, lesson_comment_id, user_id) VALUES('$comment', $lesson_comment_id, $user_id)";
		$result = execute_query_return_id($sql);
		return $result;
	}

	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET comment = '$comment' WHERE {$this->id_column} = $id";
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