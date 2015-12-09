<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Uncleared_Items_Controller extends REST_Controller {
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
		$data['current_page'] = 'uncleared_items';
		$this->load->view('uncleared_items/index', $data);
	}

	public function branch_exists_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		echo $branches_repo->branch_exists($this->input->post('branchId'));
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

	public function get_all_uncleared_items_from_this_branch_post() {
		$branch_id = $this->input->post('branchId');
		$uncleared_items_repo = new Uncleared_Items_Repository($this->base_model->get_db_instance());
		$uncleared_items = $uncleared_items_repo->get_all_items_via_branch_id($branch_id);
		$data = array();

		foreach($uncleared_items as $uncleared_item) {
			$items_repo = new Items_Repository($this->base_model->get_db_instance());
			$item = $items_repo->get_item($uncleared_item->item_id);

			array_push($data, array(
				'id' => $uncleared_item->id,
				'item_id' => $uncleared_item->item_id,
				'description' => $item->description,
				'branch_id' => $uncleared_item->branch_id,
				'quantity' => $uncleared_item->quantity,
				'created_at' => $uncleared_item->created_at,
				'updated_at' => $uncleared_item->updated_at
			));
		}
		
		echo json_encode($data);
	}
}