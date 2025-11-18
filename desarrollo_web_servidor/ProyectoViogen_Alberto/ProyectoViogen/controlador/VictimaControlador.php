<?php
/**
 * Controlador de Víctima
 * Gestiona el registro de víctimas
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'Victima.php';

/**
 * Muestra el formulario de registro de víctima
 */
function mostrarFormularioVictima() {
    $mensaje = '';
    $tipo_mensaje = '';
    $datos = [
        'nombre' => '',
        'apellidos' => '',
        'tipo_documento' => '',
        'numero_documento' => '',
        'telefono' => '',
        'observaciones' => ''
    ];
    
    include VISTA_PATH . 'registrarVictima.php';
}

/**
 * Procesa el formulario de registro de víctima
 */
function guardarVictima() {
    $mensaje = '';
    $tipo_mensaje = 'error';
    
    // Sanitizar todas las entradas
    $datos = [
        'nombre' => isset($_POST['nombre']) ? trim(htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8')) : '',
        'apellidos' => isset($_POST['apellidos']) ? trim(htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8')) : '',
        'tipo_documento' => isset($_POST['tipo_documento']) ? trim(htmlspecialchars($_POST['tipo_documento'], ENT_QUOTES, 'UTF-8')) : '',
        'numero_documento' => isset($_POST['numero_documento']) ? trim(htmlspecialchars($_POST['numero_documento'], ENT_QUOTES, 'UTF-8')) : '',
        'telefono' => isset($_POST['telefono']) ? trim(htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8')) : '',
        'observaciones' => isset($_POST['observaciones']) ? trim(htmlspecialchars($_POST['observaciones'], ENT_QUOTES, 'UTF-8')) : '',
        'usuario_id' => $_SESSION['usuario_id']
    ];
    
    // Validar que al menos hay nombre u observaciones
    if (empty($datos['nombre']) && empty($datos['observaciones'])) {
        $mensaje = 'Debe indicar al menos un nombre o unas observaciones';
        include VISTA_PATH . 'registrarVictima.php';
        return;
    }
    
    // Validar tipo de documento si se ha indicado
    if (!empty($datos['tipo_documento']) && !in_array($datos['tipo_documento'], TIPOS_DOCUMENTO)) {
        $mensaje = 'El tipo de documento no es válido';
        include VISTA_PATH . 'registrarVictima.php';
        return;
    }
    
    // Validar documento de identificación si se ha indicado tipo y número
    if (!empty($datos['tipo_documento']) && !empty($datos['numero_documento'])) {
        if (!validarDocumento($datos['tipo_documento'], $datos['numero_documento'])) {
            $mensaje = MSG_ERROR_DOCUMENTO;
            include VISTA_PATH . 'registrarVictima.php';
            return;
        }
    }
    
    // Si no se indica tipo de documento, limpiar número
    if (empty($datos['tipo_documento'])) {
        $datos['numero_documento'] = null;
        $datos['tipo_documento'] = null;
    }
    
    // Registrar víctima
    $resultado = Victima::registrar($datos);
    
    if ($resultado) {
        $_SESSION['mensaje'] = MSG_VICTIMA_REGISTRADA;
        $_SESSION['tipo_mensaje'] = 'exito';
        header('Location: index.php?accion=menu');
        exit;
    } else {
        $mensaje = 'Error al registrar la víctima';
        include VISTA_PATH . 'registrarVictima.php';
    }
}

/**
 * Valida un documento de identificación
 * @param string $tipo Tipo de documento (NIF, NIE, Pasaporte)
 * @param string $numero Número del documento
 * @return bool True si es válido, false en caso contrario
 */
function validarDocumento($tipo, $numero) {
    switch ($tipo) {
        case 'NIF':
            return validarNIF($numero);
        case 'NIE':
            return validarNIE($numero);
        case 'Pasaporte':
            // Pasaporte: al menos 5 caracteres alfanuméricos
            return preg_match('/^[A-Za-z0-9]{5,}$/', $numero);
        default:
            return false;
    }
}

/**
 * Valida un NIF español
 * @param string $nif NIF a validar
 * @return bool True si es válido
 */
function validarNIF($nif) {
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
 * @param string $nie NIE a validar
 * @return bool True si es válido
 */
function validarNIE($nie) {
    $nie = strtoupper(trim($nie));
    
    if (!preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie)) {
        return false;
    }
    
    // Convertir la primera letra a número
    $primera = substr($nie, 0, 1);
    $numero = substr($nie, 1, 7);
    
    switch ($primera) {
        case 'X':
            $numero = '0' . $numero;
            break;
        case 'Y':
            $numero = '1' . $numero;
            break;
        case 'Z':
            $numero = '2' . $numero;
            break;
    }
    
    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $letra = substr($nie, 8, 1);
    
    return $letra === $letras[$numero % 23];
}
