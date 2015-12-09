<?php

class Returns_Repository implements Returns_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_return(array $return_data) {
		$return_id_from_branch = $return_data['id'];
		$branch_id = $return_data['branch_id'];
		$main_id = $return_data['main_id'];

		$settings_repo = new Settings_Repository($this->db);
		$branches_repo = new Branches_Repository($this->db);
		
		if($settings_repo->get_settings()->app_id != $main_id) {
			return -2; // invalid main
		}
		else if(!$branches_repo->branch_exists($branch_id)) {
			return -1; // invalid branch
		}
		else {
			if(! $this->return_exists_via_return_id_from_branch($return_id_from_branch, $branch_id)) {
				$this->db->insert('returns', array(
					'branch_id' => $branch_id,
					'return_id_from_branch' => $return_id_from_branch,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				));
				$return_id = $this->db->insert_id();

				$items = $return_data['items'];
				foreach($items as $item) {
					$this->db->insert('returned_items', array(
						'return_id' => $return_id,
						'item_id' => $item['item_id'],
						'quantity' => $item['quantity']
					));
				}
				
				return $return_id;
			}
			else {
				return 0; // return exists
			}
		}
	}

	public function return_exists($return_id) {
		$query = $this->db->query('SELECT id FROM returns WHERE id=' . $return_id);
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function return_exists_via_return_id_from_branch($return_id_from_branch, $branch_id) {
		$query = $this->db->query('SELECT id FROM returns WHERE return_id_from_branch=' . $return_id_from_branch .' AND branch_id="' . $branch_id .'"');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function get_return($return_id) {
		$query = $this->db->query('SELECT * FROM returns WHERE id=' . $return_id);
		$row = $query->row();
		return new Return_Class(
			$row->id,
			$row->branch_id,
			$row->return_id_from_branch,
			$row->created_at,
			$row->updated_at
		);
	}

	public function get_all_returns() {
		$query = $this->db->query('SELECT * FROM returns');
		$result = $query->result();
		$returns = array();

		foreach($result as $row) {
			array_push($returns,
				new Return_Class(
					$row->id,
					$row->branch_id,
					$row->return_id_from_branch,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $returns;
	}

	public function get_item($returned_item_id) {
		$query = $this->db->query('SELECT * FROM returned_items WHERE id=' . $returned_item_id);
		$row = $query->row();
		return new Returned_Item(
			$row->id,
			$row->return_id,
			$row->item_id,
			$row->quantity
		);
	}

	public function get_all_items_from_return($return_id) {
		$query = $this->db->query('SELECT * FROM returned_items WHERE return_id=' . $return_id);
		$result = $query->result();
		$returned_items = array();

		foreach($result as $row) {
			array_push($returned_items,
				new Returned_Item(
					$row->id,
					$row->return_id,
					$row->item_id,
					$row->quantity
				)
			);
		}

		return $returned_items;
	}
}