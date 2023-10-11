<?php
require_once './modelos/DirectorModel.php';
require_once './vistas/DirectorView.php';

class DirectorController {
    private $directorModel;
    private $directorView;

    public function __construct(){
        $this->directorModel = new DirectorModel();
        $this->directorView = new DirectorView();
    }

    public function showDirectors(){
        $sql = "SELECT * FROM director";
        $directors = $this->directorModel->getAllDirectors($sql);
        $this->directorView->renderDirectorsView($directors);
    }

    public function showDirectorsByID($id){
        $sql = "SELECT * FROM director WHERE director_id = $id";
        $director = $this->directorModel->getDirectorByID($sql);
        $this->directorView->renderEachDirectorView($director);
    }
}
    