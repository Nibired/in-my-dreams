<?php

$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch($action){
    case 'list':{
        require_once(__DIR__ . '/../models/config.php');

        

        $lesPublications = array('Sombre ambiance', 'rêve bleu', 'rêve en noir et blanc');

        require_once __DIR__ . '/../views/publications.phtml';
        break;
    }
    default:{
        require_once __DIR__ . '/../controllers/errorController.php';

    }
}

?>

