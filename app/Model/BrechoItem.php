<?php

App::import('Connection', 'Model');
App::import('Pessoa', 'Model');

class BrechoItem {
    function __construct() {}

    function fill($data = []) {
        $this->id = $data['id'] ?? $this->id ?? null;
        $this->cod_referencia = $data['cod_referencia'] ?? null;
        $this->tipo_embarcacao_cprod = $data['tipo_embarcacao_cprod'] ?? null;
        $this->nome = $data['nome'] ?? null;
        $this->marca = $data['marca'] ?? null;
        $this->modelo = $data['modelo'] ?? null;
        $this->tamanho = $data['tamanho'] ?? null;
        $this->cor = $data['cor'] ?? null;
        $this->estado = $data['estado'] ?? null;
        $this->valor = $data['valor'] ?? null;
        $this->setDataVenda($data['data_venda'] ?? null);
        $this->observacao = $data['observacao'] ?? null;
    }

    function setDataVenda($data_venda) {
        if($data_venda && !empty($data_venda)) {
            $this->data_venda = $data_venda;
        }
        else {
            $this->data_venda = null;
        }
    }

    function vendido() {
        return $this->data_venda != null;;
    }

    static function find($id) {
        $mysqli = new mysqli('localhost', 'root', '', 'pn');

        if($mysqli->connect_error) {
            die('Database error: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');
        $mysqli->query("SET time_zone = '-3:00'");

        $stmt = $mysqli->prepare("SELECT brecho_itens.*, eprod.* FROM brecho_itens LEFT JOIN eprod ON (eprod.cprod = brecho_itens.tipo_embarcacao_cprod) WHERE brecho_itens.id = ? LIMIT 1");
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $obj = null;
        while($row = $res->fetch_object('BrechoItem')) {
            $obj = $row;
        }
        $stmt->close();
        $mysqli->close();

        return $obj;
    }

    static function save($brechoItem) {
        if(!$brechoItem->id) {
            return static::insert($brechoItem);
        }
        return static::edit($brechoItem);
    }

    static function insert($brechoItem) {
        $mysqli = new mysqli('localhost', 'root', '', 'pn');

        if($mysqli->connect_error) {
            die('Database error: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');
        $mysqli->query("SET time_zone = '-3:00'");

        $stmt = $mysqli->prepare("INSERT INTO brecho_itens (cod_referencia, tipo_embarcacao_cprod, nome, marca, modelo, tamanho, cor, estado, valor, data_venda, observacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        $stmt->bind_param('sssssssssss', $brechoItem->cod_referencia, $brechoItem->tipo_embarcacao_cprod, $brechoItem->nome, $brechoItem->marca, $brechoItem->modelo, $brechoItem->tamanho, $brechoItem->cor, $brechoItem->estado, $brechoItem->valor, $brechoItem->data_venda, $brechoItem->observacao);
        $stmt->execute();
        if($stmt->error) {
            die('Database error: ' . $stmt->error);
        }
        $success = $stmt->affected_rows > 0;
        $brechoItem->id = $stmt->insert_id;
        $stmt->close();
        $mysqli->close();

        return $success;
    }

    static function edit($brechoItem) {
        $mysqli = new mysqli('localhost', 'root', '', 'pn');

        if($mysqli->connect_error) {
            die('Database error: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');
        $mysqli->query("SET time_zone = '-3:00'");

        $stmt = $mysqli->prepare("UPDATE brecho_itens SET cod_referencia = ?, tipo_embarcacao_cprod = ?, nome = ?, marca = ?, modelo = ?, tamanho = ?, cor = ?, estado = ?, valor = ?, data_venda = ?, observacao = ? WHERE id = ?");
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        $stmt->bind_param('sssssssssssi', $brechoItem->cod_referencia, $brechoItem->tipo_embarcacao_cprod, $brechoItem->nome, $brechoItem->marca, $brechoItem->modelo, $brechoItem->tamanho, $brechoItem->cor, $brechoItem->estado, $brechoItem->valor, $brechoItem->data_venda, $brechoItem->observacao, $brechoItem->id);
        $stmt->execute();
        if($stmt->error) {
            die('Database error: ' . $stmt->error);
        }
        $stmt->close();
        $mysqli->close();
        
        return true;
    }

    static function delete($brechoItem) {
        $mysqli = new mysqli('localhost', 'root', '', 'pn');

        if($mysqli->connect_error) {
            die('Database error: ' . $mysqli->connect_error);
        }

        $mysqli->set_charset('utf8mb4');
        $mysqli->query("SET time_zone = '-3:00'");

        $stmt = $mysqli->prepare("DELETE FROM brecho_itens WHERE id = ?");
        if(!$stmt) {
            die('Database error: ' . $mysqli->error);
        }
        $stmt->bind_param('i', $brechoItem->id);
        $stmt->execute();
        if($stmt->error) {
            die('Database error: ' . $stmt->error);
        }
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        $mysqli->close();

        return $success;
    }
}