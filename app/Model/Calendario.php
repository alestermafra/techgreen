<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('AgendaCruzada', 'Model');

class Calendario extends Table {
	
	public static $_table = 'eagenda';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eagenda
			LEFT JOIN eacao ON (eacao.cacao = eagenda.cacao)
		WHERE eagenda.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eagenda.cagenda',
		'eagenda.subtitulo',
		'eagenda.cdia',
		'eagenda.cmes',
		'eagenda.can',
		'eagenda.cdia_fim',
		'eagenda.cmes_fim',
		'eagenda.can_fim',
		'eagenda.cacao',
		'eagenda.cminuto_ini',
		'eagenda.chora_ini',
		'eagenda.cminuto_fim',
		'eagenda.chora_fim',
		'eagenda.flg_dia_todo',
		'eagenda.cor',
		'eagenda.OBS',
		'eacao.sacao',
		'eacao.nacao',
	);
	
	
	/* métodos de criação de edição *///------------------------------------------------
	public static function save($data) {
		if(!isset($data['cagenda'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		$connection = new Connection();
		
		$eagenda = array();
		
		$data_local = $data['datinha'];
		
		if($data['flg_dia_todo']==1){
			$eagenda = [
				'subtitulo' => (string) _isset($data['subtitulo'], null),
				'cacao' => (int) $data['cacao'],
				'flg_dia_todo' => (int) $data['flg_dia_todo'],
				'cor' => (string) _isset($data['cor'], null),
				'cdia' => date("j",strtotime($data['datinha'])),
				'cmes' => date("n",strtotime($data['datinha'])),
				'can' => date("Y",strtotime($data['datinha'])),
				'cdia_fim' => date("j", strtotime($data_local)),
				'cmes_fim' => date("n", strtotime($data_local)),
				'can_fim' => date("Y", strtotime($data_local)),
				'chora_ini' => 0,
				'cminuto_ini' => 0,
				'chora_fim' => 23,
				'cminuto_fim' => 0,
				'OBS' => (string) _isset($data['OBS'], null)
			];
		} else {
			$eagenda = [
				'subtitulo' => (string) _isset($data['subtitulo'], null),
				'cacao' => (int) $data['cacao'],
				'flg_dia_todo' => (int) _isset($data['flg_dia_todo'], 0),
				'cor' => (string) _isset($data['cor'], null),
				'cdia' => date("j",strtotime($data['datinha'])),
				'cmes' => date("n",strtotime($data['datinha'])),
				'can' => date("Y",strtotime($data['datinha'])),
				'cdia_fim' => date("j",strtotime($data['datinha_fim'])),
				'cmes_fim' => date("n",strtotime($data['datinha_fim'])),
				'can_fim' => date("Y",strtotime($data['datinha_fim'])),
				'chora_ini' => (int) $data['chora_ini'],
				'cminuto_ini' => (int) $data['cminuto_ini'],
				'chora_fim' => (int) $data['chora_fim'],
				'cminuto_fim' => (int) $data['cminuto_fim'],
				'OBS' => (string) _isset($data['OBS'], null)
			];
		}
		
		$cagenda = $connection->insert('eagenda', $eagenda);
		
		if(isset($data['cps']) && is_array($data['cps'])) {
			foreach($data['cps'] as $pessoas) {
				$pessoas['cagenda'] = $cagenda;
				AgendaCruzada::save($pessoas);
			}
		}
		
		return static::findById($cagenda);
	}
	
	public static function edit($data) {
		if(!isset($data['cagenda']) || !static::findById($data['cagenda'], 'count')) {
			throw new Exception("Agenda não encontrada.");
		}
		
		$data_local = $data['datinha'];
		$cagenda = (int) $data['cagenda'];
		
		$connection = new Connection();
		
		if($data['flg_dia_todo']==1){
			$eagenda = [
				'cacao' => (int) $data['cacao'],
				'subtitulo' => (string) _isset($data['subtitulo'], null),
				'cacao' => (int) $data['cacao'],
				'flg_dia_todo' => (int) $data['flg_dia_todo'],
				'cor' => (string) _isset($data['cor'], null),
				'cdia' => date("j",strtotime($data['datinha'])),
				'cmes' => date("n",strtotime($data['datinha'])),
				'can' => date("Y",strtotime($data['datinha'])),
				'cdia_fim' => date("j", strtotime($data_local)),
				'cmes_fim' => date("n", strtotime($data_local)),
				'can_fim' => date("Y", strtotime($data_local)),
				'chora_ini' => 0,
				'cminuto_ini' => 0,
				'chora_fim' => 23,
				'cminuto_fim' => 0,
				'OBS' => (string) _isset($data['OBS'], null)
			];
		} else {
			$eagenda = [
				'cacao' => (int) $data['cacao'],
				'subtitulo' => (string) _isset($data['subtitulo'], null),
				'cacao' => (int) $data['cacao'],
				'flg_dia_todo' => (int) _isset($data['flg_dia_todo'], 0),
				'cor' => (string) _isset($data['cor'], null),
				'cdia' => date("j",strtotime($data['datinha'])),
				'cmes' => date("n",strtotime($data['datinha'])),
				'can' => date("Y",strtotime($data['datinha'])),
				'cdia_fim' => date("j",strtotime($data['datinha_fim'])),
				'cmes_fim' => date("n",strtotime($data['datinha_fim'])),
				'can_fim' => date("Y",strtotime($data['datinha_fim'])),
				'chora_ini' => (int) $data['chora_ini'],
				'cminuto_ini' => (int) $data['cminuto_ini'],
				'chora_fim' => (int) $data['chora_fim'],
				'cminuto_fim' => (int) $data['cminuto_fim'],
				'OBS' => (string) _isset($data['OBS'], null)
			];
		}

		$connection->update('eagenda', $eagenda, "eagenda.cagenda = $cagenda");
		
		if(isset($data['cps']) && is_array($data['cps'])) {
			foreach($data['cps'] as $pessoas) {
				$pessoas['cagenda'] = $cagenda;
				AgendaCruzada::save($pessoas);
			}
		}
		
		return static::findById($cagenda);
	}
	
	//-------------------------------------------------------------
	public static function inativar_agenda($cagenda){
		if(!isset($cagenda) || !static::findById($cagenda)) {
			throw new Exception("Agenda não encontrada.");
		}
		
		$connection = new Connection();
		
		$eagenda = [ 'RA' => 0 ];
		
		$connection->update('eagenda', $eagenda, " eagenda.cagenda = $cagenda ");
		
		return static::findById($cagenda);
	}
	//--------------------------------------------------------------
	
	public static function ean() {
		$connection = new Connection();
		$results = $connection->query(' SELECT can, san, nan FROM ean  WHERE RA = 1;');
		return $results;
	}
	
	public static function emes() {
		$connection = new Connection();
		$results = $connection->query(' SELECT cmes, cmest, smes, nmes FROM emes ;');
		return $results;
	}
	
	public static function edia() {
		$connection = new Connection();
		$results = $connection->query(' SELECT cdia, dia FROM edia WHERE RA = 1;');
		return $results;
	}
	
	public static function edsm() {
		$connection = new Connection();
		$results = $connection->query(' SELECT cdsm, sdsm, ndsm FROM edsm ;');
		return $results;
	}
	
	public static function mes_vigente($mes) { //para mês vigente
		$connection = new Connection();
		$results = $connection->query('SELECT cmes, cmest, smes, nmes FROM emes WHERE cmes ='.$mes.' ;');
		return $results;
	}
	
	public static function acao() {
		$connection = new Connection();
		$results = $connection->query('SELECT cacao, nacao FROM eacao WHERE RA = 1;');
		return $results;
	}
	
	/* specials *///----------------------------------------------------
	
	public static function primeiro_dia(string $primeiroDia){
		switch($primeiroDia){
			case "Sun":
				$pos = 0;
			break;
		 
			case "Mon":
				$pos = 1;
			break;
		 
			case "Tue":
				$pos = 2;
			break;
		 
			case "Wed":
				$pos = 3;
			break;
		 
			case "Thu":
				$pos = 4;
			break;
		 
			case "Fri":
				$pos = 5;
			break;
		 
			case "Sat":
				$pos = 6;
			break;
		}
		return $pos;
	}
	
	/* métodos de busca *///--------------------------------------------
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eagenda.cagenda = $id";
		return static::_find($type, $params);
	}
	
	//public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
	//	$params['conditions'] = _isset($params['conditions'], '');
	//	$params['conditions'] .= " AND eagenda.cps = $cps";
	//	return static::_find($type, $params);
	//}
}