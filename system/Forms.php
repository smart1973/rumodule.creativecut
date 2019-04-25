<?php

class Forms {

  private static $forms = array();

  private $form_id = 0;

  private $check_form_id = 0;

  private $all_errors = array();

  public $errors = array();

  private function __construct($check_form_id = 0) {
    $this->check_form_id = $check_form_id;
  }

  public function beforeRender() {
    $this->form_id++;
    $this->errors = isset($this->all_errors[$this->form_id]) ? $this->all_errors[$this->form_id] : array();
  }

  public static function checkFormSubmit () {
    $data = $GLOBALS[$_SERVER['REQUEST_METHOD'] == 'POST' ? '_POST' : '_GET'];
    if (isset($data['form_name']) && is_string($data['form_name']) && isset($data['form_id']) && $data['form_id'] > 0 && $class = self::checkFormFile($data['form_name'], $data['form_id'])) {
      if (method_exists($class, 'validate')) {
        $class->validate();
        if ($class->canSubmit() && method_exists($class, 'submit')) $class->submit();
      }
      elseif (method_exists($class, 'submit')) $class->submit();
    }
  }

  public function setError($field, $error_text) {
    $this->all_errors[$this->check_form_id][$field] = $error_text;
  }

  public function canSubmit() {
    return $this->all_errors ? false : true;
  }

  public static function getForm($name) {
    if (!isset(self::$forms[$name])) self::checkFormFile($name);
    return self::$forms[$name];
  }

  private static function checkFormFile($name, $id = 0) {
    try {
      if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/forms/' . $name . '.php')) throw new Exception('File not exists');
      include_once $_SERVER['DOCUMENT_ROOT'] . '/forms/' . $name . '.php';
      if (!class_exists($class_name = preg_replace('/^(?:.*?\/)*(.*)$/', '$1', $name))) throw new Exception('Class not exists');
      self::$forms[$name] = new $class_name($id);
      return self::$forms[$name];
    }
    catch (Exception $e) {
      self::$forms[$name] = new self();
      return false;
    }
  }

  protected function getFormId() {
    return $this->form_id;
  }

  public function render($args = array()) {
    echo 'File not found';
  }
}

?>