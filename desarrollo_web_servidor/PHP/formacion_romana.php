<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formación Romana</title>
</head>
<body>
    <?php
        /**$legionarios;//Dato de entrada
        $escudos;//Dato de salida

        
        
        for ($i=1; $i <= 7; $i++){
            $legionarios = $i;
            if ($i < 4) {
                $escudos = $legionarios * 5;                
            } elseif ($i <7) {
                $escudos = 12 + 5 * ($i - 4); 
            }
            echo "<p>Para $legionarios legionarios hacen falta $escudos escudos</p>";
            
        }

        function escudosCuadrado($lado) {
            return $lado**2 + $lado * 4;

        }
        */

        $legionarios = 20;
        $total_escudos = 0;

        while ($legionarios > 0) {
           $ladoMayor = floor(sqrt($legionarios));
            $total_escudos += escudosCuadrado($ladoMayor);
            $legionarios -= $ladoMayor**2;
        }
        echo "Hacen falta $total_escudos.<br />";

    
        function escudosCuadrado($lado) {
            return $lado**2 + $lado * 4;

        }
    ?>
</body>
</html>