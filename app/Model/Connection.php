<?php
class Connection {
	
	private $connection;
	
	public static $queries = array();
	
	public $insert_id;

	public function open() {
		config('database');
		$config = DatabaseConfig::${'default'};
		$this->connection = new mysqli(
			$config['host'],
			$config['login'],
			$config['password'],
			$config['database']
		);
		
		if($this->connection->connect_error)
			die("open connection error");
		else {
			$this->connection->query("SET NAMES 'utf8'");
			$this->connection->query("SET time_zone = '-3:00'");
		}
	}
	
	public function close() {
		$this->connection->close();
	}
	
	public function prepared($query, ...$params) {
		$list = [];
		
		$this->open();
		$statement = $this->connection->prepare($query);
		$statement->bind_param(...$params);
		$statement->execute();
		$res = $statement->get_result();
		$statement->close();
		if(is_object($res)) {
			while($row = $res->fetch_assoc()) {
				$list[] = $row;
			}
			$res->close();
		}
		$this->insert_id = $this->connection->insert_id;
		$this->close();
		
		static::$queries[] = $query;
		
		return $list;
	}
	
	public function query($query) {
		$list = [];
		
		$this->open();
		$res = $this->connection->query($query);
		if(is_object($res)) {
			while($row = $res->fetch_assoc()) {
				$list[] = $row;
			}
			$res->close();
		}
		$this->insert_id = $this->connection->insert_id;
		$this->close();
		
		static::$queries[] = $query;
		
		return $list;
	}
	
	public function insert_id() {
		return $this->insert_id;
	}
	
	
	public function insert(string $table, array $data) {
		$interrogations = $this->_interrogations(count($data));
		$fields = array_keys($data);
		$values = array_values($data);
		
		$qry = 'INSERT INTO {{table}} ({{fields}}) VALUES ({{values}})';
		
		$qry = str_replace('{{table}}', $table, $qry);
		$qry = str_replace('{{fields}}', implode(', ', $fields), $qry);
		$qry = str_replace('{{values}}', $interrogations, $qry);
		
		$this->prepared($qry, $this->_datatypes($values), ...$values);
		return $this->insert_id();
	}
	
	/* Faz um update. */
	public function update(string $table, array $data, string $conditions) {
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
		
		$qry = str_replace('{{table}}', $table, $qry);
		$qry = str_replace('{{fieldsets}}', implode(', ', $fields), $qry);
		$qry = str_replace('{{conditions}}', $conditions, $qry);
		
		return $this->prepared($qry, $this->_datatypes($values), ...$values);
	}
	
	public function remove(string $table, string $conditions) {
		$qry = 'DELETE FROM {{table}} WHERE {{conditions}}';
		
		$qry = str_replace('{{table}}', $table, $qry);
		$qry = str_replace('{{conditions}}', $conditions, $qry);
		
		return static::query($qry);
	}
	
	
	/* utils */
	private function _interrogations(int $count) {
		$str = str_repeat('?, ', $count);
		$str = substr($str, 0, strlen($str) - 2);
		return $str;
	}
	
	private function _datatypes(array $data) {
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
};