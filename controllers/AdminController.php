<?php


namespace beejee\controllers;


use beejee\core\Controller;
use beejee\models\Admin;

class AdminController extends Controller {

	public function logout() : void {
		unset($_SESSION["ADMIN_ID"]);
		header("Location: /");
	}

	public function login() : void {
		$login = htmlentities($_POST["login"]);
		$password = htmlentities($_POST["password"]);
		$response = [];
		if (!$login) {
			$response["errors"]["login"] = "Login is required";
		}
		if (!$password) {
			$response["errors"]["password"] = "Password is required";
		}
		if ($login && $password) {
			$admin = Admin::getOne($login, $password);
			if ($admin) {
				$response["success"] = true;
				$response["admin"] = [
					"id" => $admin->getId(),
					"login" => $admin->getLogin()
				];
				$_SESSION["ADMIN_ID"] = $admin->getId();
			} else {
				$response["errors"]["password"] = "User not found";
			}
		}
		$this->jsonResponce($response);
	}
}