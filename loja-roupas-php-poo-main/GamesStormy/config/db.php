<?php
$host = "localhost";
$banco = "loja_roupas";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql: host=$host,dbname=$banco", $usuario, $senha);
    
    echo "Conexão bem sucedida!";
}
catch (PDOException $erro) {
    echo "Ops, deu erro: " . $erro->getMessage();
} 