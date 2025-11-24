# Configuración de CORS en Apache (Contenedor Docker)

## 📋 Tabla de Contenidos
- [¿Qué es CORS?](#qué-es-cors)
- [Requisitos Previos](#requisitos-previos)
- [Arquitectura del Sistema](#arquitectura-del-sistema)
- [Proceso de Configuración](#proceso-de-configuración)
- [Verificación](#verificación)
- [Troubleshooting](#troubleshooting)
- [Recursos Adicionales](#recursos-adicionales)

---

## 🔍 ¿Qué es CORS?

**CORS (Cross-Origin Resource Sharing)** es un mecanismo de seguridad implementado por los navegadores web que bloquea las peticiones HTTP realizadas desde un dominio diferente al del servidor que sirve los recursos.

### Ejemplo del Problema

Si tu página web está en `https://example.com` e intenta hacer una petición fetch/AJAX a `https://api.example.org`, el navegador bloqueará la petición por defecto:

```javascript
// Ejecutado desde https://example.com
fetch('https://api.example.org/data.json')
  .then(res => res.json())
  .then(data => console.log(data));

// ❌ Error: "Solicitud desde otro origen bloqueada"
```

### La Solución

El servidor (`api.example.org`) debe añadir cabeceras HTTP específicas que indiquen al navegador que permite peticiones desde otros dominios:

```
Access-Control-Allow-Origin: *
```

---

## ✅ Requisitos Previos

Antes de comenzar, asegúrate de tener:

- ✅ Servidor EC2 con Ubuntu
- ✅ Docker instalado y corriendo
- ✅ Contenedor Apache ejecutándose
- ✅ Dominio DuckDNS configurado (ej: `tudominio.duckdns.org`)
- ✅ Acceso SSH al servidor EC2

---

## 🏗️ Arquitectura del Sistema

```
┌─────────────────┐
│   Navegador     │
│   (Cliente)     │
└────────┬────────┘
         │ Petición fetch()
         │ Origen: google.com
         ▼
┌─────────────────────────────────┐
│    Servidor EC2 (Ubuntu)        │
│  ┌───────────────────────────┐  │
│  │  Contenedor Docker        │  │
│  │  ┌─────────────────────┐  │  │
│  │  │   Apache Server     │  │  │
│  │  │   - mod_headers     │  │  │
│  │  │   - CORS Headers    │  │  │
│  │  │   - .htaccess       │  │  │
│  │  └─────────────────────┘  │  │
│  │   /var/www/html/          │  │
│  │   └─ holaMundo.json       │  │
│  └───────────────────────────┘  │
└─────────────────────────────────┘
         │
         ▼
    Response con
    Access-Control-Allow-Origin: *
```

---

## 🔧 Proceso de Configuración

### **Paso 1: Identificar el Contenedor Docker**

Lista todos los contenedores en ejecución:

```bash
docker ps
```

**Salida esperada:**
```
CONTAINER ID   IMAGE         NAMES      STATUS
e76b18210460   php:apache    apache     Up 27 minutes
```

Identifica el **NOMBRE** de tu contenedor Apache (en este caso: `apache`).

---

### **Paso 2: Acceder al Contenedor**

Entra al contenedor Apache en modo interactivo:

```bash
docker exec -it apache bash
```

**Verificación:** El prompt cambiará a algo como:
```
root@e76b18210460:/var/www/html#
```

Esto confirma que estás dentro del contenedor.

---

### **Paso 3: Verificar el Directorio Web**

Comprueba el contenido del directorio web:

```bash
ls -la /var/www/html/
```

**Salida esperada:**
```
total 8
drwxr-xr-x 2 root root 4096 Nov 24 10:30 .
drwxr-xr-x 3 root root 4096 Nov 21 08:15 ..
-rw-r--r-- 1 root root  612 Nov 24 10:30 index.html
```

---

### **Paso 4: Crear el Archivo JSON de Prueba**

Crea un archivo JSON simple para realizar las pruebas:

```bash
echo '{
  "mensaje": "Hola Mundo",
  "estado": "OK",
  "fecha": "2024-11-24"
}' > holaMundo.json
```

**Verifica que se creó correctamente:**

```bash
cat holaMundo.json
```

**Salida esperada:**
```json
{
  "mensaje": "Hola Mundo",
  "estado": "OK",
  "fecha": "2024-11-24"
}
```

---

### **Paso 5: Habilitar el Módulo mod_headers**

Apache necesita `mod_headers` para manipular las cabeceras HTTP:

```bash
a2enmod headers
```

**Salida esperada:**
```
Enabling module headers.
To activate the new configuration, you need to run:
  service apache2 restart
```

> **Nota:** No reinicies Apache todavía. Lo haremos después de configurar todo.

---

### **Paso 6: Instalar Nano (Editor de Texto)**

El contenedor no viene con editores instalados por defecto:

```bash
apt-get update && apt-get install -y nano
```

**Tiempo estimado:** 30-60 segundos.

---

### **Paso 7: Crear el Archivo .htaccess**

El archivo `.htaccess` permite configurar Apache a nivel de directorio:

```bash
cd /var/www/html
```

```bash
nano .htaccess
```

**Añade el siguiente contenido:**

```apache
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
    Header set Access-Control-Allow-Headers "DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range"
    Header set Access-Control-Expose-Headers "Content-Length,Content-Range"
</IfModule>
```

**Guarda el archivo:**
- Presiona `Ctrl + O` (guardar)
- Presiona `Enter` (confirmar)
- Presiona `Ctrl + X` (salir)

**Verifica el contenido:**

```bash
cat .htaccess
```

---

### **Paso 8: Configurar el VirtualHost**

Edita la configuración principal de Apache:

```bash
nano /etc/apache2/sites-available/000-default.conf
```

**Localiza el bloque `<VirtualHost *:80>` y modifícalo para que quede así:**

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    # Configuración del directorio para permitir .htaccess
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    # Configuración CORS alternativa (opcional si usas .htaccess)
    <IfModule mod_headers.c>
        Header set Access-Control-Allow-Origin "*"
    </IfModule>
</VirtualHost>
```

**Puntos clave:**
- `AllowOverride All`: Permite que `.htaccess` funcione
- `<Directory>`: Define permisos para el directorio web
- `<IfModule mod_headers.c>`: Configuración CORS a nivel de VirtualHost

**Guarda:**
- `Ctrl + O` → `Enter` → `Ctrl + X`

---

### **Paso 9: Verificar la Configuración**

Antes de reiniciar Apache, verifica que no hay errores de sintaxis:

```bash
apachectl -t
```

**Salida esperada:**
```
AH00558: apache2: Could not reliably determine the server's fully qualified domain name...
Syntax OK
```

> **Nota:** El mensaje `AH00558` es una advertencia, no un error. `Syntax OK` confirma que la configuración es válida.

---

### **Paso 10: Reiniciar Apache**

Aplica todos los cambios reiniciando el servidor Apache:

```bash
service apache2 restart
```

**Salida esperada:**
```
[ ok ] Restarting apache2 (via systemctl): apache2.service.
```

---

### **Paso 11: Salir del Contenedor**

Una vez completada la configuración, sal del contenedor:

```bash
exit
```

El prompt volverá a tu servidor EC2:
```
ubuntu@ip-172-31-25-149:~$
```

---

## ✅ Verificación

### **Prueba 1: Acceso Directo al JSON**

Abre tu navegador y ve a:

```
https://tudominio.duckdns.org/holaMundo.json
```

**Resultado esperado:**
```json
{
  "mensaje": "Hola Mundo",
  "estado": "OK",
  "fecha": "2024-11-24"
}
```

---

### **Prueba 2: Verificar CORS desde Consola del Navegador**

Esta es la prueba definitiva que confirma que CORS funciona correctamente.

#### **Paso 2.1: Abrir una Página Web**

Abre cualquier sitio web en tu navegador, por ejemplo:
- `https://google.com`
- O escribe `about:blank` en la barra de direcciones

> **¿Por qué no abrir directamente tu dominio?**  
> Porque CORS solo se activa cuando el **origen** (dominio desde el que se ejecuta el script) es **diferente** al **destino** (tu servidor). Si abres tu propio dominio y haces fetch a tu propio dominio, no hay "origen cruzado", por lo que CORS no entra en juego.

---

#### **Paso 2.2: Abrir Herramientas de Desarrollador**

Presiona **`F12`** para abrir las DevTools.

---

#### **Paso 2.3: Ir a la Consola**

Haz clic en la pestaña **"Console"** (Consola).

---

#### **Paso 2.4: Habilitar el Pegado**

La primera vez que pegues código, Chrome mostrará una advertencia de seguridad.

Escribe exactamente:
```
allow pasting
```

Y presiona **Enter**.

---

#### **Paso 2.5: Ejecutar la Prueba de CORS**

Pega el siguiente código (reemplaza `tudominio.duckdns.org` con tu dominio real):

```javascript
let url = 'https://tudominio.duckdns.org/holaMundo.json';
const peticion = (url) => {
  fetch(url)
    .then(res => res.json())
    .then(res => console.log(res));
}
peticion(url);
```

Presiona **Enter**.

---

#### **Resultado Esperado (✅ CORS Funcionando):**

```javascript
{mensaje: "Hola Mundo", estado: "OK", fecha: "2024-11-24"}
```

---

#### **Resultado con Error (❌ CORS NO Configurado):**

```
Access to fetch at 'https://tudominio.duckdns.org/holaMundo.json' 
from origin 'https://google.com' has been blocked by CORS policy: 
No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

---

### **Prueba 3: Verificar las Cabeceras HTTP**

Esta prueba confirma que el servidor está enviando las cabeceras CORS correctamente.

#### **Paso 3.1: Ir a la Pestaña Network**

En las DevTools (F12), haz clic en la pestaña **"Network"** (Red).

---

#### **Paso 3.2: Ejecutar la Petición**

Vuelve a la pestaña **"Console"** y ejecuta de nuevo el código JavaScript.

---

#### **Paso 3.3: Inspeccionar la Petición**

1. Ve a la pestaña **"Network"**
2. Busca la línea que dice **`holaMundo.json`**
3. Haz clic en ella

---

#### **Paso 3.4: Ver las Cabeceras de Respuesta**

En el panel lateral, haz clic en la pestaña **"Headers"** (Cabeceras).

Desplázate hasta **"Response Headers"** (Cabeceras de respuesta).

---

#### **Cabeceras Esperadas:**

```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, OPTIONS
Access-Control-Allow-Headers: DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range
Access-Control-Expose-Headers: Content-Length,Content-Range
```

Si ves estas cabeceras, **CORS está correctamente configurado** ✅

---

## 🐛 Troubleshooting

### **Problema 1: "command not found: a2enmod"**

**Causa:** Estás ejecutando el comando fuera del contenedor.

**Solución:**
```bash
# Primero entra al contenedor
docker exec -it apache bash

# Luego ejecuta a2enmod
a2enmod headers
```

---

### **Problema 2: "nano: command not found"**

**Causa:** El contenedor no tiene nano instalado.

**Solución (Opción 1 - Instalar nano):**
```bash
apt-get update && apt-get install -y nano
```

**Solución (Opción 2 - Usar vi):**
```bash
vi archivo.conf
# Presiona 'i' para insertar
# Escribe tu texto
# Presiona ESC
# Escribe :wq y presiona Enter
```

**Solución (Opción 3 - Crear con echo):**
```bash
echo 'contenido' > archivo.txt
```

---

### **Problema 3: CORS sigue sin funcionar**

**Checklist:**

1. **Verifica que mod_headers esté habilitado:**
   ```bash
   docker exec -it apache bash
   a2enmod headers
   service apache2 restart
   ```

2. **Verifica que AllowOverride esté en "All":**
   ```bash
   cat /etc/apache2/sites-available/000-default.conf | grep -A 5 "<Directory"
   ```
   Debe mostrar: `AllowOverride All`

3. **Verifica el contenido de .htaccess:**
   ```bash
   cat /var/www/html/.htaccess
   ```

4. **Verifica los permisos:**
   ```bash
   ls -la /var/www/html/.htaccess
   ```
   Debe ser legible por Apache.

5. **Reinicia el contenedor completo:**
   ```bash
   docker restart apache
   ```

---

### **Problema 4: Content Security Policy (CSP) Error**

**Síntoma:**
```
Refused to connect because it violates the document's Content Security Policy
```

**Causa:** Estás ejecutando el código desde una página especial del navegador (`chrome://` o página de nueva pestaña).

**Solución:** Abre una página web normal como `google.com` o `about:blank` antes de ejecutar el código.

---

### **Problema 5: Error 404 al acceder a holaMundo.json**

**Verificaciones:**

```bash
docker exec -it apache bash
cd /var/www/html
ls -la holaMundo.json
cat holaMundo.json
```

Si no existe, créalo de nuevo:
```bash
echo '{"mensaje":"Hola Mundo","estado":"OK"}' > holaMundo.json
```

---

## 📚 Recursos Adicionales

### **Explicación de las Cabeceras CORS**

| Cabecera | Propósito |
|----------|-----------|
| `Access-Control-Allow-Origin` | Especifica qué orígenes pueden acceder al recurso. `*` = todos |
| `Access-Control-Allow-Methods` | Métodos HTTP permitidos (GET, POST, etc.) |
| `Access-Control-Allow-Headers` | Cabeceras que el cliente puede enviar |
| `Access-Control-Expose-Headers` | Cabeceras que el cliente puede leer en la respuesta |

---

### **Seguridad: ¿Cuándo usar `*` vs dominios específicos?**

**Para desarrollo y pruebas:**
```apache
Header set Access-Control-Allow-Origin "*"
```

**Para producción (más seguro):**
```apache
Header set Access-Control-Allow-Origin "https://mi-app-frontend.com"
```

**Para múltiples dominios específicos (requiere lógica adicional):**
```apache
SetEnvIf Origin "^https://(www\.)?mi-dominio\.com$" ORIGIN=$0
SetEnvIf Origin "^https://app\.mi-dominio\.com$" ORIGIN=$0
Header set Access-Control-Allow-Origin "%{ORIGIN}e" env=ORIGIN
```

---

### **Documentación Oficial**

- [MDN - CORS](https://developer.mozilla.org/es/docs/Web/HTTP/CORS)
- [Apache mod_headers](https://httpd.apache.org/docs/2.4/mod/mod_headers.html)
- [CORS Specification](https://fetch.spec.whatwg.org/#http-cors-protocol)

---

## 🎯 Resumen de Comandos

```bash
# 1. Identificar contenedor
docker ps

# 2. Entrar al contenedor
docker exec -it apache bash

# 3. Habilitar mod_headers
a2enmod headers

# 4. Instalar nano
apt-get update && apt-get install -y nano

# 5. Crear archivo JSON
echo '{"mensaje":"Hola Mundo","estado":"OK"}' > /var/www/html/holaMundo.json

# 6. Crear .htaccess
nano /var/www/html/.htaccess

# 7. Editar VirtualHost
nano /etc/apache2/sites-available/000-default.conf

# 8. Verificar configuración
apachectl -t

# 9. Reiniciar Apache
service apache2 restart

# 10. Salir del contenedor
exit
```

---

## ✅ Checklist Final

- [ ] Contenedor Apache identificado y accesible
- [ ] mod_headers habilitado
- [ ] Archivo holaMundo.json creado
- [ ] Archivo .htaccess configurado con cabeceras CORS
- [ ] VirtualHost configurado con `AllowOverride All`
- [ ] `apachectl -t` muestra "Syntax OK"
- [ ] Apache reiniciado correctamente
- [ ] JSON accesible vía navegador
- [ ] Prueba de CORS desde consola exitosa
- [ ] Cabeceras CORS visibles en Network tab

---

## 📝 Notas Finales

### **¿Por qué dos configuraciones (VirtualHost + .htaccess)?**

- **VirtualHost:** Configuración global que también permite el uso de `.htaccess`
- **.htaccess:** Configuración a nivel de directorio, más fácil de modificar sin reiniciar Apache

Ambas funcionan. El `.htaccess` es más flexible para cambios rápidos.

---

### **¿Cuándo reiniciar Apache vs recargar?**

**Reload** (más rápido, no interrumpe conexiones):
```bash
service apache2 reload
```

**Restart** (reinicio completo, recomendado tras cambios importantes):
```bash
service apache2 restart
```

---

## 👨‍💻 Autor

**Alberto** - Estudiante de DAW 2º, IES Castelar, Badajoz  
Proyecto: Configuración de CORS en Apache con Docker

---

## 📅 Fecha

Última actualización: 24 de Noviembre de 2024

---

**¿Dudas o problemas?** Revisa la sección de [Troubleshooting](#troubleshooting) o consulta los logs de Apache:

```bash
docker exec -it apache tail -f /var/log/apache2/error.log
```
