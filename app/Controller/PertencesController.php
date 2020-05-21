<?php
App::import('AppController', 'Controller');

App::import('Equipamento', 'Model');
App::import('Pertence', 'Model');

class PertencesController extends AppController {
	public function inserir($cequip = null) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$pertence = Pertence::save($data);
				return $this->redirect('/equipamentos/view/' . $data['cequipe']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('equipamentos', Equipamento::find());
		$this->view->set('cequip', $cequip);
	}
	
	public function editar($cpertence = null) {
		if($cpertence === null || !$pertence = Pertence::findById($cpertence)) {
			return $this->redirect('/equipamentos');
		}
		
		if($this->request->method === 'POST') {
			$pertence['cequipe'] = _isset($_POST['cequipe'], $pertence['cequipe']);
			$pertence['npertence'] = _isset($_POST['npertence'], $pertence['npertence']);
			$pertence['marca'] = _isset($_POST['marca'], $pertence['marca']);
			$pertence['modelo'] = _isset($_POST['modelo'], $pertence['modelo']);
			$pertence['tamanho'] = _isset($_POST['tamanho'], $pertence['tamanho']);
			$pertence['cor'] = _isset($_POST['cor'], $pertence['cor']);
			$pertence['ano'] = _isset($_POST['ano'], $pertence['ano']);
			$pertence['estado_geral'] = _isset($_POST['estado_geral'], $pertence['estado_geral']);
			try {
				$pertence = Pertence::save($pertence);
				return $this->redirect('/equipamentos/view/' . $pertence['cequipe']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		else if($this->request->method === 'GET') {
			if(isset($_GET['delete'])) {
				Pertence::remove($pertence);
				return $this->redirect('/equipamentos/view/' . $pertence['cequipe']);
			}
		}
		
		$this->view->set('pertence', $pertence);
		$this->view->set('equipamentos', Equipamento::find());
	}
}