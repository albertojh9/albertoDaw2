<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏴‍☠️ Bienvenido al Juicio Pirata</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow: hidden;
        }
        
        .waves {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            opacity: 0.3;
            z-index: 0;
        }
        
        .container {
            max-width: 700px;
            background: rgba(0, 0, 0, 0.9);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
            border: 4px solid #d4af37;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .skull-icon {
            font-size: 8em;
            margin-bottom: 20px;
            animation: swing 3s ease-in-out infinite;
        }
        
        @keyframes swing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }
        
        h1 {
            color: #d4af37;
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
            letter-spacing: 3px;
        }
        
        .subtitle {
            color: #ccc;
            font-size: 1.4em;
            margin-bottom: 30px;
            font-style: italic;
            line-height: 1.6;
        }
        
        .description {
            color: #aaa;
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 40px;
            text-align: left;
            background: rgba(212, 175, 55, 0.1);
            padding: 25px;
            border-radius: 10px;
            border-left: 4px solid #d4af37;
        }
        
        .warning {
            background: rgba(255, 107, 107, 0.2);
            border: 2px solid #ff6b6b;
            color: #ff6b6b;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: bold;
        }
        
        .btn-start {
            display: inline-block;
            padding: 20px 50px;
            font-size: 1.5em;
            font-weight: bold;
            background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            color: #000;
            text-decoration: none;
            border-radius: 15px;
            text-transform: uppercase;
            letter-spacing: 3px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.3);
        }
        
        .btn-start:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.5);
        }
        
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .feature {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            font-size: 0.95em;
            color: #ccc;
        }
        
        .feature-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#1e3c72" fill-opacity="1" d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,96C960,96,1056,160,1152,165.3C1248,171,1344,117,1392,90.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>

    <div class="container">
        <div class="skull-icon float">⚓</div>
        
        <h1>EL JUICIO PIRATA</h1>
        
        <p class="subtitle">
            "Las mareas juzgan a quien navega los siete mares..."
        </p>
        
        <div class="description">
            <p>
                🏴‍☠️ Bienvenido, marinero. Has navegado por aguas traicioneras y cometido acciones 
                tanto nobles como ruines. Llegó el momento de enfrentar el juicio de las mareas.
            </p>
            <br>
            <p>
                Tu karma determinará tu destino eterno: ¿Navegarás hacia los cielos donde el ron 
                fluye infinito, o descenderás al casillero de Davy Jones para servir eternamente 
                en su tripulación fantasma?
            </p>
        </div>
        
        <div class="features">
            <div class="feature">
                <div class="feature-icon">✨</div>
                <strong>5 Acciones Nobles</strong><br>
                Rescates, honor y valentía
            </div>
            <div class="feature">
                <div class="feature-icon">💀</div>
                <strong>5 Acciones Ruines</strong><br>
                Traición, codicia y deshonor
            </div>
            <div class="feature">
                <div class="feature-icon">⚖️</div>
                <strong>Sistema de Karma</strong><br>
                Cada acción tiene su peso
            </div>
            <div class="feature">
                <div class="feature-icon">🌊</div>
                <strong>3 Destinos Posibles</strong><br>
                Cielo, Abismo o Limbo
            </div>
        </div>
        
        <div class="warning">
            ⚠️ ADVERTENCIA: Las decisiones que tomes definirán tu eternidad ⚠️
        </div>
        
        <a href="diario_marinero.php" class="btn-start">
            ⚔️ Iniciar Juicio ⚔️
        </a>
    </div>
</body>
</html>
