<?php

class Analytics {
	private $db;

	function __construct($db) {
		$this->db = $db;
	}

	/**
	 * Sales
	 */
	public function get_top_selling_items($date_from, $date_to, $by_quantity) {
		$column_to_total = '';
		$column_to_total_arr_key = '';

		if($by_quantity) {
			$column_to_total = 'receipt_items.quantity';
			$column_to_total_arr_key = 'quantity';
		}
		else {
			$column_to_total = 'receipt_items.quantity * receipt_items.price';
			$column_to_total_arr_key = 'sales';
		}

		$data = array();
		$items = $this->db->query(
			'SELECT items.id, description, SUM(' . $column_to_total . ') AS column_to_total ' .
			'FROM items ' .
			'	LEFT JOIN receipt_items ' .
			'	ON items.id=receipt_items.item_id ' .
			'GROUP BY items.id ' .
			'ORDER BY column_to_total DESC')->result();
		$branches = $this->db->query('SELECT id, description FROM branches')->result();

		foreach($items as $item) {
			$branches_data = array();
			foreach($branches as $branch) {
				$sql =
					'SELECT SUM(' . $column_to_total . ') AS column_to_total ' .
					'FROM receipts ' .
					'	INNER JOIN sales_reports ' .
					'	ON sales_reports.id=receipts.sales_report_id ' .
					'		INNER JOIN receipt_items ' .
					'		ON receipts.id=receipt_items.receipt_id ' .
					'WHERE ' .
					'	created_at_from_branch BETWEEN "'. $date_from . '" AND "' . $date_to . '" AND ' .
					'	item_id=' . $item->id . ' AND ' .
					'	branch_id="' . $branch->id . '"';

				$row = $this->db->query($sql)->row();

				array_push($branches_data, array(
					'branch_id' => $branch->id,
					$column_to_total_arr_key => is_null($row->column_to_total) ? 0 : $row->column_to_total
				));
			}

			array_push($data, array(
				'item_id' => $item->id,
				'description' => $item->description,
				'branches_data' => $branches_data
			));
		}

		return json_encode($data);
	}

	public function get_sales_by_month($year, $by_quantity) {
		$column_to_total = '';
		$column_to_total_arr_key = '';

		if($by_quantity) {
			$column_to_total = 'receipt_items.quantity';
			$column_to_total_arr_key = 'quantity';
		}
		else {
			$column_to_total = 'receipt_items.quantity * receipt_items.price';
			$column_to_total_arr_key = 'sales';
		}

		$data = array();
		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December');

		$month_num = 1;
		foreach($months as $month) {
			$date_from = $year . '/' . $month_num . '/01';
			$date = new DateTime($date_from);
			$date_to = $year . '/' . $month_num . '/' . $date->format('t');
			$month_num++;

			$row = $this->db->query(
				'SELECT SUM(' . $column_to_total . ') AS column_to_total ' .
				'FROM receipt_items ' .
				'	INNER JOIN receipts ' .
				'	ON receipt_items.receipt_id=receipts.id ' .
				'WHERE ' .
				'	created_at_from_branch BETWEEN "'. $date_from . '" AND "' . $date_to . '"')->row();

			array_push($data, array(
				'month' => $month,
				$column_to_total_arr_key => is_null($row->column_to_total) ? 0 : $row->column_to_total
			));
		}

		return json_encode($data);
	}

	/**
	 * Top Selling Branch
	 */
	public function get_top_selling_branches($date_from, $date_to, $by_quantity) {
		$column_to_total = '';
		$column_to_total_arr_key = '';

		if($by_quantity) {
			$column_to_total = 'receipt_items.quantity';
			$column_to_total_arr_key = 'quantity';
		}
		else {
			$column_to_total = 'receipt_items.quantity * receipt_items.price';
			$column_to_total_arr_key = 'sales';
		}

		$data = array();
		$sql =
			'SELECT branches.id, SUM(' . $column_to_total . ') AS column_to_total ' .
			'FROM branches ' .
			'	INNER JOIN sales_reports ' .
			'	ON branches.id=sales_reports.branch_id ' .
			'		INNER JOIN receipts ' .
			'		ON sales_reports.id=receipts.sales_report_id ' .
			'			INNER JOIN receipt_items ' .
			'			ON receipts.id=receipt_items.receipt_id ' .
			'WHERE ' .
			'	created_at_from_branch BETWEEN "'. $date_from . '" AND "' . $date_to . '" AND ';

		$branches = $this->db->query('SELECT id, description FROM branches')->result();
		foreach($branches as $branch) {
			$final_sql = $sql . 'branches.id="' . $branch->id . '" GROUP BY branches.id ';

			$row = $this->db->query($final_sql)->row();
			array_push($data, array(
				'branch_id' => $branch->id,
				$column_to_total_arr_key => isset($row->column_to_total) ? $row->column_to_total : 0
			));
		}

		return json_encode($data);
	}

