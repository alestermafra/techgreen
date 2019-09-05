<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');

App::import('Endereco', 'Model');
App::import('Pessoa', 'Model');

class EnderecoController extends AppController {
	
	public function beforeAction() {
		Auth::allow(array('json_busca_cep'));
		parent::beforeAction();
	}
	
	public function inserir(int $cps = null) {
		if(!$cps || !$pessoa = Pessoa::findById($cps)) {
			return $this->redirect('/');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$data['cps'] = $cps;
			try {
				$endereco = Endereco::save($data);
				return $this->back($cps);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('pessoa', $pessoa);
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
		$this->view->set('uf', Endereco::uf());
	}
	
	public function editar(int $cpsend = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$endereco = Endereco::save($data);
				return $this->back($endereco['cps']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
				var_dump($e->getMessage()); die();
			}
			$cpsend = $data['cpsend'];
		}
		else if($cpsend === null) {
			return $this->redirect('/');
		}
		
		$endereco = Endereco::findById($cpsend);
		
		$this->view->set('endereco', $endereco);
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
		$this->view->set('uf', Endereco::uf());
	}
	
	public function remover(int $cpsend) {
		$this->autoRender = false;
		
		$endereco = Endereco::remover($cpsend);
		return $this->back($endereco['cps']);
	}
	
	public function back(int $cps) {
		$this->autoRender = false;
		
		$pessoa = Pessoa::findById($cps);
		$redirect = '';
		if(!$pessoa) {
			$redirect = '/';
		}
		else {
			if($pessoa['czpainel']) {
				$redirect = '/painel';
				if($pessoa['cpsf']) {
					$redirect .= '/overview_pf';
				}
				else if($pessoa['cpsj']) {
					$redirect .= '/overview_pj';
				}
			}
			else if($pessoa['czfornec']) {
				$redirect = '/fornecedor/overview_pf';
			}
			$redirect .= '/' . $cps;
		}
		
		return $this->redirect($redirect);
	}
	
	public function json_busca_cep($cep = null) {
		$this->autoRender = false;
		$dados_cep = [];
		if($cep) {
			$cep = trim($cep);
			$cep = str_replace('-', '', $cep);
			$dados_cep = Endereco::cep($cep);
		}
		
		echo json_encode($dados_cep);
		die();
	}
}