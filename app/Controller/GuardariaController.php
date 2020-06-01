<?php
App::import('AppController', 'Controller');

App::import('Guardaria', 'Model');
App::import('Produto', 'Model');
App::import('ProdutoDetalhe', 'Model');
App::import('Tabela', 'Model');
App::import('Equipamento', 'Model');
App::import('TipoEquipamento', 'Model');
App::import('FormaPagamento', 'Model');
App::import('Plano', 'Model');
App::import('Ocorrencia', 'Model');
App::import('ClientePF', 'Model');
App::import('PagamentoGuarderia', 'Model');


class GuardariaController extends AppController {
	public function index() {
		$search_value = _isset($_GET['search_value'], false);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'eequipe.nome ASC',
			'proprietario' => 'eps.nps ASC',
			'embarcacao' => 'eequipe.nome ASC',
			'plano' => 'eplano.nplano ASC',
		);

		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
	
		$filter = '';
		if(($clinha = (int) _isset($_GET['linha'], 0)) !== 0) {
			$filter .= " AND elinha.clinha = $clinha";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano";
		}
		$ativo = (int) _isset($_GET['ativo'], 1);
		$filter .= " AND eguardaria.ativo = $ativo";
		
		if($search_value) {
			$list = Guardaria::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Guardaria::search($search_value, 'count', array('conditions' => $filter));
		}
		else {
			$list = Guardaria::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order], 'conditions' => $filter));
			$count = Guardaria::find('count', array('conditions' => $filter));
		}

		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));

		$this->view->set('categorias', Produto::findByCscat(1, 'all', array('group' => ' elinha.clinha ')));
		$this->view->set('planos', Plano::guardaria());
	}

	public function inserir() {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$guardaria = Guardaria::save($data);
				return $this->redirect('/guardaria/view/' . $guardaria['cguardaria'] . '?inserido');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}

		$lista_equip = Equipamento::find('all', array('conditions' => ' AND eguardaria.cequipe IS NULL'));
		$this->view->set('produtos', Produto::findByCscat(1, 'all', ['order' => 'eprod.nprod ASC']));
		$this->view->set('tabelas', Tabela::guardaria());
		$this->view->set('equipamentos', $lista_equip);
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
	}
	
	public function view($cguardaria = null) {
		if($cguardaria === null || !$guardaria = Guardaria::findById($cguardaria)) {
			return $this->redirect('/guardaria');
		}
		
		$this->view->set('guardaria', $guardaria);
		$this->view->set('pagamentos', PagamentoGuarderia::findByCguardaria($cguardaria, 'all', array('order' => 'ano_ref desc, mes_ref desc')));
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoEquipamento($guardaria['cequipe'], 'all', array('order' => 'eocorrencia.data DESC')));
	}

	public function editar($cguardaria = null) {
		if($cguardaria === null || !$guardaria = Guardaria::findById($cguardaria)) {
			return $this->redirect('/guardaria');
		}

		if($this->request->method === 'POST') {
			$guardaria['cprod'] = _isset($_POST['cprod'], $guardaria['cprod']);
			$guardaria['cequipe'] = _isset($_POST['cequipe'], $guardaria['cequipe']);
			$guardaria['cplano'] = _isset($_POST['cplano'], $guardaria['cplano']);
			$guardaria['valor'] = _isset($_POST['valor'], $guardaria['valor']);
			$guardaria['cpgt'] = _isset($_POST['cpgt'], $guardaria['cpgt']);
			$guardaria['cppgt'] = _isset($_POST['cppgt'], $guardaria['cppgt']);
			$guardaria['d_vencimento'] = _isset($_POST['d_vencimento'], $guardaria['d_vencimento']);
			$guardaria['descricao'] = _isset($_POST['descricao'], $guardaria['descricao']);
			try {
				Guardaria::save($guardaria);
				return $this->redirect('/guardaria/view/' . $guardaria['cguardaria']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}

		$equipamentos = Equipamento::find(
			'all', 
			array('conditions' => ' AND (eguardaria.cequipe IS NULL OR eguardaria.cguardaria = '.$cguardaria.')')
		);

		$this->view->set('guardaria', $guardaria);
		$this->view->set('produtos', Produto::findByCscat(1, 'all', ['order' => 'eprod.nprod ASC']));
		$this->view->set('tabelas', Tabela::guardaria());
		$this->view->set('equipamentos', $equipamentos);
		$this->view->set('formas_pagamento', FormaPagamento::find());
		$this->view->set('parcelas_pagamento', FormaPagamento::parcelas());
	}
	
	public function cancelar_contrato($cguardaria = null) {
		if($cguardaria == null || !$guardaria = Guardaria::findById($cguardaria)) {
			return $this->redirect('/guardaria');
		}

		if($this->request->method === "POST") {
			$guardaria['ativo'] = 0;
			try {
				Guardaria::save($guardaria);
			}
			catch(Exception $e) {
				var_dump($e); die();
			}
		}
		return $this->redirect('/guardaria/view/' . $guardaria['cguardaria']);
	}
	
	public function ativar_contrato($cguardaria = null) {
		if($cguardaria == null || !$guardaria = Guardaria::findById($cguardaria)) {
			return $this->redirect('/guardaria');
		}
		
		if($this->request->method === "POST") {
			$guardaria['ativo'] = 1;
			try {
				Guardaria::save($guardaria);
			}
			catch(Exception $e) {
				
			}
		}
		return $this->redirect('/guardaria/view/' . $guardaria['cguardaria']);
	}

	public function ajax_html_planos(int $cprod, int $ctabela) {
		$this->layout = false;
		$this->view->set('planos', ProdutoDetalhe::find('all', array('conditions' => " AND eprod.cprod = $cprod AND etabela.ctabela = $ctabela")));
	}
	
	public function relatorio() {
		$filter = '';
		$excel = (int) _isset($_GET['excel'], 0);
		
		if($excel==1){
			$this->layout = false;
		}
		
		$equipamento_venda = (int) _isset($_GET['equipamento_venda'], 0);
		if($equipamento_venda == 1){ $filter .= " AND eequipe.flg_venda = 1 "; }
		if($equipamento_venda == 2){ $filter .= " AND eequipe.flg_venda = 0 "; }
		
		$ativo = (int) _isset($_GET['ativo'], 1);
		$filter .= " AND eguardaria.ativo = $ativo";
		
		if(($clinha = (int) _isset($_GET['linha'], 0)) !== 0) {
			$filter .= " AND elinha.clinha = $clinha";
		}
		if(($cplano = (int) _isset($_GET['plano'], 0)) !== 0) {
			$filter .= " AND eplano.cplano = $cplano";
		}
		if(($cprod = (int) _isset($_GET['produto'], 0)) !== 0) {
			$filter .= " AND eprod.cprod = $cprod";
		}
		
		$list = Guardaria::find('all', array('order' => ' eps.nps ', 'conditions' => $filter));
		$count = Guardaria::find('count', array('conditions' => $filter));
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);

		$this->view->set('excel', $excel);
		$this->view->set('linha', Produto::findByCscat(1, 'all', array('group' => ' elinha.clinha')));
		$this->view->set('produtos', Produto::findByCscat(1));
		$this->view->set('planos', Plano::guardaria());
	}
	
	public function gerar_contrato($cguardaria) {
		$this->layout = false;
				
		$guardaria = Guardaria::findById($cguardaria);
		
		$clientepf = ClientePF::findByCps($guardaria['cps']);
		$clientepf['telefones'] = ClientePF::telefones($clientepf['cps']);
		$endereco = ClientePF::enderecos($clientepf['cps'],'first', array('conditions' => ' AND upsend.ctpsend = 1 '));
		
		$this->view->set('clientepf', $clientepf);
		$this->view->set('endereco', $endereco);
	}

	public function informar_pagamento(int $cguarderia) {
		if($this->request->method !== "POST") {
			return $this->redirect('/');
		}

		$data = $_POST;

		$pagamento_guarderia = [
			'cguardaria' => $cguarderia,
			'valor' => $data['valor'],
			'mes_ref' => $data['mes_ref'],
			'ano_ref' => $data['ano_ref'],
			'data_pagamento' => $data['data_pagamento'],
			'descricao' => _isset($data['descricao'], ''),
		];

		PagamentoGuarderia::save($pagamento_guarderia);

		return $this->redirect('/guardaria/view/' . $cguarderia);
	}

	public function remover_pagamento(int $id, int $cguarderia) {
		PagamentoGuarderia::remove("pagamento_guarderia.id = $id AND pagamento_guarderia.cguardaria = $cguarderia");
		return $this->redirect('/guardaria/view/' . $cguarderia);
	}
}