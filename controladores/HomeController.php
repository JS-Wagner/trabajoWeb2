<?php
    require_once './modelos/MovieModel.php';
    require_once './vistas/HomeView.php';
class HomeController{
    private $movieModel;
    private $HomeView;

    public function showHome(){
        $this->movieModel = new MovieModel();
        $this->HomeView = new HomeView();
        $sql = "SELECT * FROM peliculas";
        $movies = $this->movieModel->getAllMovies($sql);
        $this->HomeView->renderHomeView($movies);
    }
}