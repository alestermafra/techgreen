<?php
App::import('Table', 'Model');

class Produto extends Table {
	public static $_table = 'eprod';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eprod
			INNER JOIN elinha ON (elinha.clinha = eprod.clinha)
			INNER JOIN escat ON (escat.cscat = elinha.cscat)
			INNER JOIN ecat ON (ecat.ccat = escat.ccat)
		WHERE eprod.RA = 1 AND elinha.RA = 1 AND escat.RA = 1 AND ecat.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eprod.cprod',
		'eprod.sprod',
		'eprod.nprod',
		'eprod.descricao',
		'eprod.estoque',
		'elinha.clinha',
		'elinha.nlinha',
		'escat.cscat',
		'escat.nscat',
		'ecat.ccat',
		'ecat.ncat'
	);
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cprod'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*criação*/
	public static function create($data) {
		if(!isset($data['clinha'])) {
			throw new Exception('Linha inválida / Tipo inválido (clinha)');
		}
		
		$connection = new Connection();
		
		$eprod = [
			'clinha' => (int) _isset($data['clinha'], null),
			'sprod' => (string) _isset($data['sprod'], null),
			'nprod' => (string) _isset($data['nprod'], null),
			'estoque' => (int) _isset($data['estoque'], null),
			'descricao' => (string) _isset($data['descricao'], null),
		];
		$cprod = $connection->insert('eprod', $eprod);
		
		return static::findById($cprod);
	}
	
	/*edição*/
	public static function edit($data) {
		if(!isset($data['clinha'])) {
			throw new Exception('Linha inválida / Tipo inválido (clinha)');
		}
		
		$cprod = $data['cprod'];
		
		$connection = new Connection();
		
		$eprod = [
			'clinha' => (int) _isset($data['clinha'], null),
			'sprod' => (string) _isset($data['sprod'], null),
			'nprod' => (string) _isset($data['nprod'], null),
			'estoque' => (int) _isset($data['estoque'], null),
			'descricao' => (string) _isset($data['descricao'], null),
		];
		$prod = $connection->update('eprod', $eprod, "eprod.cprod = $cprod");
		
		return $prod;
	}

	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eprod.cprod = $id";
		return static::_find($type, $params);
	}
	
	public static function findByClinha(int $id, string $type = 'all', array $params = array()) {
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
		$params['conditions'] .= " AND ( eprod.cprod = '$value'";
		$params['conditions'] .= " OR eprod.nprod LIKE '%$value%'";
		$params['conditions'] .= " OR eprod.sprod LIKE '%$value%'";
		$params['conditions'] .= " OR elinha.nlinha LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}