<?php

class Deliveries_Repository implements Deliveries_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_delivery($branch_id, array $items) {
		$this->db->insert('deliveries', array(
			'branch_id' => $branch_id,
			'status' => Delivery_Status::Failed,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));

		$delivery_id = $this->db->insert_id();

		$items_repo = new Items_Repository($this->db);

		foreach($items as $item) {
			$this->db->insert('delivered_items', array(
				'delivery_id' => $delivery_id,
				'item_id' => $item['itemId'],
				'quantity' => $item['quantity'],
				'price' => $items_repo->get_item($item['itemId'])->price
			));
		}

		return $delivery_id;
	}

	public function update_delivery_status($delivery_id, $status) {
		$this->db->where('id', $delivery_id);
		$this->db->update('deliveries', array(
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s')
		));
	}

	public function delivery_exists($delivery_id) {
		$query = $this->db->query('SELECT id FROM deliveries WHERE id=' . $delivery_id);
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function get_delivery($delivery_id) {
		$query = $this->db->query('SELECT * FROM deliveries WHERE id=' . $delivery_id);
		$row = $query->row();
		return new Delivery(
			$row->id,
			$row->branch_id,
			$row->status,
			$row->created_at,
			$row->updated_at
		);
	}

	public function get_all_deliveries() {
		$query = $this->db->query('SELECT * FROM deliveries');
		$result = $query->result();
		$deliveries = array();

		foreach($result as $row) {
			array_push($deliveries,
				new Delivery(
					$row->id,
					$row->branch_id,
					$row->status,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $deliveries;
	}

	public function to_delivery_json($delivery_id) {
		$query = $this->db->query('SELECT * FROM deliveries WHERE id=' . $delivery_id);
		$row = $query->row();
		$branch_id = $row->branch_id;

		$settings_repo = new Settings_Repository($this->db);
		$main_id = $settings_repo->get_settings()->app_id;

		$query = $this->db->query('SELECT delivered_items.item_id, delivered_items.quantity, items.description, items.price FROM delivered_items INNER JOIN items ON delivered_items.item_id=items.id WHERE delivered_items.delivery_id=' . $delivery_id);
		$items = $query->result();

		$data = array();

		array_push($data, array(
			'transaction' => Transaction_Type::Deliver_Items,
			'id' => $delivery_id,
			'main_id' => $main_id,
			'branch_id' => $branch_id,
			'items' => $items
		));

		return json_encode($data[0]);
	}

	public function get_item($delivered_item_id) {
		$query = $this->db->query('SELECT * FROM delivered_items WHERE id=' . $delivered_item_id);
		$row = $query->row();
		return new Delivered_Item(
			$row->id,
			$row->delivery_id,
			$row->item_id,
			$row->quantity,
			$row->price
		);
	}

	public function get_all_items_from_delivery($delivery_id) {
		$query = $this->db->query('SELECT * FROM delivered_items WHERE delivery_id=' . $delivery_id);
		$result = $query->result();
		$delivered_items = array();

		foreach($result as $row) {
			array_push($delivered_items,
				new Delivered_Item(
					$row->id,
					$row->delivery_id,
					$row->item_id,
					$row->quantity,
					$row->price
				)
			);
		}

		return $delivered_items;
	}

	public function is_item_already_delivered($item_id) {
		$query = $this->db->query('SELECT id FROM delivered_items WHERE item_id=' . $item_id);
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}
}