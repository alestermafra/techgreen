<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('ClientePF', 'Model');
App::import('ClientePJ', 'Model');
App::import('Pertence', 'Model');

class Equipamento extends Table {
	
	public static $_table = 'eequipe';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eequipe
			LEFT JOIN eps ON (eps.cps = eequipe.cps)
			LEFT JOIN eprod ON (eprod.cprod = eequipe.cprod)
			LEFT JOIN elinha ON (elinha.clinha = eprod.clinha)
			LEFT JOIN escat ON (escat.cscat = elinha.cscat)
			LEFT JOIN ecat ON (ecat.ccat = escat.ccat)
			LEFT JOIN eguardaria ON (eguardaria.cequipe = eequipe.cequipe)
		WHERE eequipe.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eequipe.cequipe',
		'eps.cps',
		'eps.nps',
		'eprod.cprod',
		'eprod.nprod',
		'elinha.clinha',
		'elinha.nlinha',
		'escat.cscat',
		'escat.nscat',
		'ecat.ccat',
		'ecat.ncat',
		'eequipe.nome',
		'eequipe.marca',
		'eequipe.tamanho',
		'eequipe.cor',
		'eequipe.ano',
		'eequipe.estado_geral',
		'eequipe.flg_venda',
		'eequipe.valor_venda',
	);
	
	
	/* métodos de criação de edição */
	public static function save($equipamento) {
		if(!isset($equipamento['cequipe'])) {
			return static::create($equipamento);
		}
		return static::edit($equipamento);
	}
	
	public static function create($equipamento) {
		$connection = new Connection();
		
		$eequipe = [
			'cps' => (int) _isset($equipamento['cps'], null),
			'cprod' => (int) _isset($equipamento['cprod'], null),
			'nome' => (string) _isset($equipamento['nome'], null),
			'marca' => (string) _isset($equipamento['marca'], null),
			'tamanho' => (string) _isset($equipamento['tamanho'], null),
			'cor' => (string) _isset($equipamento['cor'], null),
			'ano' => (string) _isset($equipamento['ano'], null),
			'estado_geral' => (string) _isset($equipamento['estado_geral'], null),
			'flg_venda' => (int) ((!isset($equipamento['flg_venda']) || $equipamento['flg_venda'] == 'on') ? 1 : 0),
			'valor_venda' => (string) _isset($equipamento['valor_venda'], null),
		];
		$cequipe = $connection->insert('eequipe', $eequipe);
		
		return static::findById($cequipe);
	}
	
	public static function edit($equipamento) {
		$cequipe = $equipamento['cequipe'];
		
		$connection = new Connection();
		
		$eequipe = [
			'cps' => (int) _isset($equipamento['cps'], null),
			'cprod' => (int) _isset($equipamento['cprod'], null),
			'nome' => (string) _isset($equipamento['nome'], null),
			'marca' => (string) _isset($equipamento['marca'], null),
			'tamanho' => (string) _isset($equipamento['tamanho'], null),
			'cor' => (string) _isset($equipamento['cor'], null),
			'ano' => (string) _isset($equipamento['ano'], null),
			'estado_geral' => (string) _isset($equipamento['estado_geral'], null),
			'flg_venda' => (int) ((!isset($equipamento['flg_venda']) || $equipamento['flg_venda'] == 'on') ? 1 : 0),
			'valor_venda' => (string) _isset($equipamento['valor_venda'], null),
		];
		$cequipe = $connection->update('eequipe', $eequipe, "eequipe.cequipe = $cequipe");
		
		return $equipamento;
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eequipe.cequipe = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eps.cps = $cps";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eps.cps = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.nome LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.marca LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.tamanho LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.cor LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.ano LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.estado_geral LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
	
	
	
	public static function pertences($equipamento, string $type = 'all', array $params = array()) {
		return Pertence::FindByCequip($equipamento['cequipe'], $type, $params);
	}
	
	public static function attachments($equipamento, string $type = 'all', array $params = array()) {
		$dir = WEBROOT . DS . 'attachments' . DS . 'equipamentos' . DS . $equipamento['cequipe'];
		if(!file_exists($dir)) {
			return [];
		}
		$files = array_diff(scandir($dir), array('..', '.'));
		foreach($files as &$f) {
			$image_dir = $dir . DS . $f;
			$image_url = DS . 'attachments' . DS . 'equipamentos' . DS . $equipamento['cequipe'] . DS . $f;
			$f = array(
				'name' => $f,
				'dir' => $image_dir,
				'url' => $image_url
			);
		}
		return $files;
	}
}