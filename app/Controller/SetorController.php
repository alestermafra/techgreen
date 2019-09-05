<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');
App::import('Distrito', 'Model');
App::import('Setor', 'Model');
App::import('NivelAcesso', 'Model');

class SetorController extends AppController {
	
	public function index(){
		$this->redirect('/setor/lista');
	}
	
	public function lista(int $page = 1, int $limit = 10) {
		$user = Auth::user();
		
		$lista = Setor::find($user, 'all', array('page' => $page, 'limit' => $limit));
		$qtd = Setor::find($user, 'count');
		$qtd_p = ceil(($qtd / $limit)); //qtd de paginas
		$inicio = ceil($page - 2); // inicio para paginação
		$fim = ceil($page + 3); //fim para paginação
		
		$this->view->set('page', $page);
		$this->view->set('inicio', $inicio);
		$this->view->set('fim', $fim);
		$this->view->set('lista', $lista);		
		$this->view->set('qtd_p', $qtd_p);
	}
	
	public function inserir(){
		$user = Auth::user();
		
		$distritos = Distrito::find($user);
		
		$this->view->set('distritos', $distritos);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$cdio = (int) $_POST['cdio'];
		$sset = (string) $_POST['sset'];
		$nset = (string) $_POST['nset'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		Setor::insert(
			array(
				'cdio' => $cdio,
				'sset' => $sset,
				'nset' => $nset,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			)
		);
		$this->redirect('/setor');
	}
	
	public function editar(int $cset){
		$user = Auth::user();
		
		$setor = Setor::get($user, $cset);
		$distritos = Distrito::find($user);
		
		$this->view->set('setor', $setor);
		$this->view->set('distritos', $distritos);
	}
	
	public function confirmarEdicao(){
		$user = Auth::user();
		
		$cset = (int) $_POST['cset'];
		$cdio = (int) $_POST['cdio'];
		$sset = (string) $_POST['sset'];
		$nset = (string) $_POST['nset'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$setor = Setor::update(
			array(
				'cdio' => $cdio,
				'sset' => $sset,
				'nset' => $nset,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			),
			"cset = $cset"
		);
		$this->redirect('/setor');
	}
	
	public function pesquisar() {

	}
	
	public function listar_pesquisa() {
		$user = Auth::user();
		
		$cset = _isset($_POST['cset'], null);
		$nset = _isset($_POST['nset'], null);
		
		if(!$cset and !$nset) {
			return $this->redirect('/setor/pesquisar');
		}
		
		$cset = (int) $cset;
		$nset = (string) $nset;
		
		$lista = Setor::search($user, $cset, $nset);
		
		$this->view->set('lista', $lista);
	}
	
	public function ajax_combo(int $cdio = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($user['cna'] < NivelAcesso::SETOR && $cdio) {
			$user['cdio'] = $cdio;
		}
		
		$this->view->set('cset', $user['cset']);
		$this->view->set('setlist', Setor::ativos($user));
	}
	
	public function ajax_combo_0(int $cdio = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($cdio) {
			$user['cdio'] = $cdio;
		}
		
		$setlist = Setor::ativos($user);
		
		$this->view->set('setlist', $setlist);
	}
	
}