<?php
// juicio_marinero.php - El Juicio Final del Marinero
session_start();

// Verificar que existan datos en la sesión
if(!isset($_SESSION['nombre_marinero']) || !isset($_SESSION['karma_total'])) {
    header('Location: diario_marinero.php');
    exit();
}

$nombre = htmlspecialchars($_SESSION['nombre_marinero']);
$karma_total = $_SESSION['karma_total'];
$acciones = $_SESSION['acciones_realizadas'];

// Determinar el destino
if($karma_total > 0) {
    $destino = 'cielo';
    $mensaje = "¡Las mareas te han favorecido! Navegarás hacia los cielos eternos donde el ron fluye infinito y las tempestades jamás te alcanzarán.";
    $icono = "☁️";
} elseif($karma_total < 0) {
    $destino = 'davy_jones';
    $mensaje = "Las profundidades te reclaman, marinero. Descenderás al casillero de Davy Jones, donde servirás por la eternidad en su tripulación fantasma.";
    $icono = "💀";
} else {
    $destino = 'purgatorio';
    $mensaje = "Tu karma está en equilibrio perfecto. Vagarás eternamente en las aguas del limbo, ni en el cielo ni en el abismo...";
    $icono = "⚖️";
}

// Función para reiniciar
if(isset($_GET['nuevo'])) {
    session_destroy();
    header('Location: diario_marinero.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚖️ El Juicio Final</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            min-height: 100vh;
            padding: 20px;
            color: #fff;
            <?php if($destino == 'cielo'): ?>
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            <?php elseif($destino == 'davy_jones'): ?>
                background: linear-gradient(135deg, #000000 0%, #1a1a2e 50%, #16213e 100%);
            <?php else: ?>
                background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
            <?php endif; ?>
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.85);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.7);
            border: 3px solid #d4af37;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 3px solid #d4af37;
        }
        
        .header h1 {
            font-size: 3em;
            color: #d4af37;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
            margin-bottom: 15px;
        }
        
        .marinero-name {
            font-size: 1.8em;
            color: #fff;
            font-style: italic;
            margin-bottom: 10px;
        }
        
        .resultado-principal {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            border-radius: 15px;
            <?php if($destino == 'cielo'): ?>
                background: linear-gradient(135deg, rgba(78, 204, 163, 0.3) 0%, rgba(79, 172, 254, 0.3) 100%);
                border: 3px solid #4ecca3;
            <?php elseif($destino == 'davy_jones'): ?>
                background: linear-gradient(135deg, rgba(255, 107, 107, 0.3) 0%, rgba(139, 0, 0, 0.3) 100%);
                border: 3px solid #ff6b6b;
            <?php else: ?>
                background: linear-gradient(135deg, rgba(212, 175, 55, 0.3) 0%, rgba(169, 169, 169, 0.3) 100%);
                border: 3px solid #d4af37;
            <?php endif; ?>
        }
        
        .destino-icono {
            font-size: 5em;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .destino-titulo {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
            <?php if($destino == 'cielo'): ?>
                color: #4ecca3;
            <?php elseif($destino == 'davy_jones'): ?>
                color: #ff6b6b;
            <?php else: ?>
                color: #d4af37;
            <?php endif; ?>
        }
        
        .karma-display {
            font-size: 4em;
            font-weight: bold;
            margin: 20px 0;
            <?php if($karma_total > 0): ?>
                color: #4ecca3;
            <?php elseif($karma_total < 0): ?>
                color: #ff6b6b;
            <?php else: ?>
                color: #d4af37;
            <?php endif; ?>
        }
        
        .mensaje-destino {
            font-size: 1.3em;
            line-height: 1.8;
            color: #ccc;
            font-style: italic;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .acciones-detalle {
            margin-bottom: 30px;
        }
        
        .acciones-detalle h2 {
            font-size: 1.8em;
            color: #d4af37;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .accion-realizada {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            margin-bottom: 12px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .accion-realizada:hover {
            transform: translateX(5px);
        }
        
        .accion-buena {
            border-left: 4px solid #4ecca3;
        }
        
        .accion-mala {
            border-left: 4px solid #ff6b6b;
        }
        
        .accion-nombre {
            font-size: 1.1em;
            flex: 1;
        }
        
        .accion-karma {
            font-size: 1.2em;
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 20px;
        }
        
        .karma-pos {
            background: #4ecca3;
            color: #000;
        }
        
        .karma-neg {
            background: #ff6b6b;
            color: #fff;
        }
        
        .estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid rgba(212, 175, 55, 0.5);
        }
        
        .stat-label {
            font-size: 0.9em;
            color: #d4af37;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-value {
            font-size: 2em;
            font-weight: bold;
        }
        
        .botones {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }
        
        .btn {
            padding: 15px 30px;
            font-size: 1.2em;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .btn-nuevo {
            background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            color: #000;
        }
        
        .btn-nuevo:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.5);
        }
        
        .vacio-mensaje {
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #ccc;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ EL JUICIO FINAL ⚖️</h1>
            <div class="marinero-name">"<?php echo $nombre; ?>"</div>
        </div>
        
        <div class="resultado-principal">
            <div class="destino-icono"><?php echo $icono; ?></div>
            <div class="destino-titulo">
                <?php 
                if($destino == 'cielo') {
                    echo "¡Rumbo al Cielo!";
                } elseif($destino == 'davy_jones') {
                    echo "Casillero de Davy Jones";
                } else {
                    echo "Limbo Eterno";
                }
                ?>
            </div>
            <div class="karma-display">
                <?php echo ($karma_total > 0 ? '+' : '') . $karma_total; ?> KARMA
            </div>
            <p class="mensaje-destino">
                <?php echo $mensaje; ?>
            </p>
        </div>
        
        <div class="estadisticas">
            <div class="stat-box">
                <div class="stat-label">Total de Acciones</div>
                <div class="stat-value"><?php echo count($acciones); ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Acciones Nobles</div>
                <div class="stat-value" style="color: #4ecca3;">
                    <?php 
                    $buenas = array_filter($acciones, function($a) { return $a['tipo'] == 'buena'; });
                    echo count($buenas);
                    ?>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Acciones Ruines</div>
                <div class="stat-value" style="color: #ff6b6b;">
                    <?php 
                    $malas = array_filter($acciones, function($a) { return $a['tipo'] == 'mala'; });
                    echo count($malas);
                    ?>
                </div>
            </div>
        </div>
        
        <div class="acciones-detalle">
            <h2>📜 Registro de Tus Acciones</h2>
            
            <?php if(empty($acciones)): ?>
                <div class="vacio-mensaje">
                    No se registraron acciones durante tu travesía...
                </div>
            <?php else: ?>
                <?php foreach($acciones as $accion): ?>
                    <div class="accion-realizada <?php echo $accion['tipo'] == 'buena' ? 'accion-buena' : 'accion-mala'; ?>">
                        <span class="accion-nombre"><?php echo htmlspecialchars($accion['nombre']); ?></span>
                        <span class="accion-karma <?php echo $accion['karma'] > 0 ? 'karma-pos' : 'karma-neg'; ?>">
                            <?php echo ($accion['karma'] > 0 ? '+' : '') . $accion['karma']; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="botones">
            <a href="?nuevo=1" class="btn btn-nuevo">
                🔄 Juzgar Otro Marinero
            </a>
        </div>
    </div>
</body>
</html>
