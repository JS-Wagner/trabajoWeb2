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
        $sql = "SELECT * FROM director WHERE director_id = $id";
        $director = $this->directorModel->getDirectorByID($sql);
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
            header('Location: ' . BASE_URL);
        } else {
            $this->directorView->showError("Error al insertar la tarea");
        }
    }

    function removerDirector($id)
    {
        $this->directorModel->borrarDirector($id);
        header('Location: ' . BASE_URL);
    }

    //function modificarDirector($id)
    //{
    //    $this->directorModel->modificarDirector($id); //NO IMPLEMENTADO
    //    header('Location: ' . BASE_URL);
    //}
}
