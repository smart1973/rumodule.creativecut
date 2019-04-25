<?php

class Prompts {

  public function get($id = null) {
    $result = DB::connect()->query("SELECT * FROM prompts" . ($id && is_numeric($id) ? " WHERE id = $id" : ($id && is_array($id) ? " WHERE id IN (" . implode(', ', $id) . ")" : "")) . " ORDER BY id DESC");
    $prompts = array();
    while ($res = $result->fetch_assoc()) {
      $prompts[$res['id']] = $res;
    }
    return $id && is_numeric($id) ? (isset($prompts[$id]) ? $prompts[$id] : false) : $prompts;
  }

  public function save($data) {
    global $controller;
    $insert = array(
      'id' => isset($data['id']) && is_numeric($data['id']) && $data['id'] > 0 ? $data['id'] : 0,
      'title' => isset($data['title']) && is_string($data['title']) ? strip_tags($controller->removeScripts($data['title'])) : '',
      'text' => isset($data['text']) && is_string($data['text']) ? strip_tags($controller->removeScripts($data['text'])) : ''
    );
    $fields = array();
    $values = array();
    $update = array();
    foreach ($insert as $k => $v) {
      $fields[] = $k;
      $values[] = "'" . addslashes($v) . "'";
      if ($k != 'id') $update[] = $k . " = VALUES($k)";
    }
    DB::connect()->query("INSERT INTO prompts (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ") ON DUPLICATE KEY UPDATE " . implode(", ", $update));
  }

  public function delete($id) {
    DB::connect()->query("DELETE FROM prompts WHERE id = $id");
  }

  public function getHTML($id) {
    $html = '';
    if ($prompt = $this->get($id)) {
      $html = '<div class="help" id="help-' . $id . '"><a href="javascript:void(0)"></a><div><a href="javascript:void(0)"></a><h3>' . $prompt['title'] . '</h3><div>' . $prompt['text'] . '</div></div></div>';
    }
    return $html;
  }

}

?>