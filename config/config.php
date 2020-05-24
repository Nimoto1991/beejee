<?php
/**
 * Конфигурационный файл
 * db - параметры подключения к базе
 * router - параметры роутинга, в частности
 * controller - класс контроллера, обрабатывающего запросы
 * view => path - путь к файлам-шаблонам
 */
return [
	"db" => [
		"host" => "localhost",
		"dbname" => "beejee",
		"user" => "olga",
		"pass" => "olga"
	],
	"router" => [
		"controller" => [
			"index" => "beejee\controllers\SiteController",
			"admin" => "beejee\controllers\AdminController",
			"task" => "beejee\controllers\TaskController"
		],
	],
	"view" => [
		"path" => $_SERVER["DOCUMENT_ROOT"] . "/views/"
	]
];