<?php
App::import('Table', 'Model');

class Tabela extends Table {
	public static $_table = 'etabela';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM etabela
		WHERE etabela.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'etabela.ctabela',
		'etabela.ntabela',
	);


	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND etabela.ctabela = $id";
		return static::_find($type, $params);
	}
	
	
	
	public static function guardaria(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND etabela.ctabela in (1, 2)";
		return static::_find($type, $params);
	}
	
	public static function aula(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND etabela.ctabela in (4)";
		return static::_find($type, $params);
	}
	
	public static function locacao(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND etabela.ctabela in (3, 7)";
		return static::_find($type, $params);
	}
	
	public static function diaria(string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND etabela.ctabela in (5, 6)";
		return static::_find($type, $params);
	}
}