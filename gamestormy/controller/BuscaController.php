<?php
require_once __DIR__ . '/../model/Jogo.php';

class BuscaController {
    public function index() {
        $q = trim($_GET['q'] ?? '');
        $resultados = [];
        if ($q !== '') {
            $jogoModel = new Jogo();
            $resultados = $jogoModel->search($q);
        }
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/busca.php';
    }
}
?>
