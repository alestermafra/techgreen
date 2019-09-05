<?php
App::import('AppController', 'Controller');

App::import('Auth', 'Model');
App::import('Regiao', 'Model');
App::import('Distrito', 'Model');
App::import('NivelAcesso', 'Model');

class DistritoController extends AppController {
	
	public function index(){
		$this->redirect('/distrito/lista');
	}
	
	public function lista($page = 1, $limit = 10) {
		$user = Auth::user();
		
		$lista = Distrito::find($user, 'all', array('page' => $page, 'limit' => $limit));
		$qtd = Distrito::find($user, 'count'); //qtd registros
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
		
		$regioes = Regiao::find($user);
		
		$this->view->set('regioes', $regioes);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$crei = (int) $_POST['crei'];
		$sdio = (string) $_POST['sdio'];
		$ndio = (string) $_POST['ndio'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];	
		
		Distrito::insert(
			array(
				'crei' => $crei,
				'sdio' => $sdio,
				'ndio' => $ndio,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			)
		);
		$this->redirect('/distrito');
	}
	
	public function editar($cdio){
		$user = Auth::user();
		
		$distrito = Distrito::get($user, $cdio);
		$regioes = Regiao::find($user);

		$this->view->set('distrito', $distrito);
		$this->view->set('regioes', $regioes);
	}
	
	public function confirmarEdicao(){
		$user = Auth::user();
		
		$crei = (int) $_POST['crei'];
		$cdio = (int) $_POST['cdio'];
		$sdio = (string) $_POST['sdio'];
		$ndio = (string) $_POST['ndio'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$distrito = Distrito::update(
			array(
				'crei' => $crei,
				'sdio' => $sdio,
				'ndio' => $ndio,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			),
			"cdio = $cdio"
		);
		$this->redirect('/distrito');
	}
	
	public function pesquisar() {
		
	}
	
	public function listar_pesquisa() {
		$user = Auth::user();
		
		$cdio = _isset($_POST['cdio'], null);
		$ndio = _isset($_POST['ndio'], null);
		
		if(!$cdio and !$ndio) {
			return $this->redirect('/distrito/pesquisar');
		}
		
		$cdio = (int) $cdio;
		$ndio = (string) $ndio;
		
		$lista = Distrito::search($user, $cdio, $ndio);
		
		$this->view->set('lista', $lista);
	}
	
	public function ajax_combo(int $crei = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($user['cna'] < NivelAcesso::DISTRITO && $crei) {
			$user['crei'] = $crei;
		}
		
		$this->view->set('cdio', $user['cdio']);
		$this->view->set('diolist', Distrito::ativos($user));
	}
	
	public function ajax_combo_0(int $crei = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($crei) {
			$user['crei'] = $crei;
		}
		
		$diolist = Distrito::ativos($user);
		
		$this->view->set('diolist', $diolist);
	}
}