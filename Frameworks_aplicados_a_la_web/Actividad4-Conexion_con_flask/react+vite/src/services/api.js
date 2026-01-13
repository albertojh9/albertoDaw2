/**
 * Módulo de Servicios API - Centraliza todas las comunicaciones HTTP
 * 
 * Este módulo implementa el patrón de Separation of Concerns (SoC), 
 * desacoplando la lógica de red de los componentes visuales.
 * 
 * ¿Por qué no hacer fetch directamente en useEffect?
 * - Dificulta la reutilización de código
 * - Complica el testing de componentes
 * - Mezcla lógica de presentación con lógica de negocio
 * - Dificulta el mantenimiento y la gestión de errores centralizada
 */

// Obtener la URL base desde variables de entorno
// Vite expone las variables con prefijo VITE_ como import.meta.env
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:5000/api';

/**
 * Configuración de headers comunes para todas las peticiones
 */
const getHeaders = () => ({
  'Content-Type': 'application/json',
  'Accept': 'application/json',
});

/**
 * Función auxiliar para manejar respuestas HTTP
 * Lanza un error si la respuesta no es exitosa
 */
const handleResponse = async (response) => {
  if (!response.ok) {
    const errorData = await response.json().catch(() => ({}));
    throw new Error(errorData.message || `Error HTTP: ${response.status}`);
  }
  return response.json();
};

/**
 * Función auxiliar para manejar errores de red
 */
const handleError = (error) => {
  if (error.message.includes('Failed to fetch')) {
    throw new Error('No se pudo conectar con el servidor. Verifica que el backend esté ejecutándose.');
  }
  throw error;
};

// ==================== OPERACIONES CRUD PARA PELÍCULAS ====================

/**
 * Obtiene todas las películas
 * @returns {Promise<Array>} Lista de películas
 */
export const getMovies = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/movies`, {
      method: 'GET',
      headers: getHeaders(),
    });
    return await handleResponse(response);
  } catch (error) {
    handleError(error);
  }
};

/**
 * Obtiene una película específica por ID
 * @param {number|string} id - ID de la película
 * @returns {Promise<Object>} Datos de la película
 */
export const getMovieById = async (id) => {
  try {
    const response = await fetch(`${API_BASE_URL}/movies/${id}`, {
      method: 'GET',
      headers: getHeaders(),
    });
    return await handleResponse(response);
  } catch (error) {
    handleError(error);
  }
};

/**
 * Crea una nueva película
 * @param {Object} movieData - Datos de la película
 * @param {string} movieData.title - Título de la película
 * @param {string} movieData.director - Director
 * @param {number} movieData.year - Año de lanzamiento
 * @param {string} movieData.genre - Género
 * @returns {Promise<Object>} Película creada
 */
export const createMovie = async (movieData) => {
  try {
    const response = await fetch(`${API_BASE_URL}/movies`, {
      method: 'POST',
      headers: getHeaders(),
      body: JSON.stringify(movieData),
    });
    return await handleResponse(response);
  } catch (error) {
    handleError(error);
  }
};

/**
 * Actualiza una película existente
 * @param {number|string} id - ID de la película
 * @param {Object} movieData - Datos actualizados
 * @returns {Promise<Object>} Película actualizada
 */
export const updateMovie = async (id, movieData) => {
  try {
    const response = await fetch(`${API_BASE_URL}/movies/${id}`, {
      method: 'PUT',
      headers: getHeaders(),
      body: JSON.stringify(movieData),
    });
    return await handleResponse(response);
  } catch (error) {
    handleError(error);
  }
};

/**
 * Elimina una película
 * @param {number|string} id - ID de la película
 * @returns {Promise<Object>} Confirmación de eliminación
 */
export const deleteMovie = async (id) => {
  try {
    const response = await fetch(`${API_BASE_URL}/movies/${id}`, {
      method: 'DELETE',
      headers: getHeaders(),
    });
    return await handleResponse(response);
  } catch (error) {
    handleError(error);
  }
};

/**
 * Exportar la URL base para uso en componentes (ej. mostrar estado de conexión)
 */
export const getApiBaseUrl = () => API_BASE_URL;
