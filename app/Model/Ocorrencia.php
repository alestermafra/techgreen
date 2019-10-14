<?php
App::import('Table', 'Model');
App::import('Connection', 'Model');

App::import('ClientePF', 'Model');
App::import('ClientePJ', 'Model');
App::import('Equipamento', 'Model');

App::import('Boleto', 'Model');

class Ocorrencia extends Table {
	
	public static $_table = 'eocorrencia';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eocorrencia
			INNER JOIN tocorrencia ON (tocorrencia.ctocorrencia = eocorrencia. ctocorrencia)
			LEFT JOIN eequipe ON (eequipe.cequipe = eocorrencia.codigo)
			LEFT JOIN eps ON (eps.cps = eocorrencia.codigo)
			LEFT JOIN eps psE ON (psE.cps = eequipe.cps)
		WHERE eocorrencia.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eocorrencia.cocorrencia',
		'tocorrencia.ctocorrencia',
		'tocorrencia.ntocorrencia',
		'eocorrencia.assunto',
		'eocorrencia.codigo',
		'eocorrencia.descricao',
		'eocorrencia.data',
		'eequipe.cequipe',
		'eequipe.nome',
		'eequipe.marca',
		'psE.nps as responsavel', 
		'eps.cps',
		'eps.nps',
	);
	
	
	/* métodos de criação de edição */
	public static function save($data) {
		if(!isset($data['cocorrencia'])) {
			return static::create($data);
		}
		return static::edit($data);
	}
		
	public static function create($data) {
		if(!isset($data['codigo'])) {
			throw new Exception('Cliente / Equipamento inválido');
		}
		
		$connection = new Connection();
		
		$ocorrencia = [
			'assunto' => (string) _isset($data['assunto'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'data' => (string) _isset($data['data'], null),
			'codigo' => (int) _isset($data['codigo'], null),
			'ctocorrencia' => (int) _isset($data['ctocorrencia'], null),
		];
		$cocorrencia = $connection->insert('eocorrencia', $ocorrencia);
		
		return static::findById($cocorrencia);
	}
	
	public static function edit($data) {
		if(!isset($data['cocorrencia'])) {
			throw new Exception('Erro ao resgatar código de ocorrência');
		}
		
		if(!isset($data['codigo'])) {
			throw new Exception('Cliente / Equipamento inválido');
		}
		
		$cocorrencia = $data['cocorrencia'];
		
		$connection = new Connection();
		
		$ocorrencia = [
			'assunto' => (string) _isset($data['assunto'], null),
			'descricao' => (string) _isset($data['descricao'], null),
			'data' => (string) _isset($data['data'], null),
			'codigo' => (int) _isset($data['codigo'], null),
			'ctocorrencia' => (int) _isset($data['ctocorrencia'], null),
		];		
		$connection->update('eocorrencia', $ocorrencia, "eocorrencia.cocorrencia = $cocorrencia");
		
		return $ocorrencia;
	}	
	
	/*specials*/
	public static function tipo() {
		$connection = new Connection();
		$rows = $connection->query(
			'SELECT 
				eocorrencia.ctocorrencia,
				eocorrencia.ntocorrencia
			FROM eocorrencia.tocorrencia 
			WHERE eocorrencia.RA = 1;');
		return $rows;
	}
	
	/*boleto*/
	public static function inserir_ocorrencia_boleto(int $cboleto) {	
		$dados = Boleto::findById($cboleto);
		
		$datinha = date("Y-m-d", strtotime($dados['data_venc']));
				
		$data = [
			'ctocorrencia' => 2,
			'codigo' => $dados['cps'],
			'data' => $datinha,
			'assunto' => 'Geração de boleto',
			'descricao' => 'Vencimento '. date("d/m/Y", strtotime($dados['data_venc'])) .' - R$ '. $dados['valor_cobrado'].' (sem taxas)',
		];
		return static::create($data);
	}	
	
	
	
	/* métodos de busca */
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eocorrencia.cocorrencia = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCodigo(int $codigo, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eocorrencia.codigo = $codigo";
		return static::_find($type, $params);
	}
	
	public static function findByCodigoPessoa(int $codigo, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eocorrencia.codigo = ".$codigo." AND eocorrencia.ctocorrencia = 2";
		return static::_find($type, $params);
	}
	
	public static function findByCodigoEquipamento(int $codigo, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eocorrencia.codigo = ".$codigo." AND eocorrencia.ctocorrencia = 1";
		return static::_find($type, $params);
	}
	
	public static function search($value, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND ( eocorrencia.codigo = '$value'";
		$params['conditions'] .= " OR eps.nps LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.nome LIKE '%$value%'";
		$params['conditions'] .= " OR eequipe.marca LIKE '%$value%'";
		$params['conditions'] .= " OR eocorrencia.assunto LIKE '%$value%'";
		$params['conditions'] .= " OR eocorrencia.data LIKE '%$value%'";
		$params['conditions'] .= ")";
		return static::_find($type, $params);
	}
}