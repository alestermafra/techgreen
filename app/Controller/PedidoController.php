<?php
App::import('AppController', 'Controller');

App::import('Pedido', 'Model');
App::import('PedidoDetalhes', 'Model');

App::import('Calendario', 'Model');
App::import('Produto', 'Model');
App::import('ProdutoDetalhe', 'Model');
App::import('Tabela', 'Model');
App::import('FormaPagamento', 'Model');
App::import('Plano', 'Model');
App::import('ClientePF', 'Model');

class PedidoController extends AppController {
	
	public function lista() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'eped.data DESC',
		);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		$filter = '';
		if(($dia = (int) _isset($_GET['dia'], date("d"))) !== 0) {
			$filter .= " AND DAY(eped.data) = $dia";
		}
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND MONTH(eped.data) = $mes";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND YEAR(eped.data) = $ano";
		}
		if(($cmov = (int) _isset($_GET['mov'], 0)) !== 0) {
			$filter .= " AND emov.cmov = $cmov";
		}
		
		if($search_value) {
			$list = Pedido::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Pedido::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = Pedido::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Pedido::find('count', array('conditions' => $filter));
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
		$this->view->set('produtos', Produto::findByCcat(2));
		$this->view->set('cdia', Calendario::edia());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
		$this->view->set('dia', $dia);
	}
	
	/**----------------
		MUDAR A PARTIR DAQUI
	---------------**/
	
	public function inserir() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$data = DiariaVelejador::save($data);
				return $this->redirect('/DiariaVelejador/view/' . $data['cdiaria']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$val_prod = ProdutoDetalhe::find('all',array('conditions' => ' AND etabela.ctabela in (5,6) '));
		
		$this->view->set('produtos', Produto::findByCscat(5));
		$this->view->set('val_prod', $val_prod);
		$this->view->set('planos', Plano::diaria());
		$this->view->set('tabela', Tabela::diaria());
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
		$this->view->set('pessoas',ClientePF::find('all', array('conditions' => ' AND zpainel.ativo = 1 ')));
	}
	
	public function view($cdiaria = null) {
		if($cdiaria === null || !$diaria = DiariaVelejador::findById($cdiaria)) {
			return $this->redirect('/DiariaVelejador');
		}
		$this->view->set('diaria', $diaria);
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($diaria['cps'], 'all', array('order' => 'eocorrencia.data DESC')));
	}
	
	public function editar($cdiaria = null) {
		if($cdiaria === null || !$diaria = DiariaVelejador::findById($cdiaria)) {
			return $this->redirect('/DiariaVelejador');
		}
		
		if($this->request->method === 'POST') {
			
			$diaria['cprod'] = _isset($_POST['cprod'], $diaria['cprod']);
			$diaria['cplano'] = _isset($_POST['cplano'], $diaria['cplano']);
			$diaria['ctabela'] = _isset($_POST['ctabela'], $diaria['ctabela']);
			$diaria['valor'] = _isset($_POST['valor'], $diaria['valor']);
			$diaria['cpgt'] = _isset($_POST['cpgt'], $diaria['cpgt']);
			$diaria['cppgt'] = _isset($_POST['cppgt'], $diaria['cppgt']);
			$diaria['datinha'] = _isset(date("Y-m-d", strtotime($_POST['datinha'])), date("Y-m-d", strtotime($diaria['datinha'])));
			$diaria['datinha_pgt'] = _isset(date("Y-m-d", strtotime($_POST['datinha_pgt'])), date("Y-m-d", strtotime($diaria['datinha_pgt'])));
			$diaria['descricao'] = _isset($_POST['descricao'], $diaria['descricao']);
			try {
				DiariaVelejador::save($diaria);
				return $this->redirect('/DiariaVelejador/view/' . $diaria['cdiaria']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$val_prod = ProdutoDetalhe::find('all',array('conditions' => ' AND etabela.ctabela in (5,6) '));
		
		$this->view->set('diaria', $diaria);
		$this->view->set('produtos', Produto::findByCscat(5));
		$this->view->set('val_prod', $val_prod);
		$this->view->set('planos', Plano::diaria());
		$this->view->set('tabela', Tabela::diaria());
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
		$this->view->set('pessoas',ClientePF::find('all', array('conditions' => ' AND zpainel.ativo = 1 ')));
	}
	
	public function relatorio() {
		$filter = '';
		$excel = (int) _isset($_GET['excel'], 0);
		
		if($excel==1){
			$this->layout = false;
		}
		
		$filter = '';
		if(($mes = (int) _isset($_GET['mes'], date("n"))) !== 0) {
			$filter .= " AND ediaria.cmes = $mes ";
		}
		if(($ano = (int) _isset($_GET['ano'], date("Y"))) !== 0) {
			$filter .= " AND ediaria.can = $ano ";
		}
		if(($ctabela = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND etabela.ctabela = $ctabela";
		}
		if(($cprod = (int) _isset($_GET['produto'], 0)) !== 0) {
			$filter .= " AND eprod.cprod = $cprod";
		}
		
		$list = DiariaVelejador::find('all', array('order' => ' ediaria.TS desc ', 'conditions' => $filter));
		$count = DiariaVelejador::find('count', array('conditions' => $filter));
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);

		$this->view->set('excel', $excel);
		$this->view->set('produtos', Produto::findByCscat(5));
		$this->view->set('planos', Tabela::diaria());
		$this->view->set('can', Calendario::ean());
		$this->view->set('cmes', Calendario::emes());
		$this->view->set('ano', $ano);
		$this->view->set('mes', $mes);
	}
}