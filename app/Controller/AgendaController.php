<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

App::import('Calendario', 'Model');
App::import('AgendaCruzada', 'Model');
App::import('Pessoa', 'Model');
App::import('Guardaria', 'Model');
App::import('Aula', 'Model');
App::import('ParticipanteAula', 'Model');
App::import('Locacao', 'Model');
App::import('DiariaVelejador', 'Model');

class AgendaController extends AppController {
	
	public function agenda(int $mes = null, int $ano = null) {		
		if(!$mes){ $mes = date("m");}
		if(!$ano){ $ano = date("Y");}
		$dia = date("d");
		$totalDias = date("t");
		$primeiroDia = date("D", mktime(0, 0, 0, $mes, 1, $ano));
		$pos = Calendario::primeiro_dia($primeiroDia);
		
		$dias = array();
		for($d = 0; $d < $totalDias; $d++)$dias[$d] = array_push($dias, $d+1);
		
		$list = Calendario::find('all', array('conditions' => ' AND ((eagenda.cmes = '.$mes.' AND eagenda.can = '.$ano.') OR (eagenda.cmes_fim = '.$mes.' AND eagenda.can_fim = '.$ano.'))', 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '));
		$pessoas = AgendaCruzada::find('all', array('conditions' => '  AND ((eagenda.cmes = '.$mes.' AND eagenda.can = '.$ano.') OR (eagenda.cmes_fim = '.$mes.' AND eagenda.can_fim = '.$ano.'))') );
		
		$this->view->set('mes', Calendario::mes_vigente($mes));
		$this->view->set('dias_semana', Calendario::edsm());
		$this->view->set('ano', $ano);
		$this->view->set('dia', $dia);
		$this->view->set('dias', $dias);
		$this->view->set('pos', $pos);
		
		$this->view->set('list', $list);
		$this->view->set('pessoas', $pessoas);
	}
	//------------------------------------------------------------------------------------
	public function semana(int $dia = null, int $mes = null, int $ano = null) {		
		if(!$dia){ $dia = date("d");}
		if(!$mes){ $mes = date("m");}
		if(!$ano){ $ano = date("Y");}
		
		$d_selecionada = date("d-m-Y", strtotime($dia."-".$mes."-".$ano)); // prepara a data selecionada
		
		$d_inicio = date('d-m-Y', strtotime('sunday last week', strtotime($d_selecionada))); //data inicial da semana
		$d_fim = date("d-m-Y", strtotime('saturday this week', strtotime($d_selecionada))); //data final da semana
		
		$totalDias = 7; 
		
		$dias = array();
		for($d = 0; $d < $totalDias; $d++){
			$dias[$d]['cdia'] = date("j", strtotime($d_inicio. ' + '.$d.' days'));
			$dias[$d]['cmes'] = date("n", strtotime($d_inicio. ' + '.$d.' days'));
			$dias[$d]['can'] = date("Y", strtotime($d_inicio. ' + '.$d.' days'));
		}
				
		$list = Calendario::find(
			'all', 
			array('conditions' => ' 
					AND ((eagenda.can >= '.date("Y", strtotime($d_inicio)).' AND eagenda.cmes >= '.date("n", strtotime($d_inicio)).' AND eagenda.cdia >= '.date("j", strtotime($d_inicio)).') OR (eagenda.can <= '.date("Y", strtotime($d_fim)).' AND eagenda.cmes <= '.date("n", strtotime($d_fim)).' AND eagenda.cdia <= '.date("j", strtotime($d_fim)).'))'
				, 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		$pessoas = AgendaCruzada::find('all', array('conditions' => ' AND ((eagenda.can >= '.date("Y", strtotime($d_inicio)).' AND eagenda.cmes >= '.date("n", strtotime($d_inicio)).' AND eagenda.cdia >= '.date("j", strtotime($d_inicio)).') OR (eagenda.can <= '.date("Y", strtotime($d_fim)).' AND eagenda.cmes <= '.date("n", strtotime($d_fim)).' AND eagenda.cdia <= '.date("j", strtotime($d_fim)).'))') );
		
		$this->view->set('mes', Calendario::mes_vigente($mes));
		$this->view->set('dias_semana', Calendario::edsm());
		$this->view->set('ano', $ano);
		$this->view->set('dia', $dia);
		$this->view->set('dias', $dias);
		
		$this->view->set('list', $list);
		$this->view->set('pessoas', $pessoas);
	}
	//------------------------------------------------------------------------------------
	public function dia(int $dia = null, int $mes = null, int $ano = null) {		
		if(!$dia){ $dia = date("d");}
		if(!$mes){ $mes = date("m");}
		if(!$ano){ $ano = date("Y");}
		
		$condicoes = ' AND ((eagenda.cdia = '.$dia.' AND eagenda.cmes = '.$mes.' AND eagenda.can = '.$ano.') OR (eagenda.cdia_fim = '.$dia.' AND eagenda.cmes_fim = '.$mes.' AND eagenda.can_fim = '.$ano.') OR ('.$dia.' BETWEEN eagenda.cdia AND eagenda.cdia_fim AND '.$mes.' BETWEEN eagenda.cmes AND eagenda.cmes_fim AND '.$ano.' BETWEEN eagenda.can AND eagenda.can_fim)) ';
		
		$orderna = ' eagenda.cdia, eagenda.cdia_fim, eagenda.chora_ini, eagenda.cminuto_ini, eagenda.chora_fim, eagenda.cminuto_fim ';
		
		$list = Calendario::find('all', array('conditions' => $condicoes, 'order' => $orderna));
		$pessoas = AgendaCruzada::find('all', array('conditions' => $condicoes) );
		
		$this->view->set('mes', Calendario::mes_vigente($mes));
		$this->view->set('dias_semana', Calendario::edsm());
		$this->view->set('ano', $ano);
		$this->view->set('dia', $dia);
		
		$this->view->set('list', $list);
		$this->view->set('pessoas', $pessoas);
	}
	//------------------------------------------------------------------------------------
	public function semana_quadro(int $dia = null, int $mes = null, int $ano = null) {		
		if(!$dia){ $dia = date("d");}
		if(!$mes){ $mes = date("m");}
		if(!$ano){ $ano = date("Y");}
		
		$d_selecionada = date("d-m-Y", strtotime($dia."-".$mes."-".$ano)); // prepara a data selecionada
		
		$d_inicio = date('d-m-Y', strtotime('sunday last week', strtotime($d_selecionada))); //data inicial da semana
		$d_fim = date("d-m-Y", strtotime('saturday this week', strtotime($d_selecionada))); //data final da semana
		
		$totalDias = 7; 
		
		$dias = array();
		for($d = 0; $d < $totalDias; $d++){
			$dias[$d]['cdsm'] = $d+1;
			$dias[$d]['cdia'] = date("j", strtotime($d_inicio. ' + '.$d.' days'));
			$dias[$d]['cmes'] = date("n", strtotime($d_inicio. ' + '.$d.' days'));
			$dias[$d]['can'] = date("Y", strtotime($d_inicio. ' + '.$d.' days'));
		}
		
		$condicao = ' AND ((eagenda.can >= '.date("Y", strtotime($d_inicio)).' AND eagenda.cmes >= '.date("n", strtotime($d_inicio)).' AND eagenda.cdia >= '.date("j", strtotime($d_inicio)).') OR (eagenda.can <= '.date("Y", strtotime($d_fim)).' AND eagenda.cmes <= '.date("n", strtotime($d_fim)).' AND eagenda.cdia <= '.date("j", strtotime($d_fim)).'))';
		
		//outros eventos		
		$list = Calendario::find(
			'all', 
			array('conditions' => ' AND eagenda.cacao NOT IN (13, 14, 3, 12) '.$condicao , 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		
		//locacao veleiro	
		$list_locacao_veleiro = Calendario::find(
			'all', 
			array('conditions' => ' AND eagenda.cacao IN (3) '.$condicao , 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		
		//locacao caiaque	
		$list_locacao_caiaque = Calendario::find(
			'all', 
			array('conditions' => ' AND eagenda.cacao IN (12) '.$condicao , 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		
		//aula wind	
		$list_aula_wind = Calendario::find(
			'all', 
			array('conditions' => ' AND eagenda.cacao IN (13) '.$condicao , 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		
		//aula veleiro	
		$list_aula_veleiro = Calendario::find(
			'all', 
			array('conditions' => ' AND eagenda.cacao IN (14) '.$condicao , 'order' => ' eagenda.cdia, eagenda.cminuto_ini, eagenda.chora_ini '
			)
		);
		
		//pessoas
		$pessoas = AgendaCruzada::find('all', array('conditions' => $condicao ) );
		
		
		$this->view->set('mes', Calendario::mes_vigente($mes));
		$this->view->set('dias_semana', Calendario::edsm());
		$this->view->set('ano', $ano);
		$this->view->set('dia', $dia);
		$this->view->set('dias', $dias);
		
		$this->view->set('list', $list);
		$this->view->set('pessoas', $pessoas);
		$this->view->set('list_locacao_veleiro', $list_locacao_veleiro);
		$this->view->set('list_locacao_caiaque', $list_locacao_caiaque);
		$this->view->set('list_aula_wind', $list_aula_wind);
		$this->view->set('list_aula_veleiro', $list_aula_veleiro);
	}
	//------------------------------------------------------------------------------------
	public function inserir_agenda(int $dia = null, int $mes = null, int $ano = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$agenda = Calendario::save($data); 
				return $this->redirect('/agenda/dia/'.date("j",strtotime($data['datinha'])).'/'.date("n",strtotime($data['datinha'])).'/'.date("Y",strtotime($data['datinha'])));
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		if($dia && $mes && $ano){
			$this->view->set('dia', $dia);
			$this->view->set('mes', $mes);
			$this->view->set('ano', $ano);
		}
		
		$this->view->set('acao', Calendario::acao());
		$this->view->set('pessoa', Pessoa::find('all',array( 'group' => ' eps.nps', 'conditions' => ' AND eps.flg_sys = 0 ' )));
	}
	//------------------------------------------------------------------------------------
	public function editar_agenda(int $cagenda = null, int $dia = null, int $mes = null, int $ano = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$agenda = Calendario::save($data); 
				return $this->redirect('/agenda/dia/'.date("j",strtotime($data['datinha'])).'/'.date("n",strtotime($data['datinha'])).'/'.date("Y",strtotime($data['datinha'])));
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		if($dia && $mes && $ano){
			$this->view->set('dia', $dia);
			$this->view->set('mes', $mes);
			$this->view->set('ano', $ano);
		}
		
		$this->view->set('agenda', Calendario::findById($cagenda));
		$this->view->set('agenda_cruzada', AgendaCruzada::findByCagenda($cagenda));
		$this->view->set('acao', Calendario::acao());
		$this->view->set('pessoa', Pessoa::find('all',array( 'group' => ' eps.nps', 'conditions' => ' AND eps.flg_sys = 0 ' )));
	}
	//------------------------------------------------------------------------------------
	public function inativar(int $cagenda) {
		try {
			$agenda = Calendario::inativar_agenda($cagenda); 
			return $this->redirect('/agenda/agenda/');
		}
		catch(Exception $e) {
			$this->view->set('error', $e->getMessage());
		}
	}
	//------------------------------------------------------------------------------------
	public function agendar_cobranca_guardaria(int $cguardaria) { 
		$dados = Guardaria::findById($cguardaria);
		$qtd = (int) $dados['qtd_parcela'];
		
		if($qtd > 0){
			for ($i = 1; $i <= $qtd; $i++) {
				$mes = date("n", strtotime("+".$i." month"));
				$ano = date("Y", strtotime("+".$i." month"));
				$datinha = date("Y-m-d", strtotime($ano."-".$mes."-".$dados['d_vencimento']));
				
				$data = [
					'cacao' => 9,
					'datinha' => $datinha,
					'datinha_fim' => $datinha,
					'chora_ini' => 9,
					'cminuto_ini' => 0,
					'chora_fim' => 10,
					'cminuto_fim' => 0,
					'OBS' => "Lembrete de cobrança: Serviço de Guardaria.",
				];
				$cod_agenda = Calendario::save($data);
		
				$participantes = [
					'cps' => $dados['cps'],
					'cagenda' => $cod_agenda['cagenda'],
				];
				
				AgendaCruzada::create($participantes);
			}
		}else if($qtd == 0){
			$mes = date("n", strtotime("+1 month"));
			$ano = date("Y", strtotime("+1 month"));
			$datinha = date("Y-m-d", strtotime($ano."-".$mes."-".$dados['d_vencimento']));

			$data = [
				'cacao' => 9,
				'datinha' => $datinha,
				'datinha_fim' => $datinha,
				'chora_ini' => 9,
				'cminuto_ini' => 0,
				'chora_fim' => 10,
				'cminuto_fim' => 0,
				'OBS' => "Lembrete de cobrança: Serviço de Guardaria.",
			];
			$cod_agenda = Calendario::save($data);
		
			$participantes = [
				'cps' => $dados['cps'],
				'cagenda' => $cod_agenda['cagenda'],
			];
			
			AgendaCruzada::create($participantes);
		}
		
		return $this->redirect('/agenda/agenda/'.$mes.'/'.$ano);
		
	}
	//------------------------------------------------------------------------------------
	public function agendar_aula(int $caula) {
		$dados = Aula::findById($caula);
		
		$cacao = 1; //aula teorica como default 
		
		if($dados['clinha'] == 22 || $dados['clinha'] == 19){ 
			$cacao = 13; // aula de wind //19, 22
		}
		
		if($dados['clinha'] == 12 || $dados['clinha'] == 13 || $dados['clinha'] == 17 || $dados['clinha'] == 18 || $dados['clinha'] == 20 || $dados['clinha'] == 21){ 
			$cacao = 14; // aula de veleiro //12, 13, 17, 18, 20, 21
		}
		
		if($dados['nplano'] == "2h"){ $h_intervalo = 2; $m_intervalo = 0;}
		if($dados['nplano'] == "2h30"){ $h_intervalo = 2; $m_intervalo = 30;}
		if($dados['nplano'] == "3h"){ $h_intervalo = 3; $m_intervalo = 0;}
		
		$datinha = date("Y-m-d", strtotime($dados['can']."-".$dados['cmes']."-".$dados['cdia']));
		
		$subtitulo = $dados['subtitulo'].' - Instr: '.$dados['instrutor']; //para gerar subtitulo
				
		$data = [
			'subtitulo' => $subtitulo,
			'cacao' => $cacao,
			'datinha' => $datinha,
			'datinha_fim' => $datinha,
			'chora_ini' => $dados['chora'],
			'cminuto_ini' => $dados['cminuto'],
			'chora_fim' => $dados['chora'] + $h_intervalo,
			'cminuto_fim' => $dados['cminuto'] + $m_intervalo,
			'OBS' => $dados['descricao'],
		];
		$cod_agenda = Calendario::create($data);
		
		$participantes = ParticipanteAula::findByCaula($caula);

		foreach($participantes as $pess) {
			$pess['cagenda'] = $cod_agenda['cagenda'];
			AgendaCruzada::create($pess);
		}
				
		return $this->redirect('/agenda/dia/'.$dados['cdia'].'/'.$dados['cmes'].'/'.$dados['can']);
	}
	//------------------------------------------------------------------------------------
	public function agendar_locacao(int $clocacao) { 
		$dados = Locacao::findById($clocacao);
		
		if($dados['clinha'] == 10){ $cacao = 12;}
		if($dados['clinha'] == 11){ $cacao = 3;}
		if($dados['cprod'] == 32){ $cacao = 16;}
		if($dados['cprod'] == 33){ $cacao = 15;}
		
		$h_intervalo = 1; $m_intervalo = 0;
		if($dados['nplano'] == "1h"){ $h_intervalo = 1; $m_intervalo = 0;}
		if($dados['nplano'] == "1h30"){ $h_intervalo = 1; $m_intervalo = 30;}
		if($dados['nplano'] == "2h"){ $h_intervalo = 2; $m_intervalo = 0;}
		if($dados['nplano'] == "2h30"){ $h_intervalo = 2; $m_intervalo = 30;}
		if($dados['nplano'] == "3h"){ $h_intervalo = 3; $m_intervalo = 0;}
		if($dados['nplano'] == "3h30"){ $h_intervalo = 3; $m_intervalo = 30;}
		if($dados['nplano'] == "4h"){ $h_intervalo = 4; $m_intervalo = 0;}
		if($dados['nplano'] == "4h30"){ $h_intervalo = 4; $m_intervalo = 30;}
		
		$datinha = date("Y-m-d", strtotime($dados['can']."-".$dados['cmes']."-".$dados['cdia']));
				
		$data = [
			'cacao' => $cacao,
			'datinha' => $datinha,
			'datinha_fim' => $datinha,
			'chora_ini' => $dados['chora'],
			'cminuto_ini' => $dados['cminuto'],
			'chora_fim' => $dados['chora'] + $h_intervalo,
			'cminuto_fim' => $dados['cminuto'] + $m_intervalo,
			'OBS' => $dados['descricao'],
		];
		$cod_agenda = Calendario::save($data);
		
		$participantes = [
			'cps' => $dados['cps'],
			'cprod' => $dados['cprod'],
			'cagenda' => $cod_agenda['cagenda'],
		];
		
		AgendaCruzada::create($participantes);
				
		return $this->redirect('/agenda/dia/'.$dados['cdia'].'/'.$dados['cmes'].'/'.$dados['can']);
	}
	//------------------------------------------------------------------------------------
	public function agendar_diaria(int $cdiaria) {
		$dados = DiariaVelejador::findById($cdiaria);
		
		$datinha = date("Y-m-d", strtotime($dados['can']."-".$dados['cmes']."-".$dados['cdia']));
				
		$data = [
			'cacao' => 5,
			'datinha' => $datinha,
			'datinha_fim' => $datinha,
			'chora_ini' => 9,
			'cminuto_ini' => 0,
			'chora_fim' => 18,
			'cminuto_fim' => 0,
			'OBS' => $dados['descricao'],
		];
		$cod_agenda = Calendario::save($data);
		
		$participantes = [
			'cps' => $dados['cps'],
			'cagenda' => $cod_agenda['cagenda'],
		];
		
		AgendaCruzada::create($participantes);
				
		return $this->redirect('/agenda/dia/'.$dados['cdia'].'/'.$dados['cmes'].'/'.$dados['can']);
	}
	
	public function search_pessoa() {
		App::import("Pessoa", "Model");
		
		$this->autoRender = false;
		
		$term = _isset($_GET["term"], null);
		
		$result = [];

		if($term !== null) {
			$result = Pessoa::search($term, "all", array("conditions" => " AND eps.flg_sys = 0", "limit" => 5));
		}
		
		echo json_encode($result);
	}
	
}