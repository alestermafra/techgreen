<?php
App::import('Table', 'Model');

App::import('ClientePF', 'Model');
App::import('Aula', 'Model');

class ParticipanteAula extends Table {
	
	public static $_table = 'zaula';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM zaula
			LEFT JOIN eaula ON (eaula.caula = zaula.caula)
			LEFT JOIN eps ON (eps.cps = zaula.cps)
			LEFT JOIN eprod ON (eprod.cprod = zaula.cprod)
			LEFT JOIN elinha ON (elinha.clinha = eprod.clinha)
		WHERE zaula.RA = 1 AND eps.RA = 1
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
		'eaula.descricao',
		'eaula.subtitulo',
		'elinha.clinha',
		'elinha.nlinha',
		'eps.cps',
		'eps.nps',
		'zaula.czaula',
		'eprod.cprod',
		'eprod.nprod',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		return static::create($data);
	}
	
	/*remover*/
	public static function remover(int $cps, int $caula){
		$connection = new Connection();		
		$connection->remove('zaula', "zaula.cps = ".$cps." AND zaula.caula = ".$caula);
	}
	
	/*criação*/
	public static function create($data) {
		if(!isset($data['caula']) || !Aula::findById($data['caula'], 'first')) {
			throw new Exception('Aula inválida.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Participante ausente/inválido.');
		}
		if(!isset($data['cprod'])) {
			throw new Exception('Aula inválida.');
		}
		
		$connection = new Connection();
		
		$zaula = [
			'caula' => (int) _isset($data['caula'], null),
			'cps' => (int) _isset($data['cps'], null),
			'cprod' => (int) _isset($data['cprod'], null),
		];
		$czaula = $connection->insert('zaula', $zaula);
		
		return static::findById($czaula);
	}
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zaula.czaula = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCaula(int $id, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zaula.caula = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND zaula.cps = $cps";
		$params['order'] = 'eaula.cdia, eaula.cmes, eaula.can';
		return static::_find($type, $params);
	}
}