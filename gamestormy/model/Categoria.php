<?php
require_once __DIR__ . '/../config/database.php';

class Categoria {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Categorias ORDER BY nome");
        return $stmt->fetchAll();
    }
}
?>
