<?php

class Orders {

	public function insert($summ, $delivery_date, $name, $surname, $city, $street, $house_number, $post_index, $company_name, $company_id, $bids, $bids_quantities) {
		global $controller;
		$order = $this->getNewOrder();
		$bids_data = array();
		foreach ($bids as $bid) {
			$bids_data[] = array('b' => (int)$bid['id'], 'q' => isset($bids_quantities[$bid['id']]) ? (int)$bids_quantities[$bid['id']] : 1);
		}
		DB::connect()->query("UPDATE orders SET summ = $summ, date = " . time() . ", delivery_date = '$delivery_date', name = '" . addslashes($controller->removeScripts(strip_tags($name))) . "', surname = '" . addslashes($controller->removeScripts(strip_tags($surname))) . "', city = '" . addslashes($controller->removeScripts(strip_tags($city))) . "', street = '" . addslashes($controller->removeScripts(strip_tags($street))) . "', house_number = '" . addslashes($controller->removeScripts(strip_tags($house_number))) . "', post_index = '" . addslashes($controller->removeScripts(strip_tags($post_index))) . "', company_name = '" . addslashes($controller->removeScripts(strip_tags($company_name))) . "', company_id = '" . addslashes($controller->removeScripts(strip_tags($company_id))) . "', bids = '" . json_encode($bids_data) . "', status = 1 WHERE id = " . $order['id']);
		return DB::connect()->error ? false : array('id' => $order['id'], 'hash' => $order['hash']);
	}

	public function getOrders($id = false, $user = false, $status = false, $paid = null) {
		global $controller;
		$statuses = $controller->getStatuses();
		$where = array();
		if (is_numeric($id)) $where[] = "o.id = $id";
		if (is_array($id)) $where[] = "o.id IN (" . implode(", ", $id) . ")";
		if (is_numeric($user)) $where[] = "o.user_id = $user";
		if (is_array($status)) $where[] = "o.status IN ('" . implode("', '", $status) . "')";
		if (is_numeric($paid) && in_array($paid, array(0, 1))) $where[] = "o.paid = $paid";
		$result = DB::connect()->query("SELECT o.*, u.name AS user_name, u.surname AS user_surname, u.email, u.phone, d.name AS delivery FROM orders o INNER JOIN users u ON u.id = o.user_id INNER JOIN delivery_time d ON d.id = o.delivery_date" . ($where ? " WHERE " . implode(" AND ", $where) : "") . " ORDER BY o.date DESC");
		$orders = array();
		while ($res = $result->fetch_assoc()) {
			if ($res['status'] != 0 || $bids = Models::get('Bids')->getNewByUser($res['user_id'])) {
				if ($res['status'] == 0) {
					foreach ($bids as $bid) {
						$res['summ'] += $bid['data']['total_price'] + $bid['data']['tax'];
						$res['bids'][] = (object)array('b' => (int)$bid['id'], 'q' => 1);
					}
					$res['paid'] = '<div class="not-paid">Not paid</div>';
					$res['status_name'] = array_key_exists($res['status'], $statuses) ? $statuses[$res['status']] : '';
				}
				else {
					$res['bids'] = json_decode($res['bids']);
					$res['paid'] = $res['paid'] == 0 ? '<div class="not-paid">Not paid</div>' : '<div class="paid">Paid</div>';
					$res['status_name'] = array_key_exists($res['status'], $statuses) ? $statuses[$res['status']] : '';
				}
				$orders[] = $res;
			}
		}
		return is_numeric($id) && $id ? ($orders ? $orders[0] : $orders) : $orders;
	}

	public function getNewOrder() {
		global $controller;
		$current_user = $controller->getCurrentUser();
		$order = DB::connect()->query("SELECT * FROM orders WHERE user_id = " . $current_user['id'] . " AND status = 0")->fetch_assoc();
		if (!$order) {
			$symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			do {
				$hash = '';
				while (strlen($hash) < 30) {
					$hash .= $symbols[rand(0, strlen($symbols) - 1)];
				}
				$res = DB::connect()->query("SELECT * FROM orders WHERE hash = '$hash'")->fetch_assoc();
			} while($res);
			DB::connect()->query("INSERT INTO orders (user_id, date, hash) VALUES (" . $current_user['id'] . ", " . time() . ", '$hash')");
			$order = DB::connect()->query("SELECT * FROM orders WHERE id = " . DB::connect()->insert_id . "")->fetch_assoc();
		}
		return $order;
	}

	public function pay($id, $hash) {
		if (is_numeric($id) && ($order = $this->getOrders($id)) && isset($order['hash']) && is_string($order['hash']) && $order['hash'] && $order['hash'] == $hash && isset($order['bids']) && is_array($order['bids']) && $order['bids']) {
			DB::connect()->query("UPDATE orders SET paid = 1 WHERE id = $id");
			DB::connect()->query("UPDATE bids SET paid = 1 WHERE id IN (" . implode(', ', array_map(function ($b) {return $b->b;}, $order['bids'])) . ")");
			return $order;
		}
		return false;
	}

