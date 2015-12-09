<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Items_Controller extends REST_Controller {
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
		$data['current_page'] = 'items';
		$this->load->view('items/index', $data);
	}

	public function new_item_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$items_repo->new_item(
			new Item(
				$this->input->post('itemId'),
				$this->input->post('description'),
				null,
				$this->input->post('price'),
				null,
				null
			)
		);
	}

	public function update_item_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$item = $items_repo->get_item($this->input->post('itemId'));

		$items_repo->update_item(
			new Item(
				$this->input->post('itemId'),
				$this->input->post('description'),
				$item->quantity,
				$this->input->post('price'),
				null,
				null
			)
		);
	}

	public function update_item_quantity_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());

		$item = $items_repo->get_item($this->input->post('itemId'));

		$items_repo->update_item(
			new Item(
				$this->input->post('itemId'),
				$item->description,
				$item->quantity + $this->input->post('quantity'),
				$item->price,
				null,
				null
			)
		);
	}

	public function delete_item_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		
		if($items_repo->delete_item($this->input->post('itemId'))) {
			echo 1; // item has been deleted
		}
		else {
			echo 0; // item has not been deleted because it was already used in a delivery
		}
	}

	public function item_exists_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		echo $items_repo->item_exists($this->input->post('itemId'));
	}

	public function get_item_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$item = $items_repo->get_item($this->input->post('itemId'));
		$data = array();

		array_push($data, array(
			'id' => $item->id,
			'description' => $item->description,
			'quantity' => $item->quantity,
			'price' => $item->price,
			'created_at' => $item->created_at,
			'updated_at' => $item->updated_at
		));

		echo json_encode($data);
	}

	public function get_all_items_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$items = $items_repo->get_all_items();
		$data = array();

		foreach($items as $item) {
			array_push($data, array(
				'id' => $item->id,
				'description' => $item->description,
				'quantity' => $item->quantity,
				'price' => $item->price,
				'created_at' => $item->created_at,
				'updated_at' => $item->updated_at
			));
		}
		echo json_encode($data);
	}
}