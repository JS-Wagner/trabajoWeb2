<?php
require_once './modelos/MovieModel.php';
require_once './vistas/MovieView.php';
require_once './helpers/AuthHelper.php';
require_once './modelos/DirectorModel.php';
require_once './modelos/Model.php';

class MovieController
{
    private $movieModel;
    private $movieView;
    private $directorModel;
    private $model;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->movieView = new MovieView();
        $this->directorModel = new DirectorModel();
        $this->model = new Model();
    }

    public function showHome() {
        $sql = "SELECT * FROM peliculas";
        $directores =  $this->directorModel->getAllDirectors();
        $movies = $this->movieModel->getAllMovies($sql);
        $this->movieView->renderHomeView($movies, $directores);
    }

    public function showMovie($id)
    {
        $movie = $this->movieModel->getMovieByiD($id);
        $directorName = $this->directorModel->getDirectorNameById($movie->director_id);
        $this->movieView->renderMovieView($movie, $directorName);
    }

    public function showEditMovieForm($id)
    {
        // Verifica si el usuario está autenticado
        AuthHelper::verify();
        // Modificamos la consulta SQL y la ejecución
        $sql = "SELECT * FROM peliculas WHERE pelicula_id = ?";
        $query = $this->model->getDB()->prepare($sql);
        $query->execute([$id]);
        $movie = $query->fetch(PDO::FETCH_OBJ);

        if ($movie) {
            // Obtenemos los datos de los directores usando la función getAllDirectors
            $directores = $this->directorModel->getAllDirectors();

            // Carga la vista del formulario de edición con los datos de la película y los directores
            $this->movieView->renderEditMovieForm($movie, $directores);
        } else {
            $this->movieView->showError("Película no encontrada.");
        }
    }

    public function addMovie()
    {
        // verifico logueado
        AuthHelper::verify();
        // obtengo los datos del usuario
        $nombre = $_POST['nombre'];
        $genero = $_POST['genero'];
        $fecha = $_POST['fecha'];
        $premios = $_POST['premios'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $presupuesto = $_POST['presupuesto'];
        $estudio = $_POST['estudio'];
        $director_id = $_POST['director_id'];

        $id = $this->movieModel->insertarPelicula($nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id);
        if ($id) {
            header('Location: ' . BASE_URL . 'home');
        } else {
            $this->movieView->showError("Error al insertar la tarea");
        }
    }

    function removeMovie()
    {
        // Verifica si se ha enviado el form para eliminar
        if (isset($_POST['eliminar']) && isset($_POST['id'])) {
            // verifico logueado
            AuthHelper::verify();
            // obtengo la ID del director a eliminar
            $movieId = $_POST['id'];

            // validaciones
            if (empty($movieId)) {
                $this->movieView->showError("ID de director no válido.");
                return;
            }

            //ejecuto la operacion sql para borrarlo
            $this->movieModel->borrarPelicula($movieId);
            header('Location: ' . BASE_URL . 'home');
        } else {
            //si no lo encuentro largo error
            $ErrorController = new ErrorController();
            $ErrorController->showError404();
        }
    }

    function editarPelicula()
    {
        // verifico logueado
        AuthHelper::verify();
        // obtengo los datos del usuario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $genero = $_POST['genero'];
        $fecha = $_POST['fecha'];
        $premios = $_POST['premios'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $presupuesto = $_POST['presupuesto'];
        $estudio = $_POST['estudio'];
        $director_id = $_POST['director_id'];

        $this->movieModel->editarPelicula($id, $nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id);
        header('Location: ' . BASE_URL . 'home');
    }
}
