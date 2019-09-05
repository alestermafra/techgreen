<?php
App::import('Table', 'Model');

class ClienteYTDMes extends Table {
	
	public static $_table = 'emes';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM emes
			LEFT JOIN zpainel ON (MONTH(zpainel.TS) = emes.cmes AND zpainel.RA = 1)
		WHERE 1 = 1 {{conditions}}
		GROUP BY emes.cmes
		ORDER BY emes.cmes
	';
	
	public static $_fields = array(
		'emes.cmes',
		'COUNT(zpainel.cps) AS quantidade',
	);
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		$result = parent::_find($type, $params);
		foreach($result as &$r) {
			$r['cmes'] = (int) $r['cmes'];
			$r['quantidade'] = (int) $r['quantidade'];
		}
		return $result;
	}
}