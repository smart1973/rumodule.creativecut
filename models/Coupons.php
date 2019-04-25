<?php

class Coupons {

	protected $symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

	public function create($params) {
		do {
			$code = '';
			while (strlen($code) < 20) {
				$code .= $this->symbols[rand(0, strlen($this->symbols) - 1)];
			}
			$res = DB::connect()->query("SELECT * FROM coupons WHERE code = '$code'")->fetch_assoc();
		} while ($res);
		DB::connect()->query("INSERT INTO coupons (code, discount, valid_till, status) VALUES ('$code', " . $params['discount'] . ", " . mktime(23, 59, 59, $params['month'], $params['day'], $params['year']) . ", 0)");
		return $code;
	}

	public function getByCode($code) {
		if ($coupon = DB::connect()->query("SELECT * FROM coupons WHERE code = '" . addslashes($code) . "'")->fetch_assoc()) {
			return $coupon;
		}
		return false;
	}

	public function updateStatus($id, $status) {
		DB::connect()->query("UPDATE coupons SET status = $status WHERE id = $id");
	}
}

?>