<?php
App::import('AppController', 'Controller');

App::import('FornecedorPJ', 'Model');
App::import('Contato', 'Model');
App::import('FornecedorPF', 'Model');
App::import('TipoFornecedor', 'Model');

App::import('TipoTelefone', 'Model');
App::import('Telefone', 'Model');
App::import('Endereco', 'Model');

App::import('Ocorrencia', 'Model');

class FornecedorController extends AppController {
	public function index() {
		$this->redirect('/fornecedor/fornecedores_pj');
	}
	
	public function fornecedores_pj() {
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
			$list = FornecedorPJ::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zfornec.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = FornecedorPJ::search($search_value, 'count', array('conditions' => ' AND zfornec.ativo = '.$ativo));
		}
		else {
			$list = FornecedorPJ::find('all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zfornec.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = FornecedorPJ::find('count', array('conditions' => ' AND zfornec.ativo = '.$ativo));
		}
		
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function fornecedores_pf() {
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
			$list = FornecedorPF::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zfornec.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = FornecedorPF::search($search_value, 'count', array('conditions' => ' AND zfornec.ativo = '.$ativo));
		}
		else {
			$list = FornecedorPF::find('all', array('page' => $page, 'limit' => $limit, 'conditions' => ' AND zfornec.ativo = '.$ativo, 'order' => _isset($order_values[$order], $order_values['default'])));
			$count = FornecedorPF::find('count', array('conditions' => ' AND zfornec.ativo = '.$ativo));
		}
		
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function overview_pj(int $cps = null) {
		if(!$cps || !$fornecedor = FornecedorPJ::findByCps($cps)) {
			return $this->redirect('/fornecedor/fornecedores_pj');
		}
		
		$fornecedor['contatos'] = Contato::findByCpsConta($fornecedor['cps']);
		
		$fornecedor['telefones'] = Telefone::findByCps($fornecedor['cps']);
		$fornecedor['enderecos'] = Endereco::findByCps($fornecedor['cps']);
		
		$this->view->set('fornecedor', $fornecedor);
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($fornecedor['cps']));
	}
	
	public function overview_pf(int $cps = null) {
		if(!$cps || !$fornecedor = FornecedorPF::findByCps($cps)) {
			return $this->redirect('/fornecedor/fornecedores_pf');
		}
		
		$fornecedor['telefones'] = Telefone::findByCps($fornecedor['cps']);
		$fornecedor['enderecos'] = Endereco::findByCps($fornecedor['cps']);
		
		$this->view->set('fornecedor', $fornecedor);
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($fornecedor['cps']));
	}
	
	public function tornar_cliente(int $cps){
		if(!$cps || !$fornecedor = FornecedorPF::findByCps($cps)) {
			return $this->redirect('/fornecedor/fornecedores_pf/');
		}
		if($fornecedor = FornecedorPF::findByCps($cps)) {
			$cliente = FornecedorPF::tornarCliente($cps);
			return $this->redirect('/painel/overview_pf/' . $cliente['cps']);
		}
	}
	
	public function inserir_pj() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$fornecedor = FornecedorPJ::save($data);
				return $this->redirect('/fornecedor/overview_pj/' . $fornecedor['cps']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('tipos_fornecedor', TipoFornecedor::find());
		$this->view->set('tipos_telefone', TipoTelefone::find());
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
	}
	
	public function inserir_pf() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$fornecedor = FornecedorPF::save($data);
				return $this->redirect('/fornecedor/overview_pf/' . $fornecedor['cps']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('tipos_fornecedor', TipoFornecedor::find());
		$this->view->set('tipos_telefone', TipoTelefone::find());
	}
	
	public function editar_pj(int $cps = null){
		if(!$cps || !$fornecedor = FornecedorPJ::findByCps($cps)) {
			return $this->redirect('/fornecedor/fornecedores_pj');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$fornecedor['nps'] = _isset($data['nps'], $fornecedor['nps']);
			$fornecedor['espec'] = _isset($data['espec'], $fornecedor['espec']);
			$fornecedor['ctfornec'] = _isset($data['ctfornec'], $fornecedor['ctfornec']);
			$fornecedor['cnpj'] = _isset($data['cnpj'], $fornecedor['cnpj']);
			$fornecedor['ativo'] = _isset($_POST['ativo'], $fornecedor['ativo']);
			$fornecedor['telefones'] = _isset($data['telefones'], array());
			try {
				FornecedorPJ::save($fornecedor);
				return $this->redirect('/fornecedor/overview_pj/' . $cps);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$fornecedor['telefones'] = FornecedorPJ::telefones($fornecedor['cps']);
		$fornecedor['enderecos'] = FornecedorPJ::enderecos($fornecedor['cps']);
		
		$this->view->set('fornecedor', $fornecedor);
		$this->view->set('tipos_fornecedor', TipoFornecedor::find());
		$this->view->set('tipos_telefone', TipoTelefone::find());
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
	}
	
	public function editar_pf(int $cps = null){
		if(!$cps || !$fornecedor = FornecedorPF::findByCps($cps)) {
			return $this->redirect('/fornecedor/fornecedores_pf');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$fornecedor['nps'] = _isset($data['nps'], $fornecedor['nps']);
			$fornecedor['ctfornec'] = _isset($data['ctfornec'], $fornecedor['ctfornec']);
			$fornecedor['cpf'] = _isset($data['cpf'], $fornecedor['cpf']);
			$fornecedor['rg'] = _isset($data['rg'], $fornecedor['rg']);
			$fornecedor['email'] = _isset($data['email'], $fornecedor['email']);
			$fornecedor['telefones'] = isset($_POST['telefones'])? $_POST['telefones'] : $fornecedor['telefones'];
			$fornecedor['ativo'] = _isset($_POST['ativo'], $fornecedor['ativo']);
			try {
				FornecedorPF::save($fornecedor);
				return $this->redirect('/fornecedor/overview_pf/' . $cps);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$fornecedor['telefones'] = Telefone::findByCps($fornecedor['cps']);
		
		$this->view->set('fornecedor', $fornecedor);
		$this->view->set('tipos_fornecedor', TipoFornecedor::find());
		$this->view->set('tipos_telefone', TipoTelefone::find());
	}
	
	public function ajax_cps_to_fornec($cps = null) {
		$this->autoRender = false;
		
		if($cps && FornecedorPJ::cps_to_fornec($cps)) {
			echo 'SUCCESS';
		}
		else {
			echo 'FAIL';
		}
	}
}