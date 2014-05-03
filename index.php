<?php
header('Content-type:text/html;charset=utf-8');
require_once 'controller/FrontController.php';
use controller\FrontController;
FrontController::run(); 
?>