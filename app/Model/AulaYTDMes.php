<?php
App::import('Table', 'Model');

class AulaYTDMes extends Table {
	
	public static $_table = 'emes';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM emes
			LEFT JOIN eaula ON (MONTH(eaula.TS) = emes.cmes AND eaula.RA = 1)
		WHERE 1 = 1 {{conditions}}
		GROUP BY emes.cmes
		ORDER BY emes.cmes
	';
	
	public static $_fields = array(
		'emes.cmes',
		'COUNT(eaula.caula) AS quantidade',
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