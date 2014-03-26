<?php

header('Content-type:text/html;charset=utf-8');
//session_start();
//session_destroy();
//exit;
require_once 'base/RequestRegistry.php';
use base\ApplicationRegistry;


require_once 'controller/FrontController.php';
use controller\FrontController;
FrontController::run();
//$mysql = ApplicationRegistry::getMysql();

//echo $mysql->getDB(),$mysql->getUser();

//$map = ApplicationRegistry::getControllerMap();

//var_dump($map);

//echo $map->getForward('login',3);
?>