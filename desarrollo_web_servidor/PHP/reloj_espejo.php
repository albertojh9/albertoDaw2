<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reloj através del espejo</title>
</head>
<body>
    <?php
        $horaInicial;
        $minutosInicial;

        echo horaReal(12,00);
        echo horaReal(12,30);
        echo horaReal(6,00);
        echo horaReal(6,30);

        function horaReal($horaEspejo,$minutosEspejo) {
            return "<p>$horaEspejo : $minutosEspejo</p>";
        }

    ?>
</body>
</html>