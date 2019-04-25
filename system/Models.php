<?php

class Models {

	private static $models = array();

	public static function get($mn) {
		$path = explode('/', $mn);
		if (array_key_exists($mn, self::$models)) return self::$models[$mn];
		elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . '/models/' . $mn . '.php')) {
			include_once $_SERVER['DOCUMENT_ROOT'] . '/models/' . $mn . '.php';
			if (class_exists($model_name = $path[count($path) - 1])) {
				self::$models[$mn] = new $model_name();
				return self::$models[$mn];
			}
		}
		return false;
	}
}

?>