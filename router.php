<?php
require_once './controladores/ErrorController.php';
require_once './controladores/MovieController.php';
require_once './controladores/SearchController.php';
require_once './controladores/HomeController.php';
require_once './controladores/DirectorController.php';
require_once './controladores/AuthController.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home';
}

/*
BASE
**      /home               =>     showHome();                                  //ruta por defecto, muestra la home.

PELICULAS
**      /buscarNombre       =>     searchMoviesByName();                        //muestra las peliculas que matchean el substring dado.
**      /buscar             =>     showMoviesByGenres;                          //muestra las peliculas por generos seleccionados.
terminalas compañero 👍

AUTH
**      /login ->           =>     authContoller->showLogin();                  //muestra el formulario de autenticación.
**      /logout ->          =>     authContoller->logout();                     //elimina la session.
**      /auth               =>     authContoller->auth();                       //toma los datos del post y autentica al usuario.

DIRECTORES
**      /directores         =>     DirectorController->showDirectors();         //muestra todos los directores en la BD.
**      /director           =>     DirectorController->showDirectorsById();     //muestra el detalle del director seleccionado(recibe su id).
**      /agregardirector    =>     DirectorController->addDirector();           //agrega el director con los parametros del formulario.
**      /eliminardirector   =>     DirectorController->removerDirector();       //elimina el director.
**      /editardirector     =>     DirectorController->showEditDirectorForm();  //muestra el formulario para editar directores.
**      /modificardirector  =>     DirectorController->modificarDirector();     //modifica el director con los datos del formulario.

ERRORES
**      /??????             =>     showError404();                              //muestra la vista de error
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
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->auth();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'agregardirector':
        $controller = new DirectorController();
        $controller->addDirector();
        $controller->showDirectors();
        break;
    case 'eliminardirector':
        $controller = new DirectorController();
        $controller->removerDirector();
        $controller->showDirectors();
        break;
    case 'modificardirector':
        $controller = new DirectorController();
        $controller->modificarDirector();
        $controller->showDirectors();
        break;
    case 'editardirector':
        $directorId = isset($_POST['id']) ? $_POST['id'] : null;
        if ($directorId) {
            $DirectorController = new DirectorController();
            $DirectorController->showEditDirectorForm($directorId);
        } else {
            $ErrorController = new ErrorController();
            $ErrorController->showError404();
        }
        break;
    case 'agregarPelicula':
        $controller = new HomeController();
        $controller->addMovie();
        $controller->showHome();
        break;
    case 'eliminarPelicula':
        $controller = new HomeController();
        $controller->removeMovie();
        $controller->showHome();
        break;
    case 'modificarPelicula':
        $controller = new HomeController();
        $controller->modificarPelicula();
        $controller->showHome();
        break;
    default:
        // Cargar la vista de error 404
        $ErrorController = new ErrorController();
        $ErrorController->showError404();
        break;
}
