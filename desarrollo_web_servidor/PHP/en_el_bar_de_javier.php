<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        echo "<pre>";

        $categorias = ['D', 'C', 'A', 'M','I'];

        $ventas = ['D' => 2.80,
                   'C' => 48.0,
                   'A' => 8.0];
        //print_r($ventas);

      
        foreach($categorias as $categoria) {
            if (!array_key_exists($categoria, $ventas)) {
                $ventas[$categoria] = 0;
            }
        }

        //2. Ordenamos descendente
        asort($ventas);
        print_r($ventas);

        
        $claves = array_keys($ventas);
        print_r($claves);

        if($ventas[$claves[0]] == $ventas[$claves[1]]) {
            $menos_vendido = "EMPATE";
        } else {
            $menos_vendido = $claves[0];
        }

        $ultimo = count($claves) - 1;
        if($ventas[$claves[$ultimo]] == $ventas[$claves[$ultimo - 1]]) {
            $mas_vendido = "EMPATE";
        } else {
            $mas_vendido = $claves[$ultimo];
        }

        echo "Menos vendido: $menos_vendido\n";
        echo "Mas vendido: $mas_vendido\n";
        //print_r($ventas);

        echo "<pre>";


    ?>
</body>
</html>