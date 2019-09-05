<?php
App::import('Table', 'Model');

App::import('Produto', 'Model');
App::import('Plano', 'Model');
App::import('Tabela', 'Model');
App::import('FormaPagamento', 'Model');

class DiariaVelejador extends Table {
	
	public static $_table = 'ediaria';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM ediaria
			LEFT JOIN eps ON (eps.cps = ediaria.cps)
			LEFT JOIN eplano ON (eplano.cplano = ediaria.cplano)
			LEFT JOIN eprod ON (eprod.cprod = ediaria.cprod)
			LEFT JOIN elinha ON (elinha.clinha = eprod.clinha)
			LEFT JOIN epgt ON (epgt.cpgt = ediaria.cpgt)
			LEFT JOIN eppgt ON (eppgt.cppgt = ediaria.cppgt)
			LEFT JOIN etabela ON (etabela.ctabela = ediaria.ctabela)
		WHERE ediaria.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'ediaria.cdiaria',
		'ediaria.cdia',
		'ediaria.cmes',
		'ediaria.can',
		'eps.cps',
		'eps.nps',
		'eplano.cplano',
		'eplano.nplano',
		'etabela.ctabela',
		'etabela.ntabela',
		'eprod.cprod',
		'eprod.nprod',
		'elinha.clinha',
		'elinha.nlinha',
		'epgt.cpgt',
		'epgt.npgt',
		'eppgt.cppgt',
		'eppgt.qtd_parcela',
		'eppgt.nppgt',
		'ediaria.cdia_pgt',
		'ediaria.cmes_pgt',
		'ediaria.can_pgt',
		'ediaria.valor',
		'ediaria.descricao',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cdiaria'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		if(!isset($data['cprod']) || !Produto::findById($data['cprod'], 'count')) {
			throw new Exception('Tipo de equipamento inválido.');
		}
		if(!isset($data['cplano']) || !Plano::findById($data['cplano'], 'count')) {
			throw new Exception('Plano inválido.');
		}
		if(!isset($data['ctabela']) || !Tabela::findById($data['ctabela'], 'count')) {
			throw new Exception('Tabela de preços inválida.');
		}
		if(!isset($data['cpgt']) || !FormaPagamento::findById($data['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
				
		$connection = new Connection();
		
		$ediaria = [
			'cplano' => (int) _isset($data['cplano'], null),
			'cps' => (int) _isset($data['cps'], null),
			'cprod' => (int) _isset($data['cprod'], null),
			'ctabela' => (int) _isset($data['ctabela'], null),
			'valor' => (string) _isset($data['valor'], null),
			'cpgt' => (int) _isset($data['cpgt'], null),
			'cdia' => date("j",strtotime($data['datinha'])),
			'cmes' => date("n",strtotime($data['datinha'])),
			'can' => date("Y",strtotime($data['datinha'])),
			'cppgt' => (int) _isset($data['cppgt'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'cdia_pgt' => date("j",strtotime($data['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($data['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($data['datinha_pgt'])),
		];
		$cdiaria = $connection->insert('ediaria', $ediaria);
		
		return static::findById($cdiaria);
	}
	
	public static function edit($data) {
		if(!isset($data['cprod']) || !Produto::findById($data['cprod'], 'count')) {
			throw new Exception('Tipo de equipamento inválido.');
		}
		if(!isset($data['cplano']) || !Plano::findById($data['cplano'], 'count')) {
			throw new Exception('Plano inválido.');
		}
		if(!isset($data['ctabela']) || !Tabela::findById($data['ctabela'], 'count')) {
			throw new Exception('Tabela de preços inválida.');
		}
		if(!isset($data['cpgt']) || !FormaPagamento::findById($data['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		$cdiaria = $data['cdiaria'];
		
		$connection = new Connection();
		
		$ediaria = [
			'cps' => (int) _isset($data['cps'], null),
			'ctabela' => (int) _isset($data['ctabela'], null),
			'cplano' => (int) _isset($data['cplano'], null),
			'cprod' => (int) _isset($data['cprod'], null),
			'valor' => (string) _isset($data['valor'], null),
			'cpgt' => (int) _isset($data['cpgt'], null),
			'cdia' => date("j",strtotime($data['datinha'])),
			'cmes' => date("n",strtotime($data['datinha'])),
			'can' => date("Y",strtotime($data['datinha'])),
			'cppgt' => (int) _isset($data['cppgt'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'cdia_pgt' => date("j",strtotime($data['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($data['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($data['datinha_pgt'])),
		];
		$connection->update('ediaria', $ediaria, "ediaria.cdiaria = $cdiaria");
		
		return $data;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ediaria.cdiaria = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR eplano.nplano LIKE '%$value%'";
		$params['conditions'] .= " OR etabela.ntabela LIKE '%$value%'";
		$params['conditions'] .= " OR eprod.nprod LIKE '%$value%'";
		$params['conditions'] .= " OR epgt.pgt LIKE '%$value%'";
		$params['conditions'] .= " OR ediaria.descricao LIKE '%$value%'";
		$params['conditions'] .= " OR ediaria.valor LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}