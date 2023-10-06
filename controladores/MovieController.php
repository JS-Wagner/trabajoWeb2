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
                // Construir dinámicamente la consulta SQL con la cláusula 'AND'
                $sql = "SELECT * FROM peliculas WHERE ";
                $conditions = array();

                foreach ($genres as $genre) {
                    $conditions[] = "genero LIKE ?";
                }

                $sql .= implode(' AND ', $conditions);

                // Llama a la función del modelo con la consulta SQL y el array de géneros
                $movies = $this->movieModel->getMoviesByGenres($sql, $genres);

                // Incluir la vista directamentea
                $this->movieView->showTemplate($movies); // Muestra la vista

            } else {
                // Si no se proporcionaron géneros, muestra todas las películas
                //$movies = $this->movieModel->getAllMovies();

                // Incluir la vista directamente
                //$this->movieView->showTemplate();
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
            $this->checkRequiredData(['nombre']);
            $nombre = $_GET['nombre'];
            $movies = $this->movieModel->getMoviesByName($nombre);

            // Incluir la vista directamente
            $this->movieView->showTemplate();
        } catch (InvalidArgumentException $e) {
            // Manejo de error
            echo "Error: " . $e->getMessage();
        }
    }
}
