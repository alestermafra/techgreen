<?php
App::import('Table', 'Model');

App::import('TipoTelefone', 'Model');

App::import('Pessoa', 'Model');

class Telefone extends Table {
	
	public static $_table = 'zfone';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zfone
			INNER JOIN eps ON (eps.cps = zfone.cps)
			INNER JOIN tfone ON (tfone.ctfone = zfone.ctfone)
		WHERE zfone.RA = 1 AND tfone.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'zfone.cfone',
		'zfone.fone',
		'zfone.flg_principal',
		'tfone.ctfone',
		'tfone.ntfone',
		'eps.cps',
		'eps.nps',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cfone']) || intval($data['cfone']) === 0) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cfone'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		return $data;
	}
	
	public static function saveAssociations(&$data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !Pessoa::findById($data['cps'], 'count')) {
			throw new Exception("Registro de pessoa não encontrado.");
		}
		if($mode === 'create') {
			if(isset($data['fone']) && strlen($data['fone']) === 0) {
				throw new Exception("Número de telefone inválido.");
			}
		}
		else if($mode === 'edit') {
			$current = static::findById($data['cfone']);
			if(isset($data['fone']) && strlen($data['fone']) === 0) {
				static::remove("zfone.cfone = {$data['cfone']}");
				if($current['flg_principal'] == 1) { /* se o cara removido for o principal, nomeia o primeiro telefone como principal. */
					$fone = static::findByCps($data['cps'], 'first');
					$fone['flg_principal'] = 1;
					static::save($fone);
				}
				return array();
			}
		}
		
		$new_data = array();
		if(isset($data['cfone'])) {
			$new_data['cfone'] = intval($data['cfone']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ctfone'])) {
			$new_data['ctfone'] = intval($data['ctfone']);
		}
		if(isset($data['fone'])) {
			$new_data['fone'] = preg_replace('/[^0-9]/i', '', strval($data['fone']));
		}
		if(isset($data['flg_principal'])) {
			$new_data['flg_principal'] = intval($data['flg_principal']);
		}
		
		/* se não tiver nenhum principal, nomeia o cara como principal. */
		if(static::findByCps($data['cps'], 'count', array('conditions' => " AND zfone.flg_principal = 1")) === 0) {
			$new_data['flg_principal'] = 1;
		}
		else if(isset($new_data['flg_principal']) && $new_data['flg_principal'] == 1) {
			static::update(array('flg_principal' => 0), "zfone.cps = {$data['cps']}");
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
		static::update($data, "zfone.cfone = {$data['cfone']}");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zfone.cfone = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
}