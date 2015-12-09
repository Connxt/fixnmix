<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Item_Distribution_Controller extends REST_Controller {
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
		$data['current_page'] = 'item_distribution';
		$this->load->view('item_distribution/index', $data);
	}

	public function new_delivery_post() {
		$branch_id = $this->input->post('branchId');
		$items = $this->input->post('items'); // [ {itemId: 401, quantity: 20}, {itemId: 402, quantity: 10} ]

		$uncleared_items_repo = new Uncleared_Items_Repository($this->base_model->get_db_instance());
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$items_repo = new Items_Repository($this->base_model->get_db_instance());

		$delivery_id = $deliveries_repo->new_delivery($branch_id, $items);

		foreach($items as $item) {
			$item_info = $items_repo->get_item($item['itemId']);
			$items_repo->update_item(
				new Item(
					$item['itemId'],
					$item_info->description,
					$item_info->quantity - $item['quantity'],
					$item_info->price,
					null,
					null
				)
			);

			if($uncleared_items_repo->item_exists_via_item_id_and_branch_id($item['itemId'], $branch_id)) {
				$uncleared_item = $uncleared_items_repo->get_item_via_item_id_and_branch_id($item['itemId'], $branch_id);
				$uncleared_items_repo->update_item(
					new Uncleared_Item(
						$uncleared_item->id,
						$item['itemId'],
						$branch_id,
						$uncleared_item->quantity + $item['quantity'],
						null,
						null
					)
				);
			}
			else {
				$uncleared_items_repo->new_item(new Uncleared_Item(null, $item['itemId'], $branch_id, $item['quantity'], null, null));
			}
		}

		echo $deliveries_repo->to_delivery_json($delivery_id);
	}

	public function delivery_exists_post() {
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		echo $deliveries_repo->delivery_exists($this->input->post('deliveryId'));
	}

	public function get_delivery_post() {
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$delivery = $deliveries_repo->get_delivery($this->input->post('deliveryId'));
		$data = array();

		array_push($data, array(
			'id' => $delivery->id,
			'branch_id' => $delivery->branch_id,
			'created_at' => $delivery->created_at,
			'updated_at' => $delivery->updated_at
		));

		echo json_encode($data);
	}

	public function get_item_post() {
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$delivered_item_id = $this->input->post('deliveredItemId');
		$delivered_item = $deliveries_repo->get_item($delivered_item_id);
		$data = array();

		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$item = $items_repo->get_item($delivered_item->item_id);

		array_push($data, array(
			'id' => $delivered_item->id,
			'delivery_id' => $delivered_item->delivery_id,
			'description' => $item->description,
			'item_id' => $delivered_item->item_id,
			'quantity' => $delivered_item->quantity
		));

		echo json_encode($data);
	}

	public function get_all_deliveries_post() {
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$deliveries = $deliveries_repo->get_all_deliveries();
		$data = array();

		foreach($deliveries as $delivery) {
			array_push($data, array(
				'id' => $delivery->id,
				'branchId' => $delivery->branch_id,
				'created_at' => $delivery->created_at,
				'status' => $delivery->status
			));
		}

		echo json_encode($data);
	}

	public function get_all_items_from_this_delivery_post() {
		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$delivered_items = $deliveries_repo->get_all_items_from_delivery($this->input->post('deliveryId'));
		$data = array();

		foreach($delivered_items as $delivered_item) {
			$items_repo = new Items_Repository($this->base_model->get_db_instance());
			$item = $items_repo->get_item($delivered_item->item_id);

			array_push($data, array(
				'id' => $delivered_item->id,
				'item_id' => $delivered_item->item_id,
				'description' => $item->description,
				'quantity' => $delivered_item->quantity,
				'price' => $delivered_item->price
			));
		}

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

	public function get_item_info_post() {
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

	public function item_exists_post() {
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		echo $items_repo->item_exists($this->input->post('itemId'));
	}

	public function get_items_with_insufficient_quantity_post() {
		$num_of_branches = $this->input->post('numOfBranches');
		$items = $this->input->post('items'); // [ {itemId: 401, quantity: 20}, {itemId: 402, quantity: 10} ]
		$data = array();
		$items_repo = new Items_Repository($this->base_model->get_db_instance());

		foreach($items as $item) {
			$item_info = $items_repo->get_item($item['itemId']);
			if($item_info->quantity < ($item['quantity'] * $num_of_branches)) {
				array_push($data, array(
						'id' => $item['itemId'],
						'requested_quantity' => $item['quantity'] * $num_of_branches,
						'available_quantity' => $item_info->quantity
					)
				);
			}
		}

		echo json_encode($data);
	}

	public function get_items_that_do_not_exist_post() {
		$item_ids = $this->input->post('itemIds'); // [1, 2, 3, 4, 5]
		$items_repo = new Items_Repository($this->base_model->get_db_instance());
		$data = array();

		foreach($item_ids as $item_id) {
			if(!$items_repo->item_exists($item_id)) {
				array_push($data, $item_id);
			}
		}

		echo json_encode($data); // outputs the id of the items that does not exist
	}

	public function write_delivery_data_to_file_post() {
		$file_path = $this->input->post('filePath'); // e:\sample_path.json
		$delivery_data = $this->input->post('deliveryData'); // unparsed json string
		$delivery_id = $this->input->post('deliveryId');
		
		$enc = new Encryption();
		$file_size = file_put_contents($file_path, $enc->encrypt($delivery_data));
		if($file_size >= 1) {
			$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
			$deliveries_repo->update_delivery_status($delivery_id, Delivery_Status::Success);
		}

		echo $file_size; // if >= 1, write is successful
	}

	public function generate_delivery_data_post() {
		$file_path = $this->input->post('filePath'); // e:\sample_path.json
		$delivery_id = $this->input->post('deliveryId');

		$deliveries_repo = new Deliveries_Repository($this->base_model->get_db_instance());
		$delivery_data = $deliveries_repo->to_delivery_json($delivery_id);

		$enc = new Encryption();
		$file_size = file_put_contents($file_path, $enc->encrypt($delivery_data));

		if($file_size >= 1) {
			$deliveries_repo->update_delivery_status($delivery_id, Delivery_Status::Success);
		}
		else {
			$deliveries_repo->update_delivery_status($delivery_id, Delivery_Status::Failed);	
		}

		echo $file_size; // if >= 1, write is successful
	}
}