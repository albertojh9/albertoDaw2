<?php
    /** Controlador 
     *    Responsabilidad:
     *       -Recibir los datos de usuario
     *      -Aplicar reglas de negocio
     *      -Navegar entre vistas
     */


class Controlador1 {
    //private $atributo1 = 'ATRIB1';
    private $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function metodo1() {
        echo "Ejecutando: metodo1";        
    }

    public function verVista1() {
        require_once($this->config['dir_vistas'].'vista1.html');
    }

    public function guardar(){
        try {
            $texto = $_POST['campo1'];
            echo 'Guardando...';
            require_once($this->config['dir_modelos'].'modelo1.php');
            $modelo = new Modelo1();
            $modelo->guardar($texto);
            $resultado = "BIEN";
        }catch (Throwable $exception) {
            $resultado = "MAL";
        }
        require_once($this->config['dir_vistas'].'vista2.html');
    }
}