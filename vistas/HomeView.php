<?php
class HomeView
{
    public function renderHomeView($movies)
    {
        require_once './templates/HomeViewTemplate.phtml';
    }
    
    public function showError($error) {
        require './templates/ErrorTemplate.phtml';
    }
}
