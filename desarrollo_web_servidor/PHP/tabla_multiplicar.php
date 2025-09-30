<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de multiplicar</title>
</head>
<body>
    
<?php
//Numeros elegidos
$inicio = 1;
$fin = 5;


for($j = $inicio; $j <= $fin; $j++){
    for($i = 0; $i < 10; $i++) {
        echo "$inicio x ".($i + 1)." = ".(($i + 1) * $j)."<br />";
    }
}

?>


</body>
</html>


