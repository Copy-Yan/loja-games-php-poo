<?php
require_once __DIR__ . '/../config/database.php';

class Categoria {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Categorias ORDER BY nome ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Categorias WHERE id_categoria = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>