<?php
class Session {
	/* flag apenas para verificar se a sessão está aberta */
	private static $_session_started = false;
	
	/* abre a sessao se ainda nao tiver */
	private static function _session() {
		if(static::$_session_started)
			return;
		ini_set('session.save_path', ROOT . DS . 'tmp' . DS . 'sessions');
		static::$_session_started = session_start();
		if(!static::$_session_started)
			die('Não foi possível abrir a sessão.');
	}
	
	/* lê um valor da sessão */
	public static function read($key) {
		static::_session();
		return isset($_SESSION[$key])? $_SESSION[$key] : null;
	}
	
	/* escreve um valor na sessão */
	public static function write($key, $value) {
		static::_session();
		$_SESSION[$key] = $value;
	}
	
	/* deleta uma chave da sessão */
	public static function remove($key) {
		static::_session();
		unset($_SESSION[$key]);
	}
	
	/* consume uma chave da sessão. Vai ler e remover em seguida */
	public static function consume($key) {
		$r = static::read($key);
		static::remove($key);
		return $r;
	}
	
	/* limpa a sessão */
	public static function clear() {
		static::_session();
		$_SESSION = [];
		session_destroy();
	}
}