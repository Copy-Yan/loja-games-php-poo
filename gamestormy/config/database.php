<?php
// config/database.php
// Ajuste conforme seu ambiente local (XAMPP, WAMP, etc.)

define('DB_HOST', 'localhost');
define('DB_NAME', 'gamestormy');
define('DB_USER', 'root');
define('DB_PASS', '');        // senha padrão do XAMPP é vazia
define('DB_CHARSET', 'utf8mb4');

function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }
    return $pdo;
}
?>
