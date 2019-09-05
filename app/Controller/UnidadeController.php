<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');
App::import('Entidade', 'Model');
App::import('Unidade', 'Model');
App::import('Idioma', 'Model');

class UnidadeController extends AppController {
	
	public function index(){
		$this->redirect('/unidade/lista');
	}
	
	public function lista(int $page = 1, int $limit = 10) {
		$user = Auth::user();
		
		$unidades = Unidade::find($user, 'all', array('page' => $page, 'limit' => $limit));
		$qtd = Unidade::find($user, 'count');
		$qtd_p = ceil(($qtd / $limit)); //qtd de paginas
		$inicio = ceil($page - 2); // inicio para paginação
		$fim = ceil($page + 3); //fim para paginação
		
		$this->view->set('page', $page);
		$this->view->set('inicio', $inicio);
		$this->view->set('fim', $fim);			
		$this->view->set('unidades', $unidades);
		$this->view->set('qtd_p', $qtd_p);
	}
	
	public function inserir(){
		$user = Auth::user();
		
		$entidades = Entidade::find($user);
		$idiomas = Idioma::find();
		
		$this->view->set('entidades', $entidades);
		$this->view->set('idiomas', $idiomas);
	}
	
	public function confirmarInsercao() {
		$user = Auth::user();
		
		$cen = (int) $_POST['cen'];
		$clang = (int) $_POST['clang'];
		$sun = (string) $_POST['sun'];
		$nun = (string) $_POST['nun'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);	
		$AR = (int) $user['cps'];
		
		Unidade::insert(
			array(
				'cen' => $cen,
				'clang' => $clang,
				'sun' => $sun,
				'nun' => $nun,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			)
		);
		
		$this->redirect('/unidade');
	}
	
	public function editar(int $cun){
		$user = Auth::user();
		
		$unidade = Unidade::get($user, $cun);
		$idiomas = Idioma::find();
		
		$this->view->set('unidade', $unidade);
		$this->view->set('idiomas', $idiomas);
	}
	
	public function confirmarEdicao(){
		$user = Auth::user();
		$cun = (int) $_POST['cun'];
		$clang = (int) $_POST['clang'];
		$sun = (string) $_POST['sun'];
		$nun = (string) $_POST['nun'];
		$OBS = (string) $_POST['OBS'];
		$RA = (int) isset($_POST['RA']);
		$AR = (int) $user['cps'];
		
		$unidade = Unidade::update(
			array(
				'clang' => $clang,
				'sun' => $sun,
				'nun' => $nun,
				'OBS' => $OBS,
				'RA' => $RA,
				'AR' => $AR
			),
			"cun = $cun"
		);
		$this->redirect('/unidade');
	}
	
	public function ajax_combo(int $cen = null) {
		$this->layout = 'ajax_combo';
		
		$user = Auth::user();
		
		if($cen) {
			$user['cen'] = $cen;
		}
		
		$unlist = Unidade::ativos($user);
		
		$this->view->set('unlist', $unlist);
	}
}