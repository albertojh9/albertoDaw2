# Changelog - Arquitectura de Servicios React + Flask

## 📋 Descripción del Proyecto

Sistema de gestión de películas implementado con React (frontend) y Flask (backend), demostrando una arquitectura de servicios moderna con separación de responsabilidades (Separation of Concerns).

---

## 🏗️ Parte 1: Investigación y Diseño

### 1.1 Patrones de Diseño - Separation of Concerns (SoC)

**¿Por qué es mala práctica hacer fetch directamente en useEffect?**

Hacer `fetch` directamente dentro de un `useEffect` sin extraerlo presenta varios problemas:

1. **Falta de reutilización**: Si múltiples componentes necesitan los mismos datos, duplicamos código
2. **Dificulta el testing**: Los componentes quedan acoplados a la lógica de red, complicando las pruebas unitarias
3. **Mantenimiento complicado**: Cambios en la API requieren modificar múltiples componentes
4. **Violación de Single Responsibility**: El componente maneja tanto presentación como lógica de red
5. **Gestión de errores inconsistente**: Cada componente implementa su propio manejo de errores
6. **Dificulta el caching y optimizaciones**: No hay un punto centralizado para implementar estrategias de caché

**Ejemplo de mala práctica:**
```javascript
// ❌ MAL - Lógica de red mezclada con el componente
useEffect(() => {
  fetch('http://localhost:5000/api/movies')
    .then(res => res.json())
    .then(data => setMovies(data))
    .catch(err => console.error(err));
}, []);
```

**Ejemplo de buena práctica:**
```javascript
// ✅ BIEN - Lógica de red extraída al servicio
useEffect(() => {
  loadMovies();
}, []);

const loadMovies = async () => {
  try {
    const data = await getMovies(); // Función del servicio
    setMovies(data);
  } catch (error) {
    handleError(error);
  }
};
```

### 1.2 Diseño de la Capa de Servicios

**Estructura implementada:**
```
src/
├── services/
│   └── api.js          # Módulo centralizado de servicios
├── components/
│   └── MovieList.jsx   # Componentes que consumen los servicios
└── App.jsx
```

**Características del módulo `services/api.js`:**

1. **URL Base configurable**: Usa variables de entorno (`import.meta.env.VITE_API_BASE_URL`)
2. **Funciones asíncronas exportables**: Cada operación CRUD es una función independiente
3. **Headers centralizados**: Configuración común de `Content-Type` y `Accept`
4. **Manejo de errores estandarizado**: Función `handleError` que gestiona errores de red
5. **Manejo de respuestas**: Función `handleResponse` que valida códigos HTTP

### 1.3 CORS (Cross-Origin Resource Sharing)

**¿Qué es CORS?**

CORS es un mecanismo de seguridad del navegador que bloquea peticiones HTTP entre diferentes orígenes (protocolo, dominio o puerto diferentes).

**¿Por qué es necesario en este proyecto?**

- **Frontend React**: `http://localhost:3000`
- **Backend Flask**: `http://localhost:5000`

Aunque ambos están en `localhost`, tienen **puertos diferentes**, lo que los convierte en orígenes distintos.

**Sin CORS configurado:**
```
Access to fetch at 'http://localhost:5000/api/movies' from origin 
'http://localhost:3000' has been blocked by CORS policy
```

**Solución implementada:**
```python
CORS(app, resources={
    r"/api/*": {
        "origins": ["http://localhost:3000"],
        "methods": ["GET", "POST", "PUT", "DELETE"],
        "allow_headers": ["Content-Type", "Accept"]
    }
})
```

---

## 🔧 Parte 2: Implementación del Servicio (React)

### 2.1 Módulo de Servicios - `services/api.js`

**Características implementadas:**

#### a) Configuración de Base URL
```javascript
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:5000/api';
```

- Usa variables de entorno para flexibilidad
- Valor por defecto para desarrollo local
- Permite cambiar fácilmente entre entornos (dev, staging, producción)

#### b) Gestión de Headers
```javascript
const getHeaders = () => ({
  'Content-Type': 'application/json',
  'Accept': 'application/json',
});
```

- Centraliza la configuración de headers
- Facilita agregar autenticación en el futuro (ej. tokens JWT)

#### c) Manejo de Respuestas y Errores
```javascript
const handleResponse = async (response) => {
  if (!response.ok) {
    const errorData = await response.json().catch(() => ({}));
    throw new Error(errorData.message || `Error HTTP: ${response.status}`);
  }
  return response.json();
};

const handleError = (error) => {
  if (error.message.includes('Failed to fetch')) {
    throw new Error('No se pudo conectar con el servidor...');
  }
  throw error;
};
```

#### d) Funciones Asíncronas Exportables

Todas las operaciones CRUD están implementadas como funciones async/await:

- `getMovies()` - Obtiene todas las películas
- `getMovieById(id)` - Obtiene una película específica
- `createMovie(data)` - Crea una nueva película
- `updateMovie(id, data)` - Actualiza una película existente
- `deleteMovie(id)` - Elimina una película

### 2.2 Refactorización de Componentes

**`MovieList.jsx` - Gestión del ciclo de vida de peticiones:**

#### Estados implementados:
```javascript
const [movies, setMovies] = useState([]);
const [loading, setLoading] = useState(false);  // Estado de carga
const [error, setError] = useState(null);       // Manejo de errores
```

#### Patrón de carga de datos:
```javascript
const loadMovies = async () => {
  setLoading(true);
  setError(null);
  
  try {
    const data = await getMovies();  // Servicio externo
    setMovies(data);
  } catch (err) {
    setError(err.message);
  } finally {
    setLoading(false);
  }
};
```

