<?php

namespace beejee\core;

use mysql_xdevapi\Exception;

class View {
	private static $path;

	/**
	 * @param $config - массив параметров конфигурации, в частности
	 * path - параметр, указывающий путь к директории с файлами шаблона
	 */
	public static function init($config) : void {
		if (isset($config['path'])) {
			self::$path = $config['path'];
		}
	}

	/**
	 * @param $viewPath - относительный путь к шаблону
	 * @param array $params - параметры, которые передаются в шаблон из контроллера
	 */
	public static function render($viewPath, $params = []) : void {
		if (file_exists(self::$path . $viewPath)) {
			extract($params);
			include self::$path . $viewPath;
		} else {
			throw new Exception('View file not found');
		}
	}
}