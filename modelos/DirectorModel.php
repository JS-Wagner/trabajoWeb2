<?php
class DirectorModel{
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

    public function getAllDirectors($sql){
        $db = $this->connectToDatabase();
        $query = $db->prepare($sql);
        $query->execute();
        $directors = $query->fetchAll(PDO::FETCH_OBJ);
        foreach ($directors as $director) {
            $director->peliculas = self::getPeliculas($director->director_id);
        }
        return $directors;
    }

    // Función para obtener todas las películas de un director específico
    public function getPeliculas($director_id) {
        if (!empty($director_id)) {
            $movieModel = new MovieModel(); // Reemplaza 'MovieModel' con el nombre real de tu modelo de películas.
            $peliculas = $movieModel->getMoviesByDirector($director_id);
            return $peliculas;
        }
        return array(); // Si no se proporciona un director_id válido, retorna un arreglo vacío.
    }
}