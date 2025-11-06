<?php

/**
    *index.php
    *Responsabilidades;
     *      -Cargar la configuracion
     *      -Middleware: autenticacion, logging,
     *     -Procesar la peticion

*/

try {
    $config = require_once('config.php');

    //Configuracion inicial

    if ($config['debug']) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
    //Middleware

    //Procesar la peticion
    $controlador = $_GET['controlador'] ;
    $metodo = $_GET['metodo'] ;

    require_once($config['dir_controladores'].strtolower($controlador).'.php');
    $controlador = new $controlador($config);
    $controlador->$metodo();

    echo "<br>TRON: FIN<br/>";

} catch (Throwable $exception) {
    header('HTTP/1.1 500 Internal Server Error');
}

?>