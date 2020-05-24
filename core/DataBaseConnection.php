<?php

namespace beejee\core;

use PDO;

class DataBaseConnection {
	private static $instance;

	private function __construct() {

	}

	public static function init($config) : PDO {
		if (!self::$instance) {
			try {
				self::$instance = new PDO(
					'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
					$config['user'],
					$config['pass']
				);
			} catch (\Exception $e) {
				echo $e->getMessage();
				die();
			}
		}
		return self::$instance;
	}
}