# README - Proyecto VioGen

## Nuevas Implementaciones

Este documento detalla todas las nuevas funcionalidades implementadas en el proyecto y su ubicación exacta en el código.

---

## 1. Sistema de Autenticación (Login/Logout)

### Archivos creados:
- **`controlador/LoginControlador.php`** - Controlador completo de autenticación
- **`modelo/Usuario.php`** - Modelo para verificar credenciales
- **`vista/login.php`** - Vista del formulario de login

### Implementaciones específicas:

| Funcionalidad | Archivo | Líneas/Función |
|---------------|---------|----------------|
| Verificar credenciales con SHA256 | `modelo/Usuario.php` | `verificarCredenciales()` |
| Crear sesión con ID usuario | `controlador/LoginControlador.php` | `procesarLogin()` líneas 35-37 |
| Validar longitud mínima (4 chars) | `controlador/LoginControlador.php` | `procesarLogin()` líneas 25-27 |
| Destruir sesión (logout) | `controlador/LoginControlador.php` | `logout()` |
| Middleware autenticación | `index.php` | Líneas 12-19 |
| Error HTTP 401 | `index.php` | Líneas 15-18 |

---

## 2. Registro de Víctima

### Archivos creados:
- **`controlador/VictimaControlador.php`** - Controlador con validaciones
- **`modelo/Victima.php`** - Modelo CRUD de víctimas
- **`vista/registrarVictima.php`** - Formulario de registro

### Implementaciones específicas:

| Funcionalidad | Archivo | Líneas/Función |
|---------------|---------|----------------|
| Campos: nombre, apellidos, tipo_doc, telefono, observaciones | `vista/registrarVictima.php` | Líneas 45-75 |
| Validación NIF español | `controlador/VictimaControlador.php` | `validarNIF()` líneas 96-108 |
| Validación NIE español | `controlador/VictimaControlador.php` | `validarNIE()` líneas 115-136 |
| Validación Pasaporte | `controlador/VictimaControlador.php` | `validarDocumento()` línea 91 |
| Regla: al menos nombre u observaciones | `controlador/VictimaControlador.php` | `guardarVictima()` líneas 43-47 |
| Sanitización de campos | `controlador/VictimaControlador.php` | `guardarVictima()` líneas 32-39 |
| Todos los campos opcionales | `vista/registrarVictima.php` | Sin atributo `required` |

---

## 3. Registro de Agresión

### Archivos creados:
- **`controlador/AgresionControlador.php`** - Controlador con validaciones
- **`modelo/Agresion.php`** - Modelo CRUD de agresiones
- **`vista/registrarAgresion.php`** - Formulario de registro

### Implementaciones específicas:

| Funcionalidad | Archivo | Líneas/Función |
|---------------|---------|----------------|
| Campo Víctima (obligatorio) | `vista/registrarAgresion.php` | Líneas 46-58 |
| Campo Agresor (texto, no obligatorio) | `vista/registrarAgresion.php` | Líneas 60-66 |
| Tipo agresión: física, psicológica, sexual, vicaria | `config.php` | `TIPOS_AGRESION` líneas 33-38 |
| Campo Fecha y Hora (obligatorio) | `vista/registrarAgresion.php` | Líneas 77-86 |
| Campo Observaciones | `vista/registrarAgresion.php` | Líneas 88-92 |
| Validación campos obligatorios | `controlador/AgresionControlador.php` | Líneas 49-70 |
| Sanitización de campos | `controlador/AgresionControlador.php` | Líneas 35-42 |

---

## 4. Informe de Agresiones (Buscador)

### Archivos creados:
- **`controlador/InformeControlador.php`** - Controlador de búsqueda
- **`modelo/Agresion.php`** - Método de búsqueda completa

### Implementaciones específicas:

| Funcionalidad | Archivo | Líneas/Función |
|---------------|---------|----------------|
| Buscador en menú principal | `vista/menu.php` | Líneas 38-46 |
| Búsqueda en TODOS los campos textuales | `modelo/Agresion.php` | `buscar()` líneas 44-75 |
| Resultados: nombre completo, tipo, fecha | `vista/menu.php` | Líneas 54-67 |
| Ordenación por fecha descendente | `modelo/Agresion.php` | `buscar()` línea 72 |
| Sanitización texto búsqueda | `controlador/InformeControlador.php` | Líneas 29-33 |

---

## 5. Punto de Entrada Único con Middleware

### Archivo creado:
- **`index.php`** - Front Controller

### Implementaciones específicas:

