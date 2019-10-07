<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');

App::import('Endereco', 'Model');
App::import('Pessoa', 'Model');

class EnderecoController extends AppController {
	
	public function beforeAction() {
		parent::beforeAction();
	}
	
	public function inserir(int $cps = null) {
		if(!$cps || !$pessoa = Pessoa::findById($cps)) {
			return $this->redirect("/");
		}
		
		$redirect = _isset($_GET["redirect"], "/");
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$data['cps'] = $cps;
			
			try {
				$endereco = Endereco::save($data);
				return $this->redirect($redirect);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('pessoa', $pessoa);
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
		$this->view->set('uf', Endereco::uf());
		$this->view->set("redirect", $redirect);
	}
	
	public function editar($cpsend = null) {
		if(!$cpsend || !$endereco = Endereco::findById($cpsend)) {
			return $this->redirect("/");
		}
		
		$redirect = _isset($_GET["redirect"], "/");
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$data["cpsend"] = $cpsend;
			$data["cps"] = $endereco["cps"];
			try {
				Endereco::save($data);
				return $this->redirect($redirect);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('endereco', $endereco);
		$this->view->set('tipos_endereco', Endereco::tipoEndereco());
		$this->view->set('uf', Endereco::uf());
		$this->view->set("redirect", $redirect);
	}
	
	public function remover(int $cpsend = null) {
		$this->autoRender = false;
		
		if(!$cpsend || !$endereco = Endereco::findById($cpsend)) {
			return $this->redirect("/");
		}
		
		$redirect = _isset($_GET["redirect"], "/");
		
		$endereco = Endereco::remover($cpsend);
		
		$this->redirect($redirect);
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