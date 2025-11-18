<?php
/**
 * Modelo de conexión a la base de datos
 * Implementa el patrón Singleton para la conexión PDO
 * 
 * @author Alberto
 * @version 1.0
 */

class BaseDatos {
    private static $conexion = null;
    
    /**
     * Obtiene la conexión a la base de datos
     * @return PDO Conexión PDO
     */
    public static function getConexion() {
        if (self::$conexion === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                die(MSG_ERROR_BD . ": " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
    
    /**
     * Cierra la conexión a la base de datos
     */
    public static function cerrarConexion() {
        self::$conexion = null;
    }
}
