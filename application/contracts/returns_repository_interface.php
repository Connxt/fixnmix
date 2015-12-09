<?php

interface Returns_Repository_Interface {
	public function new_return(array $return_data);
	public function return_exists($return_id);
	public function get_return($return_id);
	public function get_all_returns();
	public function get_item($returned_item_id);
	public function get_all_items_from_return($return_id);
}