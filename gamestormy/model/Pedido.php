<?php
require_once __DIR__ . '/../config/database.php';

class Pedido {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function create($id_usuario, $valor_total) {
        $stmt = $this->pdo->prepare("INSERT INTO Pedidos (id_usuario, data_pedido, valor_total, status) VALUES (?, CURDATE(), ?, 'pago')");
        $stmt->execute([$id_usuario, $valor_total]);
        return $this->pdo->lastInsertId();
    }

    public function addItem($id_pedido, $id_jogo, $preco_unitario) {
        $stmt = $this->pdo->prepare("INSERT INTO Pedido_itens (id_pedido, id_jogo, preco_unitario) VALUES (?,?,?)");
        $stmt->execute([$id_pedido, $id_jogo, $preco_unitario]);
    }

    public function createPagamento($id_pedido, $metodo) {
        $stmt = $this->pdo->prepare("INSERT INTO Pagamentos (id_pedido, data_pagamento, metodo, status) VALUES (?, CURDATE(), ?, 'aprovado')");
        $stmt->execute([$id_pedido, $metodo]);
    }

    public function getById($id_pedido) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.nome_usuario, u.email FROM Pedidos p JOIN Usuarios u ON p.id_usuario = u.id_usuario WHERE p.id_pedido = ?");
        $stmt->execute([$id_pedido]);
        return $stmt->fetch();
    }

    public function getItens($id_pedido) {
        $stmt = $this->pdo->prepare("SELECT pi.*, j.titulo, j.capa FROM Pedido_itens pi JOIN Jogos j ON pi.id_jogo = j.id_jogo WHERE pi.id_pedido = ?");
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll();
    }

    public function getByUsuario($id_usuario, $limit = 10) {
        $stmt = $this->pdo->prepare("SELECT * FROM Pedidos WHERE id_usuario = ? ORDER BY data_pedido DESC LIMIT $limit");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll();
    }
}
?>
