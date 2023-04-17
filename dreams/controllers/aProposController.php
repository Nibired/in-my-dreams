<?php


require_once __DIR__ . '/../partials/nav.phtml'; 

$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch($action){
    case 'view':{
        require_once __DIR__ . '/..//views/a-propos.phtml';
        break;

    }
    default:{
        require_once(__DIR__ . '/../controllers/errorController.php');

    }
}
?>