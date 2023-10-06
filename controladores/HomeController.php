<?php
class HomeController{
    
    public function showHome(){
        require_once './vistas/HomeView.php';
        $home = new HomeView();
        $home->renderHomeView();
    }
}