<?php
require_once 'Model.php';

class DirectorModel extends Model
{
    public function getAllDirectors()
    {
        $sql = "SELECT * FROM director";
        $query = $this->db->query($sql);
        $directors = $query->fetchAll(PDO::FETCH_OBJ);

        foreach ($directors as $director) {
            $director->peliculas = $this->getPeliculas($director->director_id);
        }

        return $directors;
    }

    public function getDirectorNameById($id)
    {
        $sql = "SELECT Nombre, Apellido FROM director WHERE director_id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    public function getDirectorByID($id)
    {
        $sql = "SELECT * FROM director WHERE director_id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $director = $query->fetch(PDO::FETCH_OBJ);

        if ($director) {
            $director->peliculas = $this->getPeliculas($director->director_id);
        }

        return $director;
    }

    public function getPeliculas($director_id)
    {
        $sql = "SELECT * FROM peliculas WHERE director_id = :director_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':director_id', $director_id, PDO::PARAM_INT);
        $query->execute();
        $peliculas = $query->fetchAll(PDO::FETCH_OBJ);

        return $peliculas;
    }

    public function insertarDirector($nombre, $apellido, $nacionalidad)
    {
        $sql = "INSERT INTO director (Nombre, Apellido, Nacionalidad) VALUES (:nombre, :apellido, :nacionalidad)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $query->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $query->bindParam(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $query->execute();

        return $this->db->lastInsertId();
    }

    public function modificarDirector($id, $nombre, $apellido, $nacionalidad)
    {
        $sql = "UPDATE director SET Nombre = :nombre, Apellido = :apellido, Nacionalidad = :nacionalidad WHERE director_id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $query->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $query->bindParam(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
        $query->execute();
    }

    public function borrarDirector($id)
    {
        $sql = "DELETE FROM director WHERE director_id = :id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
}
