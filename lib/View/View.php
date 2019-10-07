<?php

class View {
	
	/* nome da view/arquivo */
	public $name;
	
	/* controlador */
	public $controller;
	
	/* variaveis que a view irá usar. atribua uma variavel com a função set. */
	public $vars = [];
	
	public function __construct($name = null, $controller = null) {
		$this->name = $name;
		$this->controller = $controller;
	}
	
	public function set($var, $value) {
		$this->vars += array($var => $value);
	}
	
	/* inclui o arquivo da view */
	public function render() {
		extract($this->vars);
		$viewPath = $this->_getViewPath();
		ob_start();
		include $viewPath;
		$content = ob_get_contents();
		ob_end_clean();
		if($this->controller && $this->controller->layout !== false) {
			$content_for_layout = $content;
			include APP . DS . 'View' . DS . 'layouts' . DS . $this->controller->layout . '.php';
		}
		else {
			echo $content;
		}
	}
	
	/* insere um elemento na view */
	public function element($element, $vars = null) {
		if($vars) {
			extract($vars);
		}
		ob_start();
		include APP . DS . 'View' . DS . 'elements' . DS . $element . '.php';
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	/* insere o template de email na view */
	public function email($email) {
		extract($this->vars);
		ob_start();
		include APP . DS . 'View' . DS . 'emails' . DS . $email . '.php';
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	private function _getViewPath() {
		$paths = [];
		return APP . DS . 'View' . DS . $this->controller->name . DS . $this->name . '.php';
	}
	
	/* utils */
	public function url(string $url) {
		return $this->controller->request->base . $url;
	}
}