<?php
App::import('Table', 'Model');

App::import('Pessoa', 'Model');
App::import('Email', 'Model');
App::import('Telefone', 'Model');
App::import('Endereco', 'Model');

class PessoaFisica extends Table {
	public static $_table = 'upsf';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM upsf
			INNER JOIN eps ON (eps.cps = upsf.cps)
		WHERE upsf.RA = 1
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
		'upsf.d_contato',
		'upsf.m_contato',
		'upsf.a_contato',
	);
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cpsf'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cpsf'];
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
		if(isset($data['telefones']) && is_array($data['telefones'])) {
			foreach($data['telefones'] as $tel) {
				$tel['cps'] = $data['cps'];
				try {
					Telefone::save($tel);
				}
				catch(Exception $e) {}
			}
		}
		if(isset($data['enderecos']) && is_array($data['enderecos'])) {
			foreach($data['enderecos'] as $endereco) {
				$endereco['cps'] = $data['cps'];
				try {
					Endereco::save($endereco);
				}
				catch(Exception $e) {}
			}
		}
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !Pessoa::findById($data['cps'], 'count')) {
			throw new Exception("Registro de pessoa não encontrado.");
		}
		if($mode === 'create') {
			if(isset($data['cpf']) && strlen($data['cpf']) > 0 && static::findByCPF($data['cpf'], 'count')) { 
				throw new Exception("Este CPF já está sendo usado.");
			}
		}
		else if($mode === 'edit') {
			if(isset($data['cpf']) && strlen($data['cpf']) > 0 && static::findByCPF($data['cpf'], 'count', array('conditions' => " AND eps.cps != {$data['cps']}"))) { 
				throw new Exception("Este CPF já está sendo usado.");
			}
		}
		
		$new_data = array();
		if(isset($data['cpsf'])) {
			$new_data['cpsf'] = intval($data['cpsf']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['d_nasc'])) {
			$new_data['d_nasc'] = intval($data['d_nasc']);
		}
		if(isset($data['m_nasc'])) {
			$new_data['m_nasc'] = intval($data['m_nasc']);
		}
		if(isset($data['a_nasc'])) {
			$new_data['a_nasc'] = intval($data['a_nasc']);
		}
		if(isset($data['rg'])) {
			$new_data['rg'] = strval($data['rg']);
		}
		if(isset($data['cpf'])) {
			$new_data['cpf'] = preg_replace('/[^0-9]/i', '', strval($data['cpf']));
		}
		if(isset($data['email'])) {
			$new_data['email'] = strval($data['email']);
		}
		if(isset($data['profissao'])) {
			$new_data['profissao'] = strval($data['profissao']);
		}
		if(isset($data['equipe'])) {
			$new_data['equipe'] = strval($data['equipe']);
		}
		if(isset($data['peso'])) {
			$new_data['peso'] = strval($data['peso']);
		}
		if(isset($data['dependente1'])) {
			$new_data['dependente1'] = strval($data['dependente1']);
		}
		if(isset($data['dependente2'])) {
			$new_data['dependente2'] = strval($data['dependente2']);
		}
		if(isset($data['dependente3'])) {
			$new_data['dependente3'] = strval($data['dependente3']);
		}
		if(isset($data['dependente4'])) {
			$new_data['dependente4'] = strval($data['dependente4']);
		}
		if(isset($data['dependente5'])) {
			$new_data['dependente5'] = strval($data['dependente5']);
		}
		if(isset($data['d_contato'])) {
			$new_data['d_contato'] = intval($data['d_contato']);
		}
		if(isset($data['m_contato'])) {
			$new_data['m_contato'] = intval($data['m_contato']);
		}
		if(isset($data['a_contato'])) {
			$new_data['a_contato'] = intval($data['a_contato']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "upsf.cpsf = {$data['cpsf']}");
	}



	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND upsf.cpsf = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByCPF(string $cpf, string $type = 'first', array $params = array()) {
		$cpf = preg_replace('/[^0-9]/i', '', $cpf);
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND upsf.cpf = '$cpf'";
		return static::_find($type, $params);
	}
	
	
	public static function telefones(int $cps, string $type = 'all', array $params = array()) {
		return Telefone::findByCps($cps, $type, $params);
	}
	
	public static function enderecos(int $cps, string $type = 'all', array $params = array()) {
		return Endereco::findByCps($cps, $type, $params);
	}
}