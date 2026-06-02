<?php
require_once __DIR__ . '/../config/database.php';

class Avaliacao {
    private $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getByJogo($id_jogo) {
        $stmt = $this->pdo->prepare("SELECT a.*, u.nome_usuario, u.nickname, u.foto_perfil FROM Avaliacoes a JOIN Usuarios u ON a.id_usuario = u.id_usuario WHERE a.id_jogo = ? ORDER BY a.data_avaliacao DESC");
        $stmt->execute([$id_jogo]);
        return $stmt->fetchAll();
    }

    public function create($id_usuario, $id_jogo, $nota, $comentario) {
        $stmt = $this->pdo->prepare("INSERT INTO Avaliacoes (id_usuario, id_jogo, nota, comentario, data_avaliacao) VALUES (?,?,?,?,CURDATE()) ON DUPLICATE KEY UPDATE nota=?, comentario=?");
        $stmt->execute([$id_usuario, $id_jogo, $nota, $comentario, $nota, $comentario]);
        return true;
    }

    public function getMedia($id_jogo) {
        $stmt = $this->pdo->prepare("SELECT AVG(nota) as media FROM Avaliacoes WHERE id_jogo = ?");
        $stmt->execute([$id_jogo]);
        $row = $stmt->fetch();
        return $row['media'] ? round($row['media'], 1) : 0;
    }
}
?>
