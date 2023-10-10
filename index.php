<?php
require_once './controladores/SearchController.php';
// Instancio la clase del controller

$controller = new SearchController();
$controller->showMoviesByGenres();

?>