<?php
App::import('AppController', 'Controller');

App::import('ClienteYTDMes', 'Model');
App::import('AulaYTDMes', 'Model');
App::import('LocacaoYTDMes', 'Model');
App::import('DiariaVelejadorYTDMes', 'Model');
App::import('Cliente', 'Model');
App::import('Guardaria', 'Model');
App::import('Equipamento', 'Model');
App::import('Estoque', 'Model');
App::import('Calendario', 'Model');
App::import('AgendaCruzada', 'Model');
	
class DashboardController extends AppController {
	public function index() {
		$dia = date("d"); // dia atual
		$mes = date("m"); // mes atual
		$ano = date("Y"); // ano atual
		$hora = date("G");// hora atual
		
		$dia_dp = date("d", strtotime(" + 1 days")); // dia após o dia atual
		$mes_dp = date("m", strtotime(" + 1 days")); // mes após o dia atual
		$ano_dp = date("Y", strtotime(" + 1 days")); // ano após o dia atual
		
		$condicoes = ' AND ((eagenda.cdia = '.$dia.' AND eagenda.cmes = '.$mes.' AND eagenda.can = '.$ano.') OR (eagenda.cdia_fim = '.$dia.' AND eagenda.cmes_fim = '.$mes.' AND eagenda.can_fim = '.$ano.') OR ('.$dia.' BETWEEN eagenda.cdia AND eagenda.cdia_fim AND '.$mes.' BETWEEN eagenda.cmes AND eagenda.cmes_fim AND '.$ano.' BETWEEN eagenda.can AND eagenda.can_fim)) ';
		
		$condicoes_dp = ' AND eagenda.cdia >= '.$dia_dp.' AND eagenda.cmes >= '.$mes_dp.' AND eagenda.can >= '.$ano_dp;
		
		$pessoas_ag = AgendaCruzada::find('all', array('conditions' => $condicoes) );
		$pessoas_dp = AgendaCruzada::find('all', array('conditions' => $condicoes_dp) );
		
		$tarefas_dia = Calendario::find('all', array('conditions' => $condicoes , 'order' => ' eagenda.cdia, eagenda.chora_ini, eagenda.cminuto_ini '));
		$tarefas_dp = Calendario::find('all', array('limit' => 5, 'conditions' => $condicoes_dp, 'order' => ' eagenda.cdia, eagenda.cdia_fim, eagenda.chora_ini, eagenda.cminuto_ini, eagenda.chora_fim, eagenda.cminuto_fim'));
		
		$this->view->set('cliente_ytd_month', ClienteYTDMes::find());
		$this->view->set('aulas_ytd_month', AulaYTDMes::find());
		$this->view->set('locacoes_ytd_month', LocacaoYTDMes::find());
		$this->view->set('diarias_ytd_month', DiariaVelejadorYTDMes::find());
		$this->view->set('clientes_quantidade', Cliente::find('count'));
		$this->view->set('guardaria_quantidade', Guardaria::find('count'));
		$this->view->set('equipamentos_quantidade', Equipamento::find('count'));
		$this->view->set('estoque_acabando', Estoque::acabando(.2)); /* .2 = 20% */
		$this->view->set('pessoas_ag', $pessoas_ag);
		$this->view->set('pessoas_dp', $pessoas_dp);
		$this->view->set('tarefas_dia', $tarefas_dia);
		$this->view->set('tarefas_dp', $tarefas_dp);
		$this->view->set('last_clients', Cliente::last_clients(5));
		$this->view->set('aniversariantes', ClientePF::aniversariantes('all', array('order' => 'upsf.d_nasc, upsf.m_nasc, eps.nps')));
	}
}