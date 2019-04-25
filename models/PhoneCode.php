<?php

class PhoneCode {

  public function sendCode($phone_number) {
    global $controller;
    do {
      $code = '';
      while (strlen($code) < 5) $code .= rand(0, 9);
      $res = DB::connect()->query("SELECT * FROM phone_codes WHERE phone_code = '$code'")->fetch_assoc();
    } while ($res);
    DB::connect()->query("INSERT INTO phone_codes (phone_code, phone_number) VALUES ('$code',  '$phone_number') ON DUPLICATE KEY UPDATE phone_code = VALUES(phone_code)");
    $sms = new DOMDocument();
    $sms->loadXML($controller->sendSmsEvent($phone_number, 'confirmation_phone_number', array('!confirmation_code' => $code)));
    switch ($sms->getElementsByTagName('Result')->item(0)->getElementsByTagName('Status')->item(0)->nodeValue) {
      case 1: return 'On you phone was sent a code'; break;
      case -18: return 'Wrong phone'; break;
      default: return 'Something wrong';
    }
  }

  public function checkPhoneCode($phone, $code) {
    return DB::connect()->query("SELECT * FROM phone_codes WHERE phone_number = '$phone' AND phone_code = '$code'")->fetch_assoc() ? true : false;
  }

  public function deleteByPhone($phone) {
    DB::connect()->query("DELETE FROM phone_codes WHERE phone_number = '$phone'");
  }
}

?>