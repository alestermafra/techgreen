<?php
App::import('Table', 'Model');
App::import('Interesse', 'Model');

class ClienteInteresse extends Table {
	
	public static $_table = 'zinteresse';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zinteresse
			INNER JOIN tinteresse ON (tinteresse.ctinteresse = zinteresse.ctinteresse)
			INNER JOIN eps ON (eps.cps = zinteresse.cps)
		WHERE zinteresse.RA = 1 AND tinteresse.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'zinteresse.czinteresse',
		'tinteresse.ctinteresse',
		'tinteresse.ntinteresse',
		'eps.cps',
		'eps.nps',
	);
	
	
	public static function save($data) {
		static::saveDependencies($data);
		
		if(!isset($data['czinteresse'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czinteresse'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		return $data;
	}
	
	public static function saveAssociations($data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if($mode === 'create') {
			if(!isset($data['ctinteresse'])) {
				throw new Exception("Interesse inválido.");
			}
		}
		else if($mode === 'edit') {
			if(!isset($data['ctinteresse'])) { /* remove o interesse se vier sem interesse (se vier desmarcado) */
				static::remove("zinteresse.czinteresse = {$data['czinteresse']}");
				return array();
			}
		}
		
		$new_data = array();
		if(isset($data['czinteresse'])) {
			$new_data['czinteresse'] = intval($data['czinteresse']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ctinteresse'])) {
			$new_data['ctinteresse'] = intval($data['ctinteresse']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		if(empty($data)) {
			return 0;
		}
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		if(empty($data)) {
			return 0;
		}
		static::update($data, "zinteresse.czinteresse = {$data['czinteresse']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		$params["order"] = _isset($params["order"], "tinteresse.ctinteresse asc");
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zinteresse.czinteresse = $id";
		return static::find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::find($type, $params);
	}
}