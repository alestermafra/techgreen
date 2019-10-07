<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('TipoEndereco', 'Model');
App::import('Pessoa', 'Model');

class Endereco extends Table {
	
	public static $_table = 'upsend';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM upsend
			INNER JOIN tpsend ON (tpsend.ctpsend = upsend.ctpsend)
			INNER JOIN eps ON (eps.cps = upsend.cps)
		WHERE upsend.RA = 1 AND tpsend.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'upsend.cpsend',
		'upsend.cep',
		'upsend.uf',
		'upsend.cidade',
		'upsend.bai',
		'upsend.endr',
		'upsend.no',
		'upsend.endcmplt',
		'upsend.flg_principal',
		'tpsend.ctpsend',
		'tpsend.ntpsend',
		'eps.cps',
		'eps.nps',
	);
	
	
	public static function save($data) {
		$data = static::saveDependencies($data);
		
		if(!isset($data['cpsend'])) {
			$id = static::create(static::validate($data, 'create'));
		}
		else {
			static::edit(static::validate($data, 'edit'));
			$id = $data['cpsend'];
		}
		
		static::saveAssociations($data);
		
		return static::findById($id);
	}
	
	public static function saveDependencies($data) {
		return $data;
	}
	
	public static function saveAssociations(&$data) {
		return $data;
	}
	
	public static function validate($data, $mode = 'create') {
		if(!isset($data['cps']) || intval($data['cps']) === 0 || !Pessoa::findById($data['cps'], 'count')) {
			throw new Exception("Registro de pessoa não encontrado.");
		}
		if($mode === 'create') {
			/* ... */
		}
		else if($mode === 'edit') {
			/* ... */
		}
		
		$new_data = array();
		if(isset($data['cpsend'])) {
			$new_data['cpsend'] = intval($data['cpsend']);
		}
		if(isset($data['cps'])) {
			$new_data['cps'] = intval($data['cps']);
		}
		if(isset($data['ctpsend'])) {
			$new_data['ctpsend'] = intval($data['ctpsend']);
		}
		if(isset($data['cidade'])) {
			$new_data['cidade'] = strval($data['cidade']);
		}
		if(isset($data['uf'])) {
			$new_data['uf'] = strval($data['uf']);
		}
		if(isset($data['endr'])) {
			$new_data['endr'] = strval($data['endr']);
		}
		if(isset($data['no'])) {
			$new_data['no'] = strval($data['no']);
		}
		if(isset($data['endcmplt'])) {
			$new_data['endcmplt'] = strval($data['endcmplt']);
		}
		if(isset($data['bai'])) {
			$new_data['bai'] = strval($data['bai']);
		}
		if(isset($data['cep'])) {
			$new_data['cep'] = preg_replace('/[^0-9]/i', '', strval($data['cep']));
		}
		if(isset($data['flg_principal'])) {
			$new_data['flg_principal'] = intval($data['flg_principal']);
		}
		
		return $new_data;
	}
	
	protected static function create($data) {
		static::insert($data);
		return static::$_id;
	}
	
	protected static function edit($data) {
		static::update($data, "upsend.cpsend = {$data['cpsend']}");
	}
	
	
	//----- specials
	public static function cep(string $cep) {
		$connection = new Connection();
		$qry = $connection->query("SELECT cep, endt, endereco, bairro, cidade, uf FROM ecep WHERE cep = '$cep' limit 1");
		if($qry) {
			$qry = $qry[0];
		}
		return $qry;
	}
	
	public static function uf() {
		$connection = new Connection();
		$qry = $connection->query('SELECT cuf, uf, nuf FROM euf ORDER BY uf');
		return $qry;
	}
	
	public static function tipoEndereco() {
		$connection = new Connection();
		$qry = $connection->query('SELECT ctpsend, ntpsend FROM tpsend WHERE RA = 1');
		return $qry;
	}
	
	public static function cidade(string $uf) {
		$connection = new Connection();
		$qry = $connection->query('SELECT cmn, nmn FROM emn WHERE RA = 1 AND uf = \''.$uf.'\' ');
		return $qry;
	}
	//-------------	
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND upsend.cpsend = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	
	public static function remover(int $cpsend) {
		$endereco = static::findById($cpsend);
		static::remove("upsend.cpsend = $cpsend");
		return $endereco;
	}
}