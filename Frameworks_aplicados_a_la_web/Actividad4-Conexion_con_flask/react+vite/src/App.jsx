import React from 'react';
import MovieList from './components/MovieList';
import './App.css';

/**
 * Componente principal de la aplicación
 */
function App() {
  return (
    <div className="App">
      <header className="App-header">
        <h1>🎬 Sistema de Gestión de Películas</h1>
        <p>React + Flask con Arquitectura de Servicios</p>
      </header>
      
      <main className="App-main">
        <MovieList />
      </main>

      <footer className="App-footer">
        <p>Desarrollado con React + Vite | Backend: Flask + CORS</p>
      </footer>
    </div>
  );
}

export default App;
