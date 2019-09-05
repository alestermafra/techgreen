<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');
App::import('UnidadeNegocio', 'Model');
App::import('Regiao', 'Model');
App::import('NivelAcesso', 'Model');

class RegiaoController extends AppController {
	
	public function index(){
		$this->redirect('/regiao/lista');
	}
	
	public function lista(int $page = 1, int $limit = 10) {
		$user = Auth::user();
		
		$lista = Regiao::find($user, 'all', array('page' => $page, 'limit' => $limit));
		$qtd = Regiao::find($user, 'count'); //qtd registros
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
		
		$ungs = UnidadeNegocio::find($user);
		
		$this->view->set('ungs', $ungs);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$cung = (int) $_POST['cung'];
		$srei = (string) $_POST['srei'];
		$nrei = (string) $_POST['nrei'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];	
		
		Regiao::insert(
			array(
				'cung' => $cung,
				'srei' => $srei,
				'nrei' => $nrei,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			)
		);
		
		$this->redirect('/regiao');
	}
	
	public function editar(int $crei){
		$user = Auth::user();
		
		$regiao = Regiao::get($user, $crei);
		$ungs = UnidadeNegocio::find($user);
		
		$this->view->set('regiao', $regiao);
		$this->view->set('ungs', $ungs);
	}
	
	public function confirmarEdicao(){
		$user = Auth::user();
		
		$crei = (int) $_POST['crei'];
		$cung = (int) $_POST['cung'];
		$srei = (string) $_POST['srei'];
		$nrei = (string) $_POST['nrei'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$regiao = Regiao::update(
			array(
				'cung' => $cung,
				'srei' => $srei,
				'nrei' => $nrei,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			),
			"crei = $crei"
		);
		$this->redirect('/regiao');
	}	
	
	public function ajax_combo(int $cung = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($user['cna'] < NivelAcesso::REGIAO && $cung) {
			$user['cung'] = $cung;
		}
		
		$this->view->set('crei', $user['crei']);
		$this->view->set('reilist', $reilist = Regiao::ativos($user));
	}
	
	public function ajax_combo_0(int $cung = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($cung) {
			$user['cung'] = $cung;
		}
		
		$reilist = Regiao::ativos($user);
		
		$this->view->set('reilist', $reilist);
	}
	
}