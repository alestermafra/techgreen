<?php
App::import('Table', 'Model');

App::import('PessoaJuridica', 'Model');

class FornecedorPJ extends Table {
	public static $_table = 'zfornec';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zfornec
			INNER JOIN upsj ON (upsj.cps = zfornec.cps)
			INNER JOIN eps ON (eps.cps = upsj.cps)
			LEFT JOIN tfornec ON (tfornec.ctfornec = zfornec.ctfornec)
		WHERE eps.RA = 1
			AND upsj.RA = 1
			AND zfornec.RA = 1
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
		'upsj.email',
		'zfornec.czfornec',
		'zfornec.ativo',
		'zfornec.espec',
		'tfornec.ctfornec',
		'tfornec.ntfornec',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['czfornec'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['czfornec'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		$pf = PessoaJuridica::save($data);
		
		$data['cps'] = $pf['cps'];
		$data['cpsj'] = $pf['cpsj'];
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
		if(isset($data['czfornec'])) {
			$new_data['czfornec'] = intval($data['czfornec']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ctfornec'])) {
			$new_data['ctfornec'] = intval($data['ctfornec']);
		}
		if(isset($data['ativo'])) {
			$new_data['ativo'] = intval($data['ativo']);
		}
		if(isset($data['espec'])) {
			$new_data['espec'] = strval($data['espec']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "zfornec.czfornec = {$data['czfornec']}");
	}
	
	/* insere o cps na tabela de fornecedores */
	public static function cps_to_fornec(int $cps) {
		if(!static::findByCps($cps, 'count')) {
			$connection = new Connection();
			
			$zfornec = [
				'cps' => (int) $cps
			];
			$connection->insert('zfornec', $zfornec);
			return true;
		}
		return false;
	}
	
	
	/* specials */
	public static function telefones(int $cps, string $type = 'all', array $params = array()) {
		return PessoaJuridica::telefones($cps, $type, $params);
	}
	
	public static function enderecos(int $cps, string $type = 'all', array $params = array()) {
		return PessoaJuridica::enderecos($cps, $type, $params);
	}
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zfornec.czfornec = $id";
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