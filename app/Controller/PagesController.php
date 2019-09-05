<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

class PagesController extends AppController {
	public function home() { /* pagina inicial quando o cara nao digitar nenhum controller */
		/* se nao estiver logado, manda pra login. se estiver, para o dashboard. */
		if(!Auth::is_logged()) {
			return $this->redirect('/login');
		}
		$this->redirect('/dashboard');
	}
}