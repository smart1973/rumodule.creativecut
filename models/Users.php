<?php

class Users {

	public function get($conditions = array()) {
		$users = array();
		if ($conditions) {
			$where = array();
			foreach ($conditions as $cond => $val) {
				$where[] = "u.$cond = '" . addslashes($val) . "'";
			}
		}
		$result = DB::connect()->query("SELECT u.*, s.name as specialty_name FROM users u LEFT JOIN specialties s ON s.id = u.specialty" . ($conditions ? " WHERE " . implode(" AND ", $where) : '') . " GROUP BY u.id ORDER BY u.id DESC");
		while ($res = $result->fetch_assoc()) {
			$users[$res['id']] = $res;
		}
		return $users;
	}

	public function save($user) {
		global $controller;
		if (!isset($user['id']) || !is_numeric($user['id']) || $user['id'] < 1) $user['id'] = 0;
		$user_fields = array('email', 'phone', 'name', 'surname', 'password', 'specialty', 'educational_institution', 'department', 'status', 'id', 'newbie', 'city', 'street', 'house_number', 'post_index', 'image', 'register_date');
		$fields = $values = $duplicate = array();
		foreach ($user as $key => $value) {
			if (in_array($key, $user_fields)) {
				$fields[] = $key;
				$values[] = "'" . ($key == 'password' ? md5($user['password'] . $controller->getPasswordSalt()) : addslashes(strip_tags($controller->removeScripts($value)))) . "'";
				if ($key != 'id') $duplicate[] = "$key = VALUES($key)";
			}
		}
		DB::connect()->query("INSERT INTO users (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ") ON DUPLICATE KEY UPDATE " . implode(", ", $duplicate));
	}

	public function delete($id) {
		if (isset($_SESSION['admin_login']) && is_numeric($id) && $id && $this->get(array('id' => $id))) {
			$orders = Models::get('Orders')->getOrders(false, $id);
			foreach ($orders as &$order) $order = $order['id'];
			Models::get('Orders')->delete($orders);
			DB::connect()->query("DELETE FROM users WHERE id = $id");
		}
	}
}

?>