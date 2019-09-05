<?php
App::import('Table', 'Model');

App::import('Email', 'Model');
App::import('Telefone', 'Model');
App::import('Endereco', 'Model');

class Pessoa extends Table {
	public static $_table = 'eps';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eps
			LEFT JOIN susu ON (susu.cps = eps.cps)
			LEFT JOIN upsf ON (upsf.cps = eps.cps)
			LEFT JOIN upsj ON (upsj.cps = eps.cps)
			LEFT JOIN zpainel ON (zpainel.cps = eps.cps AND zpainel.ativo = 1)
			LEFT JOIN zfornec ON (zfornec.cps = eps.cps)
		WHERE eps.RA = 1
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
		'susu.cusu',
		'upsf.cpsf',
		'upsj.cpsj',
		'zpainel.czpainel',
		'zfornec.czfornec',
	);
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cps'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cps'];
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
		if(!isset($data['nps']) || strlen(strval($data['nps'])) === 0) {
			throw new Exception("Nome inválido.");
		}
		if($mode === 'create') {
			/* ... */
		}
		else if($mode === 'edit') {
			/* ... */
		}
		
		$new_data = array();
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['sps'])) {
			$new_data['sps'] = strval($data['sps']);
		}
		if(isset($data['nps'])) {
			$new_data['nps'] = strval($data['nps']);
		}
		if(isset($data['flg_sys'])) {
			$new_data['flg_sys'] = intval($data['flg_sys']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "eps.cps = {$data['cps']}");
	}



	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $id";
		return static::_find($type, $params);
	}
}