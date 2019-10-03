<?php
App::import('Table', 'Model');

class ProdutoDetalhe extends Table {
	public static $_table = 'eprodd';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eprodd
			INNER JOIN eprod ON (eprod.cprod = eprodd.cprod)
			INNER JOIN elinha ON (elinha.clinha = eprod.clinha)
			INNER JOIN escat ON (escat.cscat = elinha.cscat)
			INNER JOIN etabela ON (etabela.ctabela = eprodd.ctabela)
			INNER JOIN eplano ON (eplano.cplano = eprodd.cplano)
		WHERE eprodd.RA = 1 AND eprod.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eprodd.cprodd',
		'eprod.cprod',
		'eprod.nprod',
		'elinha.clinha',
		'elinha.nlinha',
		'escat.cscat',
		'escat.nscat',
		'eprod.descricao',
		'etabela.ctabela',
		'etabela.ntabela',
		'eplano.cplano',
		'eplano.nplano',
		'eprodd.valor',
	);

	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cprodd'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*criação*/
	public static function create($data) {
		if(!isset($data['clinha'])) {
			throw new Exception('Linha inválida / Tipo inválido (clinha)');
		}
		
		$connection = new Connection();
		
		$dinicio = date("Y-m-d");
		$dfim =  date("Y-m-d", strtotime("+5 year"));
		
		$eprodd = [
			'cprod' => (int) _isset($data['cprod'], null),
			'ctabela' => (int) _isset($data['ctabela'], 8),
			'cplano' => (int) _isset($data['cplano'], 18),
			'valor' => (string) _isset($data['valor'], null),
			'dinicio' => (string) $dinicio,
			'dfim' => (string) $dfim,
			'flg_pedido' => (int) _isset($data['flg_pedido'], null),
		];
		$cprodd = $connection->insert('eprodd', $eprodd);
		
		return static::findById($cprodd);
	}
	
	/*edição*/
	public static function edit($data) {
		if(!isset($data['cprod']) || !static::findByCprod($data['cprod'], 'count')) {
			throw new Exception('Produto inválido');
		}
		
		$cprodd = $data['cprodd'];
		
		$connection = new Connection();
		
		$eprodd = [
			'valor' => (string) _isset($data['valor'], null),
		];
		$prodd = $connection->update('eprodd', $eprodd, "eprodd.cprodd = $cprodd");
		
		return $prodd;
	}
	

	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eprodd.cprodd = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCprod(int $id, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eprod.cprod = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eprod.cprod = '$value'";
		$params['conditions'] .= " OR eprod.nprod LIKE '%$value%'";
		$params['conditions'] .= " OR elinha.nlinha LIKE '%$value%'";
		$params['conditions'] .= " OR etabela.ntabela LIKE '%$value%'";
		$params['conditions'] .= " OR eplano.nplano LIKE '%$value%'";
		$params['conditions'] .= " OR eprodd.valor LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}