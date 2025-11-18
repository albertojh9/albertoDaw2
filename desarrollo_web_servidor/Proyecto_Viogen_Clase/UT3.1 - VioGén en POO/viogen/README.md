# Sistema VioGén - Documentación Técnica

## Descripción General

Sistema de Valoración Policial del Riesgo desarrollado en PHP siguiendo el patrón de arquitectura MVC (Modelo-Vista-Controlador).

## Estructura del Proyecto

```
viogen/
├── index.php              # Punto de entrada único (Front Controller)
├── config/
│   ├── config.php         # Constantes de configuración
│   └── Database.php       # Clase de conexión a BD (Singleton)
├── controllers/
│   ├── LoginController.php    # Controlador de autenticación
│   └── MenuController.php     # Controlador del menú principal
├── models/
│   └── Usuario.php        # Modelo de usuario
├── views/
│   ├── login/
│   │   └── login.php      # Vista del formulario de login
│   └── menu/
│       └── menu.php       # Vista del menú principal
├── datos_viogen.sql       # Datos iniciales de la BD
└── README.md              # Esta documentación
```

## Patrón MVC Implementado

### Modelo (Model)
- **Usuario.php**: Gestiona las operaciones de base de datos relacionadas con usuarios.
  - `buscarPorNombre()`: Busca un usuario por su nombre.
  - `verificarCredenciales()`: Valida usuario y contraseña.
  - `validarLogin()`: Valida los datos del formulario de login.

### Vista (View)
- **login.php**: Formulario de inicio de sesión con manejo de errores.
- **menu.php**: Menú principal con opciones de navegación.

### Controlador (Controller)
- **LoginController.php**: Gestiona el flujo de autenticación.
  - `index()`: Muestra el formulario de login.
  - `login()`: Procesa el login.
  - `logout()`: Cierra la sesión.
- **MenuController.php**: Gestiona el menú principal.
  - `index()`: Muestra el menú principal.

## Flujo de la Aplicación

1. Todas las peticiones pasan por `index.php` (Front Controller).
2. El middleware verifica si la ruta requiere autenticación.
3. Si requiere autenticación y no hay sesión, devuelve error 401.
4. Se carga el controlador y modelo correspondiente.
5. Se ejecuta la acción solicitada.
6. El controlador carga la vista apropiada.

## Características de Seguridad

### Autenticación
- Sesiones PHP con `session_regenerate_id()` tras login exitoso.
- Solo se guarda el ID del usuario en sesión (no la contraseña).
- Middleware de autenticación en el Front Controller.

### Sanitización
- Todos los datos de entrada se sanitizan antes de procesarse.
- Uso de `htmlspecialchars()` para prevenir XSS.
- Uso de prepared statements (PDO) para prevenir SQL Injection.

### Validación
- Nombre de usuario: mínimo 4 caracteres.
- Contraseña: mínimo 4 caracteres.
- Campos obligatorios validados en servidor.

## Base de Datos

### Configuración
- **Host**: localhost
- **Base de datos**: viogen
- **Usuario**: uviogen
- **Contraseña**: cviogen
- **Charset**: utf8mb4

### Tablas
- **Usuario**: Almacena credenciales de usuarios del sistema.
- **Victima**: Datos de las víctimas registradas.
- **Agresion**: Registro de agresiones vinculadas a víctimas.

## Casos de Uso Implementados

### Login
- Formulario con campos nombre y clave.
- Validación de longitud mínima (4 caracteres).
- Creación de sesión con ID de usuario.
- Redirección a menú principal tras login exitoso.

### Logout
- Destrucción completa de la sesión.
- Eliminación de cookie de sesión.
- Redirección a la vista de login.

## Constantes de Configuración

Todas las constantes están definidas en `config/config.php`:
- Conexión a base de datos (DB_HOST, DB_NAME, DB_USER, DB_PASS).
- Rutas del sistema (BASE_PATH, CONTROLLERS_PATH, etc.).
- Configuración de sesión (SESSION_NAME, SESSION_LIFETIME).
- Mensajes del sistema (MSG_LOGIN_ERROR, etc.).

## Tecnologías Utilizadas

- PHP 7.4+
- MySQL/MariaDB
- PDO para acceso a base de datos
- HTML5 + CSS3 para las vistas
- Patrón Singleton para conexión a BD

## Código Limpio

El proyecto sigue las siguientes prácticas:
- Nombres descriptivos para variables, funciones y clases.
- Comentarios de documentación en todas las clases y métodos.
- Separación clara de responsabilidades (MVC).
- Indentación consistente.
- Sin código duplicado.

## Datos de Prueba

Usuario inicial:
- **Nombre**: abcd
- **Contraseña**: 1234
