<?php
// index.php
require_once 'modelos/gerente.php';
require_once 'modelos/desarrollador.php';

echo "<h1>Sistema de Gestión de Empleados</h1>";

// Crear un Gerente
$gerente = new Gerente('Miguel', 570000, 100000);

echo "<h2>Gerente</h2>";
echo "Nombre: " . $gerente->getNombre() . "<br>";
echo "Salario: $" . number_format($gerente->getSalario(), 2) . "<br>";
echo "Bonus: $" . number_format($gerente->getBonus(), 2) . "<br>";
echo "Bono Total: $" . number_format($gerente->calcularBono(), 2) . "<br>";
echo "Departamento: " . Empleado::getDepartamento() . "<br>";

echo "<hr>";

// Crear Desarrolladores
$desarrolladores = [];
$desarrolladores[0] = new Desarrollador('Ana', 450000, ['PHP', 'JavaScript', 'Python']);
$desarrolladores[1] = new Desarrollador('Carlos', 480000, ['Java', 'C++']);

echo "<h2>Desarrolladores</h2>";
foreach ($desarrolladores as $index => $dev) {
    echo "<h3>Desarrollador " . ($index + 1) . "</h3>";
    echo "Nombre: " . $dev->getNombre() . "<br>";
    echo "Salario Base: $" . number_format($dev->getSalario(), 2) . "<br>";
    echo "Lenguajes: " . implode(', ', $dev->getLenguajes()) . "<br>";
    echo "Cantidad de lenguajes: " . count($dev->getLenguajes()) . "<br>";
    echo "Bono Total: $" . number_format($dev->calcularBono(), 2) . "<br>";
    echo "Departamento: " . Empleado::getDepartamento() . "<br>";
    echo "<br>";
}

echo "<hr>";

// Demostrar el uso de self:: con propiedad estática
echo "<h2>Cambiar Departamento (usando self::)</h2>";
echo "Departamento actual: " . Empleado::getDepartamento() . "<br>";
Empleado::setDepartamento('Desarrollo de Software');
echo "Nuevo departamento: " . Empleado::getDepartamento() . "<br>";
echo "Departamento del gerente: " . $gerente->getDepartamento() . "<br>";
echo "Departamento del desarrollador 1: " . $desarrolladores[0]->getDepartamento() . "<br>";

echo "<hr>";

// Demostrar visibilidad protegida
echo "<h2>Demostración de Visibilidad</h2>";
echo "<p><strong>Propiedad \$salario es PROTECTED:</strong></p>";
echo "<ul>";
echo "<li>Se puede acceder desde la clase base (Empleado) ✓</li>";
echo "<li>Se puede acceder desde las clases derivadas (Gerente y Desarrollador) ✓</li>";
echo "<li>El método calcularBono() en Gerente accede a \$this->salario directamente ✓</li>";
echo "<li>El método calcularBono() en Desarrollador accede a \$this->salario directamente ✓</li>";
echo "</ul>";

?>
