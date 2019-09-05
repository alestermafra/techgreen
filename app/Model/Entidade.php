<?php
App::import('Table', 'Model');	

class Entidade extends Table {
	
	public static $_table = 'een';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM een
		WHERE 1 = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'een.cen',
		'een.sen',
		'een.nen',
		'een.OBS',
		'een.RA',
		'een.TS',
	);
	
	public static function find(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		/* insere o filtro de hierarquia */
		if($h['cen']) {
			$conditions = $conditions . ' AND een.cen = ' . $h['cen'];
		}
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
}