<?php
App::import('Table', 'Model');

class PagamentoGuarderia extends Table {
	public static $_table = 'pagamento_guarderia';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM pagamento_guarderia
		WHERE pagamento_guarderia.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'pagamento_guarderia.id',
		'pagamento_guarderia.cguardaria',
		'pagamento_guarderia.valor',
		'pagamento_guarderia.mes_ref',
		'pagamento_guarderia.ano_ref',
		'pagamento_guarderia.data_pagamento',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['id'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	public static function create($data) {
		$connection = new Connection();
		
		$pagamento_guarderia = [
			'cguardaria' => (int) _isset($data['cguardaria'], null),
			'valor' => (float) _isset($data['valor'], null),
			'mes_ref' => (int) _isset($data['mes_ref'], null),
			'ano_ref' => (int) _isset($data['ano_ref'], null),
			'data_pagamento' => (string) _isset($data['data_pagamento'], null),
		];
		$id = $connection->insert('pagamento_guarderia', $pagamento_guarderia);
		
		return static::findById($id);
	}
	
	public static function edit($data) {
		$id = $data['id'];
		
		$connection = new Connection();
		
		$pagamento_guarderia = [
			'cguardaria' => (int) _isset($data['cguardaria'], null),
			'valor' => (float) _isset($data['valor'], null),
			'mes_ref' => (int) _isset($data['mes_ref'], null),
			'ano_ref' => (int) _isset($data['ano_ref'], null),
			'data_pagamento' => (string) _isset($data['data_pagamento'], null),
		];
		$connection->update('pagamento_guarderia', $pagamento_guarderia, "pagamento_guarderia.id = $id");
		
		return $pagamento_guarderia;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND pagamento_guarderia.id = $id";
		return static::_find($type, $params);
	}

	public static function findByCguardaria(int $cguardaria, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND pagamento_guarderia.cguardaria = $cguardaria";
		return static::_find($type, $params);
	}
}