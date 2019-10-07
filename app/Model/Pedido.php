<?php
App::import('Table', 'Model');

class Pedido extends Table {
	public static $_table = 'eped';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eped
			LEFT JOIN emov ON emov.cmov = eped.cmov
			LEFT JOIN epgt ON epgt.cpgt = eped.cpgt
			LEFT JOIN eppgt ON eppgt.cppgt = eped.cppgt
			LEFT JOIN cps ON eps.cps = eped.cps
		WHERE eped.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eped.cped',
		'eped.cps_vend',
		'eped.data',
		'eped.valorsale',
		'eped.valtot',
		'eped.concluido',
		'eped.descricao',
		'eped.cps',
		'eps.nps',
		'eped.cmov',
		'emov.nmov',
		'eped.cpgt',
		'epgt.npgt',
		'eped.cppgt',
		'eppgt.nppgt'
	);
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cped'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
	
	/*criação*/
	public static function create($data) {
		
		$connection = new Connection();
		
		$eped = [
			'cps_vend' => (int) _isset($data['cps_vend'], null),
			'data' => (string) date("Y-m-d"),
			'concluido' => (int) 0,
		];
		$cped = $connection->insert('eped', $eped);
		
		return static::findById($cped);
	}
	
	/*edição*/
	public static function edit($data) {
		
		$cped = $data['cped'];
		
		$connection = new Connection();
		
		$eped = [
			'cps_vend' => (int) _isset($data['cps_vend'], null),
			'cps' => (int) _isset($data['cps'], null),
			'cmov' => (int) _isset($data['cmov'], null),
			'valorsale' => (string) _isset($data['valorsale'], null),
			'valtot' => (string) _isset($data['valtot'], null),
			'cpgt' => (int) _isset($data['cpgt'], null),
			'cppgt' => (int) _isset($data['cppgt'], null),
			'concluido' => (int) _isset($data['concluido'], null),
			'descricao' => (string) _isset($data['descricao'], null),
		];
		$ped = $connection->update('eped', $eped, "eped.cped = $cped");
		
		return $ped;
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