<?php
App::import('Table', 'Model');

App::import('Produto', 'Model');
App::import('Plano', 'Model');
App::import('FormaPagamento', 'Model');

class Aula extends Table {
	
	public static $_table = 'eaula';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eaula
			LEFT JOIN eplano ON (eplano.cplano = eaula.cplano)
			LEFT JOIN elinha ON (elinha.clinha = eaula.clinha)
			LEFT JOIN epgt ON (epgt.cpgt = eaula.cpgt)
			LEFT JOIN eppgt ON (eppgt.cppgt = eaula.cppgt)
			LEFT JOIN (
				SELECT
					COUNT(czaula) as qtd,
					caula,
					cps
				FROM zaula
				WHERE RA = 1
				GROUP BY caula
			) zaula ON zaula.caula = eaula.caula
		WHERE eaula.RA = 1 
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eaula.caula',
		'eaula.cdia',
		'eaula.cmes',
		'eaula.can',
		'eaula.chora',
		'eaula.cminuto',
		'eaula.instrutor',
		'eaula.subtitulo',
		'eplano.cplano',
		'eplano.nplano',
		'elinha.clinha',
		'elinha.nlinha',
		'epgt.cpgt',
		'epgt.npgt',
		'eppgt.cppgt',
		'eppgt.qtd_parcela',
		'eppgt.nppgt',
		'eaula.valor',
		'eaula.descricao',
		'eaula.cdia_pgt',
		'eaula.cmes_pgt',
		'eaula.can_pgt',
		'zaula.qtd',
	);
	
	
	/* métodos de criação de edição */
	public static function save($aula) {
		if(!isset($aula['caula'])) {
			return static::create($aula);
		}
		return static::edit($aula);
	}
	
	public static function create($aula) {
		if(!isset($aula['clinha']) || !Produto::findByClinha($aula['clinha'], 'count')) {
			throw new Exception('Tipo de aula inválida.');
		}
		if(!isset($aula['cplano']) || !Plano::findById($aula['cplano'], 'count')) {
			throw new Exception('Plano inválido.');
		}
		if(!isset($aula['cpgt']) || !FormaPagamento::findById($aula['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		
		$connection = new Connection();
		
		$eaula = [
			'cplano' => (int) _isset($aula['cplano'], null),
			'clinha' => (int) _isset($aula['clinha'], null),
			'valor' => (int) _isset($aula['valor'], null),
			'cpgt' => (int) _isset($aula['cpgt'], null),
			'cdia' => date("j",strtotime($aula['datinha'])),
			'cmes' => date("n",strtotime($aula['datinha'])),
			'can' => date("Y",strtotime($aula['datinha'])),
			'cppgt' => (int) _isset($aula['cppgt'], null),
			'descricao' => (string) _isset($aula['descricao'], null),
			'cdia_pgt' => date("j",strtotime($aula['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($aula['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($aula['datinha_pgt'])),
			'chora' => (int) _isset($aula['chora'], null),
			'cminuto' => (int) _isset($aula['cminuto'], null),
			'instrutor' => (string) _isset($aula['instrutor'], null),
			'subtitulo' => (string) _isset($aula['subtitulo'], null),
		];
		$caula = $connection->insert('eaula', $eaula);
		
		return static::findById($caula);
	}
	
	public static function edit($aula) {
		if(!isset($aula['clinha']) || !Produto::findByClinha($aula['clinha'], 'count')) {
			throw new Exception('Tipo de aula inválida.');
		}
		if(!isset($aula['cplano']) || !Plano::findById($aula['cplano'], 'count')) {
			throw new Exception('Plano inválido.');
		}
		if(!isset($aula['cpgt']) || !FormaPagamento::findById($aula['cpgt'], 'count')) {
			throw new Exception('Forma de pagamento inválida.');
		}
		
		$caula = $aula['caula'];
		
		$connection = new Connection();
		
		$eaula = [
			'cplano' => (int) _isset($aula['cplano'], null),
			'clinha' => (int) _isset($aula['clinha'], null),
			'valor' => (int) _isset($aula['valor'], null),
			'cpgt' => (int) _isset($aula['cpgt'], null),
			'cdia' => date("j",strtotime($aula['datinha'])),
			'cmes' => date("n",strtotime($aula['datinha'])),
			'can' => date("Y",strtotime($aula['datinha'])),
			'cppgt' => (int) _isset($aula['cppgt'], null),
			'descricao' => (string) _isset($aula['descricao'], null),
			'cdia_pgt' => date("j",strtotime($aula['datinha_pgt'])),
			'cmes_pgt' => date("n",strtotime($aula['datinha_pgt'])),
			'can_pgt' => date("Y",strtotime($aula['datinha_pgt'])),
			'chora' => (int) _isset($aula['chora'], null),
			'cminuto' => (int) _isset($aula['cminuto'], null),
			'instrutor' => (string) _isset($aula['instrutor'], null),
			'subtitulo' => (string) _isset($aula['subtitulo'], null),
		];
		$connection->update('eaula', $eaula, "eaula.caula = $caula");
		
		return $aula;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eaula.caula = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( tequipe.ntequipe LIKE '%$value%'";
		$params['conditions'] .= " OR eplano.nplano LIKE '%$value%'";
		$params['conditions'] .= " OR elinha.nlinha LIKE '%$value%'";
		$params['conditions'] .= " OR epgt.pgt LIKE '%$value%'";
		$params['conditions'] .= " OR eaula.descricao LIKE '%$value%'";
		$params['conditions'] .= " OR eaula.valor LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}