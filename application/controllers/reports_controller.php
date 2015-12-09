<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Reports_Controller extends REST_Controller {
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
		$data['current_page'] = 'reports';
		$this->load->view('reports/index', $data);
	}

	public function new_sales_report_post() {
		$sales_report_data = $this->input->post('salesReportData'); // parse JSON

		if($sales_report_data['transaction'] == Transaction_Type::Export_Sales_Report) {
			$sales_reports_repo = new Sales_Reports_Repository($this->base_model->get_db_instance());
			$sales_report_id = $sales_reports_repo->new_sales_report($sales_report_data);

			if($sales_report_id <= 0) {
				if($sales_report_id == -2)
					echo -2; // invalid main
				else if($sales_report_id == -1)
					echo -1; // invalid branch
				else if($sales_report_id == 0)
					echo 0; // sales report exists
			}
			else if($sales_report_id >= 1) {
				$branch_id = $sales_report_data['branch_id'];
				$uncleared_items_repo = new Uncleared_Items_Repository($this->base_model->get_db_instance());

				foreach($sales_report_data['sales'] as $receipt) {
					foreach($receipt['items'] as $item) {
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
				}

				echo 2; // valid export
			}
		}
		else {
			echo 1; // invalid transaction
		}
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

	public function branch_exists_post() {
		$branches_repo = new Branches_Repository($this->base_model->get_db_instance());
		echo $branches_repo->branch_exists($this->input->post('branchId'));
	}

	public function sales_report_exists_post() {
		$sales_reports_repo = new Sales_Reports_Repository($this->base_model->get_db_instance());
		echo $sales_reports_repo->sales_report_exists($this->input->post('salesReportId'));
	}

	public function get_all_sales_reports_from_this_branch_post() {
		$sales_reports_repo = new Sales_Reports_Repository($this->base_model->get_db_instance());
		$receipts_repo = new Receipts_Repository($this->base_model->get_db_instance());
		$branch_id = $this->input->post('branchId');

		$data = array();

		foreach($sales_reports_repo->get_all_sales_reports_from_branch($branch_id) as $sales_report) {
			$total_amount = 0;
			foreach($receipts_repo->get_all_receipts_via_sales_report_id($sales_report->id) as $receipt) {
				foreach($receipts_repo->get_all_items_from_receipt($receipt->id) as $receipt_item) {
					$total_amount += ($receipt_item->price * $receipt_item->quantity);
				}
			}

			array_push($data, array(
				'id' => $sales_report->id,
				'branch_id' => $sales_report->branch_id,
				'sales_report_id_from_branch' => $sales_report->sales_report_id_from_branch,
				'total_amount' => $total_amount,
				'created_at' => $sales_report->created_at,
				'updated_at' => $sales_report->updated_at
			));
		}

		echo json_encode($data);
	}

	public function get_all_receipts_via_sales_report_id_post() {
		$receipts_repo = new Receipts_Repository($this->base_model->get_db_instance());
		$sales_report_id = $this->input->post('salesReportId');
		$data = array();

		foreach($receipts_repo->get_all_receipts_via_sales_report_id($sales_report_id) as $receipt) {
			$receipt_items = $receipts_repo->get_all_items_from_receipt($receipt->id);
			$total_amount = 0;

			foreach($receipt_items as $receipt_item) {
				$total_amount += ($receipt_item->price * $receipt_item->quantity);
			}

			array_push($data, array(
				'id' => $receipt->id,
				'receipt_id_from_branch' => $receipt->receipt_id_from_branch,
				'total_amount' => $total_amount,
				'created_at' => $receipt->created_at
			));
		}

		echo json_encode($data);
	}

	public function get_all_receipts_post() {
		$receipts_repo = new Receips_Repository($this->base_model->get_db_instance());
		$sales_report_id = $this->input->post('salesReportId');

		foreach($receipts_repo->get_all_receipts() as $receipt) {
			$receipt_items = $receipts_repo->get_all_items_from_receipt($receipt->id);
			$total_amount = 0;

			foreach($receipt_items as $receipt_item) {
				$total_amount += ($receipt_item->price * $receipt_item->quantity);
			}

			array_push($data, array(
				'receipt_id_from_branch' => $receipt->receipt_id_from_branch,
				'total_amount' => $total_amount,
				'created_at' => $receipt->created_at
			));
		}

		echo json_encode($data);
	}

	public function get_all_items_from_this_receipt_post() {
		$receipts_repo = new Receipts_Repository($this->base_model->get_db_instance());
		$receipt_items = $receipts_repo->get_all_items_from_receipt($this->input->post('receiptId'));
		$data = array();

		foreach($receipt_items as $receipt_item) {
			$items_repo = new Items_Repository($this->base_model->get_db_instance());
			$item = $items_repo->get_item($receipt_item->item_id);

			array_push($data, array(
				'id' => $receipt_item->id,
				'item_id' => $receipt_item->item_id,
				'description' => $item->description,
				'receipt_id' => $receipt_item->receipt_id,
				'price' => $receipt_item->price,
				'quantity' => $receipt_item->quantity
			));
		}

		echo json_encode($data);
	}

	public function decrypt_sales_report_data_post() {
		$enc = new Encryption();
		echo $enc->decrypt($this->input->post('salesReportData'));
	}

	/**
	 * Analytics
	 */
	// Sales
	public function get_top_selling_items_post() {
		$date_from = $this->input->post('dateFrom');
		$date_to = $this->input->post('dateTo');
		$by_quantity = $this->input->post('byQuantity'); // true or false

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_items($date_from, $date_to, $by_quantity);
	}

	public function get_sales_by_month_post() {
		$year = $this->input->post('year');
		$by_quantity = $this->input->post('byQuantity'); // true or false

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_sales_by_month($year, $by_quantity);	
	}

	// Top Selling Branch
	public function get_top_selling_branches_post() {
		$date_from = $this->input->post('dateFrom');
		$date_to = $this->input->post('dateTo');
		$by_quantity = $this->input->post('byQuantity'); // true or false

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_branches($date_from, $date_to, $by_quantity);
	}

	public function get_item_sales_from_this_branch_post() {
		$date_from = $this->input->post('dateFrom');
		$date_to = $this->input->post('dateTo');
		$by_quantity = $this->input->post('byQuantity'); // true or false
		$branch_id = $this->input->post('branchId');

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_item_sales_from_branch($date_from, $date_to, $by_quantity, $branch_id);
	}

	public function get_top_selling_branches_by_month_post() {
		$year = $this->input->post('year');
		$by_quantity = $this->input->post('byQuantity'); // true or false

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_branches_by_month($year, $by_quantity);
	}

	// Item Returns
	public function get_most_returned_items_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_most_returned_items($date_from, $date_to);
	}

	public function get_most_returned_items_by_month_post() {
		$year = $this->input->post('year');

		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_most_returned_items_by_month($year);
	}
}