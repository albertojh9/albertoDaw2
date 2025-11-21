# Sistema VioGén - Documentación Técnica

## Descripción General

Sistema de Valoración Policial del Riesgo desarrollado en PHP siguiendo el patrón de arquitectura MVC (Modelo-Vista-Controlador).

## Credenciales de Acceso

- **Usuario:** abcd
- **Contraseña:** 1234

## Estructura del Proyecto

```
viogen/
├── index.php                      # Punto de entrada único (Front Controller)
├── config/
│   ├── config.php                 # Constantes de configuración
│   └── Database.php               # Clase de conexión a BD (Singleton)
├── controllers/
│   ├── LoginController.php        # Controlador de autenticación
│   ├── MenuController.php         # Controlador del menú principal
│   ├── VictimaController.php      # Controlador de víctimas
│   └── AgresionController.php     # Controlador de agresiones
├── models/
│   ├── Usuario.php                # Modelo de usuario
│   ├── Victima.php                # Modelo de víctima
│   └── Agresion.php               # Modelo de agresión
├── views/
│   ├── login/
│   │   └── login.php              # Vista del formulario de login
│   ├── menu/
│   │   └── menu.php               # Vista del menú principal con buscador
│   ├── victima/
│   │   └── crear.php              # Vista de registro de víctima
│   └── agresion/
│       └── crear.php              # Vista de registro de agresión
├── sql/
│   ├── viogen.sql                 # Creación de base de datos
│   └── datos_viogen.sql           # Datos iniciales
└── README.md                      # Esta documentación
```

## Patrón MVC Implementado

### Modelo (Model)

Los modelos gestionan las operaciones de base de datos y la lógica de negocio.

- **Usuario.php**: Gestiona autenticación de usuarios.
  - `buscarPorNombre()`: Busca un usuario por nombre.
  - `verificarCredenciales()`: Valida usuario y contraseña.
  - `validarLogin()`: Valida los datos del formulario de login.

- **Victima.php**: Gestiona el registro de víctimas.
  - `crear()`: Inserta una nueva víctima.
  - `obtenerTodas()`: Obtiene listado de víctimas.
  - `obtenerPorId()`: Obtiene una víctima por ID.
  - `validar()`: Valida los datos de la víctima.
  - `validarDocumento()`: Valida NIF, NIE o Pasaporte.

- **Agresion.php**: Gestiona el registro de agresiones.
  - `crear()`: Inserta una nueva agresión.
  - `buscar()`: Busca agresiones por texto en todos los campos.
  - `obtenerTodas()`: Obtiene listado de agresiones.
  - `validar()`: Valida los datos de la agresión.

### Vista (View)

Las vistas solo muestran información y formularios, sin lógica de negocio.

- **login.php**: Formulario de inicio de sesión con manejo de errores.
- **menu.php**: Menú principal con buscador de agresiones y tabla de resultados.
- **victima/crear.php**: Formulario de registro de víctima.
- **agresion/crear.php**: Formulario de registro de agresión.

### Controlador (Controller)

Los controladores gestionan el flujo de la aplicación.

- **LoginController.php**: Gestiona el flujo de autenticación.
  - `index()`: Muestra el formulario de login.
  - `login()`: Procesa el login.
  - `logout()`: Cierra la sesión.

- **MenuController.php**: Gestiona el menú principal.
  - `index()`: Muestra el menú principal con buscador.

- **VictimaController.php**: Gestiona el registro de víctimas.
  - `crear()`: Muestra el formulario de registro.
  - `guardar()`: Procesa el registro de víctima.

- **AgresionController.php**: Gestiona el registro de agresiones.
  - `crear()`: Muestra el formulario de registro.
  - `guardar()`: Procesa el registro de agresión.

## Flujo de la Aplicación

1. Todas las peticiones pasan por `index.php` (Front Controller).
2. El middleware verifica si la ruta requiere autenticación.
3. Si requiere autenticación y no hay sesión, devuelve error 401.
4. Se cargan los modelos necesarios.
5. Se carga e instancia el controlador correspondiente.
6. Se ejecuta la acción solicitada.
7. El controlador carga la vista apropiada con los datos.

## Casos de Uso Implementados

### 1. Login
- Formulario con campos nombre y clave.
- Validación de longitud mínima (4 caracteres).
- Creación de sesión con ID de usuario (no la clave).
- Redirección a menú principal tras login exitoso.
- Mensajes de error en caso de fallo.

### 2. Logout
- Destrucción completa de la sesión.
- Eliminación de cookie de sesión.
- Redirección a la vista de login.

### 3. Registro de Víctima
- Campos: nombre, apellidos, tipo documento, documento, teléfono, observaciones.
- Todos los campos opcionales, pero debe haber nombre u observaciones.
- Validación de NIF, NIE y Pasaporte.
- Mensaje de confirmación tras registro exitoso.
- Retorno al menú principal.

