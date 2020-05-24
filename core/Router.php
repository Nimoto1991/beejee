<?php

namespace beejee\core;

use Exception;

class Router {
	const INDEX_PAGE = "index";
	const ROUTE_PARAMETER = "r";
	const ACTION_PARAMETER = "a";

	private static $controller;

	public static function init($config) : void {
		$controllerKey = $_GET[self::ROUTE_PARAMETER];

		if (!$controllerKey) {
			$controllerKey = self::INDEX_PAGE;
		}

		if (!isset($config["controller"])) {
			throw new Exception("Wrong configuration");
		}

		if (!isset($config["controller"][$controllerKey])) {
			throw new Exception("Wrong route " . $controllerKey);
		}

		self::$controller = new $config["controller"][$controllerKey]();
		if (get_parent_class(self::$controller) !== "beejee\core\Controller") {
			throw new Exception("Wrong controller class");
		}
	}

	public static function route(string $action = "") : void {
		if (!$action) {
			$action = $_GET[self::ACTION_PARAMETER];
		}
		$action = $action ?: self::INDEX_PAGE;
		self::$controller->load($action);
	}
}