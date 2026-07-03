<?php
// diagnostico.php - Coloque este arquivo na pasta raiz do projeto e acesse:
// http://localhost/gamestormy/diagnostico.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Diagnostico GameStormy</title>
<style>
body{font-family:Segoe UI,sans-serif;background:#1e1e1e;color:#fff;padding:30px;max-width:700px;margin:0 auto;line-height:1.6}
.box{background:rgba(255,255,255,.06);border-radius:12px;padding:20px;margin-bottom:16px;border-left:4px solid #7c41b1}
.ok{color:#00bc5e;font-weight:700}
.erro{color:#ff6b6b;font-weight:700}
.aviso{color:#ffd93d;font-weight:700}
pre{background:rgba(0,0,0,.3);padding:10px;border-radius:6px;overflow-x:auto;font-size:12px}
h1{color:#af76d9}
</style>
</head>
<body>
<h1>Diagnostico GameStormy</h1>

<div class="box">
<h3>1. Versao do PHP</h3>
<?php echo '<p>Versao: ' . phpversion() . '</p>'; ?>
<?php echo (version_compare(phpversion(), '7.4.0', '>=')) ? '<p class="ok">OK - PHP compativel</p>' : '<p class="erro">ERRO - PHP precisa ser 7.4+</p>'; ?>
</div>

<div class="box">
<h3>2. Extensao PDO MySQL</h3>
<?php echo extension_loaded('pdo_mysql') ? '<p class="ok">OK - pdo_mysql esta habilitado</p>' : '<p class="erro">ERRO - pdo_mysql NAO esta habilitado. Habilite no php.ini: extension=pdo_mysql</p>'; ?>
</div>

<div class="box">
<h3>3. Conexao com o Banco de Dados</h3>
<?php
require_once __DIR__ . '/config/database.php';
try {
    $db = getDB();
    echo '<p class="ok">OK - Conectou ao MySQL com sucesso</p>';
    echo '<p>Banco: ' . DB_NAME . ' | Host: ' . DB_HOST . ' | User: ' . DB_USER . '</p>';
} catch (Exception $e) {
    echo '<p class="erro">ERRO - Nao conseguiu conectar: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p class="aviso">Dica: Edite config/database.php e verifique DB_USER, DB_PASS e DB_NAME</p>';
}
?>
</div>

<div class="box">
<h3>4. Banco de dados "gamestormy" existe?</h3>
<?php
try {
    $db = getDB();
    $db->query("USE gamestormy");
    $stmt = $db->query("SHOW TABLES");
    $tabelas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo '<p class="ok">OK - Banco "gamestormy" existe com ' . count($tabelas) . ' tabelas</p>';
    echo '<pre>' . implode("
", $tabelas) . '</pre>';
} catch (Exception $e) {
    echo '<p class="erro">ERRO: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p class="aviso">Solucao: Importe o arquivo db/gamestormy.sql no phpMyAdmin</p>';
}
?>
</div>

<div class="box">
<h3>5. Permissao da pasta uploads/avatares</h3>
<?php
$pasta = __DIR__ . '/assets/uploads/avatares/';
if (is_writable($pasta)) {
    echo '<p class="ok">OK - Pasta uploads/avatares tem permissao de escrita</p>';
} else {
    echo '<p class="erro">ERRO - Pasta uploads/avatares NAO tem permissao de escrita</p>';
    echo '<p class="aviso">Windows: clique com botao direito > Propriedades > Seguranca > Permitir modificacao<br>Linux: chmod 755 assets/uploads/avatares/</p>';
}
?>
</div>

<div class="box">
<h3>6. Caminho do projeto (base_url)</h3>
<?php
$protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$url = $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
echo '<p>URL detectada: <code>' . htmlspecialchars($url) . '</code></p>';
echo '<p class="aviso">Se o projeto nao estiver em /gamestormy/, edite .htaccess e a funcao base_url() no index.php</p>';
?>
</div>

<div class="box">
<h3>7. Erros do PHP (error_log)</h3>
<?php
$logFile = ini_get('error_log');
echo '<p>Arquivo de log: ' . ($logFile ?: 'Nao configurado') . '</p>';
echo '<p>display_errors: ' . ini_get('display_errors') . '</p>';
?>
</div>

<div class="box">
<h3>8. Teste de insercao (Usuario de teste)</h3>
<?php
try {
    $db = getDB();
    $stmt = $db->query("SELECT COUNT(*) as total FROM Usuarios");
    $r = $stmt->fetch();
    echo '<p class="ok">Tabela Usuarios acessivel. Total de usuarios: ' . $r['total'] . '</p>';
} catch (Exception $e) {
    echo '<p class="erro">' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>
</div>

<p style="text-align:center;margin-top:30px;color:rgba(255,255,255,.4)">
Se algum item acima estiver em vermelho, corrija-o antes de usar o site.<br>
Caso o erro persista, copie a mensagem exata e me envie.
</p>

</body>
</html>
