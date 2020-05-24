<?php

namespace beejee\core;

use beejee\models\Admin;

abstract class Controller {
	public function render($viewPath, $params = []) {
		View::render($viewPath, $params);
	}

	public function jsonResponce(array $response) : void {
		echo json_encode($response);
	}

	public function load(string $action = "") : void {
		$this->{$action}();
	}

	public static function getCurrentAdmin() : ?Admin {
		$admin = null;
		if ($_SESSION["ADMIN_ID"]) {
			$admin = Admin::getById($_SESSION["ADMIN_ID"]);
		}
		return $admin;
	}
}