<?php
require_once __DIR__ . '/../model/Jogo.php';
require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../model/Biblioteca.php';

class PagamentoController {

    public function index() {
        redirect('?page=carrinho');
    }

    public function carrinho() {
        $carrinho = getCarrinho();
        $usuario = getUsuarioLogado();

        // Se tentar ir ao pagamento sem login
        if (!authCheck() && !empty($carrinho)) {
            setFlash('error', 'Faça login para finalizar a compra.');
        }

        require __DIR__ . '/../view/pagamento/carrinho.php';
    }

    public function checkout() {
        if (!authCheck()) {
            setFlash('error', 'Faça login para finalizar a compra.');
            redirect('?page=usuario&action=login');
        }

        $carrinho = getCarrinho();
        if (empty($carrinho)) {
            redirect('?page=pagamento&action=carrinho');
        }

        $usuario = getUsuarioLogado();
        $subtotal = totalCarrinho();
        $total = $subtotal; // Pode adicionar taxas aqui

        require __DIR__ . '/../view/pagamento/checkout.php';
    }

    public function processar() {
        if (!authCheck()) redirect('?page=usuario&action=login');

        $carrinho = getCarrinho();
        if (empty($carrinho)) redirect('?page=pagamento&action=carrinho');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('?page=pagamento&action=checkout');

        $metodo = $_POST['metodo'] ?? 'pix';
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');

        $total = totalCarrinho();

        // Criar pedido
        $pedido = new Pedido();
        $id_pedido = $pedido->create($_SESSION['usuario_id'], $total);

        // Adicionar itens e biblioteca
        foreach ($carrinho as $item) {
            $pedido->addItem($id_pedido, $item['id_jogo'], $item['preco']);
            $bib = new Biblioteca();
            $bib->add($_SESSION['usuario_id'], $item['id_jogo']);
        }

        // Registrar pagamento
        $pedido->createPagamento($id_pedido, $metodo);

        // Limpar carrinho
        clearCarrinho();

        // Gerar número do pedido
        $numero_pedido = 'GS-' . str_pad($id_pedido, 6, '0', STR_PAD_LEFT);

        setFlash('pedido_id', $id_pedido);
        setFlash('numero_pedido', $numero_pedido);
        setFlash('total', $total);

        redirect('?page=pagamento&action=confirmacao');
    }

    public function confirmacao() {
        $numero_pedido = flash('numero_pedido');
        $total = flash('total');
        $id_pedido = flash('pedido_id');

        if (!$numero_pedido) redirect('');

        $usuario = getUsuarioLogado();

        // Buscar itens do pedido
        $pdo = getDB();
        $stmt = $pdo->prepare("SELECT pi.*, j.titulo, j.capa FROM Pedido_itens pi JOIN Jogos j ON pi.id_jogo = j.id_jogo WHERE pi.id_pedido = ?");
        $stmt->execute([$id_pedido]);
        $itens = $stmt->fetchAll();

        require __DIR__ . '/../view/pagamento/confirmacao.php';
    }
}
?>