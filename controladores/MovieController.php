<?php
require_once './modelos/MovieModel.php';

class MovieController
{
    private $movieModel;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
    }

    private function checkRequiredData($data)
    {
        foreach ($data as $key) {
            if (!isset($_GET[$key]) || empty($_GET[$key])) {
                throw new InvalidArgumentException("Falta el dato requerido: $key");
            }
        }
    }

    public function showMoviesByGenres()
    {
        try {
            // Verificar si se proporcionó el parámetro 'genres'
            if (isset($_GET['genres'])) {
                $genresParam = $_GET['genres'];

                // Si es una cadena, divide los géneros en un array
                if (is_string($genresParam)) {
                    $genres = explode(',', $genresParam);
                } elseif (is_array($genresParam)) {
                    $genres = $genresParam;
                } else {
                    // El parámetro 'genres' no es válido
                    throw new InvalidArgumentException("El parámetro 'genres' no es válido");
                }

                // Construir dinámicamente la consulta SQL con la cláusula 'AND'
                $sql = "SELECT * FROM peliculas WHERE ";
                $conditions = array();

                foreach ($genres as $genre) {
                    $conditions[] = "genero LIKE ?";
                }

                $sql .= implode(' AND ', $conditions);

                // Llama a la función del modelo con la consulta SQL y el array de géneros
                $movies = $this->movieModel->getMoviesByGenres($sql, $genres);

                // Incluir la vista directamente
                //PRUEBAS DE CONSULTA SQL//
                //echo "Consulta SQL: $sql<br>";
                require_once './vistas/MovieView.phtml';
            } else {
                // El parámetro 'genres' no se proporcionó
                throw new InvalidArgumentException("Falta el dato requerido: genres");
            }
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage();
        }
    }

    public function showMoviesByYear($year)
    {
        try {
            $this->checkRequiredData(['year']);
            $year = $_GET['year'];
            $movies = $this->movieModel->getMoviesByYear($year);

            // Incluir la vista directamente
            require_once './vistas/MovieView.phtml';
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage();
        }
    }

    public function showMoviesByDirector($director)
    {
        try {
            $this->checkRequiredData(['director']);
            $director = $_GET['director'];
            $movies = $this->movieModel->getMoviesByDirector($director);

            // Incluir la vista directamente
            require_once './vistas/MovieView.phtml';
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage();
        }
    }

    public function searchMoviesByName($nombre)
    {
        try {
            $this->checkRequiredData(['nombre']);
            $nombre = $_GET['nombre'];
            $movies = $this->movieModel->getMoviesByName($nombre);

            // Incluir la vista directamente
            require_once './vistas/MovieView.phtml';
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage(); 
        }
    }
}
