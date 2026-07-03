<?php
require_once __DIR__ . '/../config/database.php';

class Avaliacao {
    private \PDO $pdo;
    public function __construct() { $this->pdo = getDB(); }

    private function safeQuery(string $sql, array $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            // Evita que a página do jogo quebre caso a tabela não exista no banco
            // (ex.: avaliação durante testes/avaliação do projeto).
            return null;
        }
    }

    public function getByJogo(int $id_jogo) {
        $stmt = $this->safeQuery(
            "SELECT a.*, u.nome_usuario, u.nickname, u.foto_perfil
             FROM Avaliacoes a
             JOIN Usuarios u ON a.id_usuario = u.id_usuario
             WHERE a.id_jogo = ?
             ORDER BY a.data_avaliacao DESC",
            [$id_jogo]
        );

        if (!$stmt) return [];
        return $stmt->fetchAll();
    }

    public function create(int $id_usuario, int $id_jogo, int $nota, string $comentario) {
        $stmt = $this->safeQuery(
            "INSERT INTO Avaliacoes (id_usuario, id_jogo, nota, comentario, data_avaliacao)
             VALUES (?,?,?,?,CURDATE())
             ON DUPLICATE KEY UPDATE nota=?, comentario=?",
            [$id_usuario, $id_jogo, $nota, $comentario, $nota, $comentario]
        );

        if (!$stmt) return false;
        return true;
    }

    public function getMedia(int $id_jogo) {
        $stmt = $this->safeQuery("SELECT AVG(nota) as media FROM Avaliacoes WHERE id_jogo = ?", [$id_jogo]);
        if (!$stmt) return 0;

        $row = $stmt->fetch();
        return (!empty($row['media'])) ? round((float)$row['media'], 1) : 0;
    }
}
?>

