<?php
App::import('AppController', 'Controller');

App::import('Ocorrencia', 'Model');

App::import('ClientePF', 'Model');
App::import('ClientePJ', 'Model');
App::import('Equipamento', 'Model');

class OcorrenciaController extends AppController {
	
	public function index() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'eocorrencia.data DESC',
			'nome' => 'eps.nps ASC',
			'equipamento' => 'eequipe.nome ASC',
			'data' => 'eocorrencia.data DESC',
		);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 30);
		
		$filter = '';
		if(($tipo = (string) _isset($_GET['tipo'], 0)) == "equipamento") {
			$filter .= " AND eocorrencia.ctocorrencia = 1 ";
		}
		if(($tipo = (string) _isset($_GET['tipo'], 0)) == "pessoa") {
			$filter .= " AND eocorrencia.ctocorrencia = 2 ";
		}
		
		if($search_value) {
			$list = Ocorrencia::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter,));
			$count = Ocorrencia::search($search_value, 'count', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter,));
		}
		else {
			$list = Ocorrencia::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter,));
			$count = Ocorrencia::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function inserir(string $target, int $cod, string $onde) {	
		$onde_link = str_replace('-','/',$onde); // corrigindo link
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$ocorrencia = Ocorrencia::save($data);
				return $this->redirect($onde_link);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		if($target == "pessoa"){
			$lista_cod = array_merge(ClientePF::find('all', array('order' => 'eps.nps')), ClientePJ::find('all', array('order' => 'eps.nps')));
		}
		else if($target == "equipamento"){
			$lista_cod = Equipamento::find('all', array('order' => 'eequipe.nome'));
		}
		
		$this->view->set('onde', $onde_link);
		$this->view->set('cod', $cod);
		$this->view->set('target', $target);
		$this->view->set('lista_cod', $lista_cod);		
	}	
	
	public function editar(int $cocorrencia, int $cod, string $onde){
		$ocorrencia = Ocorrencia::findById($cocorrencia);
		$onde_link = str_replace('-','/',$onde); // corrigindo link
		
		if(!$cocorrencia || !$ocorrencia = Ocorrencia::findById($cocorrencia)) {
			return $this->redirect($onde_link);
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$ocorrencia['ctocorrencia'] = _isset($data['ctocorrencia'], $ocorrencia['ctocorrencia']);
			$ocorrencia['codigo'] = _isset($data['codigo'], $ocorrencia['codigo']);
			$ocorrencia['assunto'] = _isset($data['assunto'], $ocorrencia['assunto']);
			$ocorrencia['descricao'] = _isset($data['descricao'], $ocorrencia['descricao']);
			$ocorrencia['data'] = _isset($data['data'], $ocorrencia['data']);
			try {
				Ocorrencia::save($ocorrencia);
				return $this->redirect($onde_link);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		if($ocorrencia['ctocorrencia'] == 2){
			$lista_cod = array_merge(ClientePF::find('all', array('order' => 'eps.nps')), ClientePJ::find('all', array('order' => 'eps.nps')));
		}
		else if($ocorrencia['ctocorrencia'] == 1){
			$lista_cod = Equipamento::find('all', array('order' => 'eequipe.nome'));
		}
		
		$this->view->set('ocorrencia', $ocorrencia);
		$this->view->set('onde', $onde_link);
		$this->view->set('cod', $cod);
		$this->view->set('lista_cod', $lista_cod);	
	}
	
}