# Documentación Técnica - Sistema VioGen

## Información General

**Nombre del Proyecto:** Sistema VioGen  
**Versión:** 1.0  
**Autor:** Alberto  
**Fecha:** 2024  

## Descripción

El Sistema VioGen es una aplicación web desarrollada en PHP que permite gestionar el registro de víctimas de violencia de género y las agresiones sufridas. La aplicación sigue el patrón de arquitectura MVC (Modelo-Vista-Controlador) y utiliza MySQL como sistema gestor de base de datos.

## Requisitos del Sistema

- **Servidor Web:** Apache con mod_rewrite habilitado
- **PHP:** Versión 7.4 o superior
- **Base de Datos:** MySQL 5.7 o superior / MariaDB 10.3 o superior
- **Extensiones PHP requeridas:**
  - PDO
  - PDO_MySQL
  - Session

## Estructura del Proyecto

```
ProyectoViogen/
├── config.php                    # Configuración del sistema
├── index.php                     # Punto de entrada único (Front Controller)
├── controlador/
│   ├── LoginControlador.php      # Control de autenticación
│   ├── MenuControlador.php       # Control del menú principal
│   ├── VictimaControlador.php    # Control de víctimas
│   ├── AgresionControlador.php   # Control de agresiones
│   └── InformeControlador.php    # Control de informes/búsqueda
├── modelo/
│   ├── BaseDatos.php             # Conexión a BD (Singleton)
│   ├── Usuario.php               # Modelo de usuarios
│   ├── Victima.php               # Modelo de víctimas
│   └── Agresion.php              # Modelo de agresiones
├── vista/
│   ├── login.php                 # Vista de login
│   ├── menu.php                  # Vista del menú principal
│   ├── registrarVictima.php      # Vista de registro de víctima
│   ├── registrarAgresion.php     # Vista de registro de agresión
│   ├── error401.php              # Vista de error 401
│   └── style.css                 # Estilos CSS
└── sql/
    ├── viogen.sql                # Script de creación de BD
    └── datos_viogen.sql          # Datos iniciales
```

## Patrón de Arquitectura MVC

### Modelo
Los modelos se encargan de la lógica de negocio y el acceso a datos:

- **BaseDatos.php:** Implementa el patrón Singleton para gestionar la conexión PDO a la base de datos.
- **Usuario.php:** Gestiona la verificación de credenciales y consultas de usuarios.
- **Victima.php:** Gestiona las operaciones CRUD de víctimas y búsquedas.
- **Agresion.php:** Gestiona las operaciones CRUD de agresiones y búsquedas complejas.

### Vista
Las vistas se encargan de la presentación de datos:

- Todas las vistas utilizan HTML5 semántico
- Los estilos se centralizan en `style.css`
- Los datos se escapan con `htmlspecialchars()` para prevenir XSS

### Controlador
Los controladores gestionan la lógica de la aplicación:

- **LoginControlador:** Gestiona login, logout y validación de sesiones
- **MenuControlador:** Gestiona la vista del menú principal
- **VictimaControlador:** Gestiona el registro de víctimas con validaciones
- **AgresionControlador:** Gestiona el registro de agresiones
- **InformeControlador:** Gestiona la búsqueda de agresiones

## Base de Datos

### Configuración
- **Base de datos:** viogen
- **Usuario:** uviogen
- **Contraseña:** cviogen
- **Charset:** utf8mb4

### Tablas

#### usuarios
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT AUTO_INCREMENT | Clave primaria |
| nombre_usuario | VARCHAR(50) | Nombre de usuario único |
| clave | VARCHAR(255) | Contraseña con hash SHA256 |
| fecha_creacion | TIMESTAMP | Fecha de creación |

#### victimas
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT AUTO_INCREMENT | Clave primaria |
| nombre | VARCHAR(100) | Nombre de la víctima |
| apellidos | VARCHAR(150) | Apellidos |
| tipo_documento | ENUM | NIF, NIE, Pasaporte |
| numero_documento | VARCHAR(20) | Número del documento |
| telefono | VARCHAR(20) | Teléfono de contacto |
| observaciones | TEXT | Observaciones |
| fecha_registro | TIMESTAMP | Fecha de registro |
| usuario_id | INT | FK a usuarios |

