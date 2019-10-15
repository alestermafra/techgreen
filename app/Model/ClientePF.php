<?php
App::import('Table', 'Model');

App::import('PessoaFisica', 'Model');
App::import('ClienteCanal', 'Model');
App::import('ClienteInteresse', 'Model');

class ClientePF extends Table {
	public static $_table = 'zpainel';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zpainel
			INNER JOIN eps ON (eps.cps = zpainel.cps)
			INNER JOIN upsf ON (upsf.cps = eps.cps)
			LEFT JOIN eseg ON (eseg.cseg = zpainel.cseg)
			LEFT JOIN zfone ON (zfone.cps = eps.cps AND zfone.flg_principal = 1)
		WHERE eps.RA = 1
			AND upsf.RA = 1
			AND zpainel.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eps.cps',
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
		'zpainel.czpainel',
		'zpainel.ativo',
		'eseg.cseg',
		'eseg.nseg',
		'zfone.cfone',
		'zfone.fone',
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
		$pf = PessoaFisica::save($data);
		
		$data['cpsf'] = $pf['cpsf'];
		$data['cps'] = $pf['cps'];
		return $data;
	}
	
	public static function saveAssociations($data) {
		if(isset($data['canais']) && is_array($data['canais'])) {
			foreach($data['canais'] as $canal) {
				$canal['cps'] = $data['cps'];
				try {
					ClienteCanal::save($canal);
				}
				catch(Exception $e) {}
			}
		}
		if(isset($data['interesses']) && is_array($data['interesses'])) {
			foreach($data['interesses'] as $interesse) {
				$interesse['cps'] = $data['cps'];
				try {
					ClienteInteresse::save($interesse);
				}
				catch(Exception $e) {}
			}
		}
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !PessoaFisica::findByCps($data['cps'], 'count')) {
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
		$params["order"] = _isset($params["order"], "eps.nps");
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zpainel.czpainel = $id";
		return static::find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::find($type, $params);
	}
	
	public static function findByCPF(string $cpf, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eaux.cpf = '$cpf'";
		return static::find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$value = trim($value);
		$value = preg_replace("/[^0-9a-zA-Z ]/i", "", $value);
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND (
			eps.cps LIKE '$value%'
			OR eps.nps LIKE '%$value%'
			OR upsf.cpf LIKE '$value%'
		)";
		return static::find($type, $params);
	}
	
	
	
	public static function telefones(int $cps, string $type = 'all', array $params = array()) {
		return PessoaFisica::telefones($cps, $type, $params);
	}
	
	public static function enderecos(int $cps, string $type = 'all', array $params = array()) {
		return PessoaFisica::enderecos($cps, $type, $params);
	}
	
	public static function canais(int $cps, string $type = 'all', array $params = array()) {
		return ClienteCanal::findByCps($cps, $type, $params);
	}
	
	public static function interesses(int $cps, string $type = 'all', array $params = array()) {
		return ClienteInteresse::findByCps($cps, $type, $params);
	}
}