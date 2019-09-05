<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

class Interesse extends Table {
	
	public static $_table = 'tinteresse';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM tinteresse
		WHERE tinteresse.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'tinteresse.ctinteresse',
		'tinteresse.ntinteresse',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		/* implementar se necessario */
	}
	
	public static function create($data) {
		/* implementar se necessario */
	}
	
	public static function edit($data) {
		/* implementar se necessario */
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND tinteresse.ctinteresse = $id";
		return static::_find($type, $params);
	}
}