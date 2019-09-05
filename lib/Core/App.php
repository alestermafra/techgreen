<?php
App::import('Inflector', 'Utility');

class App {
	private static $_classMap = array();
	
	public static function import($className, $location) {
		static::$_classMap[$className] = $location;
	}
	
	public static function load($className) {
		if(!isset(static::$_classMap[$className])) {
			return false;
		}
		
		$package = static::$_classMap[$className];
		
		$paths = [];
		$paths[] = APP . DS . $package;
		$paths[] = LIB . DS . $package;
		
		foreach($paths as $path) {
			$file = $path . DS . $className . '.php';
			if(file_exists($file)) {
				return include $file;
			}
		}
		
		return false;
	}
}