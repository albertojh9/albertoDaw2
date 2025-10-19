from flask import Flask, render_template, redirect, url_for, flash, abort, request
from models import save_contact, get_movies, get_movie_by_id, init_db, add_movies, insert_movie



app = Flask(__name__, template_folder='../frontend/templates', static_folder='../frontend/static')

app = Flask(__name__, template_folder='../frontend/templates', static_folder='../frontend/static')
app.secret_key = 'clave_super_secreta_123'

@app.route('/about')
def about():
    return render_template("about.html")

# Se ejecuta cuando index se renderiza
@app.route('/')
def index():
#    return "<h1>Hello world</h1>\n<h2>Segundo encabezado</h2>\n<p>Texto normal</p>"
    return render_template("index.html")


@app.route('/contact', methods=['GET', 'POST'])
def contact():
    if request.method == 'POST':
        name = request.form.get('name')
        email = request.form.get('email')
        message = request.form.get('message')
        subject = request.form.get('subject')

        save_contact(name, email, subject, message)
        return redirect(url_for('contact'))
    return render_template('contact.html')

@app.route('/movies')
def movies():
    movie_list = get_movies() 
    return render_template("movies.html", movies=movie_list)

@app.route("/movie/<int:movie_id>")
def movie_detail(movie_id):
    movie = get_movie_by_id(movie_id)
    if not movie_detail:
        return redirect(url_for("movies"))
    return render_template("movie_detail.html", movie = movie)


@app.route('/add_movie', methods=['GET', 'POST'])
def add_movie():
    if request.method == 'POST':
        title = request.form.get('title')
        director = request.form.get('director')
        year = request.form.get('year')
        genre = request.form.get('genre')
        description = request.form.get('description')
        rating = request.form.get('rating')
        poster_url = request.form.get('poster_url')
        
        # Llamo a la función para insertar la película
        insert_movie(title, director, year, genre, description, rating, poster_url)
        
        flash('Película añadida correctamente', 'success')
        return redirect(url_for('movies'))
    
    return render_template('add_movie.html')





if __name__ == '__main__':
    init_db()
    movie_list = get_movies()
    if not movie_list:
        add_movies()
    app.run(debug=True)
