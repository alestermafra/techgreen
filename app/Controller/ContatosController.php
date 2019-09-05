<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');

App::import('Pessoa', 'Model');
App::import('Contato', 'Model');

class ContatosController extends AppController {	
	public function inserir($cps_conta = null) {
		if(!$cps_conta || !($pessoa = Pessoa::findById($cps_conta))) {
			return $this->redirect('/');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$data['cps_conta'] = $cps_conta;
			try {
				Contato::save($data);
				return $this->back($pessoa);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('pessoa', $pessoa);
		$this->view->set('contatos', Contato::findByCpsConta($cps_conta));
	}
	
	public function editar($cccon = null) {
		if(!$cccon || !$contato = Contato::findById($cccon)) {
			return $this->redirect('/');
		}
		
		if($this->request->method === 'POST') {
			$data = $_POST;
			$contato['nps'] = _isset($data['nps'], $contato['nps']);
			$contato['profissao'] = _isset($data['profissao'], $contato['profissao']);
			$contato['email'] = _isset($data['email'], $contato['email']);
			$contato['telefones'] = _isset($data['telefones'], array());
			$contato['RA'] = _isset($data['RA'], $contato['RA']);
			try {
				Contato::save($contato);
				return $this->back(Pessoa::findById($contato['cps_conta']));
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('contato', $contato);
	}
	
	public function back($pessoa) {
		if(!is_array($pessoa)) {
			$pessoa = Pessoa::findById($pessoa);
		}
		if(isset($pessoa['czpainel']) && $pessoa['czpainel']) {
			return $this->redirect('/painel/overview_pj/' . $pessoa['cps']);
		}
		else if(isset($pessoa['czfornec']) && $pessoa['czfornec']) {
			return $this->redirect('/fornecedor/overview_pj/' . $pessoa['cps']);
		}
		else {
			return $this->redirect('/');
		}
	}
}