<?php
App::import('AppController', 'Controller');

App::import('Aula', 'Model');
App::import('ParticipanteAula', 'Model');
App::import('Produto', 'Model');
App::import('ProdutoDetalhe', 'Model');
App::import('Tabela', 'Model');
App::import('FormaPagamento', 'Model');
App::import('Plano', 'Model');
App::import('Calendario', 'Model');

class AulaController extends AppController {
	
	public function index() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'eaula.cdia, eaula.cmes, eaula.can',
			'data' => 'eaula.cdia, eaula.cmes, eaula.can', 
			'TS' => 'eaula.TS DESC',
			'plano' => 'eplano.nplano ASC',
		);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		$filter = '';
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND eaula.cmes = $mes ";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND eaula.can = $ano ";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano ";
		}
		
		if($search_value) {
			$list = Aula::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Aula::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = Aula::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Aula::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
		$this->view->set('planos', Plano::aula());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
	}
	
	public function inserir() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$aula = Aula::save($data);
				return $this->redirect('/aula/view/' . $aula['caula']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$val_prod = ProdutoDetalhe::find('all',array('conditions' => ' AND etabela.ctabela = 4 '));
		
		$this->view->set('linha', Produto::findByCscat(4, 'all', array('order' => 'elinha.nlinha', 'group' => 'elinha.nlinha')));
		$this->view->set('val_prod', $val_prod);
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
	}
	
	public function view($caula = null) {
		if($caula === null || !$aula = Aula::findById($caula)) {
			return $this->redirect('/aula');
		}
		
		$this->view->set('aula', $aula);
		$this->view->set('participantes', ParticipanteAula::FindByCaula($aula['caula']));
	}
	
	public function editar($caula = null) {
		if($caula === null || !$aula = Aula::findById($caula)) {
			return $this->redirect('/aula');
		}
		
		if($this->request->method === 'POST') {
			
			$aula['clinha'] = _isset($_POST['clinha'], $aula['clinha']);
			$aula['cplano'] = _isset($_POST['cplano'], $aula['cplano']);
			$aula['valor'] = _isset($_POST['valor'], $aula['valor']);
			$aula['datinha'] = _isset(date("Y-m-d",strtotime($_POST['datinha'])), date("Y-m-d",strtotime($aula['datinha'])));
			$aula['descricao'] = _isset($_POST['descricao'], $aula['descricao']);
			$aula['chora'] = _isset($_POST['chora'], $aula['chora']);
			$aula['cminuto'] = _isset($_POST['cminuto'], $aula['cminuto']);
			$aula['instrutor'] = _isset($_POST['instrutor'], $aula['instrutor']);
			$aula['subtitulo'] = _isset($_POST['subtitulo'], $aula['subtitulo']);
			try {
				Aula::save($aula);
				return $this->redirect('/aula/view/' . $aula['caula']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$val_prod = ProdutoDetalhe::find('all',array('conditions' => ' AND etabela.ctabela = 4 '));
		
		$this->view->set('aula', $aula);
		$this->view->set('linha', Produto::findByCscat(4, 'all', array('order' => 'elinha.nlinha', 'group' => 'elinha.nlinha')));
		$this->view->set('val_prod', $val_prod);
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
	}
	
	public function remover($caula = null) {
		if($caula === null || !$aula = Aula::findById($caula)) {
			return $this->redirect('/aula');
		}else{
			Aula::remover($caula);
			return $this->redirect('/aula');
		}
	}
	
	public function participantes(int $caula = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$participantes = ParticipanteAula::save($data);
				return $this->redirect('/aula/participantes/' . $data['caula']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		if(!$caula){
			$participantes = ParticipanteAula::findByCaula($data['caula']);
			$caula = $data['caula'];
		} else {
			$participantes = ParticipanteAula::findByCaula($caula);
		}
		
		$aula = Aula::findById($caula);
		
		$this->view->set('produtos', Produto::findByCscat(4, 'all', array('conditions' => ' AND elinha.clinha = '.$aula['clinha'] )));
		$this->view->set('participantes', $participantes);
		$this->view->set('pessoas', ClientePF::find('all', array('conditions' => ' AND zpainel.ativo = 1 ')));
		$this->view->set('caula', $caula);
	}
	
	public function remover_participante(int $cps, int $caula){
		$endereco = ParticipanteAula::remover($cps, $caula);
		
		return $this->redirect('/aula/participantes/' . $caula);
	}
	
	public function relatorio() {
		$filter = '';
		$excel = (int) _isset($_GET['excel'], 0);
		
		if($excel==1){
			$this->layout = false;
		}
		
		$filter = '';
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND eaula.cmes = $mes ";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND eaula.can = $ano ";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano";
		}
		if(($clinha = (int) _isset($_GET['linha'], 0)) !== 0) {
			$filter .= " AND elinha.clinha = $clinha";
		}
		
		$list = Aula::find('all', array('order' => ' eaula.TS desc ', 'conditions' => $filter));
		$count = Aula::find('count', array('conditions' => $filter));
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);

		$this->view->set('excel', $excel);
		$this->view->set('linhas', Produto::findByCscat(4, 'all', array('order' => 'elinha.nlinha', 'group' => 'elinha.clinha')));
		$this->view->set('planos', Plano::aula());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
	}
	
	
	
	
	public function ajax_set_descricao_participante() {
		$this->autoRender = false;
		
		$czaula = _isset($_POST["czaula"], null);
		$descricao = _isset($_POST["descricao"], '');
		
		if($czaula !== null) {
			$data["czaula"] = $czaula;
			$data["descricao"] = $descricao;
			$participanteAula = ParticipanteAula::save($data);
			if(!$participanteAula) {
				echo "error 1";
			}
			else {
				echo "success";
			}
		}
		else {
			echo "error 2";
		}
	}
	
}