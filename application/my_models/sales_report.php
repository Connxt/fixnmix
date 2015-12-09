<?php

class Sales_Report {
	private $data = array();

	function __construct($id, $branch_id, $sales_report_id_from_branch, $created_at, $updated_at) {
		$this->data['id'] = $id;
		$this->data['branch_id'] = $branch_id;
		$this->data['sales_report_id_from_branch'] = $sales_report_id_from_branch;
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