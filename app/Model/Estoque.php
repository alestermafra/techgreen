<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

class Estoque extends Table {
	
	public static $_table = 'estoque';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM estoque
			INNER JOIN eprod ON (estoque.cprod = eprod.cprod)
		WHERE estoque.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'estoque.cstoque',
		'estoque.qtd',
		'estoque.qtd_max',
		'eprod.cprod',
		'eprod.nprod',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cstoque'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		$connection = new Connection();
		
		$estoque = array();
		
		$estoque = [
			'cprod' => (int) $data['cprod'],
			'qtd' =>  (int) $data['qtd'],
			'qtd_max' => (int) $data['qtd_max']
		];
		$connection->insert('estoque', $estoque);
		
		return static::findByCprod($data['cprod']);
	}
	
	public static function edit($data) {
		if(!isset($data['cprod']) || !static::findByCprod($data['cprod'], 'count')) {
			throw new Exception("Produto não encontrado.");
		}
		
		$cstoque = (int) $data['cstoque'];
		
		$connection = new Connection();
	
		$estoque = [
			'qtd' => (int) $data['qtd'],
			'qtd_max' => (int) $data['qtd_max']
		];
		$connection->update('estoque', $estoque, "estoque.cstoque = $cstoque");
		
		return static::findById($cstoque);
	}
	
	//--------------------------------------------------------------------
	public static function produtos() {
		$connection = new Connection();
		$result = $connection->query(
			'SELECT 
				eprod.cprod,
				eprod.sprod,
				eprod.nprod,
				elinha.slinha,
				elinha.nlinha,
				escat.sscat
			FROM eprod 
				INNER JOIN elinha ON (elinha.clinha = eprod.clinha)
				INNER JOIN escat ON (escat.cscat = elinha.cscat)
				INNER JOIN ecat ON (ecat.ccat = escat.ccat)
				LEFT JOIN estoque ON (estoque.cprod = eprod.cprod)
			WHERE eprod.estoque = 1 AND eprod.RA = 1 AND estoque.cprod IS NULL ;');
		return $result;
	}
	//-------------------------------------------------------------------
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findByCprod(int $cprod, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND estoque.cprod = $cprod";
		return static::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND estoque.cstoque = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( estoque.cstoque = '$value'";
		$params['conditions'] .= " OR eprod.nprod LIKE '%$value%'";
		$params['conditions'] .= " OR eprod.sprod LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
	
	public static function acabando(float $percent, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset(
			$params['conditions'],
			" AND estoque.qtd / estoque.qtd_max < $percent"
		);
		return static::_find($type, $params);
	}
}