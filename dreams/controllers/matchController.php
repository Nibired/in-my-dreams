<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../partials/nav.phtml';
require_once __DIR__ . '/../models/Reponse.php';
require_once __DIR__ . '/../dao/dao_match.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    $page = $_GET['page'] ?? 'index';
    $action = $_GET['action'] ?? 'view';

    global $matchingUsers;
    $id_utilisateur = 0;

    $conn = getConnexion();

   
    if (isset($_SESSION['id_utilisateur'])) {
        $id_utilisateur = $_SESSION['id_utilisateur'];
    } else {
            // L'utilisateur n'est pas connecté , je dois ajouter un message pour gérer l'erreur
}


//Recuperer les id utilisateur qui ont le plus de choix similaires dans la table reponse en appelant la fonction du dao
    $matchingUsers = getMatchingUsers($id_utilisateur);

//Recupérer les 2 derniers utilisateur qui ont le plus de similitudes dans les choix
    $latestMatches = getLatestMatches();



    switch ($action) {
//Redirection apres validation qcm pour constater si il y a match
    case 'match':
        $matchingUsers = getMatchingUsers($id_utilisateur);
        require_once(__DIR__ . '/../views/match.phtml');
        break;
//Si il y des utilisateurs match, possibilité de cliquer sur le profil d'un d'entre eux pour consulter sa page
    case 'page-user':
        require_once __DIR__ . '/../dao/dao_Utilisateur.php';
        require_once __DIR__ . '/../models/config.php';
        $id_utilisateur = isset($_GET['id_utilisateur']) ? (int)urldecode($_GET['id_utilisateur']) : null;
        $utilisateur = getUtilisateurById($id_utilisateur);
        require_once __DIR__ . '/../redirect-page-user/page-user.php';
        break;
    default:
        require_once(__DIR__ . '/../controllers/errorController.php');
        break;
}
?>