	public function get_item_sales_from_branch($date_from, $date_to, $by_quantity, $branch_id)  {
		$column_to_total = '';
		$column_to_total_arr_key = '';

		if($by_quantity) {
			$column_to_total = 'receipt_items.quantity';
			$column_to_total_arr_key = 'quantity';
		}
		else {
			$column_to_total = 'receipt_items.quantity * receipt_items.price';
			$column_to_total_arr_key = 'sales';
		}

		$data = array();
		$items = $this->db->query('SELECT id, description FROM items')->result();
		$sql =
			'SELECT SUM(' . $column_to_total . ') AS column_to_total ' .
			'FROM receipt_items ' .
			'	INNER JOIN receipts ' .
			'	ON receipt_items.receipt_id=receipts.id ' .
			'		INNER JOIN sales_reports ' .
			'		ON receipts.sales_report_id=sales_reports.id ' .
			'WHERE ' .
			'	created_at_from_branch BETWEEN "'. $date_from . '" AND "' . $date_to . '" AND ' .
			'	sales_reports.branch_id="' . $branch_id . '" AND ';

		foreach($items as $item) {
			$final_sql = $sql . 'receipt_items.item_id=' . $item->id;

			$row = $this->db->query($final_sql)->row();
			array_push($data, array(
				'id' => $item->id,
				'description' => $item->description,
				$column_to_total_arr_key => is_null($row->column_to_total) ? 0 : $row->column_to_total
			));
		}

		if($by_quantity) {
			function cmp($a, $b) { return $b['quantity'] - $a['quantity']; }
		}
		else {
			function cmp($a, $b) { return $b['sales'] - $a['sales']; }
		}

		usort($data, 'cmp');

		return json_encode($data);
	}

	public function get_top_selling_branches_by_month($year, $by_quantity) {
		$column_to_total = '';
		$column_to_total_arr_key = '';

		if($by_quantity) {
			$column_to_total = 'receipt_items.quantity';
			$column_to_total_arr_key = 'quantity';
		}
		else {
			$column_to_total = 'receipt_items.quantity * receipt_items.price';
			$column_to_total_arr_key = 'sales';
		}

		$data = array();
		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December');
		$branches = $this->db->query('SELECT id, description FROM branches')->result();
		$sql =
			'SELECT branches.id, SUM(' . $column_to_total . ') AS column_to_total ' .
			'FROM branches ' .
			'	INNER JOIN sales_reports ' .
			'	ON branches.id=sales_reports.branch_id ' .
			'		INNER JOIN receipts ' .
			'		ON sales_reports.id=receipts.sales_report_id ' .
			'			INNER JOIN receipt_items ' .
			'			ON receipts.id=receipt_items.receipt_id ';

		$month_num = 1;
		foreach($months as $month) {
			$date_from = $year . '/' . $month_num . '/01';
			$date = new DateTime($date_from);
			$date_to = $year . '/' . $month_num . '/' . $date->format('t');
			$month_num++;
			$sales = array(
				'month' => $month,
				'sales' => array()
			);

			foreach($branches as $branch) {
				$final_sql = $sql .
					'WHERE ' .
					'	created_at_from_branch BETWEEN "'. $date_from . '" AND "' . $date_to . '" AND ' .
					'	branches.id="' . $branch->id . '" ' .
					'GROUP BY branches.id ' .
					'ORDER BY column_to_total DESC';

				$row = $this->db->query($final_sql)->row();
				array_push($sales['sales'], array(
					'branch_id' => $branch->id,
					'quantity' => isset($row->column_to_total) ? $row->column_to_total : 0
				));
			}

			array_push($data, $sales);
		}

		return json_encode($data);
	}

	/**
	 * Returns
	 */
	public function get_most_returned_items($date_from, $date_to) {
		$data = array();
		$items = $this->db->query('SELECT id, description FROM items')->result();
		$sql = 
			'SELECT items.id, description, SUM(returned_items.quantity) AS sum_of_quantities ' .
			'FROM items ' .
			'	LEFT JOIN returned_items ' .
			'	ON items.id=returned_items.item_id ' .
			'		LEFT JOIN returns ' .
			'		ON returned_items.return_id=returns.id ' .
			'WHERE ' .
			'	returns.created_at BETWEEN "'. $date_from . '" AND "' . $date_to . '" AND ';

		foreach($items as $item) {
			$final_sql = $sql . 'items.id=' . $item->id;
			$row = $this->db->query($final_sql)->row();

			array_push($data, array(
				'item_id' => $item->id,
				'description' => $item->description,
				'quantity' => isset($row->sum_of_quantities) ? $row->sum_of_quantities : 0
			));
		}

		function cmp($a, $b) { return $b['quantity'] - $a['quantity']; }

		usort($data, 'cmp');
		return json_encode($data);
	}

	public function get_most_returned_items_by_month($year) {
		$data = array();
		$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December');

		$sql = 
			'SELECT items.id, description, SUM(returned_items.quantity) AS sum_of_quantities ' .
			'FROM items ' .
			'	LEFT JOIN returned_items ' .
			'	ON items.id=returned_items.item_id ' .
			'		LEFT JOIN returns ' .
			'		ON returned_items.return_id=returns.id ' .
			'WHERE ';

		$month_num = 1;
		foreach($months as $month) {
			$date_from = $year . '/' . $month_num . '/01';
			$date = new DateTime($date_from);
			$date_to = $year . '/' . $month_num . '/' . $date->format('t');
			$month_num++;

			$final_sql = $sql . 'returns.created_at BETWEEN "'. $date_from . '" AND "' . $date_to . '"';
			$row = $this->db->query($final_sql)->row();

			array_push($data, array(
				'month' => $month,
				'quantity' => isset($row->sum_of_quantities) ? $row->sum_of_quantities : 0
			));
		}

		return json_encode($data);
	}


	/**
	 * Misc
	 */
	// private function cmp($a, $b) {
	// 	return $b['sum_of_quantities'] - $a['sum_of_quantities'];
	// }
}