<?php
class DirectorModel
{
    /*
    Obtiene la lista de directores.
    */

    function connectToDatabase()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=tpweb2db;charset=utf8', 'root', '');
            return $db;
        } catch (PDOException $e) {
            // (conexion fallida)
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public function getAllDirectors($sql)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
        $directors = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($directors as $director) {
            $director->peliculas = self::getPeliculas($director->director_id);
        }
        return $directors;
    }

    public function getDirectorByID($sql)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
        $director = $query->fetch(PDO::FETCH_OBJ);
        $director->peliculas = self::getPeliculas($director->director_id);
        return $director;
    }

    // Función para obtener todas las películas de un director específico
    public function getPeliculas($director_id)
    {
        if (!empty($director_id)) {
            $movieModel = new MovieModel(); //
            $peliculas = $movieModel->getMoviesByDirector($director_id);
            return $peliculas;
        }
        return array(); // Si no se proporciona un director_id válido, retorna un arreglo vacío.
    }

    public function insertarDirector($nombre, $apellido, $nacionalidad)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('INSERT INTO director (Nombre, Apellido, Nacionalidad) VALUES(?,?,?)');
        $query->execute([$nombre, $apellido, $nacionalidad]);

        return $db->lastInsertId();
    }

    public function borrarDirector($id)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('DELETE FROM director WHERE director_id = ?');
        $query->execute([$id]);
    }

    function modificarDirector($id, $nombre, $apellido, $nacionalidad)
    {
        $db = $this->connectToDatabase();
        $query = $db->prepare('UPDATE director SET Nombre = ?, Apellido = ?, Nacionalidad = ? WHERE director_id = ?');
        $query->execute([$nombre, $apellido, $nacionalidad, $id]);
    }
}
