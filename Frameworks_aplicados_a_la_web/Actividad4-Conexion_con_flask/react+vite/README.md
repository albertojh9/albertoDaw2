# Sistema de Gestión de Películas - React + Flask

Sistema completo de gestión de películas implementando arquitectura de servicios moderna con React (Vite) en el frontend y Flask en el backend.

## 🚀 Características

- ✅ Arquitectura de servicios con Separation of Concerns
- ✅ Capa de servicios centralizada (services/api.js)
- ✅ CRUD completo de películas
- ✅ Manejo de estados de carga y errores
- ✅ Backend Flask con CORS configurado
- ✅ Variables de entorno para configuración flexible
- ✅ UI moderna y responsiva

## 📁 Estructura del Proyecto

```
react+vite/
├── backend/              # Servidor Flask
│   ├── app.py           # API RESTful con CORS
│   └── requirements.txt
├── src/
│   ├── services/
│   │   └── api.js       # Capa de servicios centralizada
│   ├── components/
│   │   └── MovieList.jsx
│   ├── App.jsx
│   └── main.jsx
├── .env                 # Variables de entorno
├── package.json
└── vite.config.js
```

## 🔧 Instalación y Ejecución

### Backend (Flask)

```bash
# Navegar a la carpeta backend
cd backend

# Crear entorno virtual (opcional pero recomendado)
python -m venv venv
venv\Scripts\activate  # Windows
# source venv/bin/activate  # macOS/Linux

# Instalar dependencias
pip install -r requirements.txt

# Ejecutar servidor
python app.py
```

El servidor estará disponible en `http://localhost:5000`

### Frontend (React + Vite)

```bash
# Instalar dependencias
npm install

# Ejecutar en modo desarrollo
npm run dev
```

La aplicación estará disponible en `http://localhost:3000`

## 🌐 Endpoints de la API

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/movies` | Obtiene todas las películas |
| GET | `/api/movies/<id>` | Obtiene película por ID |
| POST | `/api/movies` | Crea nueva película |
| PUT | `/api/movies/<id>` | Actualiza película |
| DELETE | `/api/movies/<id>` | Elimina película |
| GET | `/api/health` | Estado del servidor |

## 📝 Configuración

### Variables de Entorno

Copia `.env.example` a `.env` y ajusta los valores:

```env
VITE_API_BASE_URL=http://localhost:5000/api
```

## 🏗️ Arquitectura

Este proyecto implementa **Separation of Concerns** mediante:

1. **Capa de Servicios**: Toda la lógica de red está centralizada en `services/api.js`
2. **Componentes de Presentación**: Los componentes React solo se encargan de la UI
3. **Backend Independiente**: API Flask completamente desacoplada del frontend

### ¿Por qué no hacer fetch en useEffect?

- ❌ Dificulta reutilización de código
- ❌ Complica testing
- ❌ Mezcla responsabilidades
- ❌ Manejo inconsistente de errores

✅ **Solución**: Capa de servicios centralizada

## 🔒 CORS

El backend Flask tiene CORS configurado para permitir peticiones desde:
- `http://localhost:3000`
- `http://127.0.0.1:3000`

Métodos permitidos: GET, POST, PUT, DELETE

## 📚 Documentación Completa

Ver [changelog.md](./changelog.md) para documentación detallada sobre:
- Decisiones de diseño
- Patrones implementados
- Explicación de CORS
- Conceptos aprendidos

## 🛠️ Tecnologías Utilizadas

### Frontend
- React 18
- Vite 5
- JavaScript (ES6+)

### Backend
- Python 3
- Flask 3.0
- Flask-CORS 4.0

## 👥 Contribución

Este proyecto es parte de la asignatura de Frameworks Aplicados a la Web.

**Rama de desarrollo**: `feature/conectar-flask`

## 📄 Licencia

Proyecto educativo - UT2: Desarrollo Frontend Moderno (React)
