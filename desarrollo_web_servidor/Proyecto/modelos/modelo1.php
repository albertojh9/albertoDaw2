<?php
/** Modelo
 * Responsabilidad:
 *   -Gestionar los datos del negocio
 *   -Gestionar la persistencia
 */


class Modelo1 {
    public function guardar($datos) {
        //Aqui iria la logica para guardar en base de datos
        echo "Guardando...".$datos;
        throw new Exception("No hay BD");
    }
}
