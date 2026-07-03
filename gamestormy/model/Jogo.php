<?php
require_once __DIR__ . '/../config/database.php';

class Jogo {
    private \PDO $pdo;
    public function __construct() { $this->pdo = getDB(); }

    public function getAll(int $limit = 50) {
        $stmt = $this->pdo->query("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora ORDER BY j.data_lancamento DESC LIMIT $limit");
        return $stmt->fetchAll();
    }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora WHERE j.id_jogo = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function search(string $q) {
        $q = "%$q%";
        $stmt = $this->pdo->prepare("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora WHERE j.titulo LIKE ? OR j.descricao LIKE ? OR d.nome LIKE ? ORDER BY j.titulo LIMIT 30");
        $stmt->execute([$q, $q, $q]);
        return $stmt->fetchAll();
    }

    public function getDestaques() {
        $stmt = $this->pdo->query("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora WHERE j.tag IN ('Oferta da semana','Novo lançamento','Promoção') ORDER BY j.id_jogo LIMIT 6");
        return $stmt->fetchAll();
    }

    public function getNovosLancamentos($limit = 10) {
        $stmt = $this->pdo->query("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora ORDER BY j.data_lancamento DESC LIMIT $limit");
        return $stmt->fetchAll();
    }

    public function getByCategoria(int $id_categoria, int $limit = 10) {
        $stmt = $this->pdo->prepare("SELECT j.*, d.nome AS desenvolvedora, p.nome AS publicadora FROM Jogos j JOIN Desenvolvedoras d ON j.id_desenvolvedora = d.id_desenvolvedora JOIN Publicadoras p ON j.id_publicadora = p.id_publicadora JOIN Jogos_categorias jc ON j.id_jogo = jc.id_jogo WHERE jc.id_categoria = ? ORDER BY j.titulo LIMIT $limit");
        $stmt->execute([$id_categoria]);
        return $stmt->fetchAll();
    }

    public function getCategoriasDoJogo(int $id_jogo) {
        $stmt = $this->pdo->prepare("SELECT c.nome FROM Categorias c JOIN Jogos_categorias jc ON c.id_categoria = jc.id_categoria WHERE jc.id_jogo = ?");
        $stmt->execute([$id_jogo]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getPlataformasDoJogo(int $id_jogo) {
        $stmt = $this->pdo->prepare("SELECT pl.nome FROM Plataformas pl JOIN Jogos_plataformas jp ON pl.id_plataforma = jp.id_plataforma WHERE jp.id_jogo = ?");
        $stmt->execute([$id_jogo]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
?>
