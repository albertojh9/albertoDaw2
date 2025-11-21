# INSTRUCCIONES DE PRUEBA PASO A PASO

## Instalación Inicial

### 1. Crear la Base de Datos
```bash
mysql -u root -p
```

Dentro de MySQL:
```sql
source /ruta/completa/sql/viogen.sql
source /ruta/completa/sql/datos_viogen.sql
exit
```

### 2. Verificar que la BD se creó correctamente
```bash
mysql -u uviogen -pcviogen viogen -e "SHOW TABLES;"
```

Deberías ver:
```
Usuario
Victima
Agresion
```

---

## PRUEBA 1: Login (Caso de Uso 1)

### Paso 1: Acceder sin login
1. Abre el navegador
2. Ve a: `http://localhost/viogen/index.php?controller=menu&action=index`
3. **Resultado esperado:** ERROR 401 - No Autorizado
4. **Verifica:** Aparece el mensaje "Debe iniciar sesión para acceder"

### Paso 2: Login correcto
1. Ve a: `http://localhost/viogen/index.php`
2. Introduce:
   - Usuario: `abcd`
   - Contraseña: `1234`
3. Haz clic en "Iniciar Sesión"
4. **Resultado esperado:** Redirige al Menú Principal
5. **Verifica:** Ves "Sistema VioGén - Menú Principal"

### Paso 3: Login incorrecto
1. Cierra sesión (clic en "Cerrar Sesión")
2. Introduce:
   - Usuario: `abcd`
   - Contraseña: `mal`
3. **Resultado esperado:** Muestra error "Usuario o contraseña incorrectos"
4. **Verifica:** Permaneces en el login con el mensaje de error

### Paso 4: Validación de longitud
1. Introduce:
   - Usuario: `ab` (solo 2 caracteres)
   - Contraseña: `1234`
2. **Resultado esperado:** Error "deben tener al menos 4 caracteres"

---

## PRUEBA 2: Logout (Caso de Uso 2)

### Paso 1: Hacer login
1. Login con: `abcd` / `1234`
2. Verifica que estás en el menú

### Paso 2: Cerrar sesión
1. Haz clic en "Cerrar Sesión"
2. **Resultado esperado:** Vuelves al formulario de login
3. **Verifica:** Ves el formulario de "Iniciar Sesión"

### Paso 3: Verificar que la sesión se destruyó
1. Intenta acceder directamente a: `http://localhost/viogen/index.php?controller=menu&action=index`
2. **Resultado esperado:** ERROR 401
3. **Verifica:** No puedes acceder sin login

---

## PRUEBA 3: Registro de Víctima (Caso de Uso 3)

### Paso 1: Acceder al formulario
1. Login con: `abcd` / `1234`
2. En el menú, clic en "Registrar Víctima"
3. **Verifica:** Ves el formulario con todos los campos

### Paso 2: Registro con todos los campos
1. Introduce:
   - Nombre: `Carmen`
   - Apellidos: `Pérez González`
   - Tipo documento: `NIF`
   - Documento: `12345678Z`
   - Teléfono: `666777888`
   - Observaciones: `Víctima de prueba`
2. Haz clic en "Registrar Víctima"
3. **Resultado esperado:** Vuelves al menú con mensaje "Víctima registrada correctamente"

### Paso 3: Registro solo con nombre
1. Clic en "Registrar Víctima"
2. Introduce solo:
   - Nombre: `Laura`
3. Haz clic en "Registrar Víctima"
4. **Resultado esperado:** Se guarda correctamente

### Paso 4: Registro solo con observaciones
1. Clic en "Registrar Víctima"
2. Introduce solo:
   - Observaciones: `Víctima anónima sin más datos`
3. **Resultado esperado:** Se guarda correctamente

### Paso 5: Registro vacío (ERROR)
1. Clic en "Registrar Víctima"
2. Deja todos los campos vacíos
3. Haz clic en "Registrar Víctima"
4. **Resultado esperado:** Error "Debe proporcionar al menos un nombre o una observación"
5. **Verifica:** Permaneces en el formulario

### Paso 6: Validación de NIF (cualquier NIF con formato correcto)
1. Clic en "Registrar Víctima"
2. Introduce:
   - Nombre: `Test`
   - Tipo documento: `NIF`
   - Documento: `12345678A` (8 números + 1 letra)
3. **Resultado esperado:** Se guarda correctamente (solo verifica formato básico)

### Paso 7: NIE con formato correcto
1. Introduce:
   - Nombre: `Test NIE`
   - Tipo documento: `NIE`
   - Documento: `X1234567L`
2. **Resultado esperado:** Se guarda correctamente

---

## PRUEBA 4: Registro de Agresión (Caso de Uso 4)

### Paso 1: Sin víctimas registradas
1. Si no hay víctimas, primero registra al menos una (ver Prueba 3)

### Paso 2: Acceder al formulario
1. En el menú, clic en "Registrar Agresión"
2. **Verifica:** Ves el selector de víctimas con las víctimas registradas

### Paso 3: Registro completo con todos los campos
1. Introduce:
   - Víctima: Selecciona una víctima
   - Agresor: `Juan García - Expareja`
   - Tipo de agresión: `física`
   - Fecha y hora: `2024-11-20 15:30` (usa el selector)
   - Observaciones: `Agresión en domicilio familiar`
2. Haz clic en "Registrar Agresión"
3. **Resultado esperado:** Vuelves al menú con "Agresión registrada correctamente"

### Paso 4: Registro sin agresor (opcional)
1. Clic en "Registrar Agresión"
2. Introduce:
   - Víctima: Selecciona una
   - Agresor: (déjalo vacío)
   - Tipo de agresión: `psicológica`
   - Fecha y hora: Selecciona fecha actual
