<?php


require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Reve.php';
require_once __DIR__ . '/../models/Note.php';
require_once __DIR__ . '/../dao/dao_Utilisateur.php';
require_once __DIR__ . '/../dao/dao_favoris.php';
require_once __DIR__ . '/../models/Suivre.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnexion();
// Vérif si l'utilisateur est connecté en vérifiant si une variable de session appelée 
    if (!isset($_SESSION['id_utilisateur'])) {
        header('Location: ../controllers/connexionController.php');
    exit();
    }

    $action = $_GET['action'] ?? 'dashboard';

switch ($action) {
//Dans ce case , récupère l'ID de l'utilisateur et l'ID de l'utilisateur à suivre à partir des données POST.
    case 'add-favorite':
        $id_utilisateur = $_SESSION['id_utilisateur'];
        $id_utilisateur_suivre = isset($_POST['id_utilisateur_suivre']) ? (int)$_POST['id_utilisateur_suivre'] : null;
//Si l'utilisateur n'a pas déjà ajouté l'autre à ses fav, l'ajoute et met à jour la liste des fav ds la var de session.
        if ($id_utilisateur !== null && $id_utilisateur_suivre !== null && !isFavorite($id_utilisateur, $id_utilisateur_suivre)) {
            ajouterUtilisateurFavori($id_utilisateur, $id_utilisateur_suivre);
            echo "Favori ajouté";
// Mise à jour de la liste des favoris dans la session
            $_SESSION['utilisateursFav'] = getUtilisateursFavoris($id_utilisateur_suivre) ?? [];
        } else {
            echo "Erreur: Favori non ajouté";
        }
        exit();
        break;

    default:
//Ds le cas default, récupère l'id de l'utilisateur, récupère les informations de l'utilisateur et les rêves associés
        $id_utilisateur = $_SESSION['id_utilisateur'];
        $_SESSION['utilisateur'] = getUtilisateurById($id_utilisateur) ?? [];
        $_SESSION['reves'] = getReveByNote($id_utilisateur) ?? [];
//filtre les rêves fav avec une note sup ou = à 4 et récupère la liste des fav
        $_SESSION['reves_favoris'] = array_filter($_SESSION['reves'], function($reve) {
            return $reve['note'] >= 4;
        }) ?? [];
        $_SESSION['utilisateursFav'] = getUtilisateursFavoris($id_utilisateur) ?? [];
//inclut le fichier user-dashboard.phtml et transmet les var à afficher.
        require __DIR__ . '/../tab-de-bord/user-dashboard.phtml';
        break;
}
?>