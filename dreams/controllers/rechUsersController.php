<?php

require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . '/../dao/dao_rech_users.php';
require_once __DIR__ . "/../models/Cp_ville.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Sexe.php";


    $page = $_GET['page'] ?? 'index';
        $action = $_GET['action'] ?? 'view';

    switch($action){
        case 'list':{
            require_once __DIR__ . '/../views/rech-utilisateurs.phtml';
        break;
        }
//Si au moins un champs est rempli valider la recherche 
    case 'submit': {
        if (!empty($_POST['pseudo']) 
        || !empty($_POST['id_sexe']) 
        || !empty($_POST['date_naissance']) 
        || !empty($_POST['id_cp_ville'])) {
            $pseudo = $_POST['pseudo'];
            $id_sexe = $_POST['id_sexe'];
            $date_naissance = $_POST['date_naissance'];
            $id_cp_ville = $_POST['id_cp_ville'];
//Appeller foncction dao pour récupèrer des utilisateurs à partir de critères de recherche        
//stocke leurs rêves correspondants et les stocke dans une variable de session "utilisateurs".
    $usersFound = getUtilisateurBysearch($pseudo, $id_sexe, $date_naissance, $id_cp_ville);
        foreach ($usersFound as $key => $user) {
            $usersFound[$key]['reves'] = getRevesByUtilisateur($user['id_utilisateur']);
        }
//si utilisateurs trouvés, redirection vers une page utilisateur, sinon vers page de liste de recherche.
            $_SESSION['utilisateurs'] = $usersFound;
                header('Location: dreams/redirect-page-user/page-user.php'); 
            } else {
                header('Location: index.php?page=rech-users&action=list');
            }
    break;
        }
}
?>