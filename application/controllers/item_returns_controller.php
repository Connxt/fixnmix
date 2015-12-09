<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Item_Returns_Controller extends REST_Controller {
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
		$data['current_page'] = 'item_returns';
		$this->load->view('item_returns/index', $data);
	}

	public function new_return_post() {
		$return_data = $this->input->post('returnData');

		if($return_data['transaction'] == Transaction_Type::Return_Items) {
			$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
			$return_id = $returns_repo->new_return($return_data);

			if($return_id <= 0) {
				if($return_id == -2)
					echo -2; // invalid main
				else if($return_id == -1)
					echo -1; // invalid branch
				else if($return_id == 0)
					echo 0; // return exists
			}
			else if($return_id >= 1) {
				$uncleared_items_repo = new Uncleared_Items_Repository($this->base_model->get_db_instance());
				$branch_id = $return_data['branch_id'];
				$items = $return_data['items'];
				
				foreach($items as $item) {
					$uncleared_item = $uncleared_items_repo->get_item_via_item_id_and_branch_id($item['item_id'], $branch_id);

					if(($uncleared_item->quantity - $item['quantity']) <= 0) {
						$uncleared_items_repo->delete_item($uncleared_item->id);
					}
					else {
						$uncleared_items_repo->update_item(
							new Uncleared_Item(
								$uncleared_item->id,
								$item['item_id'],
								$branch_id,
								$uncleared_item->quantity - $item['quantity'],
								null,
								null
							)
						);
					}
				}

				echo 2; // valid return
			}
		}
		else {
			echo 1; // invalid transaction
		}
	}

	public function return_exists_post() {
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
		echo $returns_repo->return_exists($this->input->post('returnId'));
	}

	public function get_return_post() {
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
		$return = $returns_repo->get_return($this->input->post('returnId'));
		$data = array();

		array_push($data, array(
			'id' => $return->id,
			'branch_id' => $return->branch_id,
			'created_at' => $return->created_at,
			'updated_at' => $return->updated_at
		));

		echo json_encode($data);
	}

	public function get_returned_item_post() {
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
		$returned_item_id = $this->input->post('returnedItemId');

		$returned_item = $returns_repo->get_returned_item($returned_item_id);
		$data = array();

		array_push($data, array(
			'id' => $returned_item->id,
			'return_id' => $returned_item->return_id,
			'item_id' => $returned_item->item_id,
			'quantity' => $returned_item->quantity,
		));

		echo json_encode($data);
	}

	public function get_all_returns_post() {
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
		$returns = $returns_repo->get_all_returns();
		$data = array();

		foreach($returns as $return) {
			array_push($data, array(
				'id' => $return->id,
				'branchId' => $return->branch_id,
				'returnIdFromBranch' => $return->return_id_from_branch,
				'created_at' => $return->created_at
			));
		}
		
		echo json_encode($data);
	}

	public function get_all_items_from_this_return_post() {
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());
		$returned_items = $returns_repo->get_all_items_from_return($this->input->post('returnId'));
		$data = array();

		foreach($returned_items as $returned_item) {
			$items_repo = new Items_Repository($this->base_model->get_db_instance());
			$item = $items_repo->get_item($returned_item->item_id);

			array_push($data, array(
				'id' => $returned_item->id,
				'item_id' => $returned_item->item_id,
				'description' => $item->description,
				'quantity' => $returned_item->quantity
			));
		}

		echo json_encode($data);
	}

	public function is_transaction_valid_post() {
		$main_id = $this->input->post('mainId');
		$branch_id = $this->input->post('branchId');
		$return_id_from_branch = $this->input->post('returnIdFromBranch');
		$transaction = $this->input->post('transaction');

		$settings_repo = new Settings_Repository($this->base_model->get_db_instance());
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		$returns_repo = new Returns_Repository($this->base_model->get_db_instance());

		if($transaction != Transaction_Type::Return_Items)
			echo 1; // invalid transaction
		else if($settings_repo->get_settings()->app_id != $main_id)
			echo -2; // invalid main
		else if(!$branches_repo->branch_exists($branch_id))
			echo -1; // invalid branch
		else if($returns_repo->return_exists_via_return_id_from_branch($return_id_from_branch, $branch_id))
			echo 0; // return exists
		else
			echo 2; // valid return
	}

	public function decrypt_return_data_post() {
		$enc = new Encryption();
		echo $enc->decrypt($this->input->post('returnData'));
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
}