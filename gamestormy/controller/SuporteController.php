<?php
require_once __DIR__ . '/../model/Suporte.php';

class SuporteController {
    public function index() {
        $usuario = getUsuarioLogado();
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuario) {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $assunto = trim($_POST['assunto'] ?? '');
            $categoria = $_POST['categoria'] ?? 'Produto';
            $mensagem = trim($_POST['mensagem'] ?? '');

            if ($nome && $email && $assunto && $mensagem) {
                $s = new Suporte();
                $s->create($usuario['id_usuario'], $assunto, $mensagem, $categoria);
                $success = true;
            }
        }
        $tickets = [];
        if ($usuario) {
            $s = new Suporte();
            $tickets = $s->getByUsuario($usuario['id_usuario']);
        }
        require __DIR__ . '/../view/suporte.php';
    }
}
?>
