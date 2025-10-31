# ⚓ Sistema de Karma del Marinero - Juicio Pirata

## 🏴‍☠️ Descripción
Sistema de karma para marineros piratas que evalúa sus acciones en alta mar y determina su destino eterno: el cielo o el casillero de Davy Jones.

## 📋 Características

### Acciones Nobles (Karma Positivo)
- 🌊 **Rescatar a un compañero del mar**: +50 karma
- 💰 **Compartir el botín equitativamente**: +30 karma
- 📜 **Respetar el código pirata**: +20 karma
- 🔨 **Ayudar a reparar el barco**: +25 karma
- ⚔️ **Defender el barco de enemigos**: +40 karma

### Acciones Ruines (Karma Negativo)
- 🗡️ **Traicionar a la tripulación**: -60 karma
- 💀 **Robar del botín común**: -45 karma
- 🍺 **Emborracharse durante la guardia**: -20 karma
- ⚓ **Amotinarse contra el capitán**: -70 karma
- 🏴‍☠️ **Abandonar a un compañero en apuros**: -50 karma

## 🎯 Destinos Posibles

### ☁️ Cielo (Karma Positivo)
El marinero ha sido noble y justo. Navegará hacia los cielos eternos donde el ron fluye infinito.

### 💀 Casillero de Davy Jones (Karma Negativo)
El marinero ha cometido demasiadas fechorías. Descenderá al abismo para servir eternamente en la tripulación fantasma.

### ⚖️ Limbo (Karma = 0)
El marinero está en perfecto equilibrio. Vagará eternamente entre mundos.

## 🚀 Instalación

1. Coloca los archivos en tu servidor PHP
2. Asegúrate de que las sesiones estén habilitadas en tu `php.ini`
3. Accede a `diario_marinero.php` desde tu navegador

## 📁 Archivos del Sistema

- **diario_marinero.php**: Página principal donde el marinero registra sus acciones
- **juicio_marinero.php**: Página del juicio que muestra el resultado final del karma

## 🔧 Requisitos Técnicos

- PHP 7.4 o superior
- Sesiones PHP habilitadas
- Navegador web moderno

## 🎨 Características Técnicas

✅ **Seguridad**:
- Uso de `htmlspecialchars()` para prevenir XSS
- Validación de entradas del usuario
- Sanitización de datos
- Sesiones PHP para mantener estado

✅ **Buenas Prácticas**:
- Código limpio y comentado
- Estructura semántica HTML5
- CSS responsive
- Animaciones suaves

✅ **Diseño**:
- Interfaz temática pirata
- Colores dinámicos según el destino
- Animaciones CSS
- Diseño responsive

## 🎮 Cómo Usar

1. **Ingresa tu nombre** de marinero
2. **Marca las acciones** que has cometido (buenas y malas)
3. **Haz clic en "Enfrentar el Juicio"**
4. **Observa tu destino** según tu karma total
5. **Opción de juzgar otro marinero** para reiniciar

## 💡 Sistema de Karma

El karma total se calcula sumando/restando los valores de cada acción:

```
Karma Total = Suma de acciones buenas + Suma de acciones malas

Si Karma > 0  → Cielo ☁️
Si Karma < 0  → Davy Jones 💀
Si Karma = 0  → Limbo ⚖️
```

## 🔐 Seguridad Implementada

- ✅ Uso de sesiones PHP para datos seguros
- ✅ Validación de existencia de sesión
- ✅ Escape de HTML con `htmlspecialchars()`
- ✅ Redirección segura con `exit()`
- ✅ Validación de datos del formulario

## 🎨 Personalización

Puedes personalizar:
- Los valores de karma de cada acción
- Los colores y estilos CSS
- Los mensajes de destino
- Agregar más acciones al sistema

## 📝 Notas Importantes

- Las sesiones se destruyen al hacer clic en "Juzgar Otro Marinero"
- El karma se calcula automáticamente al enviar el formulario
- El sistema muestra estadísticas detalladas de las acciones
- Los colores cambian dinámicamente según el destino

## 🌊 ¡Que las mareas te sean favorables, marinero!

---

**Creado siguiendo las mejores prácticas de PHP y seguridad web** 🏴‍☠️
