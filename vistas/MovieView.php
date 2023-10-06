<?php
class MovieView{
    function showTemplate($movies = null){
        require_once './templates/MovieTemplate.phtml';
    }
}