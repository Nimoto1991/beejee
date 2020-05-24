<?php


namespace beejee\controllers;


use beejee\core\Controller;
use beejee\models\Task;

class TaskController extends Controller {

	public function add() : void {
		$name = htmlentities($_POST["name"]);
		$email = htmlentities($_POST["email"]);
		$description = htmlentities($_POST["description"]);

		$response = [];
		if (!$name) {
			$response["errors"]["name"] = "Name is required";
		}
		if (!$email) {
			$response["errors"]["email"] = "Email is required";
		} else {
			$regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/';

			if (!preg_match($regex, $email)) {
				$response["errors"]["email"] = "Email is invalid";
			}
		}

		if (!$description) {
			$response["errors"]["description"] = "Description is required";
		}
		if ($response["errors"]) {
			$this->jsonResponce($response);
			exit();
		}

		$task = new Task();
		$task->setUserName($name);
		$task->setUserEmail($email);
		$task->setDescription($description);
		$task->save();
		$response["success"] = true;
		$response["task"] = [
			"user_name" => $task->getUserName(),
			"user_email" => $task->getUserEmail(),
			"description" => $task->getDescription(),
			"status" => $task->getStatus(),
		];
		$this->jsonResponce($response);
	}

	public function complete() : void {
		$this->checkRights();
		$taskId = (int)$_POST["taskId"];
		$response = [];
		if (!$taskId) {
			$response["errors"]["id"] = "ID is required";
		}
		$task = Task::getById($taskId);
		if (!$task) {
			$response["errors"]["id"] = "Task not found";
		} else {
			$task->setStatus(Task::STATUS_COMPLETED);
			$task->update();
			$response["success"] = true;
		}
		$this->jsonResponce($response);
	}

	public function update() : void {
		$this->checkRights();
		$taskId = (int)$_POST["taskId"];
		$description = htmlentities($_POST["description"]);
		$response = [];
		if (!$taskId) {
			$response["errors"]["id"] = "ID is required";
		}
		$task = Task::getById($taskId);
		if (!$task) {
			$response["errors"]["id"] = "Task not found";
		} else {
			$task->setDescription($description);
			$task->setChanged(Task::WAS_CHANGED);
			$task->update();
			$response["success"] = true;
		}
		$this->jsonResponce($response);
	}

	private function checkRights() : void {
		if (!$admin = self::getCurrentAdmin()) {
			$response["errors"]["id"] = "Session has expired";
			$this->jsonResponce($response);
			die();
		}
	}

}