<?php
require_once './controladores/MovieController.php';
// Instancio la clase del controller

$controller = new MovieController();

$controller->showMoviesByGenres();

?>