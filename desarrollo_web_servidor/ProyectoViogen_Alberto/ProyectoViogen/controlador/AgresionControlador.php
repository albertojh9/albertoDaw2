<?php
/**
 * Controlador de Agresión
 * Gestiona el registro de agresiones
 * 
 * @author Alberto
 * @version 1.0
 */

require_once MODELO_PATH . 'Agresion.php';
require_once MODELO_PATH . 'Victima.php';

/**
 * Muestra el formulario de registro de agresión
 */
function mostrarFormularioAgresion() {
    $mensaje = '';
    $tipo_mensaje = '';
    $datos = [
        'victima_id' => '',
        'agresor' => '',
        'tipo_agresion' => '',
        'fecha' => date('Y-m-d'),
        'hora' => date('H:i'),
        'observaciones' => ''
    ];
    
    // Obtener lista de víctimas para el select
    $victimas = Victima::obtenerTodas();
    
    include VISTA_PATH . 'registrarAgresion.php';
}

/**
 * Procesa el formulario de registro de agresión
 */
function guardarAgresion() {
    $mensaje = '';
    $tipo_mensaje = 'error';
    
    // Sanitizar todas las entradas
    $victima_id = isset($_POST['victima_id']) ? intval($_POST['victima_id']) : 0;
    $agresor = isset($_POST['agresor']) ? trim(htmlspecialchars($_POST['agresor'], ENT_QUOTES, 'UTF-8')) : '';
    $tipo_agresion = isset($_POST['tipo_agresion']) ? trim(htmlspecialchars($_POST['tipo_agresion'], ENT_QUOTES, 'UTF-8')) : '';
    $fecha = isset($_POST['fecha']) ? trim(htmlspecialchars($_POST['fecha'], ENT_QUOTES, 'UTF-8')) : '';
    $hora = isset($_POST['hora']) ? trim(htmlspecialchars($_POST['hora'], ENT_QUOTES, 'UTF-8')) : '';
    $observaciones = isset($_POST['observaciones']) ? trim(htmlspecialchars($_POST['observaciones'], ENT_QUOTES, 'UTF-8')) : '';
    
    $datos = [
        'victima_id' => $victima_id,
        'agresor' => $agresor,
        'tipo_agresion' => $tipo_agresion,
        'fecha' => $fecha,
        'hora' => $hora,
        'observaciones' => $observaciones
    ];
    
    // Obtener lista de víctimas para mostrar de nuevo si hay error
    $victimas = Victima::obtenerTodas();
    
    // Validar campos obligatorios
    if (empty($victima_id)) {
        $mensaje = 'Debe seleccionar una víctima';
        include VISTA_PATH . 'registrarAgresion.php';
        return;
    }
    
    if (empty($tipo_agresion) || !array_key_exists($tipo_agresion, TIPOS_AGRESION)) {
        $mensaje = 'Debe seleccionar un tipo de agresión válido';
        include VISTA_PATH . 'registrarAgresion.php';
        return;
    }
    
    if (empty($fecha) || empty($hora)) {
        $mensaje = 'Debe indicar la fecha y hora de la agresión';
        include VISTA_PATH . 'registrarAgresion.php';
        return;
    }
    
    // Validar formato de fecha y hora
    $fecha_hora = $fecha . ' ' . $hora . ':00';
    if (!strtotime($fecha_hora)) {
        $mensaje = 'La fecha y hora no tienen un formato válido';
        include VISTA_PATH . 'registrarAgresion.php';
        return;
    }
    
    // Preparar datos para guardar
    $datosGuardar = [
        'victima_id' => $victima_id,
        'agresor' => !empty($agresor) ? $agresor : null,
        'tipo_agresion' => $tipo_agresion,
        'fecha_hora' => $fecha_hora,
        'observaciones' => !empty($observaciones) ? $observaciones : null,
        'usuario_id' => $_SESSION['usuario_id']
    ];
    
    // Registrar agresión
    $resultado = Agresion::registrar($datosGuardar);
    
    if ($resultado) {
        $_SESSION['mensaje'] = MSG_AGRESION_REGISTRADA;
        $_SESSION['tipo_mensaje'] = 'exito';
        header('Location: index.php?accion=menu');
        exit;
    } else {
        $mensaje = 'Error al registrar la agresión';
        include VISTA_PATH . 'registrarAgresion.php';
    }
}
