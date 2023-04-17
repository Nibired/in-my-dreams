<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../dao/dao_categ_reves.php';


$conn = getConnexion();

$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

//La fonction array_merge() prend 2 tableau en entrée et retourne un tableau qui contient tous les éléments des 2 tableaux d'entrée.
// permet d'avoir toutes les données de la requête (get et post) ds une seule var,
    $data = $_POST;
    $request = array_merge($_GET, $_POST);

    if (isset($request['action'])) {
        $action = $request['action'];
    } else {
        // Action non définie
        echo json_encode(array('error' => 'Action non définie.'));
    exit;
}

//Appeler fonction du dao pour recuperer les categ reves
switch ($action) {
    case 'getTypeLucide':
        echo json_encode(getTypeLucide());
        break;
    case 'afficherTypePremo':
        echo json_encode(afficherTypePremo());
        break;
    case 'afficherTypeRecurrent':
        echo json_encode(afficherTypeRecurrent());
        break;
    case 'afficherTypeCollectif':
        echo json_encode(afficherTypeCollectif());
        break;
    case 'afficherTypeAmoureux':
        echo json_encode(afficherTypeAmoureux());
        break;
    case 'afficherTypeErotique':
        echo json_encode(afficherTypeErotique());
        break;
    case 'afficherTypeTerrifiant':
        echo json_encode(afficherTypeTerrifiant());
        break;
    case 'afficherTypeCata':
        echo json_encode(afficherTypeCata());
        break;
    case 'afficherTypeFunebre':
        echo json_encode(afficherTypeFunebre());
        break;
    case 'afficherTypeAbandon':
        echo json_encode(afficherTypeAbandon());
        break;
    case 'afficherTypeEchec':
        echo json_encode(afficherTypeEchec());
        break;
//Appeler fonction du dao pour insérer les notes des reves
    case 'insererNote':
        insererNote($data['id_utilisateur'], $data['id_reve'], $data['note']);
        break;
    case 'getIdUtilisateur':
            error_log("Action 'getIdUtilisateur' appelée");
            outputJson(getIdUtilisateur());
            break;
//Verif si l'utilisateur s'est co avec les bonnes infos
    case 'checkAuth':
        $loginSaisi = isset($data['loginSaisi']) ? $data['loginSaisi'] : null;
        $mdpSaisi = isset($data['mdpSaisi']) ? $data['mdpSaisi'] : null;
        if ($loginSaisi !== null && $mdpSaisi !== null) {
            echo json_encode(checkAuth($loginSaisi, $mdpSaisi));
        } else {
            echo json_encode(array('error' => 'Les données de connexion sont manquantes.'));
        }
        break;
    default:
        echo json_encode(array('error' => 'Action non prise en charge.'));
        break;
}


        switch($action){
            case 'list':
                require_once __DIR__ . '/../views/categ-reves.phtml';
                break;
//Cases rêves
            case 'lucide':
                require_once __DIR__ . '/../redirectionCateg/lucide.phtml';
                break;
            case 'premonitoire':
                require_once __DIR__ . '/../redirectionCateg/premonitoire.phtml';
                break;
            case 'recurrent':
                require_once __DIR__ . '/../redirectionCateg/recurrent.phtml';
                break;
            case 'collectif':
                require_once __DIR__ . '/../redirectionCateg/collectif.phtml';
                break;
           
            case 'amoureux':
                require_once __DIR__ . '/../redirectionCateg/amoureux.phtml';
                break;
            case 'erotique':
                require_once __DIR__ . '/../redirectionCateg/erotique.phtml';
                break;          
//Cases cauchemars
            case 'terrifiant':
                require_once __DIR__ . '/../redirectionCateg/terrifiant.phtml';
                break;
            case 'catastrophe':
                require_once __DIR__ . '/../redirectionCateg/catastrophe.phtml';
                break;
            case 'funebre':
                require_once __DIR__ . '/../redirectionCateg/funebre.phtml';
                break;
            case 'abandon':
                require_once __DIR__ . '/../redirectionCateg/abandon.phtml';
                break;
            case 'echec':
                require_once __DIR__ . '/../redirectionCateg/echec.phtml';
                break;
             default:
                require_once __DIR__ . '/../controllers/errorController.php';
                break;    
            }

?>
