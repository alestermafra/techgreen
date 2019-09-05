<?php
App::import('Table', 'Model');	

App::import('PessoaFisica', 'Model');	

class Contato extends Table {
	public static $_table = 'uccon';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM uccon
			INNER JOIN upsf ON (upsf.cps = uccon.cps_contato)
			INNER JOIN eps ON (eps.cps = upsf.cps)
		WHERE eps.RA = 1
			AND upsf.RA = 1
			AND uccon.RA = 1
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
		'upsf.d_nasc',
		'upsf.m_nasc',
		'upsf.a_nasc',
		'upsf.rg',
		'upsf.cpf',
		'upsf.email',
		'upsf.profissao',
		'upsf.equipe',
		'upsf.peso',
		'upsf.dependente1',
		'upsf.dependente2',
		'upsf.dependente3',
		'upsf.dependente4',
		'upsf.dependente5',
		'(SELECT cfone FROM zfone WHERE cps = eps.cps AND flg_principal = 1 AND RA = 1 LIMIT 1) AS cfone',
		'(SELECT fone FROM zfone WHERE cps = eps.cps AND flg_principal = 1 AND RA = 1 LIMIT 1) AS fone',
		'uccon.cccon',
		'uccon.cps_conta',
		'uccon.cps_contato',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cccon'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cccon'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		$pf = PessoaFisica::save($data);
		
		$data['cps'] = $pf['cps'];
		$data['cpsf'] = $pf['cpsf'];
		$data['cps_contato'] = $pf['cps'];
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
		if(isset($data['cccon'])) {
			$new_data['cccon'] = intval($data['cccon']);
		}
		if(isset($data['cps_conta'])) {
			$new_data['cps_conta'] = intval($data['cps_conta']);
		}
		if(isset($data['cps_contato'])) {
			$new_data['cps_contato'] = intval($data['cps_contato']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "uccon.cccon = {$data['cccon']}");
	}
	
	
	/*busca*/
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cccon = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCpsConta(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cps_conta = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByCpsContato(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cps_contato = $cps";
		return static::_find($type, $params);
	}
}