#### Experiencia de usuario mejorada:

1. **Loading State**: Spinner animado mientras carga
2. **Error State**: Mensaje claro y opción para cerrar
3. **Empty State**: Mensaje cuando no hay datos
4. **Success State**: Grid de películas con animaciones

---

## ⚙️ Parte 3: Ajuste Backend (Flask)

### 3.1 Configuración de Flask-CORS

**Instalación:**
```bash
pip install Flask-CORS
```

**Configuración implementada en `app.py`:**
```python
from flask_cors import CORS

CORS(app, resources={
    r"/api/*": {
        "origins": ["http://localhost:3000", "http://127.0.0.1:3000"],
        "methods": ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
        "allow_headers": ["Content-Type", "Accept"]
    }
})
```

**Parámetros explicados:**
- `resources`: Rutas afectadas (todas las que empiezan con `/api/`)
- `origins`: Lista de orígenes permitidos (frontend React)
- `methods`: Métodos HTTP autorizados
- `allow_headers`: Headers que el cliente puede enviar

### 3.2 Endpoints implementados

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/movies` | Obtiene todas las películas |
| GET | `/api/movies/<id>` | Obtiene película por ID |
| POST | `/api/movies` | Crea nueva película |
| PUT | `/api/movies/<id>` | Actualiza película |
| DELETE | `/api/movies/<id>` | Elimina película |
| GET | `/api/health` | Verifica estado del servidor |

### 3.3 Base de datos

Por simplicidad, se usa una lista en memoria:
```python
movies_db = [
    {"id": 1, "title": "El Padrino", "director": "Francis Ford Coppola", ...},
    ...
]
```

**Nota**: En producción, se recomienda usar SQLAlchemy con PostgreSQL/MySQL.

---

## 📦 Estructura Final del Proyecto

```
react+vite/
├── backend/
│   ├── app.py                    # Servidor Flask con CORS
│   └── requirements.txt          # Dependencias Python
├── src/
│   ├── services/
│   │   └── api.js               # ⭐ Capa de servicios centralizada
│   ├── components/
│   │   └── MovieList.jsx        # Componente con loading/error handling
│   ├── App.jsx
│   ├── App.css
│   └── main.jsx
├── .env                         # Variables de entorno (gitignored)
├── .env.example                 # Plantilla de variables de entorno
├── .gitignore
├── index.html
├── package.json
└── vite.config.js
```

---

## 🚀 Instrucciones de Ejecución

### Backend (Flask)

```bash
# Navegar a la carpeta del backend
cd backend

# Instalar dependencias
pip install -r requirements.txt

# Ejecutar servidor
python app.py
```

Servidor disponible en: `http://localhost:5000`

### Frontend (React + Vite)

```bash
# Instalar dependencias
npm install

# Ejecutar en modo desarrollo
npm run dev
```

Aplicación disponible en: `http://localhost:3000`

---

## 🔍 Decisiones Técnicas

### ¿Por qué Vite en lugar de Create React App?

1. **Rendimiento**: HMR (Hot Module Replacement) ultra rápido
2. **Build optimizado**: Usa Rollup para producción
3. **Configuración moderna**: Soporte nativo de ES modules
4. **Ligero**: Sin dependencias innecesarias

### ¿Por qué async/await en lugar de Promises?

1. **Legibilidad**: Código más limpio y fácil de leer
2. **Manejo de errores**: try/catch es más intuitivo que .catch()
3. **Debugging**: Stack traces más claros

### ¿Por qué Flask en lugar de otros frameworks?

1. **Simplicidad**: Ideal para APIs pequeñas
2. **Flexibilidad**: No impone estructura rígida
3. **Extensible**: Flask-CORS se integra fácilmente

---

## ✅ Checklist de Cumplimiento

### Parte 1: Investigación y Diseño
- [x] Documentado patrón Separation of Concerns
- [x] Explicado por qué no usar fetch en useEffect
- [x] Diseñada estructura de services/api.js
- [x] Explicado concepto de CORS

### Parte 2: Implementación React
- [x] Módulo services/api.js implementado
- [x] URL base configurable con variables de entorno
- [x] Funciones asíncronas exportables (getMovies, createMovie, etc.)
- [x] Headers configurados (Content-Type, Accept)
- [x] Componentes refactorizados para usar servicios
- [x] Estados de loading implementados
- [x] Manejo de errores en UI

### Parte 3: Backend Flask
- [x] Flask-CORS configurado
- [x] Orígenes permitidos: http://localhost:3000
- [x] Endpoints CRUD completos
- [x] Manejo de errores HTTP

### Documentación
- [x] changelog.md creado
- [x] Arquitectura documentada
- [x] Decisiones técnicas explicadas
- [x] Instrucciones de ejecución

---

## 🎯 Conceptos Clave Aprendidos

1. **Separation of Concerns**: Desacoplar lógica de red de componentes visuales
2. **Arquitectura de Servicios**: Capa intermedia entre UI y API
3. **CORS**: Entender y configurar permisos de origen cruzado
4. **Estados de UI**: Loading, Error y Success states
5. **Variables de entorno**: Configuración flexible entre entornos
6. **API RESTful**: Endpoints semánticos con verbos HTTP correctos

---

## 📚 Recursos Adicionales

- [Documentación de Vite](https://vitejs.dev/)
- [React Hooks](https://react.dev/reference/react)
- [Flask-CORS](https://flask-cors.readthedocs.io/)
- [MDN - CORS](https://developer.mozilla.org/es/docs/Web/HTTP/CORS)
- [REST API Best Practices](https://restfulapi.net/)

---

**Fecha de implementación**: Enero 2026  
**Versión**: 1.0.0  
**Rama**: feature/conectar-flask
