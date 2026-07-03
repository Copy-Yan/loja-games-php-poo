<?php
class SobreController {
    public function index() {
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/sobre.php';
    }
}
?>
