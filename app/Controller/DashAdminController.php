<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');
App::import('Usuario', 'Model');

class DashAdminController extends AppController {
	
	public function index() {
		$this->redirect('/DashAdmin/lista');
	}
	
	public function lista() {
		$user = Auth::user();
		
		$users = Usuario::find($user, 'all', array('order' => 'logado DESC, eps.nps ASC'));
		
		$this->view->set('lista', $users);
	}
}