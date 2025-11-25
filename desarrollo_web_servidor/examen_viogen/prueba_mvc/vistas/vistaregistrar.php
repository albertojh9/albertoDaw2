<?php

	class VistaRegistrar{
		private $path_html;

		public function __construct($path_html){
			$this->path_html = $path_html;
		}

		public function mostrar($mensaje = null){
			
			$html_mensaje = '';
			if ($mensaje !== null) {
				if (strpos($mensaje, 'éxito') !== false) {
					$html_mensaje = "<p style='color:green;'>$mensaje</p>";
				} else {
					$html_mensaje = "<p style='color:red;'>$mensaje</p>";
				}
			}
			require_once($this->path_html.'registrar.html');
		}

		

		
	}
