<?php
require_once __DIR__ . '/../model/Biblioteca.php';
require_once __DIR__ . '/../model/Jogo.php';

class BibliotecaController {
    public function index() {
        if (!authCheck()) redirect('?page=login');
        $bib = new Biblioteca();
        $jogos = $bib->getByUsuario($_SESSION['usuario_id']);
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/biblioteca.php';
    }

    public function addDirect() {
        if (!authCheck()) redirect('?page=login');
        $id_jogo = intval($_POST['id_jogo'] ?? 0);
        if ($id_jogo) {
            $bib = new Biblioteca();
            $bib->add($_SESSION['usuario_id'], $id_jogo);
            setFlash('success', 'Jogo adicionado à biblioteca!');
        }
        redirect('?page=biblioteca');
    }

    public function remove() {
        if (!authCheck()) redirect('?page=login');
        $id_jogo = intval($_GET['id'] ?? 0);
        if ($id_jogo) {
            $bib = new Biblioteca();
            $bib->remove($_SESSION['usuario_id'], $id_jogo);
        }
        redirect('?page=biblioteca');
    }
}
?>
