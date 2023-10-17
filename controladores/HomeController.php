<?php
require_once './modelos/MovieModel.php';
require_once './vistas/HomeView.php';

class HomeController {
    private $movieModel;
    private $homeView;

    public function __construct() {
        $this->movieModel = new MovieModel();
        $this->homeView = new HomeView();
    }

    public function showHome() {
        $sql = "SELECT * FROM peliculas";
        $movies = $this->movieModel->getAllMovies($sql);
        $this->homeView->renderHomeView($movies);
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
            $this->homeView->showError("Error al insertar la tarea");
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
                $this->homeView->showError("ID de director no válido.");
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

    function modificarPelicula()
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

        $id = $this->movieModel->modifyPelicula($id, $nombre, $genero, $fecha, $premios, $duracion, $clasificacion, $presupuesto, $estudio, $director_id);
        if ($id) {
            header('Location: ' . BASE_URL . 'home');
        } else {
            $this->homeView->showError("Error al insertar la tarea");
        }
    }
}
