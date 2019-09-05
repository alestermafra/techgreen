<?php
App::import('Table', 'Model');

class FormaPagamento extends Table {
	public static $_table = 'epgt';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM epgt
		WHERE epgt.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'epgt.cpgt',
		'epgt.npgt',
	);

	//------------------------------------------------------------
	public static function parcelas() {
		$connection = new Connection();
		$result = $connection->query(
			'SELECT 
				cppgt,
				qtd_parcela,
				nppgt
			FROM eppgt 
			WHERE RA = 1 ;');
		return $result;
	}
	//------------------------------------------------------------
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND epgt.cpgt = $id";
		return static::_find($type, $params);
	}
}