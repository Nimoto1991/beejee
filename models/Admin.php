<?php

namespace beejee\models;

use beejee\core\Application;
use PDO;

class Admin {
	const TABLE_NAME = "admin";

	const FIELD_ID = "id";
	const FIELD_LOGIN = "login";
	const FIELD_PASSWORD = "password";

	private $id;
	private $login;
	private $password;

	public function getId() : int {
		return $this->id;
	}

	public function getLogin() : string {
		return $this->login;
	}

	public static function getOne(string $login, string $password): ?Admin {
		$password = md5($password);
		$sqlQuery = "SELECT * from " . self::TABLE_NAME . " WHERE " . self::FIELD_LOGIN . "=:login AND " . self::FIELD_PASSWORD . "=:password LIMIT 1";
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		$sqlStatement->bindValue(":login", $login);
		$sqlStatement->bindValue(":password", $password);
		return self::makeAdmin($sqlStatement);
	}

	public static function getById(int $id) : ?Admin {
		$sqlQuery = "SELECT id, login from " . self::TABLE_NAME . " WHERE " . self::FIELD_ID . "=:id";
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		$sqlStatement->bindValue(":id", $id, PDO::PARAM_INT);
		return self::makeAdmin($sqlStatement);
	}

	private static function makeAdmin(\PDOStatement $sqlStatement) : ?Admin {
		$sqlStatement->execute();
		$sqlData = $sqlStatement->fetch();
		if (!$sqlData) {
			return null;
		}
		$admin = new Admin();
		$admin->id = $sqlData[self::FIELD_ID];
		$admin->login = $sqlData[self::FIELD_LOGIN];
		return $admin;
	}
}