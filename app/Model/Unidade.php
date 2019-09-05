<?php
App::import('Table', 'Model');	

class Unidade extends Table {
	
	public static $_table = 'eun';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM eun
			INNER JOIN een ON (een.cen = eun.cen)
			LEFT JOIN slang ON (slang.clang = eun.clang)
		WHERE een.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eun.cun',
		'eun.sun',
		'eun.nun',
		'eun.OBS',
		'eun.RA',
		'eun.TS',
		'een.cen',
		'een.sen',
		'een.nen',
		'slang.clang',
		'slang.slang',
		'slang.nlang',
	);
	
	public static function find(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		/* insere o filtro de hierarquia */
		if($h['cen']) {
			$conditions = $conditions . ' AND een.cen = ' . $h['cen'];
		}
		if($h['cun']) {
			$conditions = $conditions . ' AND eun.cun = ' . $h['cun'];
		}
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
	
	public static function get(array $h, int $id) {
		return static::find($h, 'first', array('conditions' => " AND eun.cun = $id"));
	}
	
	public static function ativos(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		$conditions = $conditions . " AND eun.RA = 1";
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
}