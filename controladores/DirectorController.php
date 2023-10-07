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
}
    