<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../dao/dao_favoris.php';
require_once __DIR__ . '/../dao/dao_Utilisateur.php';
require_once __DIR__ . '/../models/Suivre.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  $conn = getConnexion();
  $action = $_GET['action'] ?? 'view';


switch($action){
//récupère tous les utilisateurs enregistrés, puis inclut la vue utilisateur pur les afficher.
    case 'list':{
        require_once __DIR__ . '/../dao/dao_Utilisateur.php';
        $lesUtilisateurs = getAllUtilisateurs();
        require_once __DIR__ . '/../views/utilisateur.phtml';
        break;
    }
    case 'page-user': {
// récupère l'id utilisateur ds get .
        require_once __DIR__ . '/../dao/dao_Utilisateur.php';
        require_once __DIR__ . '/../models/config.php';
//récupère les informations de l'utilisateur et inclut la page page vue pour les afficher       
        $id_utilisateur = isset($_GET['id_utilisateur']) ? (int)urldecode($_GET['id_utilisateur']) : null;
        $utilisateur = getUtilisateurById($id_utilisateur);
        require_once __DIR__ . '/../redirect-page-user/page-user.php';
        break;
    }
    case 'upload': {
// crée un nouvel objet Upload et utilise la méthode uploadImage pour télécharger une image et la stocker sur le serveur
        require_once __DIR__ . '/../models/Upload.php';
        $upload = new Upload();
        $result = $upload->uploadImage($_FILES["fileToUpload"], $_SESSION['id_utilisateur']);
//met à jour l'avatar de l'utilisateur dans la bdd avec le chemin du fichier téléchargé   
        if ($result['success']) {
            updateAvatar($_SESSION['id_utilisateur'], $result['file_path']);
        }
//redirige l'utilisateur vers sa page de profil 
        header("Location: /inmydreams/controllers/utilisateurController.php?action=page-user&id_utilisateur=" . $_SESSION['id_utilisateur']);
        break;
    }
    case 'view':{
        require_once __DIR__ . '/../views/view.phtml';
        break;
    }
    default:{
        require_once __DIR__ . '/../controllers/errorController.php';
    }
}
?>