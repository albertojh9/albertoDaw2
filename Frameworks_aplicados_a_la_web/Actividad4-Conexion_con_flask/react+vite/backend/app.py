"""
Backend Flask con API RESTful para gestión de películas
Incluye configuración de CORS para permitir peticiones desde React
"""

from flask import Flask, jsonify, request
from flask_cors import CORS

app = Flask(__name__)

# ==================== CONFIGURACIÓN DE CORS ====================
"""
CORS (Cross-Origin Resource Sharing) permite que el frontend React
(http://localhost:3000) pueda hacer peticiones al backend Flask
(http://localhost:5000).

Sin CORS, el navegador bloquearía las peticiones por política de seguridad,
ya que son de orígenes diferentes (puertos distintos).

Configuración para desarrollo:
- origins: Lista de orígenes permitidos
- methods: Métodos HTTP permitidos
- allow_headers: Headers que el cliente puede enviar
"""
CORS(app, resources={
    r"/api/*": {
        "origins": ["http://localhost:3000", "http://127.0.0.1:3000"],
        "methods": ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
        "allow_headers": ["Content-Type", "Accept"]
    }
})

# ==================== BASE DE DATOS EN MEMORIA ====================
# En producción, usarías SQLAlchemy con PostgreSQL/MySQL
movies_db = [
    {
        "id": 1,
        "title": "El Padrino",
        "director": "Francis Ford Coppola",
        "year": 1972,
        "genre": "Drama"
    },
    {
        "id": 2,
        "title": "Pulp Fiction",
        "director": "Quentin Tarantino",
        "year": 1994,
        "genre": "Crimen"
    },
    {
        "id": 3,
        "title": "Inception",
        "director": "Christopher Nolan",
        "year": 2010,
        "genre": "Ciencia Ficción"
    }
]

# Contador para IDs autoincrementales
next_id = 4

# ==================== RUTAS DE LA API ====================

@app.route('/api/movies', methods=['GET'])
def get_movies():
    """
    Obtiene todas las películas
    GET /api/movies
    """
    return jsonify(movies_db), 200


@app.route('/api/movies/<int:movie_id>', methods=['GET'])
def get_movie(movie_id):
    """
    Obtiene una película específica por ID
    GET /api/movies/<id>
    """
    movie = next((m for m in movies_db if m['id'] == movie_id), None)
    
    if movie:
        return jsonify(movie), 200
    else:
        return jsonify({"message": "Película no encontrada"}), 404


@app.route('/api/movies', methods=['POST'])
def create_movie():
    """
    Crea una nueva película
    POST /api/movies
    Body: {"title": "...", "director": "...", "year": ..., "genre": "..."}
    """
    global next_id
    
    data = request.get_json()
    
    # Validación de datos
    required_fields = ['title', 'director', 'year', 'genre']
    if not all(field in data for field in required_fields):
        return jsonify({"message": "Faltan campos requeridos"}), 400
    
    # Crear nueva película
    new_movie = {
        "id": next_id,
        "title": data['title'],
        "director": data['director'],
        "year": int(data['year']),
        "genre": data['genre']
    }
    
    movies_db.append(new_movie)
    next_id += 1
    
    return jsonify(new_movie), 201


@app.route('/api/movies/<int:movie_id>', methods=['PUT'])
def update_movie(movie_id):
    """
    Actualiza una película existente
    PUT /api/movies/<id>
    Body: {"title": "...", "director": "...", "year": ..., "genre": "..."}
    """
    movie = next((m for m in movies_db if m['id'] == movie_id), None)
    
    if not movie:
        return jsonify({"message": "Película no encontrada"}), 404
    
    data = request.get_json()
    
    # Actualizar campos
    movie['title'] = data.get('title', movie['title'])
    movie['director'] = data.get('director', movie['director'])
    movie['year'] = int(data.get('year', movie['year']))
    movie['genre'] = data.get('genre', movie['genre'])
    
    return jsonify(movie), 200


@app.route('/api/movies/<int:movie_id>', methods=['DELETE'])
def delete_movie(movie_id):
    """
    Elimina una película
    DELETE /api/movies/<id>
    """
    global movies_db
    
    movie = next((m for m in movies_db if m['id'] == movie_id), None)
    
    if not movie:
        return jsonify({"message": "Película no encontrada"}), 404
    
    movies_db = [m for m in movies_db if m['id'] != movie_id]
    
    return jsonify({"message": "Película eliminada exitosamente"}), 200


@app.route('/api/health', methods=['GET'])
def health_check():
    """
    Endpoint de verificación de estado del servidor
    GET /api/health
    """
    return jsonify({
        "status": "OK",
        "message": "Servidor Flask ejecutándose correctamente",
        "total_movies": len(movies_db)
    }), 200


# ==================== ERROR HANDLERS ====================

@app.errorhandler(404)
def not_found(error):
    return jsonify({"message": "Ruta no encontrada"}), 404


@app.errorhandler(500)
def internal_error(error):
    return jsonify({"message": "Error interno del servidor"}), 500


# ==================== EJECUCIÓN ====================

if __name__ == '__main__':
    print("\n" + "="*60)
    print("🚀 Servidor Flask iniciado")
    print("="*60)
    print("📍 URL: http://localhost:5000")
    print("🔗 API Base: http://localhost:5000/api")
    print("🎬 Endpoints disponibles:")
    print("   - GET    /api/movies          (Obtener todas las películas)")
    print("   - GET    /api/movies/<id>     (Obtener película por ID)")
    print("   - POST   /api/movies          (Crear nueva película)")
    print("   - PUT    /api/movies/<id>     (Actualizar película)")
    print("   - DELETE /api/movies/<id>     (Eliminar película)")
    print("   - GET    /api/health          (Estado del servidor)")
    print("="*60)
    print("✅ CORS configurado para: http://localhost:3000")
    print("="*60 + "\n")
    
    app.run(debug=True, port=5000)
