<?php
App::import('Table', 'Model');	

class Regiao extends Table {
	
	public static $_table = 'erei';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM erei
			INNER JOIN eung ON (eung.cung = erei.cung)
			INNER JOIN eun ON (eun.cun = eung.cun)
			INNER JOIN een ON (een.cen = eun.cen)
		WHERE eung.RA = 1
			AND eun.RA = 1
			AND een.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'erei.crei',
		'erei.srei',
		'erei.nrei',
		'erei.OBS',
		'erei.RA',
		'erei.AR',
		'erei.TS',
		'eung.cung',
		'eung.sung',
		'eung.nung',
		'eun.cun',
		'eun.sun',
		'eun.nun',
		'een.cen',
		'een.sen',
		'een.nen',
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
		if($h['cung']) {
			$conditions = $conditions . ' AND eung.cung = ' . $h['cung'];
		}
		if($h['crei']) {
			$conditions = $conditions . ' AND erei.crei = ' . $h['crei'];
		}
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
	
	public static function get(array $h, int $id) {
		return static::find($h, 'first', array('conditions' => " AND erei.crei = $id"));
	}
	
	public static function ativos(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		$conditions = $conditions . " AND erei.RA = 1";
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
}