<?php

class Bids {

	public function get($id = '') {
		if (is_array($id) && !$id) return array();
		if (isset($id) && is_numeric($id)) {
			$bid = DB::connect()->query("SELECT b.*, u.name, m.name AS mname, mc.name AS mcname, ms.name AS msname FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size WHERE b.id = $id ORDER BY b.id DESC")->fetch_assoc();
			if (!$bid) return false;
			$bid['data'] = unserialize($bid['data']);
			return $bid;
		}
		else {
			$bids = array();
			$result = DB::connect()->query("SELECT b.*, u.name, m.name AS mname, mc.name AS mcname, ms.name AS msname FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size" . (is_array($id) ? " WHERE b.id IN (" . implode(", ", $id) . ")" : "") . " ORDER BY b.id DESC");
			while ($res = $result->fetch_assoc()) {
				$res['data'] = unserialize($res['data']);
				$bids[$res['id']] = $res;
			}
			return $bids;
		}
	}

	public function getByUser($id, $all = false) {
		$bids = array();
		$result = DB::connect()->query("SELECT b.*, u.name, mc.name AS mc_name, m.name AS m_name, ms.name AS ms_name FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size WHERE b.user_id = $id" . (!$all ? " AND b.data != ''" : "") . " ORDER BY b.id DESC");
		while ($res = $result->fetch_assoc()) {
			$res['data'] = unserialize($res['data']);
			$bids[] = $res;
		}
		return $bids;
	}

	public function getPublic($all = false) {
		$bids = array();
		$result = DB::connect()->query("SELECT b.*, u.name, mc.name AS mc_name, m.name AS m_name, ms.name AS ms_name FROM bids b INNER JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size WHERE b.public = 1" . (!$all ? " AND b.data != ''" : "") . " ORDER BY b.id DESC");
		while ($res = $result->fetch_assoc()) {
			$res['data'] = unserialize($res['data']);
			$bids[] = $res;
		}
		return $bids;
	}

	public function getPaidOrderBids() {
		$result = DB::connect()->query("SELECT o.id, m.name AS material_name, mc.name AS material_category_name, ms.name AS size_name, b.file_name, b.data, o.city, o.street, o.house_number, o.post_index, u.name, u.surname, u.email, u.phone
																	 FROM orders o
																	 INNER JOIN bids b ON o.bids LIKE concat('%\"b\":', b.id, ',%')
																	 INNER JOIN users u ON u.id = o.user_id
																	 INNER JOIN materials m ON m.id = b.material
																	 INNER JOIN material_categories mc ON mc.id = m.category
																	 INNER JOIN material_sizes ms ON ms.id = b.size
																	 WHERE o.paid = 1 AND o.status = 1 ORDER BY o.id ASC");
		$bids = array();
		while ($res = $result->fetch_assoc()) {
			$res['data'] = unserialize($res['data']);
			$bids[] = $res;
		}
		return $bids;
	}

	public function copy($id) {
		if ($original_bid = $this->get($id)) {
			$fields = $values = array();
			$daefault_values = array('file' => '', 'data' => '', 'paid' => '0');
			foreach (array('date', 'file', 'file_name', 'user_id', 'material', 'size', 'status', 'data', 'paid') as $field) {
				$fields[] = $field;
				$values[] = "'" . (isset($daefault_values[$field]) ? $daefault_values[$field] : addslashes($original_bid[$field])) . "'";
			}
			DB::connect()->query("INSERT INTO bids (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")");
			$new_id = DB::connect()->insert_id;
			$new_file = $new_id . strrchr($original_bid['file'], '.');
			DB::connect()->query("UPDATE bids SET file = '$new_file' WHERE id = $new_id");
			copy($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $original_bid['file'], $_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $new_file);
			return $this->get($new_id);
		}
		else return false;
	}

	public function getNewByUser($user_id = 0) {
		$result = DB::connect()->query("SELECT b.*, u.name, m.name AS mname, mc.name AS mcname, ms.name AS msname FROM bids b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN materials m ON m.id = b.material LEFT JOIN material_categories mc ON mc.id = m.category LEFT JOIN material_sizes ms ON ms.id = b.size LEFT JOIN orders o ON o.bids LIKE concat('%\"b\":', b.id, ',%') WHERE" . ($user_id ? " b.user_id = $user_id AND" : "") . " b.data != '' AND b.paid = 0 AND o.id IS NULL ORDER BY b.date DESC");
		$bids = array();
		while ($res = $result->fetch_assoc()) {
			$res['data'] = @unserialize($res['data']);
			$bids[] = $res;
		}
		return $bids;
	}

	public function isInOrder($id) {
		if ($order = DB::connect()->query("SELECT * FROM orders WHERE bids LIKE '%\"b\":$id,%'")->fetch_assoc()) return $order;
		else return false;
	}

	public function delete($id) {
		if ((is_numeric($id) && $id > 0) || (is_array($id) && $id)) {
			global $controller;
			$current_user = $controller->getCurrentUser();
			$result = DB::connect()->query("SELECT * FROM bids WHERE id" . (is_numeric($id) ? " = $id" : " IN (" . implode(', ', $id) . ")"));
			while ($res = $result->fetch_assoc()) {
				if ($res['user_id'] == $current_user['id'] || isset($_SESSION['admin_login'])) {
					DB::connect()->query("DELETE FROM bids WHERE id = " . $res['id']);
					@unlink($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/' . $res['file']);
					@unlink($_SERVER['DOCUMENT_ROOT'] . '/graphic_files/preview/' . $res['id'] . '.png');
				}
			}
		}
	}
}

?>