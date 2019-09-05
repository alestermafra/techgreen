<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

class AgendaCruzada extends Table {
	
	public static $_table = 'zagenda';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zagenda
			INNER JOIN eagenda ON (eagenda.cagenda = zagenda.cagenda)
			INNER JOIN eps ON (eps.cps = zagenda.cps)
			LEFT JOIN eprod ON (eprod.cprod = zagenda.cprod)
		WHERE zagenda.RA = 1 AND eagenda.RA = 1 AND eps.RA = 1 AND eps.flg_sys = 0
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'zagenda.czagenda',
		'zagenda.cprod',
		'eagenda.cagenda',
		'eprod.nprod',
		'eps.cps',
		'eps.nps',
	);
	
	
	/* métodos de criação*/
	public static function save($data) {
		if(!isset($data['czagenda'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*insere*/
	public static function create($data) {
		if(!isset($data['cagenda'])) {
			throw new Exception("Agenda inválida.");
		}
		
		$cps = (int) $data['cps'];
		$cagenda = (int) $data['cagenda'];
		$cprod = (int) _isset($data['cprod'], null);
		
		if(!$cps) {
			return $data;
		}
		
		$connection = new Connection();
		
		$zagenda = [
			'cps' => $cps,
			'cagenda' => $cagenda,
			'cprod' => $cprod,
		];
		
		$czagenda = $connection->insert('zagenda', $zagenda);
		
		return static::findById($czagenda);
	}
	
	/*edita*/
	public static function edit($data) {
		if(!isset($data['cagenda'])) {
			throw new Exception("Agenda inválida.");
		}
		
		$czagenda = (int) $data['czagenda'];
		$cps = (int) $data['cps'];
		$cagenda = (int) $data['cagenda'];
		$cprod = (int) _isset($data['cprod'], null);
		
		$connection = new Connection();
		
		$zagenda = [
			'czagenda' => $czagenda,
			'cps' => $cps,
			'cagenda' => $cagenda,
			'cprod' => $cprod,
		];
		
		/* remove o cps estiver vazio */
		if(!$data['cps'] || $cps == 0) {
			$connection->remove('zagenda', "zagenda.czagenda = $czagenda");
		}else {
			$connection->update('zagenda', $zagenda, "zagenda.czagenda = $czagenda");
		}
		
	}
	
	/*remover*/
	public static function remover(int $czagenda){
		$connection = new Connection();		
		$connection->remove('zagenda', "zagenda.czagenda = ".$czagenda);
	}
	
	/*remover special*/
	public static function remover_cps_vazio(int $cagenda){
		$connection = new Connection();		
		$connection->remove('zagenda', "zagenda.cagenda = $cagenda AND zagenda.cps = 0");
	}
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zagenda.czagenda = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByCagenda(int $cagenda, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eagenda.cagenda = $cagenda";
		return static::_find($type, $params);
	}
}