<?php
require_once './modelos/MovieModel.php';
require_once './vistas/MovieView.php';
require_once './helpers/AuthHelper.php';
require_once './modelos/DirectorModel.php';

class MovieController{
    private $movieModel;
    private $movieView;
    private $directorModel;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->movieView = new MovieView();
        $this->directorModel = new DirectorModel();
    }

    public function showMovie($id)
    {
        $sql = "SELECT * FROM peliculas WHERE pelicula_id = $id";
        $movie = $this->movieModel->getMovieByiD($sql);
        $directorName = $this->directorModel->getDirectorNameById($movie->director_id);
        $this->movieView->renderMovieView($movie, $directorName); 
    }

    ///////////////AÑADIR ALTA BAJA MODIFICACION ACÁ/////////////

    
}

?>
