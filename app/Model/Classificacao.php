<?php
App::import('Table', 'Model');	

class Classificacao extends Table {
	
	public static $_table = 'eseg2';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eseg2
		WHERE eseg2.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eseg2.id',
		'eseg2.classificacao',
	);
	
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eseg2.id = $id";
		return static::_find($type, $params);
	}
}