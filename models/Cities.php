<?php

class Cities {

  public function get($cond = array()) {
    $cities = array();
    $result = DB::connect()->query("SELECT * FROM cities" . ($cond ? " WHERE " . implode(' AND ', array_map(function ($a, $b) {return $a . (is_array($b) ? " IN (" . implode(', ', array_map(function ($a) {return "'" . addslashes($a) . "'";}, $b)) . ")" : " = '" . addslashes($b) . "'");}, array_keys($cond), $cond)) : '') . " ORDER BY id DESC");
    while ($res = $result->fetch_assoc()) {
      $cities[$res['id']] = $res;
    }
    return isset($cond['id']) && is_numeric($cond['id']) ? (isset($cities[$cond['id']]) ? $cities[$cond['id']] : false) : $cities;
  }

  public function save($data) {
    global $controller;
    $fields = array('id', 'name');
    $sql = array('fields' => array(), 'values' => array(), 'duplicate' => array());
    foreach ($fields as $field) {
      $sql['fields'][] = $field;
      $sql['values'][] = isset($data[$field]) ? "'" . addslashes($controller->removeScripts(strip_tags($data[$field]))) . "'" : ($field == 'id' ? 0 : '');
      if ($field != 'id') $sql['duplicate'][] = $field . ' = VALUES(' . $field . ')';
    }
    DB::connect()->query("INSERT INTO cities (" . implode(', ', $sql['fields']) . ") VALUES (" . implode(', ', $sql['values']) . ") ON DUPLICATE KEY UPDATE " . implode(', ', $sql['duplicate']));
    return isset($data['id']) ? $data['id'] : DB::connect()->insert_id;
  }

  public function delete($id) {
    DB::connect()->query("DELETE FROM cities WHERE id = $id");
  }

}

?>