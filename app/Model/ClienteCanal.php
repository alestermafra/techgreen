<?php
App::import('Table', 'Model');

App::import('Canal', 'Model');
App::import('Pessoa', 'Model');

class ClienteCanal extends Table {
	
	public static $_table = 'zcanal';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zcanal
			INNER JOIN ecanal ON (ecanal.ccanal = zcanal.ccanal)
			INNER JOIN eps ON (eps.cps = zcanal.cps)
		WHERE zcanal.RA = 1 AND ecanal.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'zcanal.czcanal',
		'ecanal.ccanal',
		'ecanal.ncanal',
		'ecanal.flg_obs',
		'zcanal.OBS',
		'eps.cps',
		'eps.nps',
	);
	
	
	public static function save($data) {
		static::saveDependencies($data);
		
		if(!isset($data['czcanal'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czcanal'];
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
			if(!isset($data['ccanal'])) {
				throw new Exception("Canal inválido.");
			}
		}
		else if($mode === 'edit') {
			if(!isset($data['ccanal'])) { /* remove o canal se vier sem ccanal (se vier desmarcado) */
				static::remove("zcanal.czcanal = {$data['czcanal']}");
				return array();
			}
		}
		
		$new_data = array();
		if(isset($data['czcanal'])) {
			$new_data['czcanal'] = intval($data['czcanal']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ccanal'])) {
			$new_data['ccanal'] = intval($data['ccanal']);
		}
		if(isset($data['OBS'])) {
			$new_data['OBS'] = strval($data['OBS']);
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
		static::update($data, "zcanal.czcanal = {$data['czcanal']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zcanal.czcanal = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
}