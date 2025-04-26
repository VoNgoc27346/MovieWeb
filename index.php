<?php
require_once 'controllers/MovieController.php';
require_once 'models/MovieModel.php';

$controller = new MovieController();
$controller->index(); 
$controller->fetchMoviesFromTMDB();
