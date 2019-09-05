<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

App::import('Produto', 'Model');
App::import('ProdutoDetalhe', 'Model');
App::import('Tabela', 'Model');
App::import('Plano', 'Model');

class ServicosController extends AppController {
	
	public function index() {
		$search_value = _isset($_GET['search_value'], null);
		
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => ' eprod.nprod ASC ',
			'produto' => ' eprod.nprod ASC ',
			'linha' => ' elinha.nprod ASC ',
			'subcategoria' => ' escat.nscat ASC ',
		);
		
		$filter = " AND escat.cscat NOT IN (2) ";
		if(($clinha = (int) _isset($_GET['linha'], 0)) !== 0) {
			$filter .= " AND elinha.clinha = $clinha ";
		}
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = Produto::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Produto::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = Produto::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Produto::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
		
		$this->view->set('linhas', Produto::find('all', array('conditions' => ' AND escat.cscat NOT IN (2) ', 'group' => ' elinha.clinha ', 'order' => 'escat.nscat')));
	}
	//----------------------------------------------------------------------------------------------
	public function precos() {
		$search_value = _isset($_GET['search_value'], null);
		
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => ' eprod.nprod ASC ',
			'produto' => ' eprod.nprod ASC ',
			'linha' => ' elinha.nprod ASC ',
			'valor_asc' => ' eprodd.valor ASC ',
			'valor_desc' => ' eprodd.valor DESC ',
			'plano' => ' eplano.nplano ASC ',
			'tabela' => ' etabela.ntabela ASC ',
		);
		
		$filter = " AND elinha.cscat NOT IN (2) ";
		if(($clinha = (int) _isset($_GET['linha'], 0)) !== 0) {
			$filter .= " AND elinha.clinha = $clinha ";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano ";
		}
		if(($ctabela = (int) _isset($_GET['tabela'], 0)) !== 0) {
			$filter .= " AND etabela.ctabela = $ctabela ";
		}
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = ProdutoDetalhe::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = ProdutoDetalhe::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = ProdutoDetalhe::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = ProdutoDetalhe::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
		
		$this->view->set('tabela', Tabela::find());
		$this->view->set('plano', Plano::find());
		$this->view->set('linhas', Produto::find('all', array('conditions' => ' AND escat.cscat NOT IN (2) ', 'group' => ' elinha.clinha ', 'order' => 'escat.nscat')));
	}
	//----------------------------------------------------------------------------------------------
	public function editar(int $cprod = null){
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				Produto::save($data);
				return $this->redirect('/servicos/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		else if($cprod === null) {
			return $this->redirect('/servicos/');
		}
		
		$this->view->set('produto', Produto::findById($cprod));
	}
	//----------------------------------------------------------------------------------------------
	public function editar_precos(int $cprodd = null){
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$cprodd = $data['cprodd'];
				ProdutoDetalhe::save($data);
				return $this->redirect('/servicos/precos/');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		else if($cprodd === null) {
			return $this->redirect('/servicos/precos/');
		}
		
		$this->view->set('produto', ProdutoDetalhe::findById($cprodd));
	}
	//----------------------------------------------------------------------------------------------
}