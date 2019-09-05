<?php
App::import('Table', 'Model');	

class Distrito extends Table {
	
	public static $_table = 'edio';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM edio
			INNER JOIN erei ON (erei.crei = edio.crei)
			INNER JOIN eung ON (eung.cung = erei.cung)
			INNER JOIN eun ON (eun.cun = eung.cun)
			INNER JOIN een ON (een.cen = eun.cen)
		WHERE erei.RA = 1
			AND eung.RA = 1
			AND eun.RA = 1
			AND een.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'edio.cdio',
		'edio.sdio',
		'edio.ndio',
		'edio.OBS',
		'edio.RA',
		'edio.AR',
		'edio.TS',
		'erei.crei',
		'erei.srei',
		'erei.nrei',
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
		if($h['cdio']) {
			$conditions = $conditions . ' AND edio.cdio = ' . $h['cdio'];
		}
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
	
	public static function get(array $h, int $id) {
		return static::find($h, 'first', array('conditions' => " AND edio.cdio = $id"));
	}
	
	public static function search(array $h, int $cdio, string $ndio, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		if($cdio) {
			$conditions = $conditions . " AND edio.cdio = $cdio";
		}
		else if($ndio) {
			$conditions = $conditions . " AND edio.ndio LIKE '%{$ndio}%'";
		}
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
	
	public static function ativos(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		$conditions = $conditions . " AND edio.RA = 1";
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
}