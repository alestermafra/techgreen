<?php

if(!defined('CONFIG')) {
	define('CONFIG', APP . DS . 'Config');
}

require LIB . DS . 'basics.php';
require LIB . DS . 'Core' . DS . 'App.php';
	
	/* registra o cara que vai procurar e fazer o include das classes */
	spl_autoload_register(array('App', 'load')); /* metodo load da classe App */
	
	//error_reporting(E_ALL);
	
	require APP . DS . 'Config' . DS . 'routes.php';
	require APP . DS . 'lib' . DS . 'custom.php';