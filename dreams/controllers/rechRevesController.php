<?php

require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Reve.php";
require_once __DIR__ . "/../models/Sexe.php";
require_once __DIR__ . "/../models/Cp_ville.php";


$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch ($action) {
//Affichage vue
    case 'list':
        require_once __DIR__ . '/../views/rech-reves.phtml';
        break;
//Si au moins un champs est renseigné, redirection page reve ttrouvé    
    case 'submit':
        if (!empty($_POST['MOT_CLE']) 
        || !empty($_POST['pseudo']) 
        || !empty($_POST['id_type_reve']) 
        || !empty($_POST['id_sexe']) 
        || !empty($_POST['id_cp_ville'])) {
            require_once __DIR__ . '/../dao/dao_rech_reve.php';
        } else {
            header('Location: index.php?page=rech-reves&action=list');
        }
 }
 ?>
    
     
    
    





