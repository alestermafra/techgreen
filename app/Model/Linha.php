<?php
App::import('Table', 'Model');

class Linha extends Table {
	public static $_table = 'elinha';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM elinha
			INNER JOIN escat ON (escat.cscat = elinha.cscat)
			INNER JOIN ecat ON (ecat.ccat = escat.ccat)
		WHERE elinha.RA = 1 AND escat.RA = 1 AND ecat.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'elinha.clinha',
		'elinha.slinha',
		'elinha.nlinha',
		'elinha.descricao',
		'escat.cscat',
		'escat.nscat',
		'ecat.ccat',
		'ecat.ncat'
	);
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['clinha'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*criação*/
	public static function create($data) {
		if(!isset($data['cscat']) || !static::findByCscat($data['cscat'], 'count')) {
			throw new Exception('Sub Categoria inválida (cscat)');
		}
		
		$connection = new Connection();
		
		$elinha = [
			'cscat' => (int) _isset($data['cscat'], null),
			'slinha' => (string) _isset($data['slinha'], null),
			'nlinha' => (string) _isset($data['nlinha'], null),
			'descricao' => (string) _isset($data['descricao'], null),
		];
		$clinha = $connection->insert('elinha', $elinha);
		
		return static::findById($clinha);
	}
	
	/*edição*/
	public static function edit($data) {
		if(!isset($data['cscat']) || !static::findByCscat($data['cscat'], 'count')) {
			throw new Exception('Sub Categoria inválida (cscat)');
		}
		
		$clinha = $data['clinha'];
		
		$connection = new Connection();
		
		$elinha = [
			'cscat' => (int) _isset($data['cscat'], null),
			'slinha' => (string) _isset($data['slinha'], null),
			'nlinha' => (string) _isset($data['nlinha'], null),
			'descricao' => (string) _isset($data['descricao'], null),
		];
		$linha = $connection->update('elinha', $elinha, "elinha.clinha = $clinha");
		
		return $linha;
	}

	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND elinha.clinha = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCscat(int $id, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND escat.cscat = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCcat(int $id, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ecat.ccat = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( elinha.clinha = '$value'";
		$params['conditions'] .= " OR elinha.nlinha LIKE '%$value%'";
		$params['conditions'] .= " OR elinha.sprod LIKE '%$value%'";
		$params['conditions'] .= " OR escat.nscat LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}