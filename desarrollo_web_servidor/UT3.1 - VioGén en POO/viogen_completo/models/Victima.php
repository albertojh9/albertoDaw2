<?php
/**
 * Modelo Victima
 * Gestiona las operaciones relacionadas con las víctimas
 */
class Victima {
    
    private $db;
    private $table = 'Victima';
    
    /**
     * Constructor - inicializa la conexión a BD
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Registra una nueva víctima
     * @param array $datos Datos de la víctima
     * @return int|false ID de la víctima creada o false si falla
     */
    public function crear($datos) {
        $sql = "INSERT INTO {$this->table} (nombre, apellidos, tipo_documento, documento, telefono, observaciones) 
                VALUES (:nombre, :apellidos, :tipo_documento, :documento, :telefono, :observaciones)";
        
        $stmt = $this->db->prepare($sql);
        
        try {
            $stmt->execute([
                ':nombre' => $datos['nombre'] ?: null,
                ':apellidos' => $datos['apellidos'] ?: null,
                ':tipo_documento' => $datos['tipo_documento'] ?: null,
                ':documento' => $datos['documento'] ?: null,
                ':telefono' => $datos['telefono'] ?: null,
                ':observaciones' => $datos['observaciones'] ?: null
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Obtiene todas las víctimas
     * @return array
     */
    public function obtenerTodas() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Obtiene una víctima por ID
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Valida los datos de la víctima
     * @param array $datos
     * @return array Errores encontrados
     */
    public function validar($datos) {
        $errores = [];
        
        // Al menos nombre u observaciones
        if (empty($datos['nombre']) && empty($datos['observaciones'])) {
            $errores['general'] = MSG_NOMBRE_O_OBS_REQUERIDO;
        }
        
        // Validar documento si se proporciona
        if (!empty($datos['documento']) && !empty($datos['tipo_documento'])) {
            if (!$this->validarDocumento($datos['tipo_documento'], $datos['documento'])) {
                $errores['documento'] = MSG_DOCUMENTO_INVALIDO;
            }
        }
        
        return $errores;
    }
    
    /**
     * Valida un documento según su tipo
     * @param string $tipo
     * @param string $documento
     * @return bool
     */
    public function validarDocumento($tipo, $documento) {
        switch ($tipo) {
            case 'NIF':
                return $this->validarNIF($documento);
            case 'NIE':
                return $this->validarNIE($documento);
            case 'Pasaporte':
                return $this->validarPasaporte($documento);
            default:
                return false;
        }
    }
    
    /**
     * Valida un NIF español
     */
    private function validarNIF($nif) {
        $nif = strtoupper(trim($nif));
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $nif)) {
            return false;
        }
        
        $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $numero = substr($nif, 0, 8);
        $letra = substr($nif, 8, 1);
        
        return $letra === $letras[$numero % 23];
    }
    
    /**
     * Valida un NIE español
     */
    private function validarNIE($nie) {
        $nie = strtoupper(trim($nie));
        if (!preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie)) {
            return false;
        }
        
        $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $nieNumero = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], $nie);
        $numero = substr($nieNumero, 0, 8);
        $letra = substr($nie, 8, 1);
        
        return $letra === $letras[$numero % 23];
    }
    
    /**
     * Valida un Pasaporte
     */
    private function validarPasaporte($pasaporte) {
        $pasaporte = strtoupper(trim($pasaporte));
        return strlen($pasaporte) >= 5 && strlen($pasaporte) <= 20;
    }
}
