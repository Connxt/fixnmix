<?php

interface Users_Repository_Interface {
	public function new_user(User $user);
	public function update_user(User $user);
	public function user_exists_via_username_and_password($username, $password);
	public function user_exists_via_username($username);
	public function get_user_via_id($user_id);
	public function get_user_via_username($username);
	public function get_all_users();
}