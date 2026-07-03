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

        $pdo = getDB();
        $devs = $pdo->query("SELECT * FROM Desenvolvedoras ORDER BY nome")->fetchAll();
        $pubs = $pdo->query("SELECT * FROM Publicadoras ORDER BY nome")->fetchAll();


        $desenvolvedoras = $devs;
        $publicadoras = $pubs;


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

             
                foreach ($categorias_sel as $id_cat) {
                    $pdo->prepare("INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES (?,?)")->execute([$id_jogo, $id_cat]);
                }

                $success = 'Jogo "' . htmlspecialchars($titulo) . '" adicionado com sucesso! ID: ' . $id_jogo;
            }
        }

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/add_jogo.php';
    }

    public function editJogo() {
        $this->checkAdmin();

        $erro = '';
        $success = '';

        $id = intval($_GET['id'] ?? 0);
        if (!$id) {
            setFlash('error', 'ID inválido para edição.');
            redirect('?page=admin&action=jogos');
        }

        $jogoModel = new Jogo();
        $jogo = $jogoModel->getById($id);
        if (!$jogo) {
            setFlash('error', 'Jogo não encontrado.');
            redirect('?page=admin&action=jogos');
        }

        $pdo = getDB();

       
        $categoriasModel = new Categoria();
        $categorias = $categoriasModel->getAll();

        $plataformas = $pdo->query("SELECT * FROM Plataformas ORDER BY nome")->fetchAll();
        $devs = $pdo->query("SELECT * FROM Desenvolvedoras ORDER BY nome")->fetchAll();
        $pubs = $pdo->query("SELECT * FROM Publicadoras ORDER BY nome")->fetchAll();

       
        $catsAtuais = [];
        $stmtCats = $pdo->prepare("SELECT id_categoria FROM Jogos_categorias WHERE id_jogo = ?");
        $stmtCats->execute([$id]);
        $catsAtuais = array_map(fn($r) => intval($r['id_categoria']), $stmtCats->fetchAll());

        $platsAtuais = [];
        $stmtPlats = $pdo->prepare("SELECT id_plataforma FROM Jogos_plataformas WHERE id_jogo = ?");
        $stmtPlats->execute([$id]);
        $platsAtuais = array_map(fn($r) => intval($r['id_plataforma']), $stmtPlats->fetchAll());

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
            $plataformas_sel = $_POST['plataformas'] ?? [];

            if (!$titulo || !$descricao || !$data_lancamento) {
                $erro = 'Preencha todos os campos obrigatórios (título, descrição, data de lançamento).';
            } else {
             
                $devExiste = $pdo->prepare("SELECT 1 FROM Desenvolvedoras WHERE id_desenvolvedora = ?");
                $devExiste->execute([$id_desenvolvedora]);
                $pubExiste = $pdo->prepare("SELECT 1 FROM Publicadoras WHERE id_publicadora = ?");
                $pubExiste->execute([$id_publicadora]);

                if ($id_desenvolvedora <= 0 || !$devExiste->fetch()) {
                    $erro = 'Selecione uma desenvolvedora válida.';
                } elseif ($id_publicadora <= 0 || !$pubExiste->fetch()) {
                    $erro = 'Selecione uma publicadora válida.';
                } else {
                   
                    $capaAtual = trim((string)($jogo['capa'] ?? ''));
                    $capa = $capaAtual;

                    if (!empty($_FILES['capa']['tmp_name']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION));
                        $permitidas = ['jpg','jpeg','png','gif','webp'];
                        if (in_array($ext, $permitidas)) {
                            $uploadDir = __DIR__ . '/../assets/uploads/capas/';
                            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                           
                            if ($capaAtual && strpos($capaAtual, 'assets/') === 0) {
                                $path = __DIR__ . '/../' . $capaAtual;
                                if (file_exists($path)) @unlink($path);
                            }

                            $nomeArquivo = 'capa_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                            $destino = $uploadDir . $nomeArquivo;
                            if (move_uploaded_file($_FILES['capa']['tmp_name'], $destino)) {
                                $capa = 'assets/uploads/capas/' . $nomeArquivo;
                            }
                        }
                    }

                    $pdo->beginTransaction();
                    try {
                        $stmt = $pdo->prepare("UPDATE Jogos SET id_desenvolvedora = ?, id_publicadora = ?, titulo = ?, descricao = ?, preco = ?, data_lancamento = ?, classificacao_etaria = ?, tamanho_download = ?, requisitos_minimos = ?, requisitos_recomendados = ?, capa = ?, tag = ?, nota = ? WHERE id_jogo = ?");
                        $stmt->execute([
                            $id_desenvolvedora,
                            $id_publicadora,
                            $titulo,
                            $descricao,
                            $preco,
                            $data_lancamento,
                            $classificacao,
                            $tamanho,
                            $req_min,
                            $req_rec,
                            $capa,
                            $tag,
                            $nota,
                            $id
                        ]);

                        
                        $pdo->prepare("DELETE FROM Jogos_categorias WHERE id_jogo = ?")->execute([$id]);
                        foreach ($categorias_sel as $id_cat) {
                            $id_cat = intval($id_cat);
                            if ($id_cat > 0) {
                                $pdo->prepare("INSERT INTO Jogos_categorias (id_jogo, id_categoria) VALUES (?,?)")->execute([$id, $id_cat]);
                            }
                        }

                        // Atualizar plataformas
                        $pdo->prepare("DELETE FROM Jogos_plataformas WHERE id_jogo = ?")->execute([$id]);
                        foreach ($plataformas_sel as $id_plat) {
                            $id_plat = intval($id_plat);
                            if ($id_plat > 0) {
                                $pdo->prepare("INSERT INTO Jogos_plataformas (id_jogo, id_plataforma) VALUES (?,?)")->execute([$id, $id_plat]);
                            }
                        }

                        $pdo->commit();
                        setFlash('success', 'Jogo atualizado com sucesso!');
                        redirect('?page=admin&action=jogos');
                    } catch (\Throwable $e) {
                        $pdo->rollBack();
                        $erro = 'Falha ao atualizar jogo: ' . $e->getMessage();
                    }
                }
            }
        }

       
        $jogo = $jogoModel->getById($id);

        $usuario = getUsuarioLogado();

       
        $devsList = $devs;
        $pubsList = $pubs;

        $devs = $devsList;
        $pubs = $pubsList;

       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $catsAtuais = array_map('intval', $categorias_sel ?? []);
            $platsAtuais = array_map('intval', $plataformas_sel ?? []);

            $titulo = $titulo ?? null;
            $descricao = $descricao ?? null;
            $preco = $preco ?? null;
            $data_lancamento = $data_lancamento ?? null;
            $classificacao = $classificacao ?? null;
            $tamanho = $tamanho ?? null;
            $req_min = $req_min ?? null;
            $req_rec = $req_rec ?? null;
            $tag = $tag ?? null;
            $nota = $nota ?? null;
            $id_desenvolvedora = isset($id_desenvolvedora) ? $id_desenvolvedora : null;
            $id_publicadora = isset($id_publicadora) ? $id_publicadora : null;
            $capa = $capa ?? null;

            // Atualiza valores exibidos no formulário
            // (a view usa $jogo[...] para inputs)
            $jogo['titulo'] = $titulo !== null ? $titulo : ($jogo['titulo'] ?? '');
            $jogo['descricao'] = $descricao !== null ? $descricao : ($jogo['descricao'] ?? '');
            $jogo['preco'] = $preco !== null ? $preco : ($jogo['preco'] ?? 0);
            $jogo['data_lancamento'] = $data_lancamento !== null ? $data_lancamento : ($jogo['data_lancamento'] ?? '');
            $jogo['classificacao_etaria'] = $classificacao !== null ? $classificacao : ($jogo['classificacao_etaria'] ?? 'L');
            $jogo['tamanho_download'] = $tamanho !== null ? $tamanho : ($jogo['tamanho_download'] ?? 0);
            $jogo['requisitos_minimos'] = $req_min !== null ? $req_min : ($jogo['requisitos_minimos'] ?? '');
            $jogo['requisitos_recomendados'] = $req_rec !== null ? $req_rec : ($jogo['requisitos_recomendados'] ?? '');
            $jogo['tag'] = $tag !== null ? $tag : ($jogo['tag'] ?? 'Jogo');
            $jogo['nota'] = $nota !== null ? $nota : ($jogo['nota'] ?? 0);
            $jogo['id_desenvolvedora'] = ($id_desenvolvedora !== null && intval($id_desenvolvedora) > 0) ? intval($id_desenvolvedora) : ($jogo['id_desenvolvedora'] ?? 0);
            $jogo['id_publicadora'] = ($id_publicadora !== null && intval($id_publicadora) > 0) ? intval($id_publicadora) : ($jogo['id_publicadora'] ?? 0);

            // capa se houve upload, senão mantém a atual
            if (!empty($_FILES['capa']['tmp_name']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
                $jogo['capa'] = $capa !== null ? $capa : ($jogo['capa'] ?? '');
            }
        }

        require __DIR__ . '/../view/admin/edit_jogo.php';
    }

    public function deleteJogo() {
        $this->checkAdmin();
        $id = intval($_GET['id'] ?? 0);


        if ($id) {
            $pdo = getDB();

            // Buscar e remover capa do disco (se existir)
            $stmt = $pdo->prepare("SELECT capa FROM Jogos WHERE id_jogo = ?");
            $stmt->execute([$id]);
            $jogo = $stmt->fetch();
            if ($jogo && !empty($jogo['capa']) && strpos($jogo['capa'], 'assets/') === 0) {
                $path = __DIR__ . '/../' . $jogo['capa'];
                if (file_exists($path)) unlink($path);
            }

            // Deleção em transação para garantir consistência
            $pdo->beginTransaction();
            try {
                // Relações diretas do jogo (ordem de segurança: tabelas filhas antes)
                // Observação: se alguma tabela não existir no seu schema, removemos com fallback seguro.
                $queries = [
                    "DELETE FROM Jogos_categorias WHERE id_jogo = ?",
                    // Se existir no seu schema
                    "DELETE FROM Jogos_plataformas WHERE id_jogo = ?",
                    // Avaliações (nome da tabela conforme existente no projeto)
                    "DELETE FROM Avaliacoes WHERE id_jogo = ?",
                    // Biblioteca: remover do jogo para todos os usuários
                    "DELETE FROM Biblioteca WHERE id_jogo = ?",
                    // Itens de pedidos que referenciam o jogo
                    "DELETE FROM Pedido_itens WHERE id_jogo = ?",
                ];

                foreach ($queries as $sql) {
                    try {
                        $pdo->prepare($sql)->execute([$id]);
                    } catch (\PDOException $e) {
                        // Mantém o processo se a tabela não existir (ex.: variações do schema)
                        // e deixa seguir para tentar deletar o resto.
                    }
                }

                // Por fim, deletar o jogo
                $pdo->prepare("DELETE FROM Jogos WHERE id_jogo = ?")->execute([$id]);

                $pdo->commit();
                setFlash('success', 'Jogo removido com todos os dados relacionados.');
            } catch (\Throwable $e) {
                $pdo->rollBack();
                setFlash('error', 'Falha ao remover o jogo: ' . $e->getMessage());
            }
        }

        redirect('?page=admin&action=jogos');
    }
    public function addDesenvolvedora() {
        $this->checkAdmin();
        $erro = '';
        $success = '';

        $pdo = getDB();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $data_fundacao = $_POST['data_fundacao'] ?? '';
            $pais = trim($_POST['pais'] ?? '');

            if (!$nome || !$data_fundacao || !$pais) {
                $erro = 'Preencha nome, data de fundação e país.';
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO Desenvolvedoras (nome, data_fundacao, pais) VALUES (?,?,?)");
                    $stmt->execute([$nome, $data_fundacao, $pais]);
                    $id = $pdo->lastInsertId();
                    setFlash('success', 'Desenvolvedora adicionada com sucesso! ID: ' . htmlspecialchars((string)$id));
                    redirect('?page=admin&action=addJogo');
                } catch (\Throwable $e) {
                    $erro = 'Falha ao cadastrar desenvolvedora: ' . $e->getMessage();
                }
            }
        }

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/add_desenvolvedora.php';
    }

    public function addPublicadora() {
        $this->checkAdmin();
        $erro = '';
        $success = '';

        $pdo = getDB();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $pais = trim($_POST['pais'] ?? '');

            if (!$nome || !$pais) {
                $erro = 'Preencha nome e país.';
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO Publicadoras (nome, pais) VALUES (?,?)");
                    $stmt->execute([$nome, $pais]);
                    $id = $pdo->lastInsertId();
                    setFlash('success', 'Publicadora adicionada com sucesso! ID: ' . htmlspecialchars((string)$id));
                    redirect('?page=admin&action=addJogo');
                } catch (\Throwable $e) {
                    $erro = 'Falha ao cadastrar publicadora: ' . $e->getMessage();
                }
            }
        }

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/admin/add_publicadora.php';
    }
}
?>
