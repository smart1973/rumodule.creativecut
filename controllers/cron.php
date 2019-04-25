<?php

class cronController extends Controller {

  public function notPayedOrdersRemindingAction () {
    if ($this->checkCronAccess()) {
      $days = array(3 => 'order_not_payed_3_days', 7 => 'order_not_payed_a_week');
      $result = DB::connect()->query("SELECT o.*, u.email, u.name, u.surname FROM orders o INNER JOIN users u ON u.id = o.user_id WHERE FROM_UNIXTIME(o.date, '%d.%m.%Y') IN (" . implode(', ', array_map(function ($k, $v) {return "'" . date('d.m.Y', time() - 24 * 60 * 60 * $k) . "'";}, array_keys($days), $days)) . ")");
      while ($res = $result->fetch_assoc()) {
        foreach ($days as $d => $k) {
          if (date('d.m.Y', $res['date']) == date('d.m.Y', time() - 24 * 60 * 60 * $d)) {
            $this->sendEventEmail($res['email'], $k, array('!name' => $res['name'], '!surname' => $res['surname']));
            break;
          }
        }
      }
    }
  }

  public function checkCronAccess() {
    return isset($_GET['key']) && $_GET['key'] == 'k78sh4ga534nbkfkj2fakw780anse7gpmzg2qrd';
  }
}

?>