<?php
class Database {
	private $config;
	
	private $connection = null;
	
	private static $cache = array();
	
	public function __construct($db_config = 'default') {
		if(is_string($db_config)) {
			/* Carrega as configurações do arquivo app/Config/database.php. */
			config('database'); /* Esta função está no arquivo lib/basics.php. */
			if(isset(DatabaseConfig::${$db_config})) {
				$db_config = DatabaseConfig::${$db_config};
			}
		}
		if(is_array($db_config) && isset($db_config['host'], $db_config['login'], $db_config['password'], $db_config['database'])) {
			$this->config = array(
				'host' => $db_config['host'],
				'login' => $db_config['login'],
				'password' => $db_config['password'],
				'database' => $db_config['database']
			);
		}
		else {
			throw new Exception('Invalid database configuration.');
		}
	}
	
	public function connect() {
		$key = $this->config['host'] . $this->config['login'] . $this->config['database'];
		if(!$this->is_cached()) {
			$this->connection = new mysqli(
				$this->config['host'],
				$this->config['login'],
				$this->config['password'],
				$this->config['database']
			);
			
			$this->cache();
		}
		
		return $this->get_cache();
	}
	
	public function disconnect() {
		if($this->connection !== null) {
			$this->connection->close();
		}
		$this->uncache();
	}
	
	
	
	/* Cache connection methods. */
	private function cache_key() {
		return $this->config['host'] . $this->config['login'] . $this->config['database'];
	}
	
	private function is_cached() {
		return isset(static::$cache[$this->cache_key()]);
	}
	
	private function get_cache() {
		return static::$cache[$this->cache_key()];
	}
	
	private function cache() {
		return static::$cache[$this->cache_key()] = $this->connection;
	}
	
	private function uncache() {
		unset(static::$cache[$this->cache_key()]);
	}
}