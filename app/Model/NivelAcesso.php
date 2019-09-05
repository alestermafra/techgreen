<?php
App::import('Table', 'Model');	

class NivelAcesso extends Table {
	const ADMIN = 1;
	const ENTIDADE = 2;
	const UNIDADE = 3;
	const UNIDADE_DE_NEGOCIO = 4;
	const REGIAO = 5;
	const DISTRITO = 6;
	const SETOR = 7;
	
	public static $_table = 'sna';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM sna
		WHERE sna.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'sna.cna',
		'sna.sna',
		'sna.nna',
		'sna.OBS',
		'sna.RA',
		'sna.AR',
		'sna.RD',
		'sna.TS',
	);
	
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND sna.cna = $id";
		return static::_find($type, $params);
	}
}