<?php
App::import('Table', 'Model');

class Cliente extends Table {
	public static $_table = 'zpainel';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zpainel
			INNER JOIN eps ON (eps.cps = zpainel.cps)
			INNER JOIN eseg ON (eseg.cseg = zpainel.cseg)
			LEFT JOIN upsf ON (upsf.cps = zpainel.cps AND upsf.RA = 1)
			LEFT JOIN upsj ON (upsj.cps = zpainel.cps AND upsj.RA = 1)
		WHERE zpainel.RA = 1
			AND eps.RA = 1
			AND eseg.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eps.cps',
		'eps.sps',
		'eps.nps',
		'upsf.cpsf',
		'upsj.cpsj',
	);
	
	
	public static function save($data) {
		static::saveDependencies($data);
		
		if(!isset($data['czpainel'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czpainel'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies(&$data) {
		$pessoa = Pessoa::save($data);
		$data['cps'] = $pessoa['cps'];
	}
	
	public static function saveAssociations(&$data) {
		return;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !Pessoa::findById($data['cps'], 'count')) {
			throw new Exception("Registro de pessoa não encontrado.");
		}
		if($mode === 'create') {
			/* ... */
		}
		else if($mode === 'edit') {
			/* ... */
		}
		
		$new_data = array();
		if(isset($data['cpsj'])) {
			$new_data['cpsj'] = intval($data['cpsj']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['cnpj'])) {
			$new_data['cnpj'] = preg_replace('/[^0-9]/i', '', strval($data['cnpj']));
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "upsj.cpsj = {$data['cpsj']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		$params["order"] = _isset($params["order"], "eps.nps");
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zpainel.czpainel = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function last_clients(int $last, string $type = 'all', array $params = array()) {
		$params['limit'] = $last;
		$params['order'] = 'eps.TS DESC';
		return static::_find($type, $params);
	}
	
	public static function YTD_month(int $year = null, string $type = 'all', array $params = array()) {
		if(!$year) {
			$year = date('Y');
		}
		$params['fields'] = _isset($params["fields"], ["MONTH(zpainel.TS) AS m", "COUNT(*) AS c"]);
		$params['conditions'] = _isset($params['conditions'], " AND YEAR(zpainel.TS) = $year");
		$params['group'] = _isset($params["group"], "m ASC");
		return static::_find($type, $params);
	}
	
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$value = trim($value);
		//$value = preg_quote($value);
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND (
			eps.cps LIKE '$value%'
			OR eps.nps LIKE '%$value%'
		)";
		return static::find($type, $params);
	}
}