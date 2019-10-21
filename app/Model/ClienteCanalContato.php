<?php
App::import('Table', 'Model');

App::import('CanalContato', 'Model');
App::import('Pessoa', 'Model');

class ClienteCanalContato extends Table {
	
	public static $_table = 'zcanalcontato';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zcanalcontato
			INNER JOIN ecanalcontato ON (ecanalcontato.ccanalcontato = zcanalcontato.ccanalcontato)
			INNER JOIN eps ON (eps.cps = zcanalcontato.cps)
		WHERE zcanalcontato.RA = 1 AND ecanalcontato.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'zcanalcontato.czcanalcontato',
		'ecanalcontato.ccanalcontato',
		'ecanalcontato.ncanalcontato',
		'ecanalcontato.flg_obs',
		'zcanalcontato.OBS',
		'eps.cps',
		'eps.nps',
	);
	
	
	public static function save($data) {
		static::saveDependencies($data);
		
		if(!isset($data['czcanalcontato'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czcanalcontato'];
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
			if(!isset($data['ccanalcontato'])) {
				throw new Exception("Canal de Contato inválido.");
			}
		}
		else if($mode === 'edit') {
			if(!isset($data['ccanalcontato'])) { /* remove o canal se vier sem ccanal (se vier desmarcado) */
				static::remove("zcanalcontato.czcanalcontato = {$data['czcanalcontato']}");
				return array();
			}
		}
		
		$new_data = array();
		if(isset($data['czcanalcontato'])) {
			$new_data['czcanalcontato'] = intval($data['czcanalcontato']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ccanalcontato'])) {
			$new_data['ccanalcontato'] = intval($data['ccanalcontato']);
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
		static::update($data, "zcanalcontato.czcanalcontato = {$data['czcanalcontato']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zcanalcontato.czcanalcontato = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
}