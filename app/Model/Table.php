<?php
App::import('Connection', 'Model');

class Table {
	
	/* Armazena o ultimo id de uma query de insert. */
	public static $_id;
	
	
	/* Executa a query recebida. */
	private static function _execute(string $qry, array $bind_values = array()) {
		$qry = preg_replace('/{{.*?}}/', '', $qry); /* Limpa os ids que não foram substituídos. */
		
		$connection = new Connection();
		if(empty($bind_values)) {
			$ret = $connection->query($qry);
		}
		else {
			$datatypes = static::_datatypes($bind_values);
			$ret = $connection->prepared($qry, $datatypes, ...$bind_values);
		}
		
		//echo $qry . '<br />'; 
		static::$_id = $connection->insert_id;
		return $ret;
	}
	
	
	/* Monta a query para executar. */
	public static function _find(string $type, array $params = array()) {
		$qry = null;
		$fields = null;
		$conditions = null;
		$group = null;
		$order = null;
		$limit = null;
		$page = null;
		
		
		/* Resgata os parâmetros. */
		$qry = _isset($params['qry'], static::$_qry);
		$fields = _isset($params['fields']);
		$conditions = _isset($params['conditions'], false);
		$group = _isset($params['group'], false);
		$order = _isset($params['order'], false);
		$limit = _isset($params['limit'], false);
		$page = _isset($params['page'], false);
		
		
		/* Trata os parâmetros. */
		/** $fields **/
		switch($type) {
			case 'count': $fields = array('COUNT(*) AS count'); break;
			case 'all': 
			case 'first':
			default:
				if(!$fields) {
					$fields = static::$_fields;
				}
				break;
		}
		/** $limit **/
		if($type == 'first') {
			$limit = 1;
			$page = null;
		}
		
		
		/* Faz as substituições no template de query */
		$qry = str_replace('{{fields}}', implode(', ', $fields), $qry);
		if($conditions) {
			$qry = str_replace('{{conditions}}', $conditions, $qry);
		}
		if($group) {
			$qry = str_replace('{{group}}', "GROUP BY $group", $qry);
		}
		if($order) {
			$qry = str_replace('{{order}}', "ORDER BY $order", $qry);
		}
		if($limit) {
			$qry = str_replace('{{limit}}', "LIMIT $limit", $qry);
		}
		if($page && $limit) {
			$offset = ($page - 1) * $limit;
			$qry = str_replace('{{offset}}', "OFFSET $offset", $qry);
		}
		
		
		$ret = static::_execute($qry);
		if(!$ret) {
			return $ret;
		}
		
		/* Trata o retorno. */
		switch($type) {
			case 'count': $ret = (int) $ret[0]['count']; break;
			case 'first': $ret = $ret[0]; break;
		}
		
		return $ret;
	}
	
	
	/* Faz um insert. */
	public static function insert(array $data) {
		$interrogations = static::_interrogations(count($data));
		$fields = array_keys($data);
		$values = array_values($data);
		
		$qry = 'INSERT INTO {{table}} ({{fields}}) VALUES ({{values}})';
		
		$qry = str_replace('{{table}}', static::$_table, $qry);
		$qry = str_replace('{{fields}}', implode(', ', $fields), $qry);
		$qry = str_replace('{{values}}', $interrogations, $qry);
		
		return static::_execute($qry, $values);
	}
	
	
	/* Faz um update. */
	public static function update(array $data, string $conditions) {
		$fields = array_keys($data);
		$values = array_values($data);
		
		$qry = 'UPDATE {{table}} SET {{fieldsets}}, RD = now() WHERE {{conditions}}';
		
		for($i = 0; $i < count($fields); $i++) {
			$v = $values[$i];
			$f = &$fields[$i];
			if($v === 'now()') {
				$f = "$f = now()";
				unset($values[$i]);
			}
			else {
				$f = "$f = ?";
			}
		}
		
		$qry = str_replace('{{table}}', static::$_table, $qry);
		$qry = str_replace('{{fieldsets}}', implode(', ', $fields), $qry);
		$qry = str_replace('{{conditions}}', $conditions, $qry);
		
		return static::_execute($qry, $values);
	}
	
	
	/* Faz um delete. */
	public static function remove(string $conditions) {
		$qry = 'DELETE FROM {{table}} WHERE {{conditions}}';
		
		$qry = str_replace('{{table}}', static::$_table, $qry);
		$qry = str_replace('{{conditions}}', $conditions, $qry);
		
		return static::_execute($qry);
	}
	
	
	/* utils */
	private static function _interrogations(int $count) {
		$str = str_repeat('?, ', $count);
		$str = substr($str, 0, strlen($str) - 2);
		return $str;
	}
	
	private static function _datatypes(array $data) {
		$datatypes = '';
		foreach($data as $d) {
			$type = '';
			if(is_int($d)) {
				$type = 'i';
			}
			else if(is_double($d)) {
				$type = 'd';
			}
			else if(is_string($d)) {
				$type = 's';
			}
			
			$datatypes = $datatypes . $type;
		}
		return $datatypes;
	}
}