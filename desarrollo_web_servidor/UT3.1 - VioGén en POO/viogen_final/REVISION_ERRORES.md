# REVISIÓN DE ERRORES - Sistema VioGén

## Lista de Errores Verificados ✅

### Login
- ✅ **Crea la sesión de usuario:** Sí, en `LoginController.php` línea 48: `$_SESSION['usuario_id'] = $usuarioId;`
- ✅ **Configurado como middleware en index.php:** Sí, líneas 20-39 de `index.php`
- ✅ **Al fallar devuelve 401 o aviso:** Sí, líneas 31-38 devuelven HTTP 401
- ✅ **Va a menú principal:** Sí, línea 49 redirige al menú

### Menú Principal
- ✅ **Hay menú principal:** Sí, `views/menu/menu.php`
- ✅ **Tiene los enlaces correctos:** Sí, tiene:
  - Registrar Víctima
  - Registrar Agresión
  - Cerrar Sesión
  - Buscador de agresiones

### Logout
- ✅ **Destruye la sesión:** Sí, `LoginController.php` líneas 62-63: `$_SESSION = []; session_destroy();`
- ✅ **Vuelve a vista de login:** Sí, línea 66 redirige a `index.php`

### Registro de Víctima
- ✅ **Tiene los campos pedidos:** Sí, todos los campos (nombre, apellidos, tipo_documento, documento, teléfono, observaciones)
- ✅ **Valida correctamente:** Sí:
  - Valida que haya nombre u observaciones (líneas 40-44)
  - Valida NIF formato: 8 números + 1 letra (líneas 47-51)
  - Valida NIE formato: X/Y/Z + 7 números + 1 letra (líneas 52-56)
- ✅ **Inserta correctamente en BBDD:** Sí, `Victima.php` líneas 15-25 con prepared statements
- ✅ **Informa del resultado:** Sí:
  - Éxito: mensaje en sesión (línea 60)
  - Error: muestra error (líneas 43, 50, 55, 63)
- ✅ **Vuelve al menú principal:** Sí, línea 61 tras éxito

### Registro de Agresión
- ✅ **Tiene los campos pedidos:** Sí, todos (víctima, agresor, tipo_agresion, fecha_hora, observaciones)
- ✅ **Valida correctamente:** Sí, líneas 46-50:
  - Víctima obligatoria
  - Tipo de agresión obligatorio
  - Fecha obligatoria
- ✅ **Inserta correctamente en BBDD:** Sí, `Agresion.php` líneas 15-25 con prepared statements
- ✅ **Informa del resultado:** Sí:
  - Éxito: mensaje en sesión (línea 60)
  - Error: muestra error (línea 52, 70)
- ✅ **Vuelve al menú principal:** Sí, línea 61 tras éxito

### Informe de Agresiones
- ✅ **Tiene los campos pedidos:** Sí, muestra:
  - Nombre completo víctima
  - Tipo de agresión
  - Fecha de agresión
- ✅ **Muestra correctamente resultados:** Sí, tabla en `menu.php` líneas 36-60
- ✅ **Informa si no encuentra:** Sí, línea 62: "No se encontraron resultados"

### Otros Errores
- ✅ **NO permite accesos sin login:** Middleware en `index.php` verifica sesión
- ✅ **Existe fichero de configuración correcto:** Sí, `config/config.php` con todas las constantes
- ✅ **Existe documentación técnica:** Sí, `README.md` completo

---

## Errores Graves - Verificación ✅

### NO USA EL PATRÓN MVC VISTO EN CLASE
✅ **Correcto:** 
- Modelos en `models/`
- Vistas en `views/`
- Controladores en `controllers/`
- `index.php` como Front Controller

### USA URLs ABSOLUTAS
✅ **Correcto:** Todas las URLs son relativas:
```php
index.php?controller=menu&action=index
```

### USA TECNOLOGÍAS NO AUTORIZADAS
✅ **Correcto:** 
- Solo PHP
- Solo HTML
- Sin JavaScript
- Sin CSS

### PLAGIO
✅ **Correcto:** Código original

---

## Verificación de la Base de Datos

