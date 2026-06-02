<?php
require_once __DIR__ . '/../config/database.php';

class Biblioteca {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getByUsuario($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT b.*, j.titulo, j.preco, j.capa, j.tag, j.nota, d.nome AS desenvolvedora FROM Biblioteca b JOIN Jogos j ON b.id_jogo = j.id_jogo JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora WHERE b.id_usuario = ? ORDER BY b.data_compra DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll();
    }

    public function add($id_usuario, $id_jogo) {
        // Verificar se já existe
        $check = $this->pdo->prepare("SELECT 1 FROM Biblioteca WHERE id_usuario = ? AND id_jogo = ?");
        $check->execute([$id_usuario, $id_jogo]);
        if ($check->fetch()) {
            return true; // Já existe, não insere duplicado
        }
        $stmt = $this->pdo->prepare("INSERT INTO Biblioteca (id_usuario, id_jogo, data_compra) VALUES (?, ?, CURDATE())");
        $stmt->execute([$id_usuario, $id_jogo]);
        return true;
    }

    public function possuiJogo($id_usuario, $id_jogo) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM Biblioteca WHERE id_usuario = ? AND id_jogo = ? LIMIT 1");
        $stmt->execute([$id_usuario, $id_jogo]);
        return $stmt->fetch() ? true : false;
    }

    public function remove($id_usuario, $id_jogo) {
        $stmt = $this->pdo->prepare("DELETE FROM Biblioteca WHERE id_usuario = ? AND id_jogo = ?");
        $stmt->execute([$id_usuario, $id_jogo]);
        return true;
    }
}
?>