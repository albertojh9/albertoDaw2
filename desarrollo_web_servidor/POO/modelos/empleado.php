<?php

abstract class Empleado {
    static private string $departamento = 'Informatica';
    private string $nombre;
    protected float $salario; // Cambiado a protected según requisitos
    
    function __construct(string $nombre, float $salario) {
        $this->nombre = $nombre;
        $this->salario = $salario;
    }

    function getNombre(): string {
        return $this->nombre;
    }

    function getSalario(): float {
        return $this->salario;
    }

    function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }   

    function setSalario(float $salario): void {
        $this->salario = $salario;
    }

    // Método estático para acceder a la propiedad estática usando self::
    static function getDepartamento(): string {
        return self::$departamento;
    }

    static function setDepartamento(string $departamento): void {
        self::$departamento = $departamento;
    }

    abstract function calcularBono(): float;
}

?>
