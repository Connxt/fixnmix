<?php

class Sales_Reports_Repository implements Sales_Reports_Repository_Interface {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	public function new_sales_report(array $sales_report_data) {
		$sales_report_id_from_branch = $sales_report_data['id'];
		$branch_id = $sales_report_data['branch_id'];
		$main_id = $sales_report_data['main_id'];

		$settings_repo = new Settings_Repository($this->db);
		$branches_repo = new Branches_Repository($this->db);

		if($settings_repo->get_settings()->app_id != $main_id) {
			return -2; // invalid main
		}
		else if(!$branches_repo->branch_exists($branch_id)) {
			return -1; // invalid branch
		}
		else {
			if(! $this->sales_report_exists_via_sales_report_id_from_branch($sales_report_id_from_branch, $branch_id)) {
				$this->db->insert('sales_reports', array(
					'branch_id' => $branch_id,
					'sales_report_id_from_branch' => $sales_report_id_from_branch,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				));
				$sales_report_id = $this->db->insert_id();

				$users_repo = new Users_Repository($this->db);

				foreach($sales_report_data['sales'] as $sale) {
					$this->db->insert('receipts', array(
						'receipt_id_from_branch' => $sale['receipt_id'],
						'sales_report_id_from_branch' => $sales_report_id_from_branch,
						'created_at_from_branch' => $sale['created_at'],
						'updated_at_from_branch' => $sale['updated_at'],
						'sales_report_id' => $sales_report_id,
						'user_id' => $users_repo->get_user_via_username($sale['username'])->id,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					));
					$receipt_id = $this->db->insert_id();

					foreach($sale['items'] as $item) {
						$this->db->insert('receipt_items', array(
							'item_id' => $item['item_id'],
							'receipt_id' => $receipt_id,
							'price' => $item['price'],
							'quantity' => $item['quantity']
						));
					}
				}
				
				return $sales_report_id;
			}
			else {
				return 0; // sales report exists
			}
		}
	}

	public function sales_report_exists($sales_report_id) {
		$query = $this->db->query('SELECT id FROM sales_reports WHERE id=' . $sales_report_id);
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function sales_report_exists_via_sales_report_id_from_branch($sales_report_id_from_branch, $branch_id) {
		$query = $this->db->query('SELECT id FROM sales_reports WHERE sales_report_id_from_branch=' . $sales_report_id_from_branch .' AND branch_id="' . $branch_id .'"');
		if($query->num_rows() >= 1)
			return true;
		else
			return false;
	}

	public function get_sales_report($sales_report_id) {
		$query = $this->db->query('SELECT * FROM sales_reports WHERE id=' . $sales_report_id);
		$row = $query->row();
		return new Sales_Report(
			$row->id,
			$row->branch_id,
			$row->sales_report_id_from_branch,
			$row->created_at,
			$row->updated_at
		);
	}

	public function get_all_sales_reports() {
		$query = $this->db->query('SELECT * FROM sales_reports');
		$result = $query->result();
		$sales_reports = array();

		foreach($result as $row) {
			array_push($sales_reports,
				new Sales_Report(
					$row->id,
					$row->branch_id,
					$row->sales_report_id_from_branch,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $sales_reports;
	}

	public function get_all_sales_reports_from_branch($branch_id) {
		$query = $this->db->query('SELECT * FROM sales_reports WHERE branch_id="' . $branch_id . '"');
		$result = $query->result();
		$sales_reports = array();

		foreach($result as $row) {
			array_push($sales_reports,
				new Sales_Report(
					$row->id,
					$row->branch_id,
					$row->sales_report_id_from_branch,
					$row->created_at,
					$row->updated_at
				)
			);
		}

		return $sales_reports;
	}
}