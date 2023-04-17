<?php


require_once __DIR__ . '/../dao/dao_populaire.php';


$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch($action){
    case 'list':{
        require_once __DIR__ . '/../views/plus-populaires.phtml';
        break;

    }
    default:{
        require_once(__DIR__ . '/../controllers/errorController.php');

    }
}
?>