<?php
App::import('Table', 'Model');

App::import('Produto', 'Model');
App::import('Plano', 'Model');
App::import('FormaPagamento', 'Model');
App::import('ValeLocacao', 'Model');

class Locacao extends Table {
	
	public static $_table = 'elocacao';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM elocacao
			LEFT JOIN eps ON (eps.cps = elocacao.cps)
			LEFT JOIN eplano ON (eplano.cplano = elocacao.cplano)
			LEFT JOIN eprod ON (eprod.cprod = elocacao.cprod)
			LEFT JOIN elinha ON (elinha.clinha = eprod.clinha)
			LEFT JOIN epgt ON (epgt.cpgt = elocacao.cpgt)
			LEFT JOIN eppgt ON (eppgt.cppgt = elocacao.cppgt)
			LEFT JOIN etabela ON (etabela.ctabela = elocacao.ctabela)
		WHERE elocacao.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'elocacao.clocacao',
		'elocacao.chora',
		'elocacao.cminuto',
		'elocacao.cdia',
		'elocacao.cmes',
		'elocacao.can',
		'eps.cps',
		'eps.nps',
		'etabela.ctabela',
		'etabela.ntabela', 
		'eplano.cplano',
		'eplano.nplano',
		'eprod.cprod',
		'eprod.nprod',
		'elinha.clinha',
		'elinha.nlinha',
		'epgt.cpgt',
		'epgt.npgt',
		'eppgt.cppgt',
		'eppgt.qtd_parcela',
		'eppgt.nppgt',
		'elocacao.cdia_pgt',
		'elocacao.cmes_pgt',
		'elocacao.can_pgt',
		'elocacao.valor',
		'elocacao.descricao',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['clocacao'])) {
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
		if(!isset($data['cpgt']) || !FormaPagamento::findById($data['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		//---------tratativa para vale locação*/
		$vale = [
			'cps' => (int) $data['cps'],
			'horas' => (int) 6,
		];
		/*adiciona horas ao saldo existente*/
		if($data['cplano']==13 && ValeLocacao::findByCps($data['cps'], 'count')){ 
			ValeLocacao::special($vale);
		}
		/*insere*/
		if($data['cplano']==13 && !ValeLocacao::findByCps($data['cps'], 'count')){ 
			ValeLocacao::create($vale);
		}
		//---------fim da tratativa para vale locação*/
		
		
		$connection = new Connection();
		
		$elocacao = [
			'cplano' => (int) _isset($data['cplano'], null),
			'ctabela' => (int) _isset($data['ctabela'], null),
			'cps' => (int) _isset($data['cps'], null),
			'cprod' => (int) _isset($data['cprod'], null),
			'valor' => (string) _isset($data['valor'], null),
			'cpgt' => (int) _isset($data['cpgt'], null),
			'cdia_pgt' => date("j",strtotime($data['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($data['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($data['datinha_pgt'])),
			'cppgt' => (int) _isset($data['cppgt'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'cdia' => date("j",strtotime($data['datinha'])),
			'cmes' => date("n",strtotime($data['datinha'])),
			'can' => date("Y",strtotime($data['datinha'])),
			'chora' => (int) _isset($data['chora'], null),
			'cminuto' => (int) _isset($data['cminuto'], null),
		];
		$clocacao = $connection->insert('elocacao', $elocacao);
		
		return static::findById($clocacao);
	}
	
	public static function edit($data) {
		if(!isset($data['cprod']) || !Produto::findById($data['cprod'], 'count')) {
			throw new Exception('Tipo de equipamento inválido.');
		}
		if(!isset($data['cplano']) || !Plano::findById($data['cplano'], 'count')) {
			throw new Exception('Plano inválido.');
		}
		if(!isset($data['cpgt']) || !FormaPagamento::findById($data['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Cliente inválido.');
		}
		
		$clocacao = $data['clocacao'];
		
		//---------tratativa para vale locação*/
		$vale = [
			'cps' => (int) $data['cps'],
			'horas' => (int) 6,
		];
		/*adiciona horas ao saldo existente*/
		if($data['cplano']==13 && ValeLocacao::findByCps($data['cps'], 'count')){ 
			ValeLocacao::special($vale);
		}
		/*insere*/
		if($data['cplano']==13 && !ValeLocacao::findByCps($data['cps'], 'count')){ 
			ValeLocacao::create($vale);
		}
		//---------fim da tratativa para vale locação*/
		
		$connection = new Connection();
		
		$elocacao = [
			'cps' => (int) _isset($data['cps'], null),
			'cplano' => (int) _isset($data['cplano'], null),
			'ctabela' => (int) _isset($data['ctabela'], null),
			'cprod' => (int) _isset($data['cprod'], null),
			'valor' => (string) _isset($data['valor'], null),
			'cpgt' => (int) _isset($data['cpgt'], null),
			'cdia_pgt' => date("j",strtotime($data['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($data['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($data['datinha_pgt'])),
			'cppgt' => (int) _isset($data['cppgt'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'cdia' => date("j",strtotime($data['datinha'])),
			'cmes' => date("n",strtotime($data['datinha'])),
			'can' => date("Y",strtotime($data['datinha'])),
			'chora' => (int) _isset($data['chora'], null),
			'cminuto' => (int) _isset($data['cminuto'], null),
		];
		$connection->update('elocacao', $elocacao, "elocacao.clocacao = $clocacao");
		
		return $data;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND elocacao.clocacao = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR eplano.nplano LIKE '%$value%'";
		$params['conditions'] .= " OR eprod.nprod LIKE '%$value%'";
		$params['conditions'] .= " OR epgt.pgt LIKE '%$value%'";
		$params['conditions'] .= " OR elocacao.descricao LIKE '%$value%'";
		$params['conditions'] .= " OR elocacao.valor LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}