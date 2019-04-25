<?php

class Views {

  public static function getContent($template, $vars = array()) {
    if (file_exists($views = $_SERVER['DOCUMENT_ROOT'] . '/views/' . $template . '.php') && is_array($vars)) {
      foreach ($vars as $key => $var) {
        if (preg_match('/^[a-zA-Z_]+[a-zA-Z0-9_]*$/', $key)) {
          $$key = $var;
        }
      }
      ob_start();
      include $views;
      return ob_get_clean();
    }
    else {
      return 'File not found';
    }
  }

}


?>