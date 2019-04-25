<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Map.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Controller.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Models.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/CropImage.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Views.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Forms.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/Navigation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/application/application.php';

$controllerAction = Map::getControllerAction();
$controller_name = '';
$action = '';
try {
  if (file_exists($file_path = $_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $controllerAction['folder'] . '/' . $controllerAction['controller'] . '.php')) {
    require_once $file_path;
    if (class_exists($class_name = $controllerAction['controller'] . 'Controller')) {
      $controller_name = $class_name;
      if (method_exists($class_name, $controllerAction['action'] . 'Action')) {
        $action = $controllerAction['action'] . 'Action';
      }
      else {
        $action = 'indexAction';
      }
      throw new Exception('ok');
    }
  }
  if (file_exists($file_path = $_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $controllerAction['folder'] . '/' . 'Index.php')) {
    require_once $file_path;
    if (class_exists('IndexController')) {
      $controller_name = 'IndexController';
      if (method_exists('IndexController', $controllerAction['action'] . 'Action')) {
        $action = $controllerAction['action'] . 'Action';
      }
      else {
        $action = 'indexAction';
      }
      throw new Exception('ok');
    }
  }
  if ($controllerAction['folder'] && file_exists($file_path = $_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $controllerAction['controller'] . '.php')) {
    require_once $file_path;
    if (class_exists($class_name = $controllerAction['controller'] . 'Controller')) {
      $controller_name = $class_name;
      if (method_exists($class_name, $controllerAction['action'] . 'Action')) {
        $action = $controllerAction['action'] . 'Action';
      }
      else {
        $action = 'indexAction';
      }
      throw new Exception('ok');
    }
  }
  if (file_exists($file_path = $_SERVER['DOCUMENT_ROOT'] . '/controllers/Index.php')) {
    require_once $file_path;
    if (class_exists('IndexController')) {
      $controller_name = 'IndexController';
      $action = 'indexAction';
      throw new Exception('ok');
    }
  }
  $controller_name = 'Controller';
  $action = 'indexAction';
}
catch (Exception $e) {}

$controller = new $controller_name;
Forms::checkFormSubmit();
$controller->before();
echo $controller->$action();
$controller->after();

?>