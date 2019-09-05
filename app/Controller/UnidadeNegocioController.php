<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');
App::import('Unidade', 'Model');
App::import('UnidadeNegocio', 'Model');
App::import('NivelAcesso', 'Model');


class UnidadeNegocioController extends AppController {
	
	public function index(){
		$this->redirect('/UnidadeNegocio/lista');
	}
	
	public function lista(int $page = 1, int $limit = 10) {
		$user = Auth::user();
		
		$lista = UnidadeNegocio::find($user, 'all', array('page' => $page, 'limit' => $limit));
		$qtd = UnidadeNegocio::find($user, 'count'); //qtd registros
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
		
		$unidades = Unidade::find($user);
		
		$this->view->set('unidades', $unidades);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$cun = (int) $_POST['cun'];
		$sung = (string) $_POST['sung'];
		$nung = (string) $_POST['nung'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];	
		
		UnidadeNegocio::insert(
			array(
				'cun' => $cun,
				'sung' => $sung,
				'nung' => $nung,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			)
		);
		$this->redirect('/UnidadeNegocio');
	}
	
	public function editar(int $cung){
		$user = Auth::user();
		
		$unidadeNegocio = UnidadeNegocio::get($user, $cung);
		$unidades = Unidade::find($user);
		
		$this->view->set('unidadeNegocio', $unidadeNegocio);
		$this->view->set('unidades', $unidades);
	}
	
	public function confirmarEdicao(){
		$user = Auth::user();
		
		$cun = (int) $_POST['cun'];
		$cung = (int) $_POST['cung'];
		$sung = (string) $_POST['sung'];
		$nung = (string) $_POST['nung'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$unidadeNegocio = UnidadeNegocio::update(
			array(
				'cun' => $cun,
				'sung' => $sung,
				'nung' => $nung,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			),
			"cung = $cung"
		);
		$this->redirect('/UnidadeNegocio');
	}
	
	
	
	public function ajax_combo(int $cun = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		if($user['cna'] < NivelAcesso::UNIDADE && $cun) {
			$user['cun'] = $cun;
		}
		
		$this->view->set('cung', $user['cung']);
		$this->view->set('unglist', UnidadeNegocio::ativos($user));
	}
	
	public function ajax_combo_0(int $cun = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($cun) {
			$user['cun'] = $cun;
		}
		
		$unglist = UnidadeNegocio::ativos($user);
		
		$this->view->set('unglist', $unglist);
	}
}