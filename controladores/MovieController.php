<?php
require_once './modelos/MovieModel.php';
require_once './vistas/MovieView.php';

class MovieController
{
    private $movieModel;
    private $movieView;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->movieView = new MovieView();
    }
 

    private function checkRequiredData($data)
    {
        foreach ($data as $key) {
            if (!isset($_GET[$key]) || empty($_GET[$key])) {
                throw new InvalidArgumentException("Falta el dato requerido: $key");
            }
        }
    }

    public function showMoviesByGenres($genres = [])
    {
        try {
            // Verificar si se proporcionó el parámetro 'genres'
            if (!empty($genres)) {
                // Construir dinámicamente la consulta SQL con la cláusula 'OR'
               $condicion = '';
                
                foreach ($genres as $genre) {
                    $condicion .= "(FIND_IN_SET('$genre', genero) > 0) OR ";
                }
                $sql = "SELECT * FROM peliculas WHERE $condicion";
                
                $sql = rtrim($sql, " OR");

                // Llama a la función del modelo con la consulta SQL y el array de géneros
                $movies = $this->movieModel->getMoviesByGenres($sql);

                // Incluir la vista directamentea
                $this->movieView->showTemplate($movies); // Muestra la vista

            } else {
                // Si no se proporcionaron géneros, muestra todas las películas
                $sql = "SELECT * FROM peliculas";
                $movies = $this->movieModel->getAllMovies($sql);

                // Incluir la vista directamente
                $this->movieView->showTemplate();
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
            $this->movieView->showTemplate();
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
            $this->movieView->showTemplate();;
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage();
        }
    }

    public function searchMoviesByName($nombre)
    {
        try {
            $this->checkRequiredData(['name']);
            $nombre = $_GET['name'];
            $movies = $this->movieModel->getMoviesByName($nombre);

            // Incluir la vista directamente
            $this->movieView->showTemplate($movies);
        } catch (InvalidArgumentException $e) {
            $movies = $this->movieModel->getMoviesByName(null);
        }
    }
}
