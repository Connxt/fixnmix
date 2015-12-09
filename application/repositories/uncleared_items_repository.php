<?php

class Uncleared_Items_Repository implements Uncleared_Items_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_item(Uncleared_Item $uncleared_item) {
		$this->db->insert('uncleared_items', array(
			'id' => $uncleared_item->id,
			'item_id' => $uncleared_item->item_id,
			'branch_id' => $uncleared_item->branch_id,
			'quantity' => $uncleared_item->quantity,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));
	}

	public function update_item(Uncleared_Item $uncleared_item) {
		$this->db->where('id', $uncleared_item->id);
		$data = array(
			'item_id' => $uncleared_item->item_id,
			'branch_id' => $uncleared_item->branch_id,
			'quantity' => $uncleared_item->quantity,
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->db->update('uncleared_items', $data);
	}

	public function get_item($uncleared_item_id) {
		$query = $this->db->query('SELECT * FROM uncleared_items WHERE id=' . $uncleared_item_id);
		$row = $query->row();
		return new Uncleared_Item(
			$row->id,
			$row->item_id,
			$row->branch_id,
			$row->quantity,
			$row->created_at,
			$row->updated_at
		);
	}

	public function get_item_via_item_id_and_branch_id($item_id, $branch_id) {
		$query = $this->db->query('SELECT * FROM uncleared_items WHERE item_id=' . $item_id . ' AND branch_id="' . $branch_id . '"');
		$row = $query->row();
		return new Uncleared_Item(
			$row->id,
			$row->item_id,
			$row->branch_id,
			$row->quantity,
			$row->created_at,
			$row->updated_at
		);
	}

	public function get_all_items() {
		$query = $this->db->query('SELECT * FROM uncleared_items ORDER BY branch_id ASC');
		$result = $query->result();
		$uncleared_items = array();

		foreach($result as $row) {
			array_push($uncleared_items,
				new Uncleared_Item(
					$row->id,
					$row->item_id,
					$row->branch_id,
					$row->quantity,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $uncleared_items;
	}

	public function get_all_items_via_branch_id($branch_id) {
		$query = $this->db->query('SELECT * FROM uncleared_items WHERE branch_id="' . $branch_id . '"');
		$result = $query->result();
		$uncleared_items = array();

		foreach($result as $row) {
			array_push($uncleared_items,
				new Uncleared_Item(
					$row->id,
					$row->item_id,
					$row->branch_id,
					$row->quantity,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $uncleared_items;
	}

	public function item_exists($uncleared_item_id) {
		$query = $this->db->query('SELECT id FROM uncleared_items WHERE id=' . $uncleared_item_id);
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function item_exists_via_item_id_and_branch_id($item_id, $branch_id) {
		$query = $this->db->query('SELECT id FROM uncleared_items WHERE item_id=' . $item_id . ' AND branch_id="' . $branch_id . '"');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}


	public function delete_item($uncleared_item_id) {
		$this->db->delete('uncleared_items', array('id' => $uncleared_item_id));

		if($this->db->affected_rows() >= 1)
			return true;
		else
			return false;
	}

}