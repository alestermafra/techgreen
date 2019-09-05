<?php
App::import('Auth', 'Model');

App::import('Menu', 'Model');

class AppController extends Controller {
	public function beforeAction() {
		$action = $this->request->params['action'];
		
		/* restrição se está logado ou nao */
		if(!Auth::is_logged() && !Auth::is_allowed($action)) {
			if($this->request->url !== 'login') {
				return $this->redirect('/login?redirect=' . $this->request->url);
			}
			return $this->redirect('/login');
		}
		
		/* carrega menu em todas as paginas enquanto o cara estiver logado */
		if(Auth::is_logged()) {
			/* atualiza o last_interact na susu */
			Auth::interact(); 
			
			/* pega o menu e seta a variavel para todas as views */
			$user = Auth::user();
			$menu = Menu::getMenu($user['cna']);
			$this->view->set('menu', $menu);
		}
	}
	
	public function phpinfo() {
		phpinfo();
		die();
	}
}