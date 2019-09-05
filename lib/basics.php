<?php

if(!function_exists('config')) {
	function config() {
		$args = func_get_args();
		foreach($args as $arg) {
			$path = CONFIG . DS . $arg . '.php';
			if(file_exists($path)) {
				include_once $path;
			}
		}
	}
}