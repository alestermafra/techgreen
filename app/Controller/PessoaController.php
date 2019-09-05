<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

App::import('Unidade', 'Model');
App::import('Pessoa', 'Model');
	
class PessoaController extends AppController {
	
	public function index() {
		$this->redirect('/pessoa/lista');
	}
	
	public function lista(int $page = 1, int $limit = 10) {
		$user = Auth::user();
		
		$lista = Pessoa::find($user, 'all', array('page' => $page, 'limit' => $limit, 'conditions' => " AND eps.cps != {$user['cps']}"));
		$total = Pessoa::find($user, 'count', array('conditions' => " AND eps.cps != {$user['cps']}")); //qtd registros
		$paginas = ceil(($total / $limit)); //qtd de paginas
		
		$this->view->set('lista', $lista);
		$this->view->set('total', $total);
		$this->view->set('paginas', $paginas);
		$this->view->set('page', $page);
	}
	
	public function inserir() {
		$user = Auth::user();
		
		$unidades = Unidade::find($user);

		$this->view->set('unidades', $unidades);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$cun = (int) $_POST['cun'];
		$sps = (string) $_POST['sps'];
		$nps = (string) $_POST['nps'];
		$flg_sys = (int) isset($_POST['flg_sys']);
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		Pessoa::insert(
			array(
				'cun' => $cun,
				'sps' => $sps,
				'nps' => $nps,
				'flg_sys' => $flg_sys,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR,
			)
		);
		
		$this->redirect('/pessoa');
	}
	
	public function editar(int $cps) {
		$user = Auth::user();
		
		$pessoa = Pessoa::get($user, $cps);
		$unidades = Unidade::find($user);
		
		$this->view->set('pessoa', $pessoa);
		$this->view->set('unidades', $unidades);
	}
	
	public function confirmarEdicao() {
		$user = Auth::user();
		
		$cun = (int) $_POST['cun'];
		$cps = (int) $_POST['cps'];
		$sps = (string) $_POST['sps'];
		$nps = (string) $_POST['nps'];
		$flg_sys = (int) isset($_POST['flg_sys']);
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$pessoa = Pessoa::update(
			array(
				'cun' => $cun,
				'sps' => $sps,
				'nps' => $nps,
				'flg_sys' => $flg_sys,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR,
			),
			"cps = $cps"
		);
		
		$this->redirect('/pessoa');
	}
	
	public function pesquisar() {

	}
	
	public function listar_pesquisa() {
		$user = Auth::user();
		
		$cps = _isset($_POST['cps'], null);
		$nps = _isset($_POST['nps'], null);

		if(!$cps and !$nps) {
			return $this->redirect('/pessoa/pesquisar');
		}
		
		$cps = (int) $cps;
		$nps = (string) $nps;
		
		$lista = Pessoa::search($user, $cps, $nps);
		
		$this->view->set('lista', $lista);
	}
	
}