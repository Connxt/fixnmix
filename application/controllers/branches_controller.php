<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Branches_Controller extends REST_Controller {
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
		$data['current_page'] = 'branches';
		$this->load->view('branches/index', $data);
	}

	public function new_branch_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		$branches_repo->new_branch(
			new Branch(
				$this->input->post('branchId'),
				$this->input->post('description')
			)
		);
	}

	public function update_branch_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		$branches_repo->update_branch(
			new Branch(
				$this->input->post('branchId'),
				$this->input->post('description')
			)
		);
	}

	public function branch_exists_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		echo $branches_repo->branch_exists($this->input->post('branchId'));
	}

	public function get_branch_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		$branch = $branches_repo->get_branch($this->input->post('branchId'));
		$data = array();

		array_push($data, array(
			'id' => $branch->id,
			'description' => $branch->description
		));

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
}