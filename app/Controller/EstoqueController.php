<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');

App::import('Estoque', 'Model');
App::import('Produto', 'Model');
App::import('Linha', 'Model');

class EstoqueController extends AppController {
	
	public function movimentacao() {
		$search_value = _isset($_GET['search_value'], null);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = Estoque::search($search_value, 'all', array('page' => $page, 'limit' => $limit) );
			$count = Estoque::search($search_value, 'count');
		} else {
			$list = Estoque::find('all', array('page' => $page, 'limit' => $limit));
			$count = Estoque::find('count');
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	//------------------------------------------------------------------------
	public function produtos() {
		$search_value = _isset($_GET['search_value'], null);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = Produto::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'condition' => ' AND escat.cscat = 2 '));
			$count = Produto::search($search_value, 'count', array('condition' => ' AND escat.cscat = 2 '));
		} else {
			$list = Produto::findByCscat(2, 'all', array('page' => $page, 'limit' => $limit));
			$count = Produto::findByCscat(2, 'count');
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	//------------------------------------------------------------------------
	public function linhas() {
		$search_value = _isset($_GET['search_value'], null);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
				
		if($search_value) {
			$list = Linha::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'condition' => ' AND escat.cscat = 2 '));
			$count = Linha::search($search_value, 'count', array('condition' => ' AND escat.cscat = 2 '));
		} else {
			$list = Linha::findByCscat(2, 'all', array('page' => $page, 'limit' => $limit));
			$count = Linha::findByCscat(2, 'count');
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	//------------------------------------------------------------------------
	public function inserir_linha() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$linha = Linha::save($data); 
				return $this->redirect('/estoque/linhas/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
	}
	//------------------------------------------------------------------------	
	public function editar_linha(int $clinha = null){
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				Linha::save($data);
				return $this->redirect('/estoque/linhas/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		else if($clinha === null) {
			return $this->redirect('/estoque/linhas/');
		}
				
		$this->view->set('linha', Linha::findById($clinha));
	}
	//------------------------------------------------------------------------
	public function inserir_produto() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$produto = Produto::save($data); 
				return $this->redirect('/estoque/inserir_estoque/'.$produto['cprod']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('linhas', Linha::findByCscat(2));
	}
	//------------------------------------------------------------------------	
	public function editar_produto(int $cprod = null){
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$produto = Produto::save($data);
				return $this->redirect('/estoque/produtos/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
				$cprod = $data['cprod'];
			}
		}
		else if($cprod === null) {
			return $this->redirect('/estoque/produtos/');
		}
				
		$this->view->set('produto', Produto::findById($cprod));
		$this->view->set('linhas', Linha::findByCscat(2));
	}
	//------------------------------------------------------------------------	
	public function inserir_estoque(int $cprod = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$estoque = Estoque::save($data); 
				return $this->redirect('/estoque/movimentacao/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('cprod', $cprod);
		$this->view->set('produtos', Estoque::produtos());
	}
	//------------------------------------------------------------------------	
	public function editar_estoque(int $cstoque = null){
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$estoque = Estoque::save($data);
				return $this->redirect('/estoque/movimentacao/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
				$cstoque = $data['cstoque'];
			}
		}
		else if($cstoque === null) {
			return $this->redirect('/estoque/movimentacao');
		}
		
		$estoque = Estoque::findById($cstoque);
		
		$this->view->set('estoque', $estoque);
	}
	
}