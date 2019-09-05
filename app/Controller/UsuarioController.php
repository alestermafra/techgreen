<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

App::import('Usuario', 'Model');
App::import('NivelAcesso', 'Model');

class UsuarioController extends AppController {
	
	public function index() {
		$this->redirect('/usuario/lista');
	}
	
	public function lista() {
		$search_value = _isset($_GET['search_value'], null);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = Usuario::search($search_value, 'all', array('page' => $page, 'limit' => $limit) );
			$count = Usuario::search($search_value, 'count');
		} else {
			$list = Usuario::find( 'all', array( 'page' => $page, 'limit' => $limit ) );
			$count = Usuario::find('count');
		}

		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function inserir() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$usuario = Usuario::save($data);
				return $this->redirect('/usuario/lista');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('niveis_acesso', NivelAcesso::find());
	}

	
	public function editar(int $cusu = null) {
		if($cusu === null || !$usuario = Usuario::findById($cusu)) {
			return $this->redirect('/usuario/lista');
		}
		
		if($this->request->method === 'POST') {
			$usuario['nps'] = _isset($_POST['nps'], $usuario['nps']);
			$usuario['lg'] = _isset($_POST['lg'], $usuario['lg']);
			$usuario['pwd'] = _isset($_POST['pwd'], $usuario['pwd']);
			$usuario['email'] = _isset($_POST['email'], $usuario['email']);
			$usuario['cna'] = _isset($_POST['cna'], $usuario['cna']);
			try {
				Usuario::save($usuario);
				return $this->redirect('/usuario/lista');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('usuario', Usuario::findById($cusu));
		$this->view->set('niveis_acesso', NivelAcesso::find());
	}
	
	public function alterar_senha() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				Usuario::savePwd($data);
				return $this->redirect('/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$user = Auth::user();
		$this->view->set('usu', Usuario::find('first', array('conditions' => ' AND susu.cps = '.$user['cps'])));
	}
	
}