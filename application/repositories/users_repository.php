<?php

class Users_Repository implements Users_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_user(User $user) {
		$this->db->insert('users', array(
			'username' => $user->username,
			'password' => $user->password,
			'user_level_id' => $user->user_level_id,
			'last_name' => $user->last_name,
			'first_name' => $user->first_name,
			'middle_name' => $user->middle_name,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));
	}

	public function update_user(User $user) {
		$this->db->where('id', $user->id);
		$data = array(
			'user_level_id' => $user->user_level_id,
			'last_name' => $user->last_name,
			'first_name' => $user->first_name,
			'middle_name' => $user->middle_name,
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->db->update('users', $data);
	}

	public function user_exists_via_username_and_password($username, $password) {
		$query = $this->db->query('SELECT id FROM users WHERE username="' . $username . '" AND password="' . $password . '" AND user_level_id=1');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function user_exists_via_username($username) {
		$query = $this->db->query('SELECT id FROM users WHERE username="' . $username . '"');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function get_user_via_id($user_id) {
		$query = $this->db->query('SELECT * FROM users WHERE id=' . $user_id);
		$row = $query->row();
		$user_levels_repo = new User_levels_Repository($this->db);

		return new User(
			$row->id, 
			$row->username, 
			$row->password, 
			$row->user_level_id, 
			$user_levels_repo->get_user_level($row->user_level_id), 
			$row->last_name, 
			$row->first_name, 
			$row->middle_name, 
			$row->created_at, 
			$row->updated_at
		);
	}

	public function get_user_via_username($username) {
		$query = $this->db->query('SELECT * FROM users WHERE username="' . $username . '"');
		$row = $query->row();
		$user_levels_repo = new User_levels_Repository($this->db);

		return new User(
			$row->id, 
			$row->username, 
			$row->password, 
			$row->user_level_id, 
			$user_levels_repo->get_user_level($row->user_level_id), 
			$row->last_name, 
			$row->first_name, 
			$row->middle_name, 
			$row->created_at, 
			$row->updated_at
		);
	}

	public function get_all_users() {
		$query = $this->db->query('SELECT * FROM users');
		$result = $query->result();
		$users = array();

		foreach($result as $row) {
			$user_levels_repo = new User_levels_Repository($this->db);

			array_push($users, 
				new User(
					$row->id, 
					$row->username, 
					$row->password, 
					$row->user_level_id, 
					$user_levels_repo->get_user_level($row->user_level_id), 
					$row->last_name, 
					$row->first_name, 
					$row->middle_name, 
					$row->created_at, 
					$row->updated_at
				)
			);
		}

		return $users;
	}

	public function to_json($user_ids, $branch_id) {
		$data = array();
		$users = array();

		foreach($user_ids as $user_id) {
			$query = $this->db->query('SELECT * FROM users WHERE id=' . $user_id);
			$row = $query->row();
			array_push($users, array(
				'username' => $row->username,
				'password' => $row->password,
				'user_level_id' => $row->user_level_id,
				'last_name' => $row->last_name,
				'first_name' => $row->first_name,
				'middle_name' => $row->middle_name
			));
		}

		$settings_repo = new Settings_Repository($this->db);

		array_push($data, array(
			'transaction' => Transaction_Type::Export_Users,
			'main_id' => $settings_repo->get_settings()->app_id,
			'branch_id' => $branch_id,
			'users' => $users
		));

		return json_encode($data[0]);
	}
}