<?php
App::import('Table', 'Model');

App::import('PessoaFisica', 'Model');

class ColaboradorPF extends Table {
	public static $_table = 'zcolab';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zcolab
			INNER JOIN upsf ON (upsf.cps = zcolab.cps)
			INNER JOIN eps ON (eps.cps = upsf.cps)
		WHERE eps.RA = 1
			AND upsf.RA = 1
			AND zcolab.RA = 1
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
		'upsf.rg',
		'upsf.cpf',
		'upsf.email',
		'upsf.d_nasc',
		'upsf.m_nasc',
		'upsf.a_nasc',
		'zcolab.czcolab',
		'zcolab.ativo',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['czcolab'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czcolab'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		$pf = PessoaFisica::save($data);
		
		$data['cps'] = $pf['cps'];
		$data['cpsf'] = $pf['cpsf'];
		return $data;
	}
	
	public static function saveAssociations($data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if($mode === 'create') {
			/* ... */
		}
		else if($mode === 'edit') {
			/* ... */
		}
		
		$new_data = array();
		if(isset($data['czcolab'])) {
			$new_data['czcolab'] = intval($data['czcolab']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
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
		static::update($data, "zcolab.czcolab = {$data['czcolab']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zcolab.czcolab = $id";
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