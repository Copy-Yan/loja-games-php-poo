<?php
echo "<h2>Teste da classe Database (db.php)</h2>";

require_once__DIR__. '/config/db.php';

if(!class_exists('Database')){
    die("<p style='color:red;> Classe Database NÃO foi carregada.</p>");
}
echo "<p style='color:green;'> OK Classe Database carregada.</p>";

try{
    $conn = Database::getConection();

    if($conn instanceof PDO){
        echo("<p style='color:green;'> OK Conexão retornou um objeto PDO.</p>";)
    } else{
        echo"<p style='color:red;'> X Conexão NÃO retornou PDO.</p>";
    }
    $stmt=$conn->query("SHOW TABLES");

    echo "<p>Tabelas encontradas:</p></ul>";
    while ($row=$stmt->fetch(PDO::FETCH_NUM)){
        echo "<li>{$row[0]}</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "<p style='color:red;'> X Erro ao usar Database:</p>";
    echo "<pre>". $e->getMessage();
}
