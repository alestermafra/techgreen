<?php
App::import('Table', 'Model');

App::import('Locacao', 'Model');

class ValeLocacao extends Table {
	
	public static $_table = 'uhoraslocacao';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM uhoraslocacao
			LEFT JOIN eps ON (eps.cps = uhoraslocacao.cps)
		WHERE uhoraslocacao.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'uhoraslocacao.choraslocacao',
		'uhoraslocacao.horas',
		'eps.cps',
		'eps.nps',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['choraslocacao'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*insere*/
	public static function create($data) {
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		$connection = new Connection();
		
		$ehoraslocacao = [
			'cps' => (int) _isset($data['cps'], null),
			'horas' => (int) _isset($data['horas'], null),
		];
		$choraslocacao = $connection->insert('uhoraslocacao', $ehoraslocacao);
		
		return static::findById($choraslocacao);
	}
	
	/*edita*/
	public static function edit($data) {
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		$choraslocacao = $data['choraslocacao'];
		
		$connection = new Connection();
		
		$ehoraslocacao = [
			'horas' => (int) _isset($data['horas'], null),
		];
		$connection->update('uhoraslocacao', $ehoraslocacao, "uhoraslocacao.choraslocacao = $choraslocacao");
		
		return $data;
	}
	
	/*adiciona horas ao saldo existente*/
	public static function special($data) {
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		$atual = static::FindByCps($data['cps'], 'first');
		
		$cps = $data['cps'];
		
		$connection = new Connection();
		
		$ehoraslocacao = [
			'horas' => (int) $atual['horas'] + (int) _isset($data['horas'], null),
		];
		$connection->update('uhoraslocacao', $ehoraslocacao, "uhoraslocacao.cps = $cps");
		
		return $data;
	}
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uhoraslocacao.choraslocacao = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uhoraslocacao.cps = $cps";
		return static::_find($type, $params);
	}
	
}