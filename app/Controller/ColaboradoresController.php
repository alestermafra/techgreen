<?php
App::import('AppController', 'Controller');

App::import('ColaboradorPF', 'Model');

App::import('TipoTelefone', 'Model');
App::import('Telefone', 'Model');
App::import('Endereco', 'Model');

App::import('Ocorrencia', 'Model');

class ColaboradoresController extends AppController {
	public function index() {
		$this->redirect('/colaboradores/colaboradores_pf');
	}
	
	public function colaboradores_pf() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'nome');
		$order_values = array(
			'default' => 'eps.nps',
			'nome' => 'eps.nps',
			'data' => 'eps.ts',
		);
		
		$ativo = _isset($_GET['ativo'], 1);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = ColaboradorPF::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zcolab.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = ColaboradorPF::search($search_value, 'count', array('conditions' => ' AND zcolab.ativo = '.$ativo));
		}
		else {
			$list = ColaboradorPF::find('all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zcolab.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = ColaboradorPF::find('count', array('conditions' => ' AND zcolab.ativo = '.$ativo));
		}
		
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function overview_pf(int $cps = null) {
		if(!$cps || !$colaborador = ColaboradorPF::findByCps($cps)) {
			return $this->redirect('/colaboradores/colaboradores_pf');
		}
		
		$colaborador['telefones'] = Telefone::findByCps($colaborador['cps']);
		$colaborador['enderecos'] = Endereco::findByCps($colaborador['cps']);
		
		$this->view->set('colaborador', $colaborador);
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($colaborador['cps']));
	}
	
	public function inserir_pf() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$colaborador = ColaboradorPF::save($data);
				return $this->redirect('/colaboradores/overview_pf/' . $colaborador['cps']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('tipos_telefone', TipoTelefone::find());
	}
	
	public function editar_pf(int $cps = null){
		if(!$cps || !$colaborador = ColaboradorPF::findByCps($cps)) {
			return $this->redirect('/colaboradores/colaboradores_pf');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$colaborador['nps'] = _isset($data['nps'], $colaborador['nps']);
			$colaborador['cpf'] = _isset($data['cpf'], $colaborador['cpf']);
			$colaborador['rg'] = _isset($data['rg'], $colaborador['rg']);
			$colaborador['email'] = _isset($data['email'], $colaborador['email']);
			$colaborador['telefones'] = isset($_POST['telefones'])? $_POST['telefones'] : $colaborador['telefones'];
			$colaborador['ativo'] = _isset($_POST['ativo'], $colaborador['ativo']);
			$colaborador['d_nasc'] = _isset($_POST['d_nasc'], $colaborador['d_nasc']);
			$colaborador['m_nasc'] = _isset($_POST['m_nasc'], $colaborador['m_nasc']);
			$colaborador['a_nasc'] = _isset($_POST['a_nasc'], $colaborador['a_nasc']);
			try {
				ColaboradorPF::save($colaborador);
				return $this->redirect('/colaboradores/overview_pf/' . $cps);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$colaborador['telefones'] = Telefone::findByCps($colaborador['cps']);
		
		$this->view->set('colaborador', $colaborador);
		$this->view->set('tipos_telefone', TipoTelefone::find());
	}
}