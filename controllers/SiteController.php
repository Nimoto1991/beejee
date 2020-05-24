<?php

namespace beejee\controllers;

use beejee\core\Controller;
use beejee\models\Task;

class SiteController extends Controller {
	const TASK_PER_PAGE = 3;

	/**
	 * Обработка главной страницы
	 */
	public function index() : void {
		$admin = self::getCurrentAdmin();
		$offset = 0;
		$page = (int)$_GET["page"];
		if ($page) {
			$offset = ($page - 1) * self::TASK_PER_PAGE;
		}
		$orderBy = htmlentities($_GET["field"]) ?: Task::FIELD_ID;
		$orderDir = htmlentities($_GET["dir"]) ?: "desc";
		$tasks = Task::getList(self::TASK_PER_PAGE, $offset, $orderBy, $orderDir);
		$this->render('index.php', [
			"tasks" => json_encode($tasks),
			"admin" => $admin ? ["id" => $admin->getId(), "login" => $admin->getLogin()] : [],
			"orderBy" => $orderBy,
			"orderDir" => $orderDir,
			"itemsPerPage" => self::TASK_PER_PAGE,
			"page" => $page,
			"count" => Task::getCount()
		]);
	}
}