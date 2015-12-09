<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Users_Controller extends REST_Controller {
	public function __construct() {
		parent::__construct();
		
		if(!$this->session->userdata('auth')) {
			redirect('login', 'refresh');
		}
		
		$this->load->model('base_model');
	}

	public function index_get() {
		$session_data = $this->session->userdata('auth');
		$data['user_id'] = $session_data['user_id'];
		$data['name'] = $session_data['name'];
		$data['app_id'] = $session_data['app_id'];
		$data['current_page'] = "users";
		$this->load->view("users/index", $data);
	}

	public function new_user_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		$user_levels_repo = new User_Levels_Repository($this->base_model->get_db_instance());
		$users_repo->new_user(
			new User(
				null,
				$this->input->post('username'),
				$this->input->post('password'),
				$this->input->post('userLevelId'),
				$user_levels_repo->get_user_level($this->input->post('userLevelId')),
				$this->input->post('lastName'),
				$this->input->post('firstName'),
				$this->input->post('middleName'),
				null,
				null
			)
		);
	}

	public function update_user_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		$user_levels_repo = new User_Levels_Repository($this->base_model->get_db_instance());
		$users_repo->update_user(
			new User(
				$this->input->post('userId'),
				null,
				null,
				$this->input->post('userLevelId'),
				$user_levels_repo->get_user_level($this->input->post('userLevelId')),
				$this->input->post('lastName'),
				$this->input->post('firstName'),
				$this->input->post('middleName'),
				null,
				null
			)
		);
	}

	public function username_exists_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		echo $users_repo->user_exists_via_username($this->input->post('username'));
	}

	public function get_user_via_id_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		$user = $users_repo->get_user_via_id($this->input->post('userId'));
		$data = array();

		array_push($data, array(
			'id' => $user->id,
			'username' => $user->username,
			'user_level_id' => $user->user_level_id,
			'user_level' => $user->user_level,
			'last_name' => $user->last_name,
			'first_name' => $user->first_name,
			'middle_name' => $user->middle_name,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at
		));

		echo json_encode($data);
	}

	public function get_user_via_username_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		$user = $users_repo->get_user_via_username($this->input->post('username'));
		$data = array();

		array_push($data, array(
			'id' => $user->id,
			'username' => $user->username,
			'user_level_id' => $user->user_level_id,
			'user_level' => $user->user_level,
			'last_name' => $user->last_name,
			'first_name' => $user->first_name,
			'middle_name' => $user->middle_name,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at
		));

		echo json_encode($data);
	}

	public function get_all_users_post() {
		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		$users = $users_repo->get_all_users();
		$data = array();

		foreach($users as $user) {
			array_push($data, array(
				'id' => $user->id,
				'username' => $user->username,
				'user_level_id' => $user->user_level_id,
				'user_level' => $user->user_level,
				'last_name' => $user->last_name,
				'first_name' => $user->first_name,
				'middle_name' => $user->middle_name,
				'created_at' => $user->created_at,
				'updated_at' => $user->updated_at
			));
		}

		echo json_encode($data);
	}

	public function get_all_branches_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		$branches = $branches_repo->get_all_branches();
		$data = array();

		foreach($branches as $branch) {
			array_push($data, array(
				'id' => $branch->id,
				'description' => $branch->description
			));
		}
		echo json_encode($data);
	}

	public function write_user_data_to_file_post() {
		$user_ids = $this->input->post('userIds'); // [1, 2, 3]
		$branch_id = $this->input->post('branchId');
		$file_path = $this->input->post('filePath');

		$users_repo = new Users_Repository($this->base_model->get_db_instance());
		
		$enc = new Encryption();
		$file_size = file_put_contents($file_path, $enc->encrypt($users_repo->to_json($user_ids, $branch_id)));

		echo $file_size;
	}
}