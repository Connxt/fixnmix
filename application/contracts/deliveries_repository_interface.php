<?php

interface Deliveries_Repository_Interface {
	public function new_delivery($branch_id, array $items);
	public function update_delivery_status($delivery_id, $status);
	public function delivery_exists($delivery_id);
	public function get_delivery($delivery_id);
	public function get_all_deliveries();
	public function to_delivery_json($delivery_id);
	public function get_item($delivered_item_id);
	public function get_all_items_from_delivery($delivery_id);
}