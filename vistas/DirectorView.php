<?php
class DirectorView
{
    function renderDirectorsView($directors)
    {
        require_once './templates/AllDirectorTemplate.phtml';
    }

    function renderEachDirectorView($director){
        require_once './templates/EachDirectorTemplate.phtml';
    }

    public function showError($error) {
        require './templates/ErrorTemplate.phtml';
    }

    function renderEditDirectorForm($director)
    {
        require_once './templates/EditDirectorTemplate.phtml';
    }

}
