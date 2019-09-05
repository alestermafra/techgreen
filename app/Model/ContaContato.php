<?php
App::import('Table', 'Model');	
App::import('Connection', 'Model');	

class ContaContato extends Table {
	
	public static $_table = 'uccon';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM uccon
			INNER JOIN upsj ON (upsj.cps = uccon.cps_conta)
			INNER JOIN eps conta ON (conta.cps = upsj.cps)
			INNER JOIN upsf ON (upsf.cps = uccon.cps_contato)
			INNER JOIN eps contato ON (contato.cps = upsf.cps)
		WHERE uccon.RA = 1
			AND upsj.RA = 1
			AND conta.RA = 1
			AND upsf.RA = 1
			AND contato.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'uccon.cccon',
		'uccon.cps_conta',
		'uccon.cps_contato',
		'conta.nps as conta_nps',
		'contato.nps as contato_nps',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		static::saveDependencies($data);
		
		$data = static::validate($data);
		if(!isset($data['cccon'])) {
			$id = static::create($data);
		}
		else {
			static::edit($data);
			$id = $data['cccon'];
		}
		return static::findById($id);
	}
	
	public static function saveDependencies(&$data) {
		$pessoa = Pessoa2::save($data);
		$data['cps'] = $pessoa['cps'];
	}
	
	public static function validate($data) {
		$validated = array();
		if(isset($data['cccon'])) {
			$validated['cccon'] = intval($data['cccon']);
		}
		if(isset($data['cps_conta'])) {
			$validated['cps_conta'] = intval($data['cps_conta']);
		}
		if(isset($data['cps_contato'])) {
			$validated['cps_contato'] = strval($data['cps_contato']);
		}
		
		return $validated;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "uccon.cccon = {{$data['cccon']}}");
	}
	
	public static function disable(int $id) {
		if($data = static::findById($id)) {
			$data['RA'] = 0;
			return static::save($data);
		}
	}
	
	public static function enable(int $id) {
		if($data = static::findById($id)) {
			$data['RA'] = 1;
			return static::save($data);
		}
	}

	
	/*busca*/
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cccon = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCpsConta(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cps_conta = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByCpsContato(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND uccon.cps_contato = $cps";
		return static::_find($type, $params);
	}
	
	
	public static function contatos() {
		$connection = new Connection();
		$ctt = $connection->query(
			'SELECT 
				zpainel.cps, 
				eps.nps
			FROM zpainel 
				INNER JOIN eps ON eps.cps = zpainel.cps
				INNER JOIN upsf ON upsf.cps = zpainel.cps
				LEFT JOIN uccon ON uccon.cps_contato = zpainel.cps 
				LEFT JOIN eaux ON eaux.cps = zpainel.cps 
			WHERE eaux.ativo = 1 AND uccon.cps_contato IS NULL ;');
		return $ctt;
	}
	
	public static function contatos_fornec() {
		$connection = new Connection();
		$ctt = $connection->query(
			'SELECT 
				zfornec.cps, 
				eps.nps
			FROM zfornec 
				INNER JOIN eps ON eps.cps = zfornec.cps
				INNER JOIN upsf ON upsf.cps = zfornec.cps
				LEFT JOIN uccon ON uccon.cps_contato = zfornec.cps 
				LEFT JOIN eaux ON eaux.cps = zfornec.cps 
			WHERE eaux.ativo = 1 AND uccon.cps_contato IS NULL ;');
		return $ctt;
	}
	
	public static function contas() {
		$connection = new Connection();
		$cnt = $connection->query(
			'SELECT 
				zpainel.cps, 
				eps.nps 
			FROM zpainel 
				INNER JOIN eps ON eps.cps = zpainel.cps
				INNER JOIN upsj ON upsj.cps = zpainel.cps
				LEFT JOIN uccon ON uccon.cps_conta = zpainel.cps 
			WHERE 1 =1 ;');
		return $cnt;
	}
	
	public static function contas_fornec() {
		$connection = new Connection();
		$cnt = $connection->query(
			'SELECT 
				zfornec.cps, 
				eps.nps 
			FROM zfornec 
				INNER JOIN eps ON eps.cps = zfornec.cps
				INNER JOIN upsj ON upsj.cps = zfornec.cps
				LEFT JOIN uccon ON uccon.cps_conta = zfornec.cps 
			WHERE 1 = 1 ;');
		return $cnt;
	}
	
	public static function conta_fornec(int $cps_contato) {
		$connection = new Connection();
		$cnt = $connection->query(
			'SELECT 
				zfornec.cps, 
				eps.nps 
			FROM zfornec 
				INNER JOIN eps ON eps.cps = zfornec.cps
				INNER JOIN upsj ON upsj.cps = zfornec.cps
				LEFT JOIN uccon ON uccon.cps_conta = zfornec.cps 
			WHERE uccon.cps_contato = '.$cps_contato.' ;');
		return $cnt;
	}
	
	public static function contatos_conta(int $cps_conta) {
		$connection = new Connection();
		$ctt = $connection->query(
			'SELECT 
				uccon.cps_contato, 
				eps.nps,
				eaux.profissao,
				email.email
			FROM uccon 
				INNER JOIN eps ON eps.cps = uccon.cps_contato
				LEFT JOIN eaux ON eaux.cps = uccon.cps_contato
				LEFT JOIN email ON email.cps = uccon.cps_contato
			WHERE eaux.ativo = 1 
				AND uccon.cps_conta = '.$cps_conta.' ;');
		return $ctt;
	}
	
}