<?php
require_once 'empleado.php';

class Gerente extends Empleado {
    private float $bonus;

    function __construct(string $nombre, float $salario, float $bonus) {
        parent::__construct($nombre, $salario);
        $this->bonus = $bonus;
    }

    function getBonus(): float {
        return $this->bonus;
    }

    function setBonus(float $bonus): void {
        $this->bonus = $bonus;
    }

    function calcularBono(): float {
        return $this->salario + $this->bonus;
    }
}

?>