### 4. Registro de Agresión
- Campos: víctima (obligatorio), agresor, tipo agresión (obligatorio), fecha/hora (obligatorio), observaciones.
- Selector de víctimas registradas.
- Tipos de agresión: física, psicológica, sexual, vicaria.
- Mensaje de confirmación tras registro exitoso.
- Retorno al menú principal.

### 5. Informe de Agresiones
- Buscador en el menú principal.
- Búsqueda en todos los campos textuales (nombre, apellidos, teléfono, observaciones).
- Tabla de resultados con:
  - Nombre completo de la víctima
  - Tipo de agresión
  - Fecha de la agresión
- Resultados ordenados por fecha descendente.
- Mensaje si no hay resultados.

## Características de Seguridad

### Autenticación
- Sesiones PHP con `session_regenerate_id()` tras login exitoso.
- Solo se guarda el ID del usuario en sesión (no la contraseña).
- Middleware de autenticación en el Front Controller.
- Error 401 para accesos no autorizados.

### Sanitización
- Todos los datos de entrada se sanitizan antes de procesarse.
- Uso de `htmlspecialchars()` para prevenir XSS.
- Uso de `trim()` y `stripslashes()` para limpiar datos.

### Validación
- Nombre de usuario: mínimo 4 caracteres.
- Contraseña: mínimo 4 caracteres.
- Campos obligatorios validados en servidor.
- Validación de documentos (NIF, NIE, Pasaporte) con algoritmo de letra.

### Prepared Statements
- Uso de PDO con prepared statements para prevenir SQL Injection.
- Todas las consultas usan parámetros vinculados.

## Base de Datos

### Configuración
- **Host**: localhost
- **Base de datos**: viogen
- **Usuario**: uviogen
- **Contraseña**: cviogen
- **Charset**: utf8mb4

### Tablas

#### Usuario
- `id`: INT, clave primaria, auto-incremento
- `nombre`: VARCHAR(64), no nulo, mínimo 4 caracteres
- `clave`: VARCHAR(128), no nulo, mínimo 4 caracteres

#### Victima
- `id`: INT, clave primaria, auto-incremento
- `nombre`: VARCHAR(128), opcional
- `apellidos`: VARCHAR(128), opcional
- `tipo_documento`: ENUM('NIF', 'NIE', 'Pasaporte')
- `documento`: VARCHAR(64), opcional
- `telefono`: VARCHAR(128), opcional
- `observaciones`: TEXT, opcional
- CHECK: nombre o observaciones deben tener valor

#### Agresion
- `id`: INT, clave primaria, auto-incremento
- `id_victima`: INT, clave foránea, no nulo
- `agresor`: TEXT, opcional
- `tipo_agresion`: ENUM('física', 'psicológica', 'sexual', 'vicaria'), no nulo
- `fecha_hora`: DATETIME, no nulo
- `observaciones`: TEXT, opcional

## Constantes de Configuración

Todas las constantes están definidas en `config/config.php`:

### Base de Datos
- DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET

### Rutas
- BASE_PATH, CONTROLLERS_PATH, MODELS_PATH, VIEWS_PATH

### Sesión
- SESSION_NAME, SESSION_LIFETIME

### Tipos Válidos
- TIPOS_DOCUMENTO: ['NIF', 'NIE', 'Pasaporte']
- TIPOS_AGRESION: ['física', 'psicológica', 'sexual', 'vicaria']

### Mensajes
- MSG_LOGIN_ERROR, MSG_LOGIN_REQUIRED, MSG_LOGOUT_SUCCESS
- MSG_FIELD_REQUIRED, MSG_MIN_LENGTH
- MSG_VICTIMA_REGISTRADA, MSG_AGRESION_REGISTRADA
- MSG_ERROR_REGISTRO, MSG_NOMBRE_O_OBS_REQUERIDO, MSG_DOCUMENTO_INVALIDO

## Tecnologías Utilizadas

- PHP 7.4+
- MySQL/MariaDB
- PDO para acceso a base de datos
- HTML5 para las vistas
- Patrón Singleton para conexión a BD

## Código Limpio

El proyecto sigue las siguientes prácticas:
- Nombres descriptivos para variables, funciones y clases.
- Comentarios de documentación en todas las clases y métodos.
- Separación clara de responsabilidades (MVC).
- Indentación consistente.
- Sin código duplicado.
- URLs relativas en todo el proyecto.

## Instalación

1. Ejecutar el script de creación de base de datos:
```bash
mysql -u root -p < sql/viogen.sql
```

2. Ejecutar el script de datos iniciales:
```bash
mysql -u root -p < sql/datos_viogen.sql
```

3. Configurar el servidor web para apuntar a la carpeta del proyecto.

4. Acceder a `index.php` en el navegador.

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o MariaDB 10.3 o superior
- Extensión PDO de PHP
- Extensión pdo_mysql de PHP

## Autor

Alberto - DAW 2º - IES Castelar

## Versión

1.0.0