### Usuario de BD
✅ **Correcto:** `uviogen` con contraseña `cviogen` (según SQL proporcionado)

### Tablas
✅ **Correctas:** Estructura exacta del SQL proporcionado:
- `Usuario` con CHECK de longitud >= 4
- `Victima` con CHECK de nombre o observaciones
- `Agresion` con FOREIGN KEY y tipos correctos ('física', 'psicológica', 'sexual', 'vicaria')

### Usuario de prueba
✅ **Correcto:** `abcd` con contraseña `1234` en `datos_viogen.sql`

---

## Verificación de Seguridad

### Sanitización
✅ **Implementada:** Todos los controladores usan:
```php
htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8')
```

### Prepared Statements
✅ **Implementados:** Todos los modelos usan:
```php
$stmt->execute([':parametro' => $valor])
```

### Sesión Segura
✅ **Implementada:**
- Solo guarda ID: `$_SESSION['usuario_id']`
- Regenera ID: `session_regenerate_id(true)`
- Destruye completamente en logout

---

## Verificación de Middleware

### Estructura del Middleware (index.php)

```php
// Líneas 20-21: Define rutas públicas
$rutasPublicas = [
    'login' => ['index', 'login']
];

// Línea 24: Asume que necesita login
$necesitaLogin = true;

// Líneas 27-29: Verifica si es ruta pública
if (isset($rutasPublicas[$controller]) && in_array($action, $rutasPublicas[$controller])) {
    $necesitaLogin = false;
}

// Líneas 31-43: Si necesita login y NO hay sesión -> 401
if ($necesitaLogin && !isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    // ... página 401
    exit;
}
```

✅ **Funcionamiento correcto:**
1. Por defecto todo necesita login
2. Solo `login/index` y `login/login` son públicas
3. Si intentas acceder sin sesión → 401
4. Si tienes sesión → continúa

---

## Cumplimiento de la Rúbrica

### 1. Funcionalidad (10 puntos)
✅ **Maestro (10):** Los 5 casos de uso completamente implementados:
- Login ✅
- Logout ✅
- Registro Víctima ✅
- Registro Agresión ✅
- Informe Agresiones ✅

### 2. Corrección (10 puntos)
✅ **Maestro (10):** 0 errores detectados según lista

### Penalizaciones
✅ **0 puntos de penalización:**
- Código limpio con comentarios
- Patrón MVC correcto
- URLs relativas

---

## Puntos Clave del Código

### 1. Middleware Más Simple (index.php)
```php
// Solo estas 3 líneas son el middleware:
if ($necesitaLogin && !isset($_SESSION['usuario_id'])) {
    // Error 401
}
```

### 2. Login Solo Guarda ID (LoginController.php línea 48)
```php
$_SESSION['usuario_id'] = $usuarioId;  // NO guarda la clave
```

### 3. Sanitización (todos los controladores)
```php
htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8')
```

### 4. Prepared Statements (todos los modelos)
```php
$stmt->execute([':nombre' => $nombre])
```

### 5. Validación de Documentos (Victima.php)
```php
// NIF: verifica formato (8 números + 1 letra)
preg_match('/^[0-9]{8}[A-Z]$/', $nif)

// NIE: verifica formato (X/Y/Z + 7 números + 1 letra)
preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $nie)
```

---

## Estructura MVC Correcta

```
REQUEST → index.php (middleware) → Controller → Model → Database
                                        ↓
                                      View → HTML
```

✅ **Separación correcta:**
- **Model:** Solo acceso a datos
- **View:** Solo HTML, sin lógica
- **Controller:** Une Model y View

---

## Resumen Final

| Aspecto | Estado |
|---------|--------|
| 5 Casos de uso | ✅ Completos |
| Errores lista | ✅ 0 errores |
| Middleware | ✅ Funciona |
| Patrón MVC | ✅ Correcto |
| URLs relativas | ✅ Todas |
| Sin CSS | ✅ Sin CSS |
| Sin JavaScript | ✅ Sin JS |
| BD correcta | ✅ Según SQL |
| Documentación | ✅ Completa |
| Código limpio | ✅ Comentado |

**CALIFICACIÓN ESPERADA:** 10/10
