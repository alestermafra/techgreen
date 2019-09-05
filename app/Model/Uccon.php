<?php
App::import('Table', 'Model');	
App::import('Connection', 'Model');	

class Uccon extends Table {
	
	public static $_table = 'uccon';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM uccon
			LEFT JOIN eps ps ON (ps.cps = cps_conta)
			LEFT JOIN eps pss ON (pss.cps = cps_contato)
		WHERE 1=1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'IFNULL(uccon.cccon,0) as cccon',
		'uccon.cps_conta',
		'uccon.cps_contato',
		//'count(uccon.cps_contato) qtd_contato',
		'uccon.OBS',
		'uccon.RA',
		'uccon.AR',
		'uccon.RD',
		'uccon.TS',
		'ps.nps as conta',
		'pss.nps as contato',
	);
	
	public static function find(array $h, string $type = 'all', array $params = array()) {
		$conditions = _isset($params['conditions'], '');
		
		$params['conditions'] = $conditions;
		return parent::_find($type, $params);
	}
	
	public static function get(array $h, int $id) {
		return static::find($h, 'first', array('conditions' => " AND uccon.cccon = $id"));
	}
	
	public static function contatos(int $cset) {
		$connection = new Connection();
		$ctt = $connection->query(
			'SELECT 
				zpainel.cps, 
				eps.nps
			FROM zpainel 
				INNER JOIN eps ON eps.cps = zpainel.cps
				INNER JOIN upsf ON upsf.cps = zpainel.cps
				LEFT JOIN uccon ON uccon.cps_contato = zpainel.cps 
			WHERE uccon.cps_contato IS NULL 
				AND zpainel.cset = '.$cset.' ;');
		return $ctt;
	}
	
	public static function contas(int $cset) {
		$connection = new Connection();
		$cnt = $connection->query(
			'SELECT 
				zpainel.cps, 
				eps.nps 
			FROM zpainel 
				INNER JOIN eps ON eps.cps = zpainel.cps
				INNER JOIN upsj ON upsj.cps = zpainel.cps
				LEFT JOIN uccon ON uccon.cps_conta = zpainel.cps 
			WHERE 1 =1
				AND zpainel.cset = '.$cset.' ;');
		return $cnt;
	}
	
	public static function contatos_conta(int $cps_conta) {
		$connection = new Connection();
		$ctt = $connection->query(
			'SELECT 
				uccon.cps_contato, 
				eps.nps
			FROM uccon 
				INNER JOIN eps ON eps.cps = uccon.cps_contato
				LEFT JOIN eaux ON eaux.cps = uccon.cps_contato
			WHERE eaux.ativo = 1 
				AND uccon.cps_conta = '.$cps_conta.' ;');
		return $ctt;
	}
}