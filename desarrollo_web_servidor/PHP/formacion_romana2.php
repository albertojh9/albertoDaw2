<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // Lee la entrada desde STDIN (puedes probarlo en consola o adaptarlo para web)
        while (true) {
            $line = trim(fgets(STDIN));
            if ($line === '' || $line == '0') break;
            $n = intval($line);
            $totalEscudos = 0;
            while ($n > 0) {
                $lado = (int)sqrt($n); // El mayor cuadrado posible
                $escudos = $lado == 1 ? 4 : ($lado * $lado) + 4 * ($lado - 1);
                $totalEscudos += $escudos;
                $n -= $lado * $lado;
            }
            echo $totalEscudos . PHP_EOL;
        }
    ?>
</body>
</html>


