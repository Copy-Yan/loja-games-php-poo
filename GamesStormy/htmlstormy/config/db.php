<?php
class Database
{
    private static $conn === null;
    public static function getConection()
    {
        if (self::$conn === null){
            try {
                self::$conn = new PDO(
                    "mysql:host=localhost;dbname=GamesStormy;charset=utf8mb4"
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                  );
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados.");
            }
        }
        return self::$conn;
    }
}
