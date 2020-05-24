<?php

namespace beejee\core;


class Asset {
	public static $css = [];
	public static $js = [];

	public static function printCss() : void {
		foreach (static::$css as $link) {
			echo "<link href='$link'  rel=\"stylesheet\"/>";
		}
	}

	public static function printJs() : void {
		foreach (static::$js as $link) {
			echo "<script src='$link'></script>";
		}
	}
}