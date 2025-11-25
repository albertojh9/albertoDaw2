<?php
class ControladorCalificacion{
	private $config;
	private $modelo;
		
	public function __construct($config){
		$this->config = $config;
		require_once($this->config['path_modelos'].'calificacion.php');
		$this->modelo = new Calificacion($this->config['path_servicios'], $this->config['path_bd']);
	}
	public function listar(){
		$calificaciones = $this->modelo->listar();
		require_once($this->config['path_vistas'].'vistalistar.php');
		$vista = new VistaListar($this->config['path_html']);
		$vista->mostrar($calificaciones);
	}
	public function registrar(){
		//Sanitización de parámetros
		$errores;
			if (isset($_POST['nombre'])) {
				$_POST['nombre'] = htmlspecialchars($_POST['nombre']);
			}
			if (isset($_POST['calificacion'])) {
				$_POST['calificacion'] = htmlspecialchars($_POST['calificacion']);
			}
		//Validación de parámetros
			if (strlen($_POST['nombre']) <= 2) {
				$errores[] = "La calificacion del alumno deber tener mas de 2 caracteres";
			}
			if (!is_numeric($_POST['calificacion']) || $_POST['calificacion'] < 1 || $_POST['calificacion'] > 10) {
				$errores[] = "La calificacion debe ser un valor entre 1 y 10";
			}
			if (!empty($errores)) {
				$this->verRegistrar(implode("<br>", $errores));
				return;
			}
		$alumno = $_POST['nombre'];
		$calificacion = $_POST['calificacion'];
		try {
		$this->modelo->registrar($alumno, $calificacion);
		$this->verRegistrar("El registro de la calificación se realizó con éxito");
		} catch (Exception $e) {
			$this->verRegistrar("Error en la base de datos: " . $e->getMessage());
			return;
		}
	}
	public function verRegistrar($mensaje = null){
		require_once($this->config['path_vistas'].'vistaregistrar.php');		
		$vista = new VistaRegistrar($this->config['path_html']);
		if ($mensaje !== null) {
			$vista->mostrar($mensaje);
			return;
		}
		$vista->mostrar();
	}
}