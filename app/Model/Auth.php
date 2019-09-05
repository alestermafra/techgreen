<?php
App::import('Connection', 'Model');
App::import('Session', 'Model');

App::import('Usuario', 'Model');

class Auth {
	/* sistema de login */
	public static $login_redirect = '/dashboard'; /* pagina de redirecionamento quando o cara logar */
	public static $logout_redirect = '/login'; /* pagina de redirecionamento quando o cara deslogar */
	
	/* loga o cara */
	public static function login($login, $password) {
		$user = Usuario::authenticate($login, $password);
		if(empty($user)) {
			return false;
		}
		
		Session::write('user', $user);
		
		//Usuario::interact($user['cusu']);
		
		return true;
	}
	
	/* desloga o cara */
	public static function logout() {
		Session::remove('user');
	}
	
	/* verifica se está logado */
	public static function is_logged() {
		$user = Session::read('user');
		return $user !== null;
	}
	
	/* retorna os dados do usuário logado */
	public static function user() {
		return Session::read('user');
	}
	
	/* atualiza o last_inter do usuario logado */
	public static function interact() {
		$user = static::user();
		$connection = new Connection();
		$connection->prepared(
			'UPDATE susu SET last_inter = now() WHERE cusu = ?',
			'i',
			$user['cusu']
		);
	}
	
	
	/* sistema de permissao de acesso as paginas quando nao esta logado. */
	private static $_allowed_actions = []; /* aqui ficara armazenado as paginas que os deslogados podem ver */
	
	/* adiciona uma pagina na lista de paginas permitidas */
	public static function allow($actions) {
		self::$_allowed_actions = $actions;
	}
	
	/* verifica se a pagina está permitida */
	public static function is_allowed($action) {
		return in_array($action, self::$_allowed_actions);
	}
}