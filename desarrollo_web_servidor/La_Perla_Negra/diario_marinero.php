<?php
// diario_marinero.php - Diario de Acciones del Marinero
session_start();

// Definir las acciones disponibles con sus valores de karma
$acciones_buenas = [
    'rescate' => ['nombre' => '🌊 Rescatar a un compañero del mar', 'karma' => 50],
    'compartir' => ['nombre' => '💰 Compartir el botín equitativamente', 'karma' => 30],
    'codigo' => ['nombre' => '📜 Respetar el código pirata', 'karma' => 20],
    'reparar' => ['nombre' => '🔨 Ayudar a reparar el barco', 'karma' => 25],
    'defender' => ['nombre' => '⚔️ Defender el barco de enemigos', 'karma' => 40]
];

$acciones_malas = [
    'traicion' => ['nombre' => '🗡️ Traicionar a la tripulación', 'karma' => -60],
    'robar' => ['nombre' => '💀 Robar del botín común', 'karma' => -45],
    'borracho' => ['nombre' => '🍺 Emborracharse durante la guardia', 'karma' => -20],
    'motin' => ['nombre' => '⚓ Amotinarse contra el capitán', 'karma' => -70],
    'abandonar' => ['nombre' => '🏴‍☠️ Abandonar a un compañero en apuros', 'karma' => -50]
];

// Procesar el formulario
if(isset($_POST['enviar'])) {
    $nombre_marinero = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : null;
    
    if(empty($nombre_marinero)) {
        $error = "¡Por Barbanegra! Debes ingresar tu nombre, marinero.";
    } else {
        // Calcular karma total
        $karma_total = 0;
        $acciones_realizadas = [];
        
        // Procesar acciones buenas
        foreach($acciones_buenas as $key => $accion) {
            if(isset($_POST['buena_' . $key])) {
                $karma_total += $accion['karma'];
                $acciones_realizadas[] = [
                    'nombre' => $accion['nombre'],
                    'karma' => $accion['karma'],
                    'tipo' => 'buena'
                ];
            }
        }
        
        // Procesar acciones malas
        foreach($acciones_malas as $key => $accion) {
            if(isset($_POST['mala_' . $key])) {
                $karma_total += $accion['karma'];
                $acciones_realizadas[] = [
                    'nombre' => $accion['nombre'],
                    'karma' => $accion['karma'],
                    'tipo' => 'mala'
                ];
            }
        }
        
        // Guardar en sesión
        $_SESSION['nombre_marinero'] = $nombre_marinero;
        $_SESSION['karma_total'] = $karma_total;
        $_SESSION['acciones_realizadas'] = $acciones_realizadas;
        
        // Redirigir al juicio
        header('Location: juicio_marinero.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚓ Diario del Marinero</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
            color: #fff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 3px solid #d4af37;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #d4af37;
        }
        
        .header h1 {
            font-size: 2.5em;
            color: #d4af37;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1em;
            color: #ccc;
            font-style: italic;
        }
        
        .nombre-section {
            margin-bottom: 30px;
            background: rgba(212, 175, 55, 0.1);
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #d4af37;
        }
        
        .nombre-section label {
            display: block;
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #d4af37;
        }
        
        .nombre-section input {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            border: 2px solid #d4af37;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
            color: #000;
        }
        
        .acciones-section {
            margin-bottom: 30px;
        }
        
        .acciones-section h2 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #d4af37;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .acciones-buenas h2 {
            color: #4ecca3;
        }
        
        .acciones-malas h2 {
            color: #ff6b6b;
        }
        
        .accion-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .accion-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }
        
        .accion-item input[type="checkbox"] {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            cursor: pointer;
        }
        
        .accion-label {
            flex: 1;
            font-size: 1.1em;
            cursor: pointer;
        }
        
        .karma-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9em;
        }
        
        .karma-positivo {
            background: #4ecca3;
            color: #000;
        }
        
        .karma-negativo {
            background: #ff6b6b;
            color: #fff;
        }
        
        .error {
            background: #ff6b6b;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .submit-btn {
            width: 100%;
            padding: 18px;
            font-size: 1.3em;
            font-weight: bold;
            background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            color: #000;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .submit-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.5);
        }
        
        .instrucciones {
            background: rgba(212, 175, 55, 0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #d4af37;
        }
        
        .instrucciones p {
            line-height: 1.6;
            color: #ccc;
        }
        
        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .wave {
            animation: wave 2s ease-in-out infinite;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><span class="wave">⚓</span> Diario del Marinero <span class="wave">⚓</span></h1>
            <p>"Que las mareas juzguen tus acciones, marinero..."</p>
        </div>
        
        <?php if(isset($error)): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="instrucciones">
            <p>
                🏴‍☠️ <strong>Bienvenido, marinero.</strong> Marca las acciones que has cometido durante tu travesía por los siete mares. 
                Tu karma determinará si navegarás hacia los cielos eternos o descenderás al casillero de Davy Jones...
            </p>
        </div>
        
        <form method="POST">
            <div class="nombre-section">
                <label for="nombre">⚓ Nombre del Marinero:</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       placeholder="Ej: Jack Sparrow" 
                       required
                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
            </div>
            
            <div class="acciones-section acciones-buenas">
                <h2>✨ Acciones Nobles</h2>
                <?php foreach($acciones_buenas as $key => $accion): ?>
                    <div class="accion-item">
                        <input type="checkbox" 
                               id="buena_<?php echo $key; ?>" 
                               name="buena_<?php echo $key; ?>"
                               value="1">
                        <label for="buena_<?php echo $key; ?>" class="accion-label">
                            <?php echo $accion['nombre']; ?>
                        </label>
                        <span class="karma-badge karma-positivo">
                            +<?php echo $accion['karma']; ?> karma
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="acciones-section acciones-malas">
                <h2>💀 Acciones Ruines</h2>
                <?php foreach($acciones_malas as $key => $accion): ?>
                    <div class="accion-item">
                        <input type="checkbox" 
                               id="mala_<?php echo $key; ?>" 
                               name="mala_<?php echo $key; ?>"
                               value="1">
                        <label for="mala_<?php echo $key; ?>" class="accion-label">
                            <?php echo $accion['nombre']; ?>
                        </label>
                        <span class="karma-badge karma-negativo">
                            <?php echo $accion['karma']; ?> karma
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" name="enviar" class="submit-btn">
                ⚖️ Enfrentar el Juicio ⚖️
            </button>
        </form>
    </div>
</body>
</html>
