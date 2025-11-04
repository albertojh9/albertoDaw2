<?php
require_once 'empleado.php';

class Desarrollador extends Empleado {
    private array $lenguajes;

    function __construct(string $nombre, float $salario, array $lenguajes = []) {
        parent::__construct($nombre, $salario);
        $this->lenguajes = $lenguajes;
    }

    function getLenguajes(): array {
        return $this->lenguajes;
    }

    function setLenguajes(array $lenguajes): void {
        $this->lenguajes = $lenguajes;
    }

    function agregarLenguaje(string $lenguaje): void {
        $this->lenguajes[] = $lenguaje;
    }

    function calcularBono(): float {
        // Salario + 10% por cada lenguaje
        $porcentajeTotal = count($this->lenguajes) * 0.10;
        return $this->salario + ($this->salario * $porcentajeTotal);
    }
}

?>
