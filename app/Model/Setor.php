<?php
App::import('Table', 'Model');	

class Setor extends Table {
	
	public static $_table = 'eset';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM eset
			INNER JOIN edio ON (edio.cdio = eset.cdio)
			INNER JOIN erei ON (erei.crei = edio.crei)
			INNER JOIN eung ON (eung.cung = erei.cung)
			INNER JOIN eun ON (eun.cun = eung.cun)
			INNER JOIN een ON (een.cen = eun.cen)
		WHERE edio.RA = 1
			AND erei.RA = 1
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
		'eset.cset',
		'eset.sset',
		'eset.nset',
		'eset.OBS',
		'eset.RA',
		'eset.AR',
		'eset.TS',
		'edio.cdio',
		'edio.sdio',
		'edio.ndio',
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
		if($h['cset']) {
			$conditions = $conditions . ' AND eset.cset = ' . $h['cset'];
		}
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
	
	public static function get(array $h, int $id) {
		return static::find($h, 'first', array('conditions' => " AND eset.cset = $id"));
	}
	
	public static function search(array $h, int $cset, string $nset, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		if($cset) {
			$conditions = $conditions . " AND eset.cset = $cset";
		}
		else if($nset) {
			$conditions = $conditions . " AND eset.nset LIKE '%{$nset}%'";
		}
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
	
	public static function ativos(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		$conditions = $conditions . " AND eset.RA = 1";
		
		$params['conditions'] = $conditions;
		return static::find($h, $type, $params);
	}
	
	public static function setores(int $cset) {//Criada exclusivamente para o painel
		$connection = new Connection();
		$setores = $connection->query('
			SELECT 
				eset.cset, eset.nset,
				edio.cdio, edio.ndio
			FROM eset 
				INNER JOIN edio ON (edio.cdio = eset.cdio)
				INNER JOIN erei ON (erei.crei = edio.crei)
				INNER JOIN eung ON (eung.cung = erei.cung)
			WHERE eset.RA = 1 
				AND edio.RA = 1
				AND erei.RA = 1
				AND eung.RA = 1
				AND eset.cset not in ('.$cset.') 
				AND erei.crei in (SELECT crei FROM edio WHERE cdio in (SELECT cdio FROM eset WHERE cset = '.$cset.') );');
		return $setores;
	}
}