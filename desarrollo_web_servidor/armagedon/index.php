<?php
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        listar();
        break;
    case 'POST':
        insertar();
        break;
    default:
        http_response_code(501);
        echo 'Not Implemented';
}

die();

function listar() {
    // Llamo al modelo y obtengo la vista de armagedones
    $respuesta = [
        ['id' => 1, 'bajas' => 5000000, 'titulo' => 'Guerra nuclear total'],
        ['id' => 2, 'bajas' => 100000, 'titulo' => 'Pandemmia de gripe aviar'],
        ['id' => 3, 'bajas' => 300000, 'titulo' => 'Invasión alienígena']
    ];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respuesta);
}

function insertar() {
    $datos = json_decode(file_get_contents('php://input'), true);

    // Validación: si no existe 'titulo'
    if (!array_key_exists('titulo', $datos)) {
        return;
    }

    // El titulo no puede estar vacío
    if ($datos['titulo'] === '') {
        http_response_code(400);
        echo 'El título es obligatorio';
        die();
    }

    // El número de bajas es obligatorio y mayor que 0
    if (!array_key_exists('bajas', $datos) || !is_numeric($datos['bajas']) || $datos['bajas'] < 0) {
        http_response_code(400);
        echo 'El número de bajas es obligatorio y debe ser un número positivo';
        die();
    }

    $id_insertado = 42;
    $respuesta = ["url" => "http://localhost/armagedon/?id=$id_insertado"];

    http_response_code(201);
    echo json_encode($respuesta);

    die();
}
?>
