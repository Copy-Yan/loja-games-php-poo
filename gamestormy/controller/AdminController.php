<?php
require_once __DIR__ . '/../model/Jogo.php';
require_once __DIR__ . '/../model/Categoria.php';
require_once __DIR__ . '/../model/Usuario.php';

class AdminController {

    private function checkAdmin() {
        if (!authCheck()) redirect('?page=login');
        $u = new Usuario();
        $admin = $u->isAdmin($_SESSION['usuario_id']);
        if (!$admin) {
            setFlash('error', 'Acesso restrito a administradores.');
            redirect('');
        }
        return $admin;
    }

    public function index() {
        $this->checkAdmin();
        $jogoModel = new Jogo();
        $jogos = $jogoModel->getAll(100);
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/dashboard.php';
    }

    public function jogos() {
        $this->checkAdmin();
        $jogoModel = new Jogo();
        $jogos = $jogoModel->getAll(100);
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/jogos.php';
    }

    public function addJogo() {
        $this->checkAdmin();
        $erro = '';
        $success = '';
        $catModel = new Categoria();
        $categorias = $catModel->getAll();

        // Buscar desenvolvedoras e publicadoras do banco
        $pdo = getDB();
        $devs = $pdo->query("SELECT * FROM Desenvolvedoras ORDER BY nome")->fetchAll();
        $pubs = $pdo->query("SELECT * FROM Publicadoras ORDER BY nome")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $preco = floatval(str_replace(',', '.', $_POST['preco'] ?? 0));
            $data_lancamento = $_POST['data_lancamento'] ?? '';
            $classificacao = $_POST['classificacao_etaria'] ?? 'L';
            $tamanho = floatval($_POST['tamanho_download'] ?? 0);
            $req_min = trim($_POST['requisitos_minimos'] ?? '');
            $req_rec = trim($_POST['requisitos_recomendados'] ?? '');
            $id_desenvolvedora = intval($_POST['id_desenvolvedora'] ?? 0);
            $id_publicadora = intval($_POST['id_publicadora'] ?? 0);
            $tag = trim($_POST['tag'] ?? 'Jogo');
            $nota = floatval($_POST['nota'] ?? 0);
            $categorias_sel = $_POST['categorias'] ?? [];

            // Validar desenvolvedora e publicadora
            $devExiste = $pdo->prepare("SELECT 1 FROM Desenvolvedoras WHERE id_desenvolvedora = ?");
            $devExiste->execute([$id_desenvolvedora]);
            $pubExiste = $pdo->prepare("SELECT 1 FROM Publicadoras WHERE id_publicadora = ?");
            $pubExiste->execute([$id_publicadora]);

            if (!$titulo || !$descricao || !$data_lancamento) {
                $erro = 'Preencha todos os campos obrigatórios (título, descrição, data de lançamento).';
            } elseif ($id_desenvolvedora <= 0 || !$devExiste->fetch()) {
                $erro = 'Selecione uma desenvolvedora válida. Se não houver, cadastre uma primeiro no phpMyAdmin.';
            } elseif ($id_publicadora <= 0 || !$pubExiste->fetch()) {
                $erro = 'Selecione uma publicadora válida. Se não houver, cadastre uma primeiro no phpMyAdmin.';
            } else {
                // Upload da capa
                $capa = '#3d3d3d';
                if (!empty($_FILES['capa']['tmp_name']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));
                    $permitidas = ['jpg','jpeg','png','gif','webp'];
                    if (in_array($ext, $permitidas)) {
                        $uploadDir = __DIR__ . '/../assets/uploads/capas/';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                        $nomeArquivo = 'capa_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                        $destino = $uploadDir . $nomeArquivo;
                        if (move_uploaded_file($_FILES['capa']['tmp_name'], $destino)) {
                            $capa = 'assets/uploads/capas/' . $nomeArquivo;
                        }
                    }
                }

                $stmt = $pdo->prepare("INSERT INTO Jogos (id_desenvolvedora, id_publicadora, titulo, descricao, preco, data_lancamento, classificacao_etaria, tamanho_download, requisitos_minimos, requisitos_recomendados, capa, tag, nota) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$id_desenvolvedora, $id_publicadora, $titulo, $descricao, $preco, $data_lancamento, $classificacao, $tamanho, $req_min, $req_rec, $capa, $tag, $nota]);
                $id_jogo = $pdo->lastInsertId();

                // Inserir categorias
                foreach ($categorias_sel as $id_cat) {
                    $pdo->prepare("INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES (?,?)")->execute([$id_jogo, $id_cat]);
                }

                $success = 'Jogo "' . htmlspecialchars($titulo) . '" adicionado com sucesso! ID: ' . $id_jogo;
            }
        }

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/add_jogo.php';
    }

    public function deleteJogo() {
        $this->checkAdmin();
        $id = intval($_GET['id'] ?? 0);
        if ($id) {
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT capa FROM Jogos WHERE id_jogo = ?");
            $stmt->execute([$id]);
            $jogo = $stmt->fetch();
            if ($jogo && !empty($jogo['capa']) && strpos($jogo['capa'], 'assets/') === 0) {
                $path = __DIR__ . '/../' . $jogo['capa'];
                if (file_exists($path)) unlink($path);
            }
            $pdo->prepare("DELETE FROM Jogos WHERE id_jogo = ?")->execute([$id]);
            setFlash('success', 'Jogo removido.');
        }
        redirect('?page=admin&action=jogos');
    }
}
?>