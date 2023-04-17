<?php



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';


switch($page){
    case 'index' :{
        require_once("dreams/controllers/controller.php");
        break;
    }
    case 'accueil' :{
        require_once("dreams/controllers/Controller.php");
        break;
    }
    case 'publications' :{
        require_once("dreams/controllers/publicationsController.php");
        break;
    }
    case 'share-dream' :{
        require_once("dreams/controllers/partagRevController.php");
        break;
    }
    case 'chat' :{
        require_once("dreams/controllers/chatController.php");
        break;
    }
    case 'inscription' :{
        require_once("dreams/controllers/inscriptionController.php");
        break;
    }
    case 'connexion' :{
        require_once("dreams/controllers/connexionController.php");
        break;
    }
    case 'qcm':
        switch ($action) {
            case 'submit':
                require_once("dreams/controllers/qcmController.php");
                break;
            case 'match':
                require_once("dreams/controllers/matchController.php");
                break;
            default:
                require_once("dreams/controllers/qcmController.php");
                break;
        }
        break;
    case 'a-propos' :{
        require_once("dreams/controllers/aProposController.php");
        break;
    }
    case 'frm-inscript' :{
        require_once("dreams/controllers/inscriptionController.php");
        break;
    }
    case 'plus-populaires' :{
        require_once("dreams/controllers/populairesController.php");
        break;
    }
    case 'categ-reves' :{
        require_once("dreams/controllers/categController.php");
        break;
    }
    case 'rech-reves' :{
        require_once("dreams/controllers/rechRevesController.php");
        break;
    }
    case 'rech-utilisateurs' :{
        require_once("dreams/controllers/rechUsersController.php");
        break;
    }
    case 'utilisateur' :{
        require_once("dreams/controllers/utilisateurController.php");
        break;
    }
    case 'frm-connexion' :{
        require_once("dreams/controllers/connexionController.php");
        break;
    } 
    case 'last_publi' :{
        require_once("dreams/controllers/lastPubliController.php");
        break;
    } 
    case 'user-dashboard' :{
        require_once("dreams/controllers/userDashboardController.php");
        break;
    }
    case 'temoignage' :{
        require_once("dreams/controllers/temoignageController.php");
        break;
    }
    default :{
        require_once("dreams/controllers/errorController.php");
        break;
    }
}
?>