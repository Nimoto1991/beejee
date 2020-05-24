<?php

namespace beejee\models;

use beejee\core\Application;
use mysql_xdevapi\Exception;
use PDO;

class Task {

	const TABLE_NAME = "task";

	const FIELD_ID = "id";
	const FIELD_USER_NAME = "user_name";
	const FIELD_USER_EMAIL = "user_email";
	const FIELD_DESCRIPTION = "description";
	const FIELD_STATUS = "status";
	const FIELD_CHANGED = "changed";

	const STATUS_COMPLETED = 1;
	const WAS_CHANGED = 1;

	private $id;
	private $userName;
	private $userEmail;
	private $description;
	private $status;
	private $changed;

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getUserName() {
		return $this->userName;
	}

	/**
	 * @param mixed $userName
	 */
	public function setUserName($userName): void {
		$this->userName = $userName;
	}

	/**
	 * @return mixed
	 */
	public function getUserEmail() {
		return $this->userEmail;
	}

	/**
	 * @param mixed $userEmail
	 */
	public function setUserEmail($userEmail): void {
		$this->userEmail = $userEmail;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description): void {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status): void {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getChanged() {
		return $this->changed;
	}

	/**
	 * @param mixed $changed
	 */
	public function setChanged($changed): void {
		$this->changed = $changed;
	}

	public function save() : bool {
		$sqlQuery = "INSERT INTO " . self::TABLE_NAME . " (" . self::FIELD_USER_NAME . ", " . self::FIELD_USER_EMAIL . ", " . self::FIELD_DESCRIPTION . ") VALUES (?,?,?)";
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		return $sqlStatement->execute([$this->userName, $this->userEmail, $this->description]);
	}

	public function update() : bool {
		$sqlQuery = "UPDATE " . self::TABLE_NAME . " SET " . self::FIELD_USER_NAME . "=?, " . self::FIELD_USER_EMAIL . "=?, " . self::FIELD_DESCRIPTION . "=?, " . self::FIELD_STATUS . "=?, " . self::FIELD_CHANGED . "=? WHERE " . self::FIELD_ID . "=?";
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		return $sqlStatement->execute([$this->userName, $this->userEmail, $this->description, $this->status, $this->changed, $this->id]);
	}

	public static function getList(int $limit = 0, int $offset = 0, string $orderBy = self::FIELD_ID, string $orderDir = "desc") : array {
		if (!in_array($orderBy, [
			self::FIELD_ID,
			self::FIELD_STATUS,
			self::FIELD_USER_NAME,
			self::FIELD_USER_EMAIL,
		])) {
			throw new Exception("Wrong field");
		}

		$orderDir = strtolower($orderDir);
		if (!in_array($orderDir, [
			"desc",
			"asc"
		])) {
			throw new Exception("Wrong sort order");
		}

		$sqlQuery = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY {$orderBy} {$orderDir}";
		if ($limit) {
			$sqlQuery .= " LIMIT :limit";
		}
		if ($offset) {
			$sqlQuery .= " OFFSET :offset";
		}
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		if ($limit) {
			$sqlStatement->bindValue(":limit", $limit, PDO::PARAM_INT);
		}
		if ($offset) {
			$sqlStatement->bindValue(":offset", $offset, PDO::PARAM_INT);
		}
		$sqlStatement->execute();
		return $sqlStatement->fetchAll();
	}


	public static function getCount() : int {
		$sqlQuery = "SELECT * FROM " . self::TABLE_NAME;
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		$sqlStatement->execute();
		return $sqlStatement->rowCount();
	}

	public static function getById(int $id) : ?Task {
		$sqlQuery = "SELECT * from " . self::TABLE_NAME . " WHERE " . self::FIELD_ID . "=:id";
		$sqlStatement = Application::$dbConnection->prepare($sqlQuery);
		$sqlStatement->bindValue(":id", $id, PDO::PARAM_INT);
		$sqlStatement->execute();
		$taskData = $sqlStatement->fetch();
		if (!$taskData) {
			return null;
		}
		$task = new Task();
		$task->id = $taskData[self::FIELD_ID];
		$task->userEmail = $taskData[self::FIELD_USER_EMAIL];
		$task->userName = $taskData[self::FIELD_USER_NAME];
		$task->description = $taskData[self::FIELD_DESCRIPTION];
		$task->status = $taskData[self::FIELD_STATUS];
		$task->changed = $taskData[self::FIELD_CHANGED];
		return $task;
	}

}