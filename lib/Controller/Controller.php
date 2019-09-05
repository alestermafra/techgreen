<?php
App::import('ControllerNotFoundException', 'Error');
App::import('PrivateMethodException', 'Error');
App::import('ActionNotFoundException', 'Error');

class Controller {
	public $name;
	
	public $request;
	
	public $view;
	
	public $layout = 'default';
	
	public $autoRender = true;
	
	
	public function __construct($name, $request) {
		$this->name = substr(get_class($this), 0, -10); /* -10 para remover o 'Controller' do nome da classe */
		$this->request = $request;
	}
	
	public function invokeAction($action, $args = []) {
		$reflectionMethod = null;
		try {
			$reflectionMethod = new ReflectionMethod($this, $action);
		}
		catch(Exception $e) {
			throw new ActionNotFoundException();
		}
		if($reflectionMethod->isPrivate()) {
			throw new PrivateMethodException();
		}
		$reflectionMethod->invokeArgs($this, $args);
	}
	
	public function redirect(string $url) {
		if(!preg_match('#^https?://#', $url)) {
			$url = $this->request->base . $url;
		}
		header('Location: ' . $url);
	}

	
	
	/* events */
	public function beforeAction() {}
	
	
	/* static functions */
	public static function getController($name) {
		$class = $name . 'Controller';
		App::import($class, 'Controller');
		if(class_exists($class)) {
			return $class;
		}
		throw new ControllerNotFoundException();
	}
}