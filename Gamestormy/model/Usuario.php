<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private \PDO $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE id_usuario = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByEmail(string $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function getByNickname(string $nickname) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE nickname = ? LIMIT 1");
        $stmt->execute([$nickname]);
        return $stmt->fetch();
    }

    public function create(string $nome, string $nickname, string $email, string $senha, string $data_nascimento) {
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO Usuarios (nome_usuario, nickname, email, senha, data_nascimento) VALUES (?,?,?,?,?)");
        $stmt->execute([$nome, $nickname, $email, $hash, $data_nascimento]);
        return $this->pdo->lastInsertId();
    }

    public function update(int $id, string $nome, string $nickname, string $email, string $data_nascimento, $foto_perfil = null) {
        if ($foto_perfil) {
            $stmt = $this->pdo->prepare("UPDATE Usuarios SET nome_usuario=?, nickname=?, email=?, data_nascimento=?, foto_perfil=? WHERE id_usuario=?");
            $stmt->execute([$nome, $nickname, $email, $data_nascimento, $foto_perfil, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE Usuarios SET nome_usuario=?, nickname=?, email=?, data_nascimento=? WHERE id_usuario=?");
            $stmt->execute([$nome, $nickname, $email, $data_nascimento, $id]);
        }
        return true;
    }

    public function updateSenha(int $id, string $novaSenha) {
        $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE Usuarios SET senha=? WHERE id_usuario=?");
        $stmt->execute([$hash, $id]);
        return true;
    }

    public function isAdmin(int $id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM Administradores WHERE id_usuario = ? AND ativo = 1 LIMIT 1");
        $stmt->execute([$id_usuario]);
        return $stmt->fetch();
    }
}
?>
