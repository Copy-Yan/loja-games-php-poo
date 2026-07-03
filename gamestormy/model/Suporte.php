<?php
require_once __DIR__ . '/../config/database.php';

class Suporte {
    private \PDO $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function create(int $id_usuario, string $assunto, string $descricao, string $categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO Suporte (id_usuario, assunto, descricao, categoria, status) VALUES (?,?,?,?,'Aberto')");
        $stmt->execute([$id_usuario, $assunto, $descricao, $categoria]);
        return $this->pdo->lastInsertId();
    }

    public function getByUsuario(int $id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM Suporte WHERE id_usuario = ? ORDER BY data_abertura DESC");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll();
    }
}
?>
