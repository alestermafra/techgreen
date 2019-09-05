<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

class LoginController extends AppController {
	
	public function beforeAction() {
		/* permite somente as seguintes acoes enquanto o cara não estiver logado */
		Auth::allow(array('index', 'login', 'logout', 'server'));
		parent::beforeAction();
	}
	
	public function index($err = null) {
		/* se estiver logado manda pra pagina de redirecionamento configurada na Auth */
		if(Auth::is_logged())
			return $this->redirect(Auth::$login_redirect);
		
		$this->layout = 'login';
	}
	
	public function server() {
		$this->autoRender = false;
		
		var_dump($_SERVER);
	}
	
	public function login() {
		if(Auth::is_logged())
			return $this->redirect(Auth::$login_redirect);
		
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		if(Auth::login($login, $password)) {
			$redirect_url = _isset($_GET['redirect'], Auth::$login_redirect);
			return $this->redirect($redirect_url);
		}
		$this->redirect('/login');
	}
	
	public function logout() {
		Auth::logout();
		$this->redirect(Auth::$logout_redirect);
	}
}