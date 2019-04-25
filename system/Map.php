<?php

class Map {

  protected static $controllers = array();

  public static function setPath($path) {
    if (is_string($path)) {
      $path = array('path' => $path, 'folder' => '', 'controller' => '', 'action' => '');
    }
    elseif (is_array($path) && array_key_exists('path', $path) && is_string($path['path'])) {
      if (!array_key_exists('controller', $path) || !is_string($path['controller'])) {
        $path['controller'] = '';
      }
      if (!array_key_exists('action', $path) || !is_string($path['action'])) {
        $path['action'] = '';
      }
      if (!array_key_exists('folder', $path) || !is_string($path['folder'])) {
        $path['folder'] = '';
      }
    }
    if (is_array($path) && array_key_exists('path', $path) && is_string($path['path']))
      self::$controllers[] = $path;
  }

  public static function getControllerAction() {
    $request_url = preg_replace(array('/\?.*/', '/^\/*/'), '', $_SERVER['REQUEST_URI']);
    foreach (self::$controllers as $controller) {
      if (preg_match('/^' . str_replace(array('%', '/', '(', ')'), array('.*?', '\\/', '(?:', ')?'), $controller['path']) . '$/', $request_url)) {
        $expl = explode('/', $request_url);
        return array(
          'folder' => $controller['folder'],
          'controller' => $controller['controller'] === '' && isset($expl[0]) && $expl[0] && preg_match('/^[\w\d-_]+$/', $expl[0]) ? str_replace(array('-', ' '), '_', $expl[0]) : (preg_match('/^[\w\d-_]+$/', $controller['controller']) ? str_replace(array('-', ' '), '_', $controller['controller']) : 'Index'),
          'action' => $controller['action'] === '' && isset($expl[1]) && $expl[1] && preg_match('/^[\w\d-_]+$/', $expl[1]) ? str_replace(array('-', ' '), '_', $expl[1]) : (preg_match('/^[\w\d-_]+$/', $controller['action']) ? str_replace(array('-', ' '), '_', $controller['action']) : 'index')
        );
      }
    }
    return array('folder' => '', 'controller' => 'Index', 'action' => 'index');
  }

}


?>