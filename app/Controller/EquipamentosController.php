<?php
App::import('AppController', 'Controller');

App::import('Equipamento', 'Model');
App::import('Produto', 'Model');
App::import('ClientePF', 'Model');
App::import('ClientePJ', 'Model');
App::import('Ocorrencia', 'Model');
App::import('Pertence', 'Model');

class EquipamentosController extends AppController {
	
	public function index() {
		$search_value = _isset($_GET['search_value'], null);
		$order = _isset($_GET['order'], 'default');
		$order_values = array(
			'default' => 'eps.nps ASC',
			'pessoa' => 'eps.nps ASC',
		);
		
		$page = (int) _isset($_GET['page'], 1);
		$limit = (int) _isset($_GET['limit'], 20);
		
		if($search_value) {
			$list = Equipamento::search($search_value, 'all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order]));
			$count = Equipamento::search($search_value, 'count', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order]));
		}
		else {
			$list = Equipamento::find('all', array('page' => $page, 'limit' => $limit, 'order' => $order_values[$order]));
			$count = Equipamento::find('count');
		}
		
		$this->view->set('list', $list);
		$this->view->set('count', $count);
		$this->view->set('page', $page);
		$this->view->set('pages', (int) ceil($count / $limit));
	}
	
	public function inserir($cps) {
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$equipamento = Equipamento::save($data);
				return $this->redirect('/equipamentos/view/' . $equipamento['cequipe'] . '?inserido');
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('categorias', Produto::findByCscat(1));
		$this->view->set('responsavel', ClientePF::findByCps($cps));
		//$this->view->set('pessoas', array_merge(ClientePF::find('all', array('order' => 'eps.nps', 'conditions' => ' AND zpainel.ativo = 1 ')), ClientePJ::find('all', array('order' => 'eps.nps', 'conditions' => ' AND zpainel.ativo = 1 '))));
	}
	
	public function view($cequipe = null) {
		if($cequipe === null || !$equipamento = Equipamento::findById($cequipe)) {
			return $this->redirect('/equipamentos');
		}
		
		$equipamento['pertences'] = Equipamento::pertences($equipamento);
		$equipamento['attachments'] = Equipamento::attachments($equipamento);
		
		$this->view->set('equipamento', $equipamento);
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($equipamento['cequipe'], 'all', array('order' => 'eocorrencia.data DESC')));
	}
	
	public function editar($cequipe = null) {
		if($cequipe === null || !$equipamento = Equipamento::findById($cequipe)) {
			return $this->redirect('/equipamentos');
		}
		
		if($this->request->method === 'POST') {
			$equipamento['cps'] = _isset($_POST['cps'], $equipamento['cps']);
			$equipamento['cprod'] = _isset($_POST['cprod'], $equipamento['cprod']);
			$equipamento['nome'] = _isset($_POST['nome'], $equipamento['nome']);
			$equipamento['marca'] = _isset($_POST['marca'], $equipamento['marca']);
			$equipamento['tamanho'] = _isset($_POST['tamanho'], $equipamento['tamanho']);
			$equipamento['cor'] = _isset($_POST['cor'], $equipamento['cor']);
			$equipamento['ano'] = _isset($_POST['ano'], $equipamento['ano']);
			$equipamento['estado_geral'] = _isset($_POST['estado_geral'], $equipamento['estado_geral']);
			$equipamento['flg_venda'] = _isset($_POST['flg_venda'], $equipamento['flg_venda']);
			$equipamento['valor_venda'] = _isset($_POST['valor_venda'], $equipamento['valor_venda']);
			try {
				$equipamento = Equipamento::save($equipamento);
				return $this->redirect('/equipamentos/view/' . $equipamento['cequipe']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$this->view->set('equipamento', $equipamento);
		$this->view->set('categorias', Produto::findByCscat(1));
		$this->view->set('pessoas', array_merge(ClientePF::find('all', array('order' => 'eps.nps', 'conditions' => ' AND zpainel.ativo = 1 ')), ClientePJ::find('all', array('order' => 'eps.nps', 'conditions' => ' AND zpainel.ativo = 1 '))));
	}
	

	public function image_upload($cequipe = null) {
		$this->layout = false;
		$this->autoRender = false;
		
		if($cequipe === null || !$equipamento = Equipamento::findById($cequipe)) {
			return $this->redirect('/equipamentos');
		}
		
		if($this->request->method === 'POST' && isset($_FILES['attachments'])) {
			$count_files = sizeof($_FILES['attachments']['name']);
			for($i = 0; $i < $count_files; $i++) {
				$file_type = $_FILES['attachments']['type'][$i];
				if(in_array($file_type, array('image/jpeg', 'image/png', 'image/gif'))) {
					$upload_dir = WEBROOT . DS . 'attachments' . DS . 'equipamentos' . DS . $equipamento['cequipe'];
					if(!file_exists($upload_dir)) {
						if(!mkdir($upload_dir, 0755, true)) {
							continue;
						}
					}
					$file_name = $_FILES['attachments']['name'][$i];
					if(!move_uploaded_file($_FILES['attachments']['tmp_name'][$i], $upload_dir . DS . $file_name)) {
						$this->view->set('error', 'Erro ao fazer upload do arquivo. Tente novamente.');
					}
				}
			}
		}
		
		return $this->redirect('/equipamentos/view/' . $cequipe);
	}
	
	public function image_delete($cequipe = null) {
		$this->layout = false;
		$this->autoRender = false;
		
		if($cequipe === null || !$equipamento = Equipamento::findById($cequipe)) {
			return $this->redirect('/equipamentos');
		}
		
		if($this->request->method === 'POST') {
			$filename = $_POST['image_name'];
			$dir = WEBROOT . DS . 'attachments' . DS . 'equipamentos' . DS . $equipamento['cequipe'];
			unlink($dir . DS . $filename);
		}
		
		return $this->redirect('/equipamentos/view/' . $cequipe);
	}
	
	public function gerar_relacao($cequipe) {
		$this->layout = false;
				
		$equipamento = Equipamento::findById($cequipe);
		$pertences = Pertence::findByCequip($cequipe);
		
		$this->view->set('pertences', $pertences);
		$this->view->set('equipamento', $equipamento);
	}
}