<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('Equipamento', 'Model');

class Pertence extends Table {
	
	public static $_table = 'epertence';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM epertence
			INNER JOIN eequipe ON (eequipe.cequipe = epertence.cequipe)
		WHERE epertence.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'epertence.cpertence',
		'eequipe.cequipe',
		'eequipe.nome',
		'epertence.npertence',
		'epertence.marca',
		'epertence.modelo',
		'epertence.tamanho',
		'epertence.cor',
		'epertence.ano',
		'epertence.estado_geral',
	);
	
	
	/* métodos de criação de edição */
	public static function save($pertence) {
		if(!isset($pertence['cpertence'])) {
			return static::create($pertence);
		}
		return static::edit($pertence);
	}
	
	public static function create($pertence) {
		if(!isset($pertence['cequipe']) || !Equipamento::findById($pertence['cequipe'])) {
			throw new Exception('Equipamento inválido.');
		}
		if(!isset($pertence['npertence']) || strlen($pertence['npertence']) == 0) {
			throw new Exception('Nome inválido.');
		}
		
		$connection = new Connection();
		
		$epertence = [
			'cequipe' => (int) _isset($pertence['cequipe'], null),
			'npertence' => (string) _isset($pertence['npertence'], null),
			'marca' => (string) _isset($pertence['marca'], null),
			'modelo' => (string) _isset($pertence['modelo'], null),
			'tamanho' => (string) _isset($pertence['tamanho'], null),
			'cor' => (string) _isset($pertence['cor'], null),
			'ano' => (string) _isset($pertence['ano'], null),
			'estado_geral' => (string) _isset($pertence['estado_geral'], null),
		];
		$cpertence = $connection->insert('epertence', $epertence);
		
		return static::findById($cpertence);
	}
	
	public static function edit($pertence) {
		if(!isset($pertence['cequipe']) || !Equipamento::findById($pertence['cequipe'])) {
			throw new Exception('Equipamento inválido.');
		}
		if(!isset($pertence['npertence']) || strlen($pertence['npertence']) == 0) {
			throw new Exception('Nome inválido.');
		}
		
		$cpertence = $pertence['cpertence'];
		
		$connection = new Connection();
		
		$epertence = [
			'cequipe' => (int) _isset($pertence['cequipe'], null),
			'npertence' => (string) _isset($pertence['npertence'], null),
			'marca' => (string) _isset($pertence['marca'], null),
			'modelo' => (string) _isset($pertence['modelo'], null),
			'tamanho' => (string) _isset($pertence['tamanho'], null),
			'cor' => (string) _isset($pertence['cor'], null),
			'ano' => (string) _isset($pertence['ano'], null),
			'estado_geral' => (string) _isset($pertence['estado_geral'], null),
		];
		$connection->update('epertence', $epertence, "epertence.cpertence = $cpertence");
		
		return static::findById($cpertence);
	}
	
	public static function remove($pertence) {
		if(!isset($pertence['cpertence'])) {
			return;
		}
		
		$cpertence = (int) $pertence['cpertence'];
		
		$connection = new Connection();
		$connection->remove('epertence', "epertence.cpertence = $cpertence");
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND epertence.cpertence = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCequip(int $cequip, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND epertence.cequipe = $cequip";
		return static::_find($type, $params);
	}
}