<?php

class Uncleared_Item {
	private $data = array();

	private $id;
	private $item_id;
	private $branch_id;
	private $quantity;
	private $created_at;
	private $updated_at;

	function __construct($id, $item_id, $branch_id, $quantity, $created_at, $updated_at) {
		$this->data['id'] = $id;
		$this->data['item_id'] = $item_id;
		$this->data['branch_id'] = $branch_id;
		$this->data['quantity'] = $quantity;
		$this->data['created_at'] = $created_at;
		$this->data['updated_at'] = $updated_at;
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}}