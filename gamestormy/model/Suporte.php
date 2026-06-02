<?php
require_once __DIR__ . '/../config/database.php';

class Suporte {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function create($id_usuario, $assunto, $descricao, $categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO Suporte (id_usuario, assunto, descricao, categoria, status) VALUES (?,?,?,?,'Aberto')");
        $stmt->execute([$id_usuario, $assunto, $descricao, $categoria]);
        return $this->pdo->lastInsertId();
    }

    public function getByUsuario($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM Suporte WHERE id_usuario = ? ORDER BY data_abertura DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll();
    }
}
?>
