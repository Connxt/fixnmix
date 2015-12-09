<?php

class Delivered_Item {
	private $data = array();

	function __construct($id, $delivery_id, $item_id, $quantity, $price) {
		$this->data['id'] = $id;
		$this->data['delivery_id'] = $delivery_id;
		$this->data['item_id'] = $item_id;
		$this->data['quantity'] = $quantity;
		$this->data['price'] = $price;
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}
}