<?php

namespace beejee\assets;

use beejee\core\Asset;

class AssetBundle extends Asset {
	public static $css = [
		"assets/css/bootstrap.css",
		"assets/css/style.css"
	];
	public static $js = [
		"assets/js/jquery.min.js",
		"assets/js/script.js",
		"https://cdn.jsdelivr.net/npm/vue@2.6.11"
	];
}