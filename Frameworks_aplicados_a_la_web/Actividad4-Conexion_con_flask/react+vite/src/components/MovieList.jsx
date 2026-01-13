import React, { useState, useEffect } from 'react';
import { getMovies, createMovie, updateMovie, deleteMovie } from '../services/api';

/**
 * Componente principal para la gestión de películas
 * Demuestra el uso correcto de:
 * - Servicios externos desacoplados
 * - Estados de carga (loading)
 * - Manejo de errores (error)
 * - Operaciones CRUD completas
 */
const MovieList = () => {
  // Estados para gestionar el ciclo de vida de las peticiones
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  
  // Estados para el formulario
  const [isFormOpen, setIsFormOpen] = useState(false);
  const [editingMovie, setEditingMovie] = useState(null);
  const [formData, setFormData] = useState({
    title: '',
    director: '',
    year: '',
    genre: ''
  });

  /**
   * Carga inicial de películas
   * Nota: La lógica de fetch está extraída al servicio api.js
   * NO hacemos fetch directamente en el useEffect
   */
  useEffect(() => {
    loadMovies();
  }, []);

  /**
   * Función para cargar todas las películas
   * Gestiona estados de loading y error
   */
  const loadMovies = async () => {
    setLoading(true);
    setError(null);
    
    try {
      const data = await getMovies();
      setMovies(data);
    } catch (err) {
      setError(err.message);
      console.error('Error al cargar películas:', err);
    } finally {
      setLoading(false);
    }
  };

  /**
   * Maneja el envío del formulario (crear o actualizar)
   */
  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      if (editingMovie) {
        // Actualizar película existente
        await updateMovie(editingMovie.id, formData);
      } else {
        // Crear nueva película
        await createMovie(formData);
      }
      
      // Recargar la lista
      await loadMovies();
      
      // Resetear formulario
      resetForm();
    } catch (err) {
      setError(err.message);
      console.error('Error al guardar película:', err);
    } finally {
      setLoading(false);
    }
  };

  /**
   * Maneja la eliminación de una película
   */
  const handleDelete = async (id) => {
    if (!window.confirm('¿Estás seguro de eliminar esta película?')) {
      return;
    }

    setLoading(true);
    setError(null);

    try {
      await deleteMovie(id);
      await loadMovies();
    } catch (err) {
      setError(err.message);
      console.error('Error al eliminar película:', err);
    } finally {
      setLoading(false);
    }
  };

  /**
   * Prepara el formulario para edición
   */
  const handleEdit = (movie) => {
    setEditingMovie(movie);
    setFormData({
      title: movie.title,
      director: movie.director,
      year: movie.year,
      genre: movie.genre
    });
    setIsFormOpen(true);
  };

  /**
   * Resetea el formulario
   */
  const resetForm = () => {
    setFormData({ title: '', director: '', year: '', genre: '' });
    setEditingMovie(null);
    setIsFormOpen(false);
  };

  /**
   * Maneja cambios en los inputs del formulario
   */
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  // ==================== RENDERIZADO ====================

  return (
    <div className="movie-list-container">
      <h1>Gestión de Películas</h1>
      
      {/* Botón para abrir formulario */}
      {!isFormOpen && (
        <button 
          className="btn btn-primary"
          onClick={() => setIsFormOpen(true)}
          disabled={loading}
        >
          ➕ Nueva Película
        </button>
      )}

      {/* Mensaje de error */}
      {error && (
        <div className="error-message">
          <strong>⚠️ Error:</strong> {error}
          <button onClick={() => setError(null)}>✕</button>
        </div>
      )}

      {/* Estado de carga */}
      {loading && (
        <div className="loading-spinner">
          <div className="spinner"></div>
          <p>Cargando...</p>
        </div>
      )}

      {/* Formulario de creación/edición */}
      {isFormOpen && (
        <div className="movie-form">
          <h2>{editingMovie ? 'Editar Película' : 'Nueva Película'}</h2>
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label htmlFor="title">Título:</label>
              <input
                type="text"
                id="title"
                name="title"
                value={formData.title}
                onChange={handleInputChange}
                required
                disabled={loading}
              />
            </div>

            <div className="form-group">
              <label htmlFor="director">Director:</label>
              <input
                type="text"
                id="director"
                name="director"
                value={formData.director}
                onChange={handleInputChange}
                required
                disabled={loading}
              />
            </div>

            <div className="form-group">
              <label htmlFor="year">Año:</label>
              <input
                type="number"
                id="year"
                name="year"
                value={formData.year}
                onChange={handleInputChange}
                required
                min="1800"
                max="2100"
                disabled={loading}
              />
            </div>

            <div className="form-group">
              <label htmlFor="genre">Género:</label>
              <input
                type="text"
                id="genre"
                name="genre"
                value={formData.genre}
                onChange={handleInputChange}
                required
                disabled={loading}
              />
            </div>

            <div className="form-actions">
              <button 
                type="submit" 
                className="btn btn-success"
                disabled={loading}
              >
                {editingMovie ? '💾 Actualizar' : '➕ Crear'}
              </button>
              <button 
                type="button" 
                className="btn btn-secondary"
                onClick={resetForm}
                disabled={loading}
              >
                ✕ Cancelar
              </button>
            </div>
          </form>
        </div>
      )}

      {/* Lista de películas */}
      {!loading && movies.length === 0 && !error && (
        <p className="empty-message">No hay películas registradas. ¡Añade la primera!</p>
      )}

      {!loading && movies.length > 0 && (
        <div className="movies-grid">
          {movies.map((movie) => (
            <div key={movie.id} className="movie-card">
              <h3>{movie.title}</h3>
              <p><strong>Director:</strong> {movie.director}</p>
              <p><strong>Año:</strong> {movie.year}</p>
              <p><strong>Género:</strong> {movie.genre}</p>
              
              <div className="card-actions">
                <button 
                  className="btn btn-edit"
                  onClick={() => handleEdit(movie)}
                  disabled={loading}
                >
                  ✏️ Editar
                </button>
                <button 
                  className="btn btn-delete"
                  onClick={() => handleDelete(movie.id)}
                  disabled={loading}
                >
                  🗑️ Eliminar
                </button>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default MovieList;
