<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('Segmentacao', 'Model');

App::import('ClientePF', 'Model');
App::import('ClientePJ', 'Model');
App::import('Fornecedor', 'Model');
App::import('FornecedorPF', 'Model');

class DadosAuxiliares extends Table {
	
	public static $_table = 'eaux';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eaux
			INNER JOIN eps ON (eps.cps = eaux.cps)
			LEFT JOIN eseg ON (eseg.cseg = eaux.cseg)
		WHERE eaux.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eaux.caux',
		'eaux.cpf',
		'eaux.d_nasc',
		'eaux.m_nasc',
		'eaux.a_nasc',
		'eaux.peso',
		'eaux.ativo',
		'eaux.profissao',
		'eaux.dependente1',
		'eaux.dependente2',
		'eaux.dependente3',
		'eaux.dependente4',
		'eaux.dependente5',
		'eps.cps',
		'eps.nps',
		'eseg.cseg',
		'eseg.nseg',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['caux'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		if(isset($data['cps']) && static::findByCps($data['cps'], 'count')) {
			return static::edit($data);
		}
		if(!isset($data['cps']) || !FornecedorPF::findByCps($data['cps'], 'count') && !Fornecedor::findByCps($data['cps'], 'count') && !ClientePF::findByCps($data['cps'], 'count') && !ClientePJ::findByCps($data['cps'], 'count')) {
			throw new Exception("Cliente não encontrado.");
		}
		if(isset($data['cseg']) && !Segmentacao::findById($data['cseg'], 'count')) {
			throw new Exception("Segmentação inválida.");
		}
		
		$cps = (int) $data['cps'];
		
		$eaux = [
			'cps' => $cps
		];
		if(isset($data['cpf'])) {
			$eaux['cpf'] = (string) $data['cpf'];
		}
		if(isset($data['rg'])) {
			$eaux['rg'] = (string) $data['rg'];
		}
		if(isset($data['d_nasc'])) {
			$eaux['d_nasc'] = (int) $data['d_nasc'];
		}
		if(isset($data['m_nasc'])) {
			$eaux['m_nasc'] = (int) $data['m_nasc'];
		}
		if(isset($data['a_nasc'])) {
			$eaux['a_nasc'] = (int) $data['a_nasc'];
		}
		if(isset($data['peso'])) {
			$eaux['peso'] = (string) $data['peso'];
		}
		if(isset($data['equipe'])) {
			$eaux['equipe'] = (string) $data['equipe'];
		}
		if(isset($data['cseg'])) {
			$eaux['cseg'] = (int) $data['cseg'];
		}
		if(isset($data['ativo'])) {
			$eaux['ativo'] = (int) $data['ativo'];
		}
		if(isset($data['profissao'])) {
			$eaux['profissao'] = $data['profissao'];
		}
		if(isset($data['dependente1'])) {
			$eaux['dependente1'] = $data['dependente1'];
		}
		if(isset($data['dependente2'])) {
			$eaux['dependente2'] = $data['dependente2'];
		}
		if(isset($data['dependente3'])) {
			$eaux['dependente3'] = $data['dependente3'];
		}
		if(isset($data['dependente4'])) {
			$eaux['dependente4'] = $data['dependente4'];
		}
		if(isset($data['dependente5'])) {
			$eaux['dependente5'] = $data['dependente5'];
		}
		
		$connection = new Connection();
		$caux = $connection->insert('eaux', $eaux);
		
		return static::findById($caux);
	}
	
	public static function edit($data) {
		if(!isset($data['cps']) || !FornecedorPF::findByCps($data['cps'], 'count') && !Fornecedor::findByCps($data['cps'], 'count') && !ClientePF::findByCps($data['cps'], 'count') && !ClientePJ::findByCps($data['cps'], 'count')) {
			throw new Exception("Nome inválido.");
		}
		if(isset($data['cseg']) && !Segmentacao::findById($data['cseg'], 'count')) {
			throw new Exception("Segmentação inválida.");
		}
		
		$cps = (int) $data['cps'];
		$cliente_segmentacao = static::findByCps($cps);
		$caux = $cliente_segmentacao['caux'];
		
		$eaux = [
			'cps' => $cps
		];
		if(isset($data['cpf'])) {
			$eaux['cpf'] = (string) $data['cpf'];
		}
		if(isset($data['rg'])) {
			$eaux['rg'] = (string) $data['rg'];
		}
		if(isset($data['d_nasc'])) {
			$eaux['d_nasc'] = (int) $data['d_nasc'];
		}
		if(isset($data['m_nasc'])) {
			$eaux['m_nasc'] = (int) $data['m_nasc'];
		}
		if(isset($data['a_nasc'])) {
			$eaux['a_nasc'] = (int) $data['a_nasc'];
		}
		if(isset($data['peso'])) {
			$eaux['peso'] = (string) $data['peso'];
		}
		if(isset($data['equipe'])) {
			$eaux['equipe'] = (string) $data['equipe'];
		}
		if(isset($data['cseg'])) {
			$eaux['cseg'] = (int) $data['cseg'];
		}
		if(isset($data['ativo'])) {
			$eaux['ativo'] = (int) $data['ativo'];
		}
		if(isset($data['profissao'])) {
			$eaux['profissao'] = $data['profissao'];
		}
		if(isset($data['dependente1'])) {
			$eaux['dependente1'] = $data['dependente1'];
		}
		if(isset($data['dependente2'])) {
			$eaux['dependente2'] = $data['dependente2'];
		}
		if(isset($data['dependente3'])) {
			$eaux['dependente3'] = $data['dependente3'];
		}
		if(isset($data['dependente4'])) {
			$eaux['dependente4'] = $data['dependente4'];
		}
		if(isset($data['dependente5'])) {
			$eaux['dependente5'] = $data['dependente5'];
		}
		
		$connection = new Connection();
		$connection->update('eaux', $eaux, "eaux.caux = $caux");
		
		return static::findById($caux);
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eaux.caux = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
}