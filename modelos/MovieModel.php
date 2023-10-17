<?php
require_once './config.php';
class MovieModel
{
    /*
    Obtiene la lista de películas según su genero.
    */

    function connectToDatabase()
    {
        try {
            $db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
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

    public function getMoviesByGenres($sql)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
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

    function getMovieByiD($sql)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
        $movie = $query->fetch(PDO::FETCH_OBJ);
        return $movie;
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

    public function insertarPelicula($nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('INSERT INTO peliculas (nombre, genero, `fecha de lanzamiento`, premios, `duracion en min`, `clasificacion por edades`, presupuesto, `estudio de produccion`, director_id) VALUES (?,?,?,?,?,?,?,?,?)');
        $query->execute([$nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director]);
        return $db->lastInsertId();
    }

    public function borrarPelicula($id)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('DELETE FROM peliculas WHERE pelicula_id = ?');
        $query->execute([$id]);
    }

    function modifyPelicula($id, $nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('UPDATE `peliculas` SET `nombre`= ?,`genero`= ?,`fecha de lanzamiento` = ?,`premios`= ?,`duracion en min`= ?,`clasificacion por edades`= ?,`presupuesto`= ?,`estudio de produccion`= ?,`director_id`= ? WHERE pelicula_id = ?');
        $query->execute([$nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director, $id]);
    }
}
