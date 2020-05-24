<?php

namespace beejee\core;

class Application {
	/**
	 * @var \PDO
	 */
	public static $dbConnection = false;

	public static function run($config) : void {
		session_start();
		if (isset($config["db"])) {
			self::$dbConnection = DataBaseConnection::init($config["db"]);
		}
		if (isset($config["view"])) {
			View::init($config["view"]);
		}
		if (isset($config["router"])) {
			Router::init($config["router"]);
			Router::route();
		}
	}
}