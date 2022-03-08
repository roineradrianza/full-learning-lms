<?php 

/**
 * 
 */
class PaymentsMeta
{
	private $table = "payment_method_meta";
	private $id_column = "payment_method_meta_id";
	private $payment_column = "payment_method_id";

	function __construct() {
	}

	public function get(int $id = 0) {
		if ($id == 0) return false;
		$sql = "SELECT * FROM {$this->table} WHERE {$this->payment_column} = $id";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function get_meta(int $course_id = 0, $meta_name = '') {
		if (empty($meta_name) || $course_id == 0) return false;
		$sql = "SELECT * FROM {$this->table} WHERE {$this->payment_column} = $course_id AND payment_method_meta_name = '$meta_name'";
		$result = execute_query($sql);
		if (empty($result)) {
			return [];
		}
		return $result->fetch_assoc();
	}

	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET payment_method_meta_val = '$payment_method_meta_val' WHERE {$this->payment_column} = $id AND payment_method_meta_name = '$payment_method_meta_name'";
		$result = execute_query($sql);
		return $result;
	}

}