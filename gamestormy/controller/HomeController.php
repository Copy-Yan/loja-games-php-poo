<?php
require_once __DIR__ . '/../model/Jogo.php';
require_once __DIR__ . '/../model/Categoria.php';

class HomeController {
    public function index() {
        $jogoModel = new Jogo();
        $catModel = new Categoria();

        $destaques = $jogoModel->getDestaques();
        $novos = $jogoModel->getNovosLancamentos(10);
        $todos = $jogoModel->getAll(20);
        $categorias = $catModel->getAll();

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/home.php';
    }
}
?>
