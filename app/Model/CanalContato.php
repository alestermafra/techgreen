<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

class CanalContato extends Table {
	
	public static $_table = 'ecanalcontato';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM ecanalcontato
		WHERE ecanalcontato.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'ecanalcontato.ccanalcontato',
		'ecanalcontato.ncanalcontato',
		'ecanalcontato.flg_obs',
		'ecanalcontato.OBS',
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
		$params['conditions'] .= " AND ecanalcontato.ccanalcontato = $id";
		return static::_find($type, $params);
	}
}