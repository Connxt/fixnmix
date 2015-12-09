<?php

class Branches_Repository implements Branches_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_branch(Branch $branch) {
		$this->db->insert('branches', array(
			'id' => $branch->id,
			'description' => $branch->description
		));
	}

	public function update_branch(Branch $branch) {
		$this->db->where('id', $branch->id);
		$data = array('description' => $branch->description);
		$this->db->update('branches', $data);
	}

	public function get_branch($branch_id) {
		$query = $this->db->query('SELECT * FROM branches WHERE id="' . $branch_id . '"');
		$row = $query->row();
		return new Branch(
			$row->id,
			$row->description
		);
	}

	public function get_all_branches() {
		$query = $this->db->query('SELECT * FROM branches');
		$result = $query->result();
		$branches = array();

		foreach($result as $row) {
			array_push($branches,
				new Branch(
					$row->id,
					$row->description
				)
			);
		}

		return $branches;
	}

	public function branch_exists($branch_id) {
		$query = $this->db->query('SELECT id FROM branches WHERE id="' . $branch_id . '"');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}
}