	public function delete($id) {
		if ((is_numeric($id) && $id > 0) || (is_array($id) && $id)) {
			global $controller;
			$current_user = $controller->getCurrentUser();
			$orders = $this->getOrders($id);
			if ($orders) {
				if (is_numeric($id)) {
					if ($orders['user_id'] == $current_user['id'] || isset($_SESSION['admin_login'])) {
						Models::get('Bids')->delete(array_map(function ($b) {return $b->b;}, $orders['bids']));
						DB::connect()->query("DELETE FROM orders WHERE id = " . $orders['id']);
					}
				}
				else {
					foreach ($orders as $order) {
						if ($order['user_id'] == $current_user['id'] || isset($_SESSION['admin_login'])) {
							Models::get('Bids')->delete(array_map(function ($b) {return $b->b;}, $order['bids']));
							DB::connect()->query("DELETE FROM orders WHERE id = " . $order['id']);
						}
					}
				}
			}
		}
	}

	public function reset($id) {
		DB::connect()->query("UPDATE orders SET summ = 0, delivery_date = '', name = '', surname = '', city = '', street = '', house_number = '', post_index = '', company_name = '', company_id = '', bids = '', status = 0, paid = 0, pdf_link = '' WHERE id = $id");
	}

	public function payWithZCredit($PaymentSum, $UniqueID, $Hash, $ItemQtty, $CustomerName) {
		$TerminalNumber = '2660616011';
		$UserName = 'tiv16';
		$PaymentsNumber = 1;
		$Lang = 'he-IL';
		$Currency = 1;
		$ItemDescription = '';
		$ItemPicture = '';
		$RedirectLink = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . '/cart?id=' . $UniqueID . '&hash=' . $Hash);
		$NotifyLink = urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER['SERVER_NAME']) . '/notify-payment?type=zcredit';
		$UsePaymentsRange = false;
		$ShowHolderID = false;
		$AuthorizeOnly = false;
		$HideCustomer = false;
		$CssType = 1;
		$IsCssResponsive = 1;

		$url = "https://pci.zcredit.co.il/WebControl/RequestToken.aspx";
		$post = "TerminalNumber=$TerminalNumber"
		."&Username=$UserName&PaymentSum=$PaymentSum&PaymentsNumber=$PaymentsNumber&Lang=$Lang"
		."&Currency=$Currency&UniqueID=$UniqueID&ItemDescription=$ItemDescription&ItemQtty=$ItemQtty"
		."&ItemPicture=$ItemPicture&RedirectLink=$RedirectLink&NotifyLink=$NotifyLink"
		."&UsePaymentsRange=$UsePaymentsRange&ShowHolderID=$ShowHolderID&AuthorizeOnly=$AuthorizeOnly"
		."&HideCustomer=$HideCustomer&CustomerName=$CustomerName&CssType=$CssType&IsCssResponsive=$IsCssResponsive";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$page = curl_exec($ch);

		$Resdata = '';
		$tmpArray = explode("\n", trim($page), 2);
		if (sizeof($tmpArray) > 1) {
			$ResGUID = $tmpArray[0];
			if (!preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $ResGUID)) {
				$this->reset($UniqueID);
				header("Location: /cart?message=Invalid GUID");
				exit;
			}
			$Resdata = $tmpArray[1];
		}
		else {
			$this->reset($UniqueID);
			header("Location: /cart?message=Error");
			exit;
		}
		DB::connect()->query("UPDATE orders SET payment_data = '" . addslashes(json_encode(array('GUID' => $ResGUID))) . "' WHERE id = $UniqueID");
		$url = "https://pci.zcredit.co.il/WebControl/Transaction.aspx?GUID=$ResGUID&DataPackage=$Resdata";	
		header("Location: $url");
		exit;
	}

		public function sendICountDocument($company_id, $company_name, $user_email, $order_id, $price, $card_type, $card_number, $exp_month, $exp_year, $holder_id, $holder_name, $confirmation_code) {
		$url = "https://api.icount.co.il/api/v3.php/doc/create";
		$params = array(
			"cid" => "CreativeCut",
			"user" => "info",
			"pass" => "1q2w3e",
			"doctype" => "invrec",
			"vat_id" => $company_id,
			"client_name" => $company_name,
			"email" => $user_email,
			"lang" => "he",
			"currency_code" => "ILS",
			"tax_exempt" => 0,
			"vat_percent" => 17,
			"items" => array(
				array(
					"description" => "שירותי חיתוך עפ\"י הזמנה מס' $order_id",
					"unitprice" => $price,
					"quantity" => 1,
					),
				),
			"cc" => array(
				"sum" => $price + $price / 100 * 17,
				"card_type" => $card_type,
				"card_number" => $card_number,
				"exp_year" => $exp_year,
				"exp_month" => $exp_month,
				"holder_id" => $holder_id,
				"holder_name" => $holder_name,
				"confirmation_code" => $confirmation_code,
			),
			"send_email" => 1,
			"email_to_client" => 1,
			"email_to" => "info@creativecut.co.il"
		);
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, null, '&'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);

		return json_decode($response);
	}
}

?>