<?php
require_once './config.php';
require_once 'Model.php';

class MovieModel extends Model
{
    public function getAllMovies()
    {
        $sql = "SELECT * FROM peliculas";
        $query = $this->db->query($sql);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function getMoviesByGenres($sql)
    {
        $query = $this->db->prepare($sql);
        $query->execute();
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function getMoviesByYear($year)
    {
        $sql = "SELECT * FROM peliculas WHERE YEAR(`fecha de lanzamiento`) = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$year]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function getMoviesByDirector($director_id)
    {
        $sql = "SELECT * FROM peliculas WHERE director_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$director_id]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function getMovieById($id)
    {
        $sql = "SELECT * FROM peliculas WHERE pelicula_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        $movie = $query->fetch(PDO::FETCH_OBJ);
        return $movie;
    }

    public function getMoviesByName($name)
    {
        $sql = "SELECT * FROM peliculas WHERE nombre LIKE ?";
        $query = $this->db->prepare($sql);
        $query->execute(["%$name%"]);
        $movies = $query->fetchAll(PDO::FETCH_OBJ);
        return $movies;
    }

    public function insertarPelicula($nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id)
    {
        $sql = "INSERT INTO peliculas (nombre, genero, `fecha de lanzamiento`, premios, `duracion en min`, `clasificacion por edades`, presupuesto, `estudio de produccion`, director_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->prepare($sql);
        $query->execute([$nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id]);
        return $this->db->lastInsertId();
    }

    public function borrarPelicula($id)
    {
        $sql = "DELETE FROM peliculas WHERE pelicula_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
    }

    public function editarPelicula($id, $nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id)
    {
        $sql = "UPDATE peliculas SET nombre = ?, genero = ?, `fecha de lanzamiento` = ?, premios = ?, `duracion en min` = ?, `clasificacion por edades` = ?, presupuesto = ?, `estudio de produccion` = ?, director_id = ? WHERE pelicula_id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id, $id]);
    }
}
?>
