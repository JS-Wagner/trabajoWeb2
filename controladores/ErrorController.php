<?php

class ErrorController{
    function showError404(){

        require_once './vistas/404.php';
        $E404 = new E404View();
        $E404->show404();
    }
}
