<?php
require_once './modelos/DirectorModel.php';
require_once './vistas/DirectorView.php';
require_once './helpers/AuthHelper.php';

class DirectorController
{
    private $directorModel;
    private $directorView;

    public function __construct()
    {
        $this->directorModel = new DirectorModel();
        $this->directorView = new DirectorView();
    }

    public function showDirectors()
    {
        $sql = "SELECT * FROM director";
        $directors = $this->directorModel->getAllDirectors($sql);
        $this->directorView->renderDirectorsView($directors);
    }

    public function showDirectorsByID($id)
    {
        $director = $this->directorModel->getDirectorByID($id);
        $this->directorView->renderEachDirectorView($director);
    }


    public function addDirector()
    {
        // verifico logueado
        AuthHelper::verify();
        // obtengo los datos del usuario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nacionalidad = $_POST['nacionalidad'];

        // validaciones
        if (empty($nombre) || empty($apellido) || empty($nacionalidad)) {
            $this->directorView->showError("Debe completar todos los campos");
            return;
        }

        $id = $this->directorModel->insertarDirector($nombre, $apellido, $nacionalidad);
        if ($id) {
            header('Location: ' . BASE_URL . 'directores');
        } else {
            $this->directorView->showError("Error al insertar la tarea");
        }
    }

    function removerDirector()
    {
        // Verifica si se ha enviado el form para eliminar
        if (isset($_POST['eliminar']) && isset($_POST['id'])) {
            // verifico logueado
            AuthHelper::verify();
            // obtengo la ID del director a eliminar
            $directorId = $_POST['id'];

            // validaciones
            if (empty($directorId)) {
                $this->directorView->showError("ID de director no válido.");
                return;
            }

            //ejecuto la operacion sql para borrarlo
            $this->directorModel->borrarDirector($directorId);
            header('Location: ' . BASE_URL . 'directores');
        } else {
            //si no lo encuentro largo error
            $ErrorController = new ErrorController();
            $ErrorController->showError404();
        }
    }

    function modificarDirector()
    {
        // verifico logueado
        AuthHelper::verify();
        // obtengo los datos del usuario
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nacionalidad = $_POST['nacionalidad'];

        // validaciones
        if (empty($id) || empty($nombre) || empty($apellido) || empty($nacionalidad)) {
            $this->directorView->showError("Debe completar todos los campos");
            return;
        }
        $this->directorModel->modificarDirector($id, $nombre, $apellido, $nacionalidad);
        header('Location: ' . BASE_URL . 'directores');
    }

    public function showEditDirectorForm($directorId)
    {
        // Verifica si el usuario está autenticado
        AuthHelper::verify();

        // Obtén los datos del director a editar
        $director = $this->directorModel->getDirectorByID($directorId);

        if ($director) {
            // Carga la vista del formulario de edición con los datos del director
            $this->directorView->renderEditDirectorForm($director);
        } else {
            $this->directorView->showError("Director no encontrado.");
        }
    }
}
