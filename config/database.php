<?php
require_once 'config.php';

class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    public static function getConnection() {
        $database = new Database();
        $database->conn = null;

        try {
            $database->conn = new PDO("mysql:host={$database->host};dbname={$database->db_name}", $database->username, $database->password);
            $database->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
        }

        return $database->conn;
    }
}
?>
