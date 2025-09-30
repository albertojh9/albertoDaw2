<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso valor por referencia</title>
</head>
<body>
    <?php
        $a = 7;
        $b = 5;
        
        echo '$a = '.$a.'$b = '.$b.'<br />';
        cambiar($a,$b);

        echo'Ahora $a = '.$a.' $b = '.$b.'<br />';

        function cambiar(&$a, &$b){
            $c = $a;
            $a = $b;
            $b = $c;
        }
    ?>


</body>
</html>