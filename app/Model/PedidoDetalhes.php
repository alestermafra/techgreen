<?php
App::import('Table', 'Model');

class PedidoDetalhes extends Table {
	public static $_table = 'epedd';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM epedd
			INNER JOIN eped ON eped.cped = epedd.cped
			INNER JOIN eprod ON eprod.cprod = epedd.cprod
			LEFT JOIN eprodd ON eprodd.cprod = eprod.cprod AND eprodd.flg_pedido = 1
		WHERE epedd.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'epedd.cpedd',
		'epedd.cped',
		'epedd.qtd',
		'epedd.val_orig',
		'epedd.val_unit',
		'epedd.val_tot',
		'epedd.cprod',
		'eprod.nprod'
	);
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cpedd'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*criação*/
	public static function create($data) {
		
		$connection = new Connection();
		
		$epedd = [
			'cped' => (int) _isset($data['cped'], null),
			'qtd' => (int) _isset($data['qtd'], null),
			'cprod' => (int)  _isset($data['cprod'], null),
			'val_orig' => (string) _isset($data['val_orig'], null),
			'val_unit' => (string) _isset($data['val_unit'], null),
			'val_tot' => (string) _isset($data['val_tot'], null),
		];
		$cpedd = $connection->insert('epedd', $epedd);
		
		return static::findById($cped);
	}
	
	/*edição*/
	public static function edit($data) {
		
		$cpedd = $data['cpedd'];
		
		$connection = new Connection();
		
		$epedd = [
			'cped' => (int) _isset($data['cped'], null),
			'qtd' => (int) _isset($data['qtd'], null),
			'cprod' => (int)  _isset($data['cprod'], null),
			'val_orig' => (string) _isset($data['val_orig'], null),
			'val_unit' => (string) _isset($data['val_unit'], null),
			'val_tot' => (string) _isset($data['val_tot'], null),
		];
		$pedd = $connection->update('epedd', $epedd, "epedd.cpedd = $cpedd");
		
		return $ped;
	}
	
	/*remover*/
	public static function remover(int $cpedd) {
		$epedd = static::findById($cpedd);
		static::remove("epedd.cpedd = $cpedd");
	}

	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eped.cped = $id";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eped.cped = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR emov.nmov LIKE '%$value%'";
		$params['conditions'] .= " OR eped.valtot LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}