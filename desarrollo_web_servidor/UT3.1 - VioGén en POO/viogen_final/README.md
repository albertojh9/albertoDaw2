# Sistema VioGén - Documentación Técnica

## Descripción
Sistema de Valoración Policial del Riesgo desarrollado en PHP con patrón MVC.

## Credenciales
- **Usuario:** abcd
- **Contraseña:** 1234

---

## Estructura del Proyecto

```
viogen/
├── index.php                    # Punto de entrada único con middleware
├── config/
│   ├── config.php               # Todas las constantes
│   └── Database.php             # Conexión BD (Singleton)
├── controllers/
│   ├── LoginController.php      # Login y Logout
│   ├── MenuController.php       # Menú y buscador
│   ├── VictimaController.php    # Registro de víctimas
│   └── AgresionController.php   # Registro de agresiones
├── models/
│   ├── Usuario.php              # Modelo de usuario
│   ├── Victima.php              # Modelo de víctima
│   └── Agresion.php             # Modelo de agresión
├── views/
│   ├── login/login.php          # Formulario de login
│   ├── menu/menu.php            # Menú con buscador
│   ├── victima/crear.php        # Formulario víctima
│   └── agresion/crear.php       # Formulario agresión
└── sql/
    ├── viogen.sql               # Creación de BD
    └── datos_viogen.sql         # Datos iniciales
```

---

## Patrón MVC

### Modelo (Model)
Gestiona datos y lógica de negocio.

**Usuario.php**
- `verificarCredenciales($nombre, $clave)`: Retorna ID si es válido

**Victima.php**
- `crear($datos)`: Inserta víctima
- `obtenerTodas()`: Lista todas las víctimas
- `validarNIF($nif)`: Valida formato NIF (8 números + 1 letra)
- `validarNIE($nie)`: Valida formato NIE (X/Y/Z + 7 números + 1 letra)

**Agresion.php**
- `crear($datos)`: Inserta agresión
- `buscar($texto)`: Busca en todos los campos textuales

### Vista (View)
Solo muestra información, sin lógica.

**login.php**: Formulario de login
**menu.php**: Menú principal con buscador
**victima/crear.php**: Formulario de registro de víctima
**agresion/crear.php**: Formulario de registro de agresión

### Controlador (Controller)
Gestiona el flujo.

**LoginController**
- `index()`: Muestra formulario
- `login()`: Procesa login
- `logout()`: Cierra sesión

**MenuController**
- `index()`: Muestra menú y procesa búsqueda

**VictimaController**
- `crear()`: Muestra formulario
- `guardar()`: Procesa registro

**AgresionController**
- `crear()`: Muestra formulario
- `guardar()`: Procesa registro

---

## Middleware de Autenticación

El archivo `index.php` contiene el middleware más simple:

```php
// Define rutas públicas (sin login)
$rutasPublicas = [
    'login' => ['index', 'login']
];

// Si necesita login y NO hay sesión -> ERROR 401
if ($necesitaLogin && !isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    // Mostrar página 401
    exit;
}
```

**Funcionamiento:**
1. Todas las rutas requieren login EXCEPTO las definidas en `$rutasPublicas`
2. Si intentas acceder sin login → Error 401
3. Tras login exitoso se guarda solo `$_SESSION['usuario_id']`

---

## Casos de Uso

### 1. Login
- Campos: nombre (4+ caracteres), clave (4+ caracteres)
- Crea sesión solo con ID de usuario
- Va al menú principal tras éxito
- Muestra error si falla

### 2. Logout
- Destruye la sesión completamente
- Vuelve al login

### 3. Registro de Víctima
- Campos opcionales: nombre, apellidos, tipo_documento, documento, teléfono, observaciones
- **Regla:** Al menos nombre u observaciones
- Valida NIF/NIE si se proporciona
- Vuelve al menú con mensaje de confirmación

### 4. Registro de Agresión
- Campos obligatorios: víctima, tipo_agresion, fecha_hora
- Campos opcionales: agresor, observaciones
- Tipos: física, psicológica, sexual, vicaria
- Vuelve al menú con mensaje de confirmación

### 5. Informe de Agresiones
- Buscador en menú principal
- Busca en todos los campos textuales
- Muestra tabla con:
  - Nombre completo víctima
  - Tipo de agresión
  - Fecha de agresión
- Ordenado por fecha descendente
- Informa si no hay resultados

---

## Base de Datos

**Configuración:**
- Host: localhost
- Base de datos: viogen
- Usuario: uviogen
- Contraseña: cviogen

**Tablas:**

```sql
Usuario (id, nombre, clave)
Victima (id, nombre, apellidos, tipo_documento, documento, telefono, observaciones)
Agresion (id, id_victima, agresor, tipo_agresion, fecha_hora, observaciones)
```

---

## Seguridad

### Sanitización
Todos los datos se sanitizan con:
```php
htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8')
```

### Prepared Statements
Todas las consultas usan PDO con parámetros:
```php
$stmt->execute([':nombre' => $nombre]);
```

### Sesión Segura
- Solo se guarda el ID del usuario
- Se regenera el ID tras login: `session_regenerate_id(true)`

### Validación
- Longitud mínima (4 caracteres)
- Validación de NIF: 8 números + 1 letra (formato básico)
- Validación de NIE: X/Y/Z + 7 números + 1 letra (formato básico)

---

## Configuración (config.php)

Todas las constantes en un solo archivo:

```php
// Base de datos
DB_HOST, DB_NAME, DB_USER, DB_PASS

// Rutas
BASE_PATH, CONTROLLERS_PATH, MODELS_PATH, VIEWS_PATH

// Tipos válidos
TIPOS_DOCUMENTO = ['NIF', 'NIE', 'Pasaporte']
TIPOS_AGRESION = ['física', 'psicológica', 'sexual', 'vicaria']

// Mensajes
MSG_LOGIN_ERROR, MSG_VICTIMA_OK, etc.
```


## Flujo de la Aplicación

1. Usuario accede a `index.php`
2. **Middleware verifica sesión**
3. Si no hay sesión y necesita login → 401
4. Si hay sesión o es ruta pública → continúa
5. Carga modelos y controlador
6. Ejecuta acción
7. Controlador carga vista

## Tecnologías

- PHP 7.4+
- MySQL/MariaDB
- PDO
- HTML5
- Patrón MVC
- Patrón Singleton (Database)

---

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Extensión PDO
- Extensión pdo_mysql

---

## Autor
Alberto - DAW 2º - IES Castelar
