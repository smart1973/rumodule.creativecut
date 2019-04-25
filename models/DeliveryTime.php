<?php

class DeliveryTime {

	public function get($id = '') {
		if (is_numeric($id) && $id > 0) {
			return DB::connect()->query("SELECT * FROM delivery_time WHERE id = $id")->fetch_assoc();
		}
		else {
			$result = DB::connect()->query("SELECT * FROM delivery_time ORDER BY id DESC");
			$dtimes = array();
			while ($res = $result->fetch_assoc()) {
				$dtimes[] = $res;
			}
			return $dtimes;
		}
	}
}

?>