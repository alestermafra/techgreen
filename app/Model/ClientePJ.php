<?php
App::import('Table', 'Model');

App::import('PessoaJuridica', 'Model');

class ClientePJ extends Table {
	public static $_table = 'zpainel';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zpainel
			INNER JOIN eps ON (eps.cps = zpainel.cps)
			INNER JOIN upsj ON (upsj.cps = eps.cps)
			INNER JOIN eseg ON (eseg.cseg = zpainel.cseg)
		WHERE eps.RA = 1
			AND upsj.RA = 1
			AND zpainel.RA = 1
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
		'upsj.cpsj',
		'upsj.cnpj',
		'zpainel.czpainel',
		'zpainel.ativo',
		'eseg.cseg',
		'eseg.nseg',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
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
	
	public static function saveDependencies($data) {
		$pf = PessoaJuridica::save($data);
		
		$data['cpsj'] = $pf['cpsj'];
		$data['cps'] = $pf['cps'];
		return $data;
	}
	
	public static function saveAssociations($data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !PessoaJuridica::findByCps($data['cps'], 'count')) {
			throw new Exception("[cps] inválido.");
		}
		if($mode === 'create') {
			/* ... */
		}
		else if($mode === 'edit') {
			/* ... */
		}
		
		$new_data = array();
		if(isset($data['czpainel'])) {
			$new_data['czpainel'] = intval($data['czpainel']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['cseg'])) {
			$new_data['cseg'] = intval($data['cseg']);
		}
		if(isset($data['ativo'])) {
			$new_data['ativo'] = intval($data['ativo']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "zpainel.czpainel = {$data['czpainel']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
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
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}