<?php

use beejee\core\Application;

ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$config = file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/config.php')
	? require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php' : [];

Application::run($config);