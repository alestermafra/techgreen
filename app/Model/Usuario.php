<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('NivelAcesso', 'Model');

class Usuario extends Table {
	public static $_table = 'susu';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM susu
			INNER JOIN eps ON (eps.cps = susu.cps)
		WHERE susu.RA = 1 AND eps.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'susu.cusu',
		'susu.admin',
		'susu.lg',
		'susu.pwd',
		'susu.email',
		'susu.clang',
		'susu.chora_in',
		'susu.chora_out',
		'susu.cdsm_in',
		'susu.cdsm_out',
		'susu.last_login',
		'susu.last_inter',
		'eps.cps',
		'eps.sps',
		'eps.nps',
		'1 as cna',
		'2 as sna',
		'3 as nna',
	);
	
	
	public static function save($data) {
		if(!isset($data['cps'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		if(!isset($data['nps']) || strlen($data['nps']) == 0) {
			throw new Exception("Nome inválido.");
		}
		if(!isset($data['lg']) || strlen($data['lg']) == 0) {
			throw new Exception("Login inválido.");
		}
		if(!isset($data['pwd']) || strlen($data['pwd']) == 0) {
			throw new Exception("Senha inválida.");
		}
		if(!isset($data['email']) || strlen($data['email']) == 0) {
			throw new Exception("Email inválido.");
		}
		
		if(static::findByLogin($data['lg'], 'count')) {
			throw new Exception("Este login já está sendo usado.");
		}
		if(static::findByEmail($data['email'], 'count')) {
			throw new Exception("Este email já está sendo usado.");
		}
		
		
		$connection = new Connection();
		
		$eps = [
			'nps' => (string) $data['nps']
		];
		$cps = $connection->insert('eps', $eps);
		
		$susu = [
			'cps' => (int) $cps,
			'lg' => (string) $data['lg'],
			'pwd' => (string) $data['pwd'],
			'email' => (string) $data['email'],
			'cna' => (int) $data['cna'],
			'admin' => (int) $data['admin'],
		];
		$connection->insert('susu', $susu);
		
		return static::findByCps($cps);
	}
	
	public static function edit($data) {
		if(!isset($data['nps']) || strlen($data['nps']) == 0) {
			throw new Exception("Nome inválido.");
		}
		if(!isset($data['lg']) || strlen($data['lg']) == 0) {
			throw new Exception("Login inválido.");
		}
		if(!isset($data['pwd']) || strlen($data['pwd']) == 0) {
			throw new Exception("Senha inválida.");
		}
		if(!isset($data['email']) || strlen($data['email']) == 0) {
			throw new Exception("Email inválido.");
		}
		
		$cps = (int) $data['cps'];
		
		if(static::findByLogin($data['lg'], 'count', array('conditions' => " AND eps.cps != $cps"))) {
			throw new Exception("Este login já está sendo usado.");
		}
		if(static::findByEmail($data['email'], 'count', array('conditions' => " AND eps.cps != $cps"))) {
			throw new Exception("Este email já está sendo usado.");
		}
		
		$connection = new Connection();
		
		$eps = [
			'nps' => (string) $data['nps'],
		];
		$connection->update('eps', $eps, "eps.cps = $cps");
		
		$susu = [
			'lg' => (string) $data['lg'],
			'pwd' => (string) $data['pwd'],
			'email' => (string) $data['email'],
			'cna' => (int) $data['cna'],
			'admin' => (int) $data['admin'],
		];
		$connection->update('susu', $susu, "susu.cps = $cps");
		
		return static::findByCps($cps);
	}
	
	public static function savePwd($data){
		if(!isset($data['pwd1']) || !isset($data['pwd2'])) {
			throw new Exception("Preencha corretamente os campos");
		}
		
		if($data['pwd1'] != $data['pwd2']) {
			throw new Exception("Senhas não conferem");
		}
		
		$cusu = (int) $data['cusu'];
		
		$susu = [ 'pwd' => (string) $data['pwd1'], ];
		
		$connection = new Connection();
		$connection->update('susu', $susu, "susu.cusu = $cusu");
		return static::findById($cusu);
	}
	
	public static function authenticate(string $login, string $password) {
		return static::_find('first', array('conditions' => " AND susu.RA = 1 AND susu.lg = '$login' AND binary susu.pwd = '$password'"));
	}
	
	public static function find(string $type = 'all', array $params = array()) {
		return static::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND susu.cusu = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function findByLogin(string $login, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND susu.lg = '$login'";
		return static::_find($type, $params);
	}
	
	public static function findByEmail(string $email, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND susu.email = '$email'";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.sps LIKE '%$value%'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR susu.lg LIKE '%$value%'";
		$params['conditions'] .= " OR susu.email LIKE '%$value%'";
		$params['conditions'] .= " OR sna.sna LIKE '%$value%'";
		$params['conditions'] .= " OR sna.nna LIKE '%$value%' )";
		return static::_find($type, $params);
	}

	// cache de permissoes
	public static $permissoes = [];

	public static function getPermissoes($cusu) {
		if(!isset(static::$permissoes[$cusu])) {
			$connection = new Connection();
			$result = $connection->query('
				SELECT 
					permissao
				FROM
					permissoes
				WHERE cusu = ' . $cusu
			);

			$permissoes = [];
			foreach($result as $r) {
				$permissoes[] = $r['permissao'];
			}
			static::$permissoes[$cusu] = $permissoes;
		}

		return static::$permissoes[$cusu];
	}

	public static function setPermissoes($cusu, $permissoes) {
		$connection = new Connection();

		$connection->query('DELETE FROM permissoes WHERE cusu = ' . $cusu);

		foreach($permissoes as $permissao) {
			$connection->query("INSERT INTO permissoes (cusu, permissao) VALUES ($cusu, '$permissao')");
		}
	}
}