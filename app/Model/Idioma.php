<?php
App::import('Table', 'Model');	

class Idioma extends Table {
	public static $_qry = '
		SELECT
			{{fields}}
		FROM slang
		WHERE 1 = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'slang.clang',
		'slang.slang',
		'slang.nlang',
		'slang.OBS',
		'slang.RA',
		'slang.AR',
		'slang.TS',
	);
	
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
}