| Funcionalidad | Archivo | Líneas |
|---------------|---------|--------|
| Middleware de autenticación | `index.php` | 12-19 |
| Error 401 Unauthorized | `index.php` | 15-18 |
| Enrutamiento por acción | `index.php` | 21-73 |
| Acciones públicas (login) | `index.php` | 10 |

---

## 6. Archivo de Configuración

### Archivo creado:
- **`config.php`** - Todas las constantes

### Implementaciones específicas:

| Constante | Línea | Descripción |
|-----------|-------|-------------|
| `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` | 14-17 | Configuración BD |
| `TIPOS_DOCUMENTO` | 30 | Array de tipos permitidos |
| `TIPOS_AGRESION` | 33-38 | Array de tipos de agresión |
| `MIN_LENGTH_USUARIO`, `MIN_LENGTH_CLAVE` | 41-42 | Validaciones de longitud |
| Mensajes del sistema | 45-52 | Mensajes centralizados |

---

## 7. Base de Datos

### Archivos creados:
- **`sql/viogen.sql`** - Creación de BD, usuario y tablas
- **`sql/datos_viogen.sql`** - Datos iniciales

### Implementaciones específicas:

| Elemento | Archivo | Descripción |
|----------|---------|-------------|
| Base de datos `viogen` | `viogen.sql` | Líneas 6-7 |
| Usuario `uviogen`/`cviogen` | `viogen.sql` | Líneas 10-12 |
| Tabla `usuarios` | `viogen.sql` | Líneas 17-22 |
| Tabla `victimas` | `viogen.sql` | Líneas 25-36 |
| Tabla `agresiones` | `viogen.sql` | Líneas 39-51 |
| Usuario `abcd`/`1234` | `datos_viogen.sql` | Líneas 8-9 |
| Índices para búsquedas | `viogen.sql` | Líneas 54-58 |

---

## 8. Seguridad

### Implementaciones distribuidas:

| Funcionalidad | Archivo | Ubicación |
|---------------|---------|-----------|
| Sanitización con `htmlspecialchars()` | Todos los controladores | En cada `guardar*()` |
| Consultas preparadas PDO | Todos los modelos | Todos los métodos |
| Hash SHA256 para contraseñas | `modelo/Usuario.php` | `verificarCredenciales()` |
| Sesión sin contraseña | `controlador/LoginControlador.php` | `procesarLogin()` líneas 35-36 |
| Escape en vistas | Todas las vistas | Todos los `echo` |

---

## 9. Estructura MVC

### Directorios creados:

```
ProyectoViogen/
├── config.php                    # NUEVO - Configuración centralizada
├── index.php                     # NUEVO - Punto de entrada único
├── DOCUMENTACION.md              # NUEVO - Documentación técnica
├── README.md                     # NUEVO - Este archivo
├── controlador/                  # NUEVO - Carpeta de controladores
│   ├── LoginControlador.php      # NUEVO
│   ├── MenuControlador.php       # NUEVO
│   ├── VictimaControlador.php    # NUEVO
│   ├── AgresionControlador.php   # NUEVO
│   └── InformeControlador.php    # NUEVO
├── modelo/                       # NUEVO - Carpeta de modelos
│   ├── BaseDatos.php             # NUEVO - Singleton conexión
│   ├── Usuario.php               # NUEVO
│   ├── Victima.php               # NUEVO
│   └── Agresion.php              # NUEVO
├── vista/                        # NUEVO - Carpeta de vistas
│   ├── login.php                 # NUEVO
│   ├── menu.php                  # NUEVO
│   ├── registrarVictima.php      # NUEVO
│   ├── registrarAgresion.php     # NUEVO
│   ├── error401.php              # NUEVO
│   └── style.css                 # NUEVO
└── sql/                          # NUEVO - Scripts SQL
    ├── viogen.sql                # NUEVO
    └── datos_viogen.sql          # NUEVO
```

---

## 10. Características Adicionales

| Característica | Archivo | Descripción |
|----------------|---------|-------------|
| URLs relativas | Todo el proyecto | Sin URLs absolutas |
| Mensajes de confirmación/error | Controladores y vistas | Feedback al usuario |
| Redirección al menú tras registro | Controladores | Tras éxito |
| Permanencia en vista tras error | Controladores | Mantiene datos |
| Diseño responsive | `vista/style.css` | Media queries |
| Badges por tipo agresión | `vista/style.css` y `menu.php` | Colores distintivos |

---

## Credenciales de Prueba

- **Usuario:** abcd
- **Contraseña:** 1234

---

## Autor

**Alberto**  
IES Castelar - Badajoz  
DAW 2024/2025
