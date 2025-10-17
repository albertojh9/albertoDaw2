import sqlite3 


def get_movies_array():
    return [
        (
            "Mi pelicula",
            "Yo",
            2026,
            "Comedia",
            "Una comedia",
            10,
            "data:image/jpeg;base64,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",
        ),
        (
            "Otra peli",
            "Yo tambien",
            2023,
            "Terror",
            "Otra pelicula más",
            10,
            "https://creativereview.imgix.net/uploads/2024/12/AlienRomulus-scaled.jpg?auto=compress,format&crop=faces,entropy,edges&fit=crop&q=60&w=1728&h=2560",
        )
    ]

def init_db():
    connection = sqlite3.connect('backend/peliculas.db')

    # TABLA DE CONTACTOS
    cursor = connection.cursor()
    cursor.execute(
        """
        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            subject TEXT,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
        """
    )

    # TABLA DE PELICULAS
    cursor.execute(
        """
        CREATE TABLE IF NOT EXISTS movies (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            director TEXT NOT NULL,
            year INTEGER NOT NULL,
            genre TEXT NOT NULL,
            description TEXT NOT NULL,
            rating REAL DEFAULT 0.0,
            poster_url TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_STAMP
        )
        """
    )
    connection.commit()
    connection.close()

def add_movies():
    connection = sqlite3.connect('backend/peliculas.db')
    cursor = connection.cursor()

    #código
    movies = get_movies_array()

    cursor.executemany(
        '''
        INSERT INTO movies(title, director, year, genre, description, rating, poster_url)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ''',movies
    )

    connection.commit()
    connection.close()

def save_contact(name, email, subject, message):
    connection = sqlite3.connect('backend/peliculas.db')
    cursor = connection.cursor()

    #código
    if not subject:
        subject = " "

    cursor.executemany(
        '''
        INSERT INTO contacts(name, email, subject, message)
        VALUES (?, ?, ?, ?)
        ''',(name, email, subject, message)
    )

    connection.commit()
    connection.close()

def get_movies():
    connection = sqlite3.connect('backend/peliculas.db')
    connection.row_factory = sqlite3.Row

    cursor = connection.cursor()


    #código
    cursor.execute('SELECT * FROM movies ORDER BY created_at DESC')
    movies = cursor.fetchall()


    connection.commit()
    connection.close()
    return movies
    
def get_movie_by_id(movie_id: int):
    #return movie_list[movie_id]

    connection = sqlite3.connect('backend/peliculas.db')
    connection.row_factory = sqlite3.Row

    cursor = connection.cursor()


    #código
    cursor.execute('SELECT * FROM movies WHERE id = ?',(movie_id,))
    movie = cursor.fetchone()


    connection.commit()
    connection.close()
    return movie


def insert_movie(titulo, director, año, genero, descripcion, valoracion, poster_url):
    connection = sqlite3.connect('backend/peliculas.db')
    cursor = connection.cursor()
    
    cursor.execute(
        '''
        INSERT INTO movies(title, director, year, genre, description, rating, poster_url)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ''',
        (titulo, director, año, genero, descripcion, valoracion, poster_url)
    )
    
    connection.commit()
    connection.close()