<?php
/**
 * CLASE DATABASE
 * Conexión a la base de datos usando Singleton
 */
class Database {
    private static $instance = null;
    private $connection;
    
    // Constructor privado (Singleton)
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    // Obtener la instancia única
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Obtener la conexión PDO
    public function getConnection() {
        return $this->connection;
    }
    
    // Evitar clonación
    private function __clone() {}
}
