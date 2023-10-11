<?php
require_once './controladores/ErrorController.php';
require_once './controladores/MovieController.php';
require_once './controladores/SearchController.php';
require_once './controladores/HomeController.php';
require_once './controladores/DirectorController.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home';
}

/*
**      /home               =>     showHome(); //FALTA IMPLEMENTAR 
**      /about/:director    =>     showAbout(:dev); //FALTA IMPLEMENTAR
**      /buscar/:genero     =>     showMoviesByGenres(:genero);
**      /??????             =>     showError404();
*/

// parsea la accion Ej: about/juan --> ['about', 'juan']
$params = explode('/', $action); // genera un arreglo

switch ($params[0]) {
    case 'home':
        $HomeController = new HomeController();
        $HomeController->showHome();
        break;
    case 'buscarNombre':
        $names = explode('/', substr($action, 12));
        $SearchController = new SearchController();
        $SearchController->searchMoviesByName($names);
        break;
    case 'buscar':
        $genres = array();
        foreach ($_GET as $parametro => $valor) {
            if ($valor == 'on') {
                // El parámetro está seleccionado, agrégalo a la lista de géneros seleccionados
                $genres[] .= $parametro;
            }
        }
        $SearchController = new SearchController();
        $SearchController->showMoviesByGenres($genres);
        break;
    case 'movie':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {

            $movieId = $_GET['id'];
            $MovieController = new MovieController();
            $MovieController->showMovie($movieId);
        } else {
            $ErrorController = new ErrorController();
            $ErrorController->showError404();
        }
        break;
    case 'directores':
        $DirectorController = new DirectorController();
        $DirectorController->showDirectors();
        break;
    case 'director':
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $directorId = $_GET['id'];
            $DirectorController = new DirectorController();
            $DirectorController->showDirectorsByID($directorId);
        } else {
            $ErrorController = new ErrorController();
            $ErrorController->showError404();
        }
        break;
    default:
        // Cargar la vista de error 404
        $ErrorController = new ErrorController();
        $ErrorController->showError404();
        break;
}
