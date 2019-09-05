<?php
App::import('Router', 'Core');

class Request {
	
	/*
	$base: base da url. A pasta root. Por exemplo, se o sistema está na pasta /mgold, $base = '/mgold'. Se estiver em /, $base = '/'
	*/
	public $base;
	
	/*
	$url: armazena o restante da url após a base.
	*/
	public $url;
	
	/*
	$method: armazena a request method.
	*/
	public $method;
	
	/*
	$params: armazena o controle, ação e argumentos.
	*/
	public $params;
	
	public function __construct() {
		$this->base = $this->_base();
		$this->url = $this->_url();
		$this->method = $this->_method();
		$this->params = Router::parse($this->url);
	}
	
	private function _base() {
		$base = dirname($_SERVER['PHP_SELF']);
		
		if('webroot' === basename($base)) {
			$base = dirname($base);
		}
		if('app' === basename($base)) {
			$base = dirname($base);
		}
		if($base === '/' || $base === '\\') {
			$base = '';
		}
		
		return $base;
	}
	
	private function _url() {
		$url = $_SERVER['REQUEST_URI'];
		$base = $this->base;
		
		$url = preg_replace('#/+#', '/', $url); /* Remove as barras duplas. */
		
		if($base !== '') {
			if(strpos($url, $base) !== false) {
				$url = substr($url, strlen($base));
			}
		}
		
		return $url;
	}
	
	private function _method() {
		return $_SERVER['REQUEST_METHOD'];
	}
}