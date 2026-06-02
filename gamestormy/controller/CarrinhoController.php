<?php
require_once __DIR__ . '/../model/Jogo.php';
require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../model/Biblioteca.php';

class CarrinhoController {
    public function index() {
        $carrinho = getCarrinho();
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/carrinho.php';
    }

    public function add() {
        $id = intval($_POST['id_jogo'] ?? 0);
        if ($id) {
            $j = new Jogo();
            $jogo = $j->getById($id);
            if ($jogo) addCarrinho($jogo);
        }
        $redirect = $_POST['redirect'] ?? '?page=carrinho';
        header("Location: " . base_url($redirect));
        exit;
    }

    public function remove() {
        $id = intval($_GET['id'] ?? 0);
        if ($id) removeCarrinho($id);
        redirect('?page=carrinho');
    }

    public function updateQty() {
        $id = intval($_POST['id_jogo'] ?? 0);
        $qty = intval($_POST['qty'] ?? 1);
        $cart = getCarrinho();
        if (isset($cart[$id])) {
            if ($qty < 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            $_SESSION['carrinho'] = $cart;
        }
        redirect('?page=carrinho');
    }

    public function payment() {
        if (!authCheck()) redirect('?page=login');
        $carrinho = getCarrinho();
        if (empty($carrinho)) redirect('?page=carrinho');
        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/payment.php';
    }

    public function checkout() {
        if (!authCheck()) redirect('?page=login');
        $carrinho = getCarrinho();
        if (empty($carrinho)) redirect('?page=carrinho');

        $erro = '';
        $success = false;
        $pedidoId = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodo = $_POST['metodo'] ?? 'pix';
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $total = totalCarrinho();

            if (!$nome || !$email) {
                $erro = 'Preencha nome e e-mail para continuar.';
            } else {
                $pedido = new Pedido();
                $id_pedido = $pedido->create($_SESSION['usuario_id'], $total);

                foreach ($carrinho as $item) {
                    $pedido->addItem($id_pedido, $item['id_jogo'], $item['preco']);
                    $bib = new Biblioteca();
                    $bib->add($_SESSION['usuario_id'], $item['id_jogo']);
                }

                $pedido->createPagamento($id_pedido, $metodo);
                clearCarrinho();
                $success = true;
                $pedidoId = $id_pedido;
            }
        }

        $usuario = getUsuarioLogado();
        require __DIR__ . '/../view/confirmation.php';
    }
}
?>