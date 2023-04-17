<?php
require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . '/../dao/dao_chat.php';

$conn = getConnexion();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'login':
        require_once __DIR__ . '/../dao/dao_Utilisateur.php';

//Vérif d'authentification
        if (!empty($_POST)){
            $loginSaisi = $_POST["pseudo"];
            $mdpSaisi = $_POST["mdp"];
        
            if (userExist($loginSaisi)){
                print("Mon pseudo existe");
        
                $id_utilisateur = checkAuth($loginSaisi, $mdpSaisi);
                if ($id_utilisateur){
                    print ("Je suis authentifié ");
                    $_SESSION['login'] = $loginSaisi;
                    $_SESSION['id_utilisateur'] = intval($id_utilisateur);

                updateConnexionStatus($_SESSION['id_utilisateur'], 'connecté');
                echo "updateConnexionStatus called";
                }
                else {
                    $message = "Mauvaises informations d'identification";
                }
            } else {
                $message = "Cet utilisateur n'existe pas!";
            }
        }
        require_once __DIR__ . '/../views/frm-connexion.phtml';
    break;
    case 'logout':
        if (isset($_SESSION['login'])){
            unset($_SESSION['login']);
            updateConnexionStatus($_SESSION['id_utilisateur'], 'déconnecté');
            echo "updateDeconnexionStatus called";
        }
            header('Location: index.php?page=chat&action=view');
    break;
    default:
    require_once __DIR__ . "/../controllers/errorController.php";
}
?>