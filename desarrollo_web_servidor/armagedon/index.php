<?php
    header('Content-Type: application/json; charset=utf-8');

    //Llamo al modelo y obtengo la lista de armagedones:
    $respuesta = [
        ['id' => 1, 'titulo' => 'Guerra nuclear total'],
        ['id' => 2, 'titulo' => 'Pandemia de gripe aviar'],
        ['id' => 3, 'titulo' => 'Invasion alienigena'],        
    ];
    echo json_encode($respuesta);