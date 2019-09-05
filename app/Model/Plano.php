<?php
App::import('Table', 'Model');

class Plano extends Table {
	public static $_table = 'eplano';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eplano
			INNER JOIN tplano ON (tplano.ctplano = eplano.ctplano)
		WHERE eplano.RA = 1 AND tplano.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eplano.cplano',
		'eplano.nplano',
	);


	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eplano.cplano = $id";
		return static::_find($type, $params);
	}
	
	public static function guardaria(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eplano.ctplano = 1";
		return static::_find($type, $params);
	}
	
	public static function aula(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eplano.ctplano = 3";
		return static::_find($type, $params);
	}
	
	public static function locacao(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eplano.ctplano = 2";
		return static::_find($type, $params);
	}
	
	public static function diaria(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eplano.ctplano = 4";
		return static::_find($type, $params);
	}
}