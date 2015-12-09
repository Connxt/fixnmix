<?php

interface Sales_Reports_Repository_Interface {
	public function new_sales_report(array $sales_report_data);
	public function sales_report_exists($sales_report_id);
	public function sales_report_exists_via_sales_report_id_from_branch($sales_report_id_from_branch, $branch_id);
	public function get_sales_report($sales_report_id);
	public function get_all_sales_reports();
}