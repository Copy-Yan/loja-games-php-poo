<?php
session_start();
require_once __DIR__ . '/config/database.php';

// Helpers
function base_url(string $path = '') {
    // Base dinâmica para funcionar mesmo que o projeto não esteja em /gamestormy/
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
    $scriptDir = rtrim(str_replace('\\', '/', $scriptDir), '/');
    $base = $scriptDir === '/' ? '' : $scriptDir;
    return $base . '/' . ltrim($path, '/');
}


function redirect(string $path) {
    header("Location: " . base_url($path));
    exit;
}

function authCheck() {
    return isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] > 0;
}

function getUsuarioLogado() {
    if (!authCheck()) return null;
    require_once __DIR__ . '/model/Usuario.php';
    $u = new Usuario();
    return $u->getById($_SESSION['usuario_id']);
}

function flash(string $key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

function setFlash(string $key, string $msg) {
    $_SESSION['flash'][$key] = $msg;
}

// Carrinho na sessão
function getCarrinho() {
    if (!isset($_SESSION['carrinho'])) $_SESSION['carrinho'] = [];
    return $_SESSION['carrinho'];
}

function addCarrinho(array $jogo) {
    $cart = getCarrinho();
    if (isset($cart[$jogo['id_jogo']])) {
        $cart[$jogo['id_jogo']]['qty']++;
    } else {
        $cart[$jogo['id_jogo']] = [
            'id_jogo' => $jogo['id_jogo'],
            'titulo' => $jogo['titulo'],
            'preco' => $jogo['preco'],
            'capa' => $jogo['capa'],
            'tag' => $jogo['tag'],
            'qty' => 1
        ];
    }
    $_SESSION['carrinho'] = $cart;
}

function removeCarrinho( int  $id_jogo) {
    $cart = getCarrinho();
    unset($cart[$id_jogo]);
    $_SESSION['carrinho'] = $cart;
}

function clearCarrinho() {
    $_SESSION['carrinho'] = [];
}

function totalCarrinho() {
    $total = 0;
    foreach (getCarrinho() as $item) {
        $total += $item['preco'] * $item['qty'];
    }
    return $total;
}

// Roteamento
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Segurança básica
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$page);
$action = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$action);

// Fallbacks
if ($page === '' || $page === 'home' || !is_string($page)) {
    $page = 'home';
}
if ($action === '') {
    $action = 'index';
}

$controllerFile = __DIR__ . '/controller/' . ucfirst($page) . 'Controller.php';
$defaultControllerFile = __DIR__ . '/controller/HomeController.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $className = ucfirst($page) . 'Controller';
    if (!class_exists($className)) {
        require_once $defaultControllerFile;
        $c = new HomeController();
        $c->index();
        exit;
    }

    $controller = new $className();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->index();
    }
} else {
    // Página não encontrada -> home
    require_once $defaultControllerFile;
    $c = new HomeController();
    $c->index();
}
?>

