<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('DadosAuxiliares', 'Model');
App::import('Telefone', 'Model');
App::import('Endereco', 'Model');

class Fornecedor extends Table {
	
	public static $_table = 'zfornec';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zfornec
			INNER JOIN eps ON (eps.cps = zfornec.cps)
			INNER JOIN upsj ON (upsj.cps = zfornec.cps)
			LEFT JOIN eaux ON (eaux.cps = zfornec.cps AND eaux.RA = 1)
			LEFT JOIN eseg ON (eseg.cseg = eaux.cseg AND eseg.RA = 1)
			LEFT JOIN email ON (email.cps = zfornec.cps AND email.RA = 1)
			LEFT JOIN zfone ON (zfone.cps = zfornec.cps AND zfone.flg_principal = 1 AND zfone.RA = 1)
			LEFT JOiN zpainel ON (zpainel.cps = zfornec.cps AND zpainel.RA = 1)
		WHERE zfornec.RA = 1 AND eps.RA = 1 AND upsj.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eps.cps',
		'eps.sps',
		'eps.nps',
		'eaux.ativo',
		'eseg.cseg',
		'eseg.nseg',
		'upsj.cnpj',
		'email.email',
		'zfone.fone',
		'zpainel.czpainel',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cps'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		if(!isset($data['nps']) || strlen($data['nps']) === 0) {
			throw new Exception("Nome inválido.");
		}
		
		$connection = new Connection();
		
		/* insere a pessoa */
		$eps = [
			'nps' => (string) $data['nps'],
			'flg_sys' => 0
		];
		$cps = $connection->insert('eps', $eps);
		
		$upsj = [
			'cps' => (int) $cps,
			'cnpj' => (string) $data['cnpj'],
		];
		$connection->insert('upsj', $upsj);
		
		$zfornec = [
			'cps' => (int) $cps
		];
		$connection->insert('zfornec', $zfornec);
		
		/* insere o email */
		$email = [
			'cps' => (int) $cps,
			'email' => (string) _isset($data['email'], '')
		];
		$connection->insert('email', $email);
		
		/* dados auxiliares */
		$dados_auxiliares = [
			'cps' => (int) $cps
		];
		if(isset($data['ativo'])) {
			$dados_auxiliares['ativo'] = (int) $data['ativo'];
		}
		if(isset($data['cseg'])) {
			$dados_auxiliares['cseg'] = (int) $data['cseg'];
		}
		DadosAuxiliares::save($dados_auxiliares);
		
		if(isset($data['telefones']) && is_array($data['telefones'])) {
			foreach($data['telefones'] as $tel) {
				$tel['cps'] = $cps;
				Telefone::save($tel);
			}
		}
		
		if(isset($data['enderecos']) && is_array($data['enderecos'])) {
			foreach($data['enderecos'] as $endr) {
				$endr['cps'] = $cps;
				Endereco::save($endr);
			}
		}
		
		return static::findByCps($cps);
	}
	
	public static function edit($data) {
		if(!isset($data['cps']) || !static::findByCps($data['cps'], 'count')) {
			throw new Exception("Cliente não encontrado.");
		}
		if(isset($data['nps']) && strlen($data['nps']) === 0) {
			throw new Exception("Nome inválido.");
		}
		
		$cps = (int) $data['cps'];
		
		$connection = new Connection();
		
		/* atualiza o nome */
		if(isset($data['nps'])) {
			$eps = [
				'nps' => (string) $data['nps']
			];
			$connection->update('eps', $eps, "eps.cps = $cps");
		}
		
		/* atualiza o email */
		if(isset($data['email'])) {
			$email = [
				'email' => (string) $data['email']
			];
			$connection->update('email', $email, "email.cps = $cps");
		}
		
		/* atualiza upsj */
		if(isset($data['cnpj'])) {
			$cnpj = [
				'cnpj' => (string) $data['cnpj']
			];
			$connection->update('upsj', $cnpj, "upsj.cps = $cps");
		}
		
		/* dados auxiliares */
		$dados_auxiliares = [
			'cps' => $cps
		];
		if(isset($data['ativo'])) {
			$dados_auxiliares['ativo'] = $data['ativo'];
		}
		if(isset($data['cseg'])) {
			$dados_auxiliares['cseg'] = $data['cseg'];
		}
		DadosAuxiliares::save($dados_auxiliares);
		
		if(isset($data['telefones']) && is_array($data['telefones'])) {
			foreach($data['telefones'] as $tel) {
				$tel['cps'] = $cps;
				Telefone::save($tel);
			}
		}
		
		if(isset($data['enderecos']) && is_array($data['enderecos'])) {
			foreach($data['enderecos'] as $endr) {
				$endr['cps'] = $cps;
				Endereco::save($endr);
			}
		}

		return static::findByCps($data['cps']);
	}
	
	/* insere o cps na tabela de fornecedores */
	public static function cps_to_fornec(int $cps) {
		if(!static::findByCps($cps, 'count')) {
			$connection = new Connection();
			
			$zfornec = [
				'cps' => (int) $cps
			];
			$connection->insert('zfornec', $zfornec);
			return true;
		}
		return false;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zfornec.czfornec = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.sps LIKE '%$value%'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR eseg.sseg LIKE '%$value%'";
		$params['conditions'] .= " OR eseg.nseg LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
	
	
	public static function telefones(int $cps, string $type = 'all', array $params = array()) {
		return Telefone::findByCps($cps, $type, $params);
	}
	
	public static function enderecos(int $cps, string $type = 'all', array $params = array()) {
		return Endereco::findByCps($cps, $type, $params);
	}
	
}