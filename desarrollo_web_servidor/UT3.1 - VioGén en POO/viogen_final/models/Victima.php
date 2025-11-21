<?php
/**
 * MODELO VICTIMA
 * Gestiona operaciones de víctimas
 */
class Victima {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Registra una nueva víctima
     */
    public function crear($datos) {
        $sql = "INSERT INTO Victima (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
                VALUES (:nombre, :apellidos, :tipo_documento, :documento, :telefono, :observaciones)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre'] ?: null,
            ':apellidos' => $datos['apellidos'] ?: null,
            ':tipo_documento' => $datos['tipo_documento'] ?: null,
            ':documento' => $datos['documento'] ?: null,
            ':telefono' => $datos['telefono'] ?: null,
            ':observaciones' => $datos['observaciones'] ?: null
        ]);
    }
    
    /**
     * Obtiene todas las víctimas
     */
    public function obtenerTodas() {
        $sql = "SELECT * FROM Victima ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Valida un NIF español - formato básico
     */
    public function validarNIF($nif) {
        $nif = strtoupper(trim($nif));
        // Solo verifica que tenga 8 números y 1 letra
        return preg_match('/^[0-9]{8}[A-Z]$/', $nif) === 1;
    }
    
    /**
     * Valida un NIE español - formato básico
     */
    public function validarNIE($nie) {
        $nie = strtoupper(trim($nie));
        // Solo verifica que tenga X/Y/Z + 7 números + 1 letra
        return preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie) === 1;
    }
}
