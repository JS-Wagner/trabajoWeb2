<?php
class MovieModel
{
    /*
    Obtiene la lista de películas según su genero.
    */

    function connectToDatabase()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=tpweb2db;charset=utf8', 'root', '');
            return $db;
        } catch (PDOException $e) {
            // Manejo de errores, (conexion fallida)
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public function getAllMovies($sql)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function getMoviesByGenres($sql, $genres)
    {
        $db = $this->connectToDatabase();

        $query = $db->prepare($sql);

        // Asigna los valores a los marcadores de posición
        $genreValues = array_map(function ($genre) {
            return '%' . trim($genre) . '%';
        }, $genres);

        $query->execute($genreValues);

        $movies = $query->fetchAll(PDO::FETCH_OBJ);

        return $movies;
    }

    function getMoviesByYear($year)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('SELECT * FROM peliculas WHERE YEAR(date) = :year');
        $query->execute([':year' => $year]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    function getMoviesByDirector($director_id)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('SELECT * FROM peliculas WHERE director_id = ?');
        $query->execute([$director_id]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }


    function getMoviesByName($nombre)
    {
        $db = $this->connectToDatabase();
        $keyword = '%' . $nombre . '%'; // Agregar comodines para buscar cualquier coincidencia en el nombre
        $query = $db->prepare('SELECT * FROM peliculas WHERE nombre LIKE :keyword');
        $query->execute([':keyword' => $keyword]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }
}
