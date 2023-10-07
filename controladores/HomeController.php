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
}
