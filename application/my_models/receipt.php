<?php

class Receipt {
	private $data = array();

	function __construct($id, $receipt_id_from_branch, $sales_report_id_from_branch, $created_at_from_branch, $updated_at_from_branch, $user_id, $sales_report_id, $created_at, $updated_at) {
		$this->data['id'] = $id;
		$this->data['receipt_id_from_branch'] = $receipt_id_from_branch;
		$this->data['sales_report_id_from_branch'] = $sales_report_id_from_branch;
		$this->data['created_at_from_branch'] = $created_at_from_branch;
		$this->data['updated_at_from_branch'] = $updated_at_from_branch;
		$this->data['user_id'] = $user_id;
		$this->data['sales_report_id'] = $sales_report_id;
		$this->data['created_at'] = $created_at;
		$this->data['updated_at'] = $updated_at;
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}
}