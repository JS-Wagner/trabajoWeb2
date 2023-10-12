<?php
require_once './modelos/MovieModel.php';
require_once './vistas/MovieView.php';
require_once './helpers/AuthHelper.php';

class MovieController{
    private $movieModel;
    private $movieView;

    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->movieView = new MovieView();
    }

    public function showMovie($id)
    {
        $sql = "SELECT * FROM peliculas WHERE pelicula_id = $id";
        $movie = $this->movieModel->getMovieByiD($sql);
        $this->movieView->renderMovieView($movie);
    }

    ///////////////AÑADIR ALTA BAJA MODIFICACION ACÁ/////////////

    
}

?>