#### agresiones
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT AUTO_INCREMENT | Clave primaria |
| victima_id | INT | FK a víctimas (obligatorio) |
| agresor | VARCHAR(255) | Descripción del agresor |
| tipo_agresion | ENUM | fisica, psicologica, sexual, vicaria |
| fecha_hora | DATETIME | Fecha y hora de la agresión |
| observaciones | TEXT | Observaciones |
| fecha_registro | TIMESTAMP | Fecha de registro |
| usuario_id | INT | FK a usuarios |

## Seguridad

### Autenticación
- Las contraseñas se almacenan con hash SHA256
- La sesión almacena solo el ID del usuario, nunca la contraseña
- El middleware de autenticación en `index.php` protege todas las rutas excepto login

### Sanitización
Todos los campos de entrada se sanitizan antes de almacenarse:
- `htmlspecialchars()` con ENT_QUOTES y UTF-8
- `trim()` para eliminar espacios
- Consultas preparadas (PDO) para prevenir SQL Injection

### Validación
- Validación de NIF/NIE con algoritmo de letra
- Validación de Pasaporte (mínimo 5 caracteres alfanuméricos)
- Validación de longitud mínima en usuario y contraseña
- Validación de campos obligatorios

## Funcionalidades

### 1. Login/Logout
- Autenticación con nombre de usuario (mín. 4 caracteres) y contraseña (mín. 4 caracteres)
- Creación de sesión con ID de usuario
- Destrucción de sesión al cerrar

### 2. Registro de Víctima
- Campos: Nombre, Apellidos, Tipo documento, Número documento, Teléfono, Observaciones
- Todos los campos son opcionales
- Regla: Debe haber al menos nombre u observaciones
- Validación de documentos según tipo

### 3. Registro de Agresión
- Campos: Víctima (obligatorio), Agresor, Tipo agresión (obligatorio), Fecha/Hora (obligatorio), Observaciones
- Tipos de agresión: Física, Psicológica, Sexual, Vicaria

### 4. Informe de Agresiones
- Búsqueda en todos los campos textuales
- Resultados ordenados por fecha descendente
- Muestra: Nombre completo, Tipo de agresión, Fecha

## Códigos de Error HTTP

- **200:** OK - Operación exitosa
- **401:** Unauthorized - No autenticado (requiere login)

## Mensajes del Sistema

Los mensajes están centralizados en `config.php`:
- `MSG_LOGIN_EXITO`: "Sesión iniciada correctamente"
- `MSG_LOGIN_ERROR`: "Usuario o contraseña incorrectos"
- `MSG_LOGOUT_EXITO`: "Sesión cerrada correctamente"
- `MSG_VICTIMA_REGISTRADA`: "Víctima registrada correctamente"
- `MSG_AGRESION_REGISTRADA`: "Agresión registrada correctamente"
- `MSG_ERROR_CAMPOS`: "Por favor, complete los campos requeridos"
- `MSG_ERROR_DOCUMENTO`: "El documento de identificación no es válido"

## Flujo de la Aplicación

1. Usuario accede a `index.php`
2. Si no está autenticado → Mostrar login
3. Si está autenticado → Mostrar menú principal
4. Desde el menú puede:
   - Registrar víctimas
   - Registrar agresiones
   - Buscar agresiones
   - Cerrar sesión

## Consideraciones Técnicas

### URLs Relativas
Todas las URLs del sistema son relativas, utilizando el parámetro `accion` para el enrutamiento.

### Sesiones
- Nombre de sesión: `viogen_session`
- Tiempo de vida: 3600 segundos (1 hora)
- Zona horaria: Europe/Madrid

### Conexión a Base de Datos
- Implementación con patrón Singleton
- Modo de errores: Excepciones
- Modo de fetch: Array asociativo
- Sin emulación de prepares (mayor seguridad)

## Datos de Prueba

Usuario del sistema:
- **Usuario:** abcd
- **Contraseña:** 1234

El script `datos_viogen.sql` incluye:
- 1 usuario de prueba
- 5 víctimas de ejemplo
- 7 agresiones de ejemplo

## Autor

**Alberto**  
IES Castelar - Badajoz  
DAW - Desarrollo de Aplicaciones Web  
Curso 2024/2025
