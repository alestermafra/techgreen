<?php
App::import('Table', 'Model');

class TipoEquipamento extends Table {
	public static $_table = 'tequipe';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM tequipe
		WHERE tequipe.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'tequipe.ctequipe',
		'tequipe.ntequipe',
	);


	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND tequipe.ctequipe = $id";
		return static::_find($type, $params);
	}
}