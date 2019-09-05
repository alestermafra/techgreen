<?php
App::import('Table', 'Model');

App::import('Pessoa', 'Model');

class PessoaJuridica extends Table {
	public static $_table = 'upsj';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM upsj
			INNER JOIN eps ON (eps.cps = upsj.cps)
		WHERE upsj.RA = 1
			AND eps.RA = 1
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
		'upsj.cpsj',
		'upsj.cnpj',
	);
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cpsj'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cpsj'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		$pessoa = Pessoa::save($data);
		$data['cps'] = $pessoa['cps'];
		
		return $data;
	}
	
	public static function saveAssociations($data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !Pessoa::findById($data['cps'], 'count')) {
			throw new Exception("Registro de pessoa não encontrado.");
		}
		if($mode === 'create') {
			if(isset($data['cnpj']) && static::findByCNPJ($data['cnpj'], 'count')) { 
				throw new Exception("Este CNPJ já está sendo usado.");
			}
		}
		else if($mode === 'edit') {
			if(isset($data['cnpj']) && static::findByCNPJ($data['cnpj'], 'count', array('conditions' => " AND eps.cps != {$data['cps']}"))) {
				throw new Exception("Este CNPJ já está sendo usado.");
			}
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
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND upsj.cpsj = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByCNPJ(string $cnpj, string $type = 'first', array $params = array()) {
		$cnpj = preg_replace('/[^0-9]/i', '', $cnpj);
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND upsj.cnpj = $cnpj";
		return static::_find($type, $params);
	}
}