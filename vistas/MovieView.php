<?php
class MovieView
{
    function renderMovieView($movie, $directorName){
        require_once './templates/MovieTemplate.phtml';
    }

    public function renderHomeView($movies, $directores)
    {
        require_once './templates/HomeViewTemplate.phtml';
    }

    public function renderEditMovieForm($movie, $directores){
        require_once './templates/EditMovieTemplate.phtml';
    }

    public function showError($error) {
        require './templates/ErrorTemplate.phtml';
    }
}
