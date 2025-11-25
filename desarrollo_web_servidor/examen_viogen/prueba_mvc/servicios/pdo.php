<?php
/**
	Para configurar el acceso a SQL en XAMPP: Edita el fichero xampp/php/php.ini, descomenta la línea ;extension=sqlite3 (quitando el ;), salva el fichero y reinicia el servidor de XAMPP.
	Además, asegúrate de que hay permisos de escritura en el directorio de la base de datos para todos los usuarios y que hay permisos de escritura sobre el fichero de base de datos para cualquier usuario.
**/

	class PDO_SQLite{
		private $conexion;

		public function __construct($path_bd){
			
		    try {
		        $this->conexion = new PDO('sqlite:' . $path_bd);
		        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    } catch (PDOException $e) {
		        throw new Exception("Error al conectar con la base de datos: " . $e->getMessage());
		    }
	
		}

		
		public function listar(string $tabla, array $campos){

	    	try {
		        $campos_str = implode(', ', $campos);
		        $sql = "SELECT $campos_str FROM $tabla";
		        $stmt = $this->conexion->prepare($sql);
		        $stmt->execute();
		        return $stmt->fetchAll(PDO::FETCH_ASSOC);
		    } catch (PDOException $e) {
		        throw new Exception("Error al listar: " . $e->getMessage());
		    }

			
		}

		public function insertar(string $tabla, array $campos,array $valores){
			
			try {
				$campos_str = implode(', ', $campos);
				$placeholders = implode(', ', array_fill(0,count($campos), '?'));
				$sql = "INSERT INTO $tabla ($campos_str) VALUES (placeholders)";
				$stm = $this->conexion->prepare($sql);
				$stmt->execute($valores);
			}catch (PDOException $e) {
				throw new Exception("Error al insertar: " . $e->getMessage());
			}
		}

	}
