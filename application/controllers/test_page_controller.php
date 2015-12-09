<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once(APPPATH . 'libraries/REST_Controller.php');

class Test_Page_Controller extends REST_Controller {
	public function __construct() {
		parent::__construct();

		if(!$this->session->userdata('auth')) {
			redirect('login', 'refresh');
		}

		$this->load->model('base_model');
	}

	public function index_get() {
		$data['current_page'] = 'test_page';
		$this->load->view('test_page/index', $data);
		
		echo '<br /> <b>Analytics</b> <br />';
		// $this->get_top_selling_items_post();
		// echo '<br /><br />';
		// $this->get_sales_by_month_post();
		// echo '<br /><br />';
		// $this->get_top_selling_branches_post();
		// echo '<br /><br />';
		// $this->get_item_sales_From_this_branch_post();
		// echo '<br /><br />';
		// $this->get_top_selling_branches_by_month_post();
		// echo '<br /><br />';
		// $this->get_most_returned_items_post();
		// echo '<br /><br />';
		$this->get_most_returned_items_by_month_post();
	}

	public function get_top_selling_items_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_items('2015-06-07 14:56:03', date('Y-m-d H:i:s'), true);
	}

	public function get_sales_by_month_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_sales_by_month(2015, true);	
	}

	public function get_top_selling_branches_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_branches('2015-06-07 14:56:03', date('Y-m-d H:i:s'), !true);
	}

	public function get_item_sales_from_this_branch_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_item_sales_from_branch('2015-06-07 14:56:03', date('Y-m-d H:i:s'), !true, 'KAB002');
	}

	public function get_top_selling_branches_by_month_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_top_selling_branches_by_month(2015, !true);
	}

	public function get_most_returned_items_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_most_returned_items('2015-06-07 14:56:03', date('Y-m-d H:i:s'));
	}

	public function get_most_returned_items_by_month_post() {
		$analytics = new Analytics($this->base_model->get_db_instance());
		echo $analytics->get_most_returned_items_by_month(2015);
	}
}