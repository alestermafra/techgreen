<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');
App::import('Session', 'Model');

App::import('BrechoItem', 'Model');
App::import('Produto', 'Model');

class BrechoController extends AppController {
    public function index() {
        $filter['search'] = $_GET['search'] ?? null;
        $filter['tipo_embarcacao'] = $_GET['tipo_embarcacao'] ?? null;
        $filter['exibir_vendidos'] = $_GET['exibir_vendidos'] ?? 'nao_exibir_vendidos';
        $filter['order'] = $_GET['order'] ?? 'cod_referencia';
        $filter['limit'] = $_GET['limit'] ?? 10;
        $filter['page'] = $_GET['page'] ?? 1;

        $query = "SELECT id, cod_referencia, tipo_embarcacao_cprod, nome, marca, modelo, tamanho, cor, estado, valor, data_venda, observacao, created_at, updated_at, eprod.nprod as tipo_embarcacao FROM brecho_itens LEFT JOIN eprod ON (eprod.cprod = brecho_itens.tipo_embarcacao_cprod) WHERE 1 = 1";
        $bind = [];
        $bindTypes = '';
        $where = '';

        // where
        // montar o where
        // precisa desta variável para ser usada também na query do count mais a frente.
        if($filter['search']) {
            // quando alterar estas condicoes, corrigir também o for pois ele tem que percorrer a quantidade de likes que está fazendo.
            $where .= " AND (cod_referencia like ? OR nome like ? OR marca like ? or modelo like ? or tamanho like ? or cor like ? or estado like ? or observacao like ?)";
            for($i = 0; $i < 8; $i++) {
                $bind[] = '%' . $filter['search'] . '%';
                $bindTypes .= 's';
            }
        }

        if($filter['tipo_embarcacao']) {
            $where .= " AND brecho_itens.tipo_embarcacao_cprod = ?";
            $bind[] = $filter['tipo_embarcacao'];
            $bindTypes .= 'i';
        }

        if($filter['exibir_vendidos'] == 'nao_exibir_vendidos') {
            $where .= " AND brecho_itens.data_venda is null ";
        }

        $query .= $where;
        // fim where

        if($filter['order']) {
            $query .= " ORDER BY {$filter['order']}";
        }

        if($filter['limit']) {
            $query .= " LIMIT {$filter['limit']}";
        }

        if($filter['page']) {
            $offset = ($filter['page'] - 1) * $filter['limit'];
            $query .= " OFFSET $offset";
        }

		config('database');
		$config = DatabaseConfig::${'default'};
        $mysqli = new mysqli($config['host'], $config['login'], $config['password'], $config['database']);

        if($mysqli->connect_error) {
            die('Database error: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');
        $mysqli->query("SET time_zone = '-3:00'");
        $stmt = $mysqli->prepare($query);
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        if(sizeof($bind) > 0) {
            $stmt->bind_param($bindTypes, ...$bind);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $arr = [];
        while($row = $res->fetch_object()) {
            $arr[] = $row;
        }
        $stmt->close();

        $query = "SELECT COUNT(id) as count FROM brecho_itens LEFT JOIN eprod ON (eprod.cprod = brecho_itens.tipo_embarcacao_cprod) $where";
        $stmt = $mysqli->prepare($query);
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        if(sizeof($bind) > 0) {
            $stmt->bind_param($bindTypes, ...$bind);
        }
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $mysqli->close();

        $tiposEmbarcacoes = array_merge([['cprod' => -1, 'nprod' => 'Todas']], Produto::findByCscat(1, 'all', ['order' => 'eprod.nprod ASC']));

        $this->view->set('brechoItens', $arr);
        $this->view->set('tiposEmbarcacoes', $tiposEmbarcacoes);
        $this->view->set('count', $count);
    }

    public function create() {
        if($this->request->method === 'POST') {
            $brechoItem = new BrechoItem();
            $brechoItem->fill($_POST);
            $saved = BrechoItem::save($brechoItem);
            if(!$saved) {
                $this->view->set('error', 'Ocorreu um erro ao salvar os dados. Tente novamente.');
            }
            else {
                Session::write('success', 'Equipamento inserido com sucesso.');
                return $this->redirect('/brecho');
            }
        }

        $tipos_embarcacoes = array_merge([['cprod' => -1, 'nprod' => 'Todas']], Produto::findByCscat(1, 'all', ['order' => 'eprod.nprod ASC']));

        $this->view->set('tipos_embarcacoes', $tipos_embarcacoes);
    }

    public function edit($id) {
        $brechoItem = BrechoItem::find($id);

        if(!$brechoItem) {
            Session::write('error', 'Este produto não existe.');
            return $this->redirect('/brecho');
        }

        if($this->request->method === 'POST') {
            $brechoItem->fill($_POST);
            if(!BrechoItem::save($brechoItem)) {
                $this->view->set('error', 'Ocorreu um erro ao salvar os dados. Tente novamente.');
            }
            else {
                Session::write('success', 'Equipamento editado com sucesso.');
                return $this->redirect('/brecho/show/' . $id);
            }
        }

        $tipos_embarcacoes = array_merge([['cprod' => -1, 'nprod' => 'Todas']], Produto::findByCscat(1, 'all', ['order' => 'eprod.nprod ASC']));

        $this->view->set('brechoItem', $brechoItem);
        $this->view->set('tipos_embarcacoes', $tipos_embarcacoes);
    }

    public function show($id) {
        $brechoItem = BrechoItem::find($id);

        if(!$brechoItem) {
            Session::write('error', 'Este produto não existe.');
            return $this->redirect('/brecho');
        }

        $this->view->set('brechoItem', $brechoItem);
    }

    public function baixa($id) {
        $brechoItem = BrechoItem::find($id);

        if(!$brechoItem) {
            Session::write('error', 'Este produto não existe.');
            return $this->redirect('/brecho');
        }

        $brechoItem->data_venda = date('Y-m-d');
        BrechoItem::save($brechoItem);

        return $this->redirect('/brecho/show/' . $id);
    }

    public function destroy($id) {
        $brechoItem = BrechoItem::find($id);

        if(!$brechoItem) {
            Session::write('error', 'Este produto não existe.');
            return $this->redirect('/brecho');
        }

        BrechoItem::delete($brechoItem);
        
        Session::write('success', 'Produto removido!');
        return $this->redirect('/brecho');
    }

}