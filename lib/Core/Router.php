<?php
class Router {
	
	private static $routes = [];
	
	public static function parse(string $url) {
		if(isset(static::$routes[$url])) {
			return static::$routes[$url];
		}
		
		return static::_parse($url);
	}
	
	private static function _parse($url) {
		$url = trim($url, '/'); /* remove barra do inicio e do fim */
		
		/* verifica se tem ? de atributos GET */
		$pos = strpos($url, '?');
		if($pos !== false) {
			$url = substr($url, 0, $pos);
		}
		
		/* separa a url para obter o controlador e a ação */
		$exploded_url = explode('/', $url);
		
		$out = array(
			'controller' => '/',
			'action' => 'index',
			'args' => array()
		);
		$out['controller'] = $exploded_url[0];
		if(count($exploded_url) > 1) {
			$out['action'] = $exploded_url[1];
			$out['args'] = array_slice($exploded_url, 2);
		}
		
		return $out;
	}
	
	public static function connect($alias, $route) {
		$route = static::_parse($route);
		static::$routes[$alias] = $route;
	}
}