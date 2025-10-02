<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lo que cuesta sumar</title>
</head>
<body>
    <?php
        //Datos de entrada
        $numeros = [1,2,3];
        echo "<br />Resultado: ".calcularEsfuerzo($numeros);
        $numeros = [3,1,4,2];
        echo "<br />Resultado: ".calcularEsfuerzo($numeros);
        $numeros = [30,40,50,60];
        echo "<br />Resultado: ".calcularEsfuerzo($numeros);
        $numeros = [];
        echo "<br />Resultado: ".calcularEsfuerzo($numeros);



        function calcularEsfuerzo($numeros){
            //Datos de salida
            $esfuerzo = 0;

            while(count($numeros) >= 2){

                //1. Ordeno el array en orden ascendente
                sort($numeros);
                //print_r($numeros);

                //2. Sumo los dos primeros y los añado al esfuerzo
                $tmp = $numeros[0] + $numeros[1];
                $esfuerzo += $tmp;
                array_push($numeros, $tmp);
                //print_r($numeros);
                array_splice($numeros, 0, 2);
                //print_r($numeros);
            }
            return $esfuerzo;
        }





    ?>    
</body>
</html>