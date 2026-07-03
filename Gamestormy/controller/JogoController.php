<?php
require_once __DIR__ . '/../model/Jogo.php';
require_once __DIR__ . '/../model/Avaliacao.php';
require_once __DIR__ . '/../model/Biblioteca.php';

class JogoController {
    public function index() {
        $id = intval($_GET['id'] ?? 0);
        if (!$id) redirect('');

        $jogoModel = new Jogo();
        $jogo = $jogoModel->getById($id);
        if (!$jogo) redirect('');

        $avaliacaoModel = new Avaliacao();
        $avaliacoes = $avaliacaoModel->getByJogo($id);
        $media = $avaliacaoModel->getMedia($id);
        $categorias = $jogoModel->getCategoriasDoJogo($id);
        $plataformas = $jogoModel->getPlataformasDoJogo($id);

        $usuario = getUsuarioLogado();
        $possui = false;
        if ($usuario) {
            $bib = new Biblioteca();
            $possui = $bib->possuiJogo($usuario['id_usuario'], $id);
        }

        require __DIR__ . '/../view/jogo.php';
    }

    public function avaliar() {
        if (!authCheck()) redirect('?page=login');
        $id_jogo = intval($_POST['id_jogo'] ?? 0);
        $nota = intval($_POST['nota'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? '');

        if ($id_jogo && $nota >= 0 && $nota <= 5 && $comentario) {
            $ava = new Avaliacao();
            $ava->create($_SESSION['usuario_id'], $id_jogo, $nota, $comentario);
            setFlash('success', 'Avaliação enviada com sucesso!');
        } else {
            setFlash('error', 'Preencha todos os campos da avaliação.');
        }
        redirect("?page=jogo&id=$id_jogo");
    }
}
?>
