<?php
require_once './controladores/ErrorController.php';
require_once './controladores/MovieController.php';
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
    case 'buscar':
        // Verificar si la acción buscar/ contiene géneros separados por /
        if (strpos($action, 'buscar/') === 0) {
            $genres = explode('/', substr($action, 7)); // Eliminar "buscar/" y dividir géneros
            $MovieController = new MovieController();
            $MovieController->showMoviesByGenres($genres);
        } else {
            // parsea la accion Ej: about/juan --> ['about', 'juan']
            $params = explode('/', $action); // genera un arreglo
            // Verificar si se proporcionaron géneros
        }
        if (count($params) > 1) {
            $genres = $params;
            array_shift($genres); // Eliminar el primer elemento (que es 'buscar')
            $MovieController = new MovieController();
            $MovieController->showMoviesByGenres($genres);
        } elseif (isset($_GET['genres'])) {
            // Búsqueda por un solo género
            $genres = [$_GET['genres']];
            $MovieController = new MovieController();
            $MovieController->showMoviesByGenres($genres);
        } else {
            // Realizar alguna acción de búsqueda sin géneros o redirigir a una página de búsqueda
        }
        break;
    case 'director':
        if (empty($params[1])) {
            $DirectorController = new DirectorController();
            $DirectorController->showDirectors();
        } else {
            //showAbout($params[1]);
        }
        break;
    default:
        // Cargar la vista de error 404
        $ErrorController = new ErrorController();
        $ErrorController->showError404();
        break;
}
