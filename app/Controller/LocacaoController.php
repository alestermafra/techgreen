<?php
App::import('AppController', 'Controller');

App::import('Locacao', 'Model');
App::import('ValeLocacao', 'Model');
App::import('Produto', 'Model');
App::import('ProdutoDetalhe', 'Model');
App::import('Tabela', 'Model');
App::import('FormaPagamento', 'Model');
App::import('Plano', 'Model');
App::import('Calendario', 'Model');
App::import('ClientePF', 'Model');
App::import('Ocorrencia', 'Model');

class LocacaoController extends AppController {
	
	public function index() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'elocacao.TS DESC',
			'data' => 'elocacao.TS DESC',
			'plano' => 'eplano.nplano ASC',
		);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		$filter = '';
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND elocacao.cmes = $mes";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND elocacao.can = $ano";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano";
		}
		if(($cprod = (int) _isset($_GET['produto'], 0)) !== 0) {
			$filter .= " AND eprod.cprod = $cprod";
		}
		
		if($search_value) {
			$list = Locacao::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Locacao::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = Locacao::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Locacao::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
		$this->view->set('produtos', Produto::findByCscat(3));
		$this->view->set('planos', Plano::locacao());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
	}
	
	public function ajax_html_planos(int $cprod, int $ctabela) {
		$this->layout = false;
		$this->view->set('planos', ProdutoDetalhe::find('all', array('conditions' => " AND eprod.cprod = $cprod AND etabela.ctabela = $ctabela")));
	}
	
	public function inserir() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$data = Locacao::save($data);
				return $this->redirect('/locacao/view/' . $data['clocacao']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('produtos', Produto::findByCscat(3));
		$this->view->set('planos', Plano::locacao());
		$this->view->set('tabela', Tabela::locacao());
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
		$this->view->set('pessoas',ClientePF::find('all', array('conditions' => ' AND zpainel.ativo = 1 ')));
	}
	
	public function editar($clocacao = null) {
		if($clocacao === null || !$locacao = Locacao::findById($clocacao)) {
			return $this->redirect('/aula');
		}
		
		if($this->request->method === 'POST') {
			$locacao['cps'] = _isset($_POST['cps'], $locacao['cps']);
			$locacao['cprod'] = _isset($_POST['cprod'], $locacao['cprod']);
			$locacao['cplano'] = _isset($_POST['cplano'], $locacao['cplano']);
			$locacao['ctabela'] = _isset($_POST['ctabela'], $locacao['ctabela']);
			$locacao['valor'] = _isset($_POST['valor'], $locacao['valor']);
			$locacao['cpgt'] = _isset($_POST['cpgt'], $locacao['cpgt']);
			$locacao['cppgt'] = _isset($_POST['cppgt'], $locacao['cppgt']);
			$locacao['datinha_pgt'] = _isset(date("Y-m-d",strtotime($_POST['datinha_pgt'])), date("Y-m-d",strtotime($locacao['datinha_pgt'])));
			$locacao['descricao'] = _isset($_POST['descricao'], $locacao['descricao']);
			$locacao['datinha'] = _isset(date("Y-m-d",strtotime($_POST['datinha'])), date("Y-m-d",strtotime($locacao['datinha'])));
			$locacao['chora'] = _isset($_POST['chora'], $locacao['chora']);
			$locacao['cminuto'] = _isset($_POST['cminuto'], $locacao['cminuto']);
			try {
				Locacao::save($locacao);
				return $this->redirect('/locacao/view/' . $locacao['clocacao']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('locacao', $locacao);
		$this->view->set('produtos', Produto::findByCscat(3));
		$this->view->set('planos', Plano::locacao());
		$this->view->set('tabela', Tabela::locacao());
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
		$this->view->set('pessoas',ClientePF::find('all', array('conditions' => ' AND zpainel.ativo = 1 ')));
	}
	
	public function view($clocacao = null) {
		if($clocacao === null || !$locacao = Locacao::findById($clocacao)) {
			return $this->redirect('/locacao');
		}
		$this->view->set('locacao', $locacao);
		$this->view->set('vale_locacao', ValeLocacao::findByCps($locacao['cps'], 'all'));
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($locacao['cps'], 'all', array('order' => 'eocorrencia.data DESC')));
	}
	
	public function vale_locacao($cps = null, $clocacao = null) {
		if($cps === null || !$vale = ValeLocacao::findByCps($cps, 'first')) {
			return $this->redirect('/aula');
		}
		
		if($this->request->method === 'POST') {
			
			$vale['choraslocacao'] = _isset($_POST['choraslocacao'], $vale['choraslocacao']);
			$vale['cps'] = _isset($_POST['cps'], $vale['cps']);
			$vale['horas'] = _isset($_POST['horas'], $vale['horas']);
			$vale['clocacao'] = _isset($_POST['clocacao'], $clocacao);
			
			try {
				ValeLocacao::save($vale);
				return $this->redirect('/locacao/view/' . $vale['clocacao']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('vale', $vale);
		$this->view->set('clocacao', $clocacao);
	}
	
	public function relatorio() {
		$filter = '';
		$excel = (int) _isset($_GET['excel'], 0);
		
		if($excel==1){
			$this->layout = false;
		}
		
		$filter = '';
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND elocacao.cmes = $mes ";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND elocacao.can = $ano ";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano";
		}
		if(($cprod = (int) _isset($_GET['produto'], 0)) !== 0) {
			$filter .= " AND eprod.cprod = $cprod";
		}
		
		$list = Locacao::find('all', array('order' => ' elocacao.TS desc ', 'conditions' => $filter));
		$count = Locacao::find('count', array('conditions' => $filter));
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);

		$this->view->set('excel', $excel);
		$this->view->set('produtos', Produto::findByCscat(3));
		$this->view->set('planos', Plano::locacao());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
	}
	
}