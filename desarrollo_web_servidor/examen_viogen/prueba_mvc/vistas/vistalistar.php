<?php

	class VistaListar{
		private $path_html;

		public function __construct($path_html){
			$this->path_html = $path_html;
		}

		public function mostrar($calificaciones){

			require_once($this->path_html.'listar.html');
		}
	}