3. **Resultado esperado:** Se guarda correctamente

### Paso 5: Campos obligatorios (ERROR)
1. Clic en "Registrar Agresión"
2. Deja víctima vacía
3. **Resultado esperado:** Error "Debe seleccionar una víctima"

### Paso 6: Probar todos los tipos de agresión
1. Registra una agresión de cada tipo:
   - `física`
   - `psicológica`
   - `sexual`
   - `vicaria`
2. **Verifica:** Todos se guardan correctamente

---

## PRUEBA 5: Informe de Agresiones (Caso de Uso 5)

### Paso 1: Preparar datos
1. Asegúrate de tener al menos 3 agresiones registradas con fechas diferentes
2. Anota algunos nombres, teléfonos u observaciones

### Paso 2: Búsqueda por nombre de víctima
1. En el menú principal, en el buscador escribe: `María`
2. Haz clic en "Buscar"
3. **Resultado esperado:** 
   - Aparece tabla con resultados
   - Muestra: Nombre completo, Tipo de agresión, Fecha
   - Ordenado por fecha descendente (más reciente primero)

### Paso 3: Búsqueda por teléfono
1. Busca: `600123456`
2. **Resultado esperado:** Muestra agresiones de víctimas con ese teléfono

### Paso 4: Búsqueda por observaciones
1. Busca: `amenazas`
2. **Resultado esperado:** Muestra agresiones con esa palabra en observaciones

### Paso 5: Búsqueda sin resultados
1. Busca: `ZZZZZZZZ`
2. **Resultado esperado:** Mensaje "No se encontraron resultados"

### Paso 6: Verificar orden por fecha
1. Busca algo que devuelva varios resultados
2. **Verifica:** 
   - La primera fila tiene la fecha más reciente
   - Las fechas van en orden descendente

### Paso 7: Verificar formato de fecha
1. **Verifica:** Las fechas aparecen en formato `dd/mm/YYYY HH:MM`
2. Ejemplo: `20/11/2024 15:30`

---

## PRUEBA 6: Middleware y Seguridad

### Paso 1: Intentar acceder sin login
1. Cierra sesión
2. Intenta acceder a:
   - `index.php?controller=menu&action=index`
   - `index.php?controller=victima&action=crear`
   - `index.php?controller=agresion&action=crear`
3. **Resultado esperado:** ERROR 401 en todos los casos

### Paso 2: Verificar sanitización
1. Login con: `abcd` / `1234`
2. Registra una víctima con:
   - Nombre: `<script>alert('XSS')</script>`
3. Ve al buscador y busca "script"
4. **Verifica:** El código HTML no se ejecuta, se muestra como texto

### Paso 3: Verificar que solo se guarda el ID en sesión
1. Haz login
2. Abre las herramientas de desarrollo del navegador (F12)
3. En la consola, ejecuta:
```javascript
document.cookie
```
4. **Verifica:** No se ve la contraseña en ninguna parte

---

## PRUEBA 7: URLs Relativas

### Verificación
1. Revisa el código fuente de cualquier vista
2. **Verifica:** Todas las URLs son del tipo:
   - `index.php?controller=X&action=Y`
   - NUNCA: `http://localhost/...`

---

## PRUEBA 8: Confirmaciones y Errores

### Paso 1: Mensaje de confirmación
1. Registra una víctima
2. **Verifica:** Aparece mensaje verde "Víctima registrada correctamente"

### Paso 2: Mensaje de error
1. Intenta registrar víctima sin nombre ni observaciones
2. **Verifica:** Aparece mensaje rojo con el error
3. **Verifica:** Permaneces en el formulario (no vuelves al menú)

---

## Verificación Final de la Rúbrica

### Funcionalidad (5 casos de uso)
- ✅ Login: Funciona con validación
- ✅ Logout: Destruye sesión
- ✅ Registro Víctima: Campos opcionales, validación
- ✅ Registro Agresión: Campos obligatorios/opcionales
- ✅ Informe Agresiones: Buscador con tabla ordenada

### Corrección (sin errores)
- ✅ Login crea sesión con solo ID
- ✅ Middleware en index.php funciona
- ✅ Error 401 si no hay login
- ✅ Logout destruye sesión
- ✅ Registros validan e informan
- ✅ Vuelve al menú tras éxito
- ✅ Permanece en formulario si hay error
- ✅ config.php con constantes
- ✅ Documentación técnica (README.md)

### Sin Penalizaciones
- ✅ Patrón MVC correcto
- ✅ URLs relativas
- ✅ Sin CSS
- ✅ Sin JavaScript

---

## Datos de Prueba Útiles

### NIFs válidos para probar (formato: 8 números + 1 letra)
- `12345678A`
- `87654321X`
- `11111111H`
- `99999999R`

### NIEs válidos para probar (formato: X/Y/Z + 7 números + 1 letra)
- `X1234567L`
- `Y7654321Z`
- `Z1111111Z`

### Fechas de ejemplo
- `2024-11-20 15:30`
- `2024-11-19 10:00`
- `2024-11-18 18:45`

---

## Solución de Problemas

### Error: "Controlador no encontrado"
- Verifica que los archivos de controladores existen
- Verifica los nombres de archivos (mayúsculas/minúsculas)

### Error: "Error de conexión"
- Verifica que MySQL está ejecutándose
- Verifica usuario `uviogen` / `cviogen`
- Verifica que la base de datos `viogen` existe

### Error 401 constante
- Verifica que `session_start()` está en `index.php`
- Verifica que las cookies están habilitadas en el navegador

---

## Resumen de Credenciales

| Sistema | Usuario | Contraseña |
|---------|---------|------------|
| Aplicación | abcd | 1234 |
| MySQL | uviogen | cviogen |
| Base de datos | viogen | - |
