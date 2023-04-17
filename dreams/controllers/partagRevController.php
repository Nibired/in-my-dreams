<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../dao/dao-share-dream.php';
require_once __DIR__ . '/../dao/dao_Utilisateur.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Reve.php';
require_once __DIR__ . '/../models/Sexe.php';
require_once __DIR__ . '/../models/Cp_ville.php';

$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';


switch ($action) {
    case 'view': {
    $conn=getConnexion();

// recup des données du form
        $id_reve = 0; 
        $libelle_reve = '';
        $date_creation_reve = new DateTime();
        $date_creation_reve_formatee = $date_creation_reve->format('Y-m-d H:i:s');
        $id_famille_reve = 0;
        $id_utilisateur=0; 
        $id_type_reve = 0;
        $titre_reve = '';
        $libelle_type_reve = ''; 

        require_once __DIR__ . '/../views/share-dream.phtml';
        break;
    }  
    case 'submit': {
    $conn=getConnexion();

 //récupération des données du formulaire
    $id_reve = 0; 
    $libelle_reve = $_POST['Libelle_Reve'] ?? '';
    $date_creation_reve = new DateTime();
    //$date_creation_reve_formatee = $date_creation_reve->format('Y-m-d H:i:s');
    $id_famille_reve = intval($_POST['id_famille_reve'] ?? 0); 
    $id_type_reve = intval($_POST['id_type_reve'] ?? 0);
    $titre_reve = $_POST['Titre_Reve'] ?? '';
    $libelle_type_reve = ''; 


// Lier les categ à un id

    switch($id_type_reve) {
        case 1: $libelle_type_reve = 'Lucide'; break;
        case 2: $libelle_type_reve = 'prémonitoire'; break;
        case 3: $libelle_type_reve = 'récurent'; break;
        case 3: $libelle_type_reve = 'collectif'; break;
        case 3: $libelle_type_reve = 'amoureux'; break;
        case 3: $libelle_type_reve = 'erotique'; break;
        case 3: $libelle_type_reve = 'terrifiant'; break;
        case 3: $libelle_type_reve = 'catastrophe'; break;
        case 3: $libelle_type_reve = 'funebre'; break;
        case 3: $libelle_type_reve = 'abandon'; break;
        case 3: $libelle_type_reve = 'echec'; break;
    }
        

//Recuperer les reves par type (categorie), les utilisateurs via leur session
    $id_famille_reve = getIdFamilleFromType($id_type_reve);
    $id_utilisateur = getUserIdByLogin($_SESSION['login']);

//creation objet Reve
    $newReve = new Reve($id_reve, $libelle_reve, $date_creation_reve, $id_famille_reve, $id_utilisateur,
    $id_type_reve, $titre_reve, $libelle_type_reve);
    $date_creation_reve_formatee = $date_creation_reve->format('Y-m-d H:i:s');



//si les val sont de type null leur affectr une valeur par def
        
        $errors = [];

        if (isset($_POST['Libelle_Reve'])) {//forcer à renseigner le champe libelle_reve
                $errors[] = "Veuillez ajouter un rêve.";
        }
        if ($date_creation_reve === null) {
            $date_creation_reve= new DateTime();
        }
        if ($id_reve === null) {
           $id_reve= 0;
        }
        if ($libelle_type_reve=== null) {
            $libelle_type_reve= 0;
        }
        if ($id_famille_reve === null) {
            $id_famille_reve= 0;
        }

           

//Si ces valeurs existent et qu'elles ne sont pas vide
        if (
            isset($id_reve) 
            && isset($libelle_reve)
            && isset($date_creation_reve)
            && isset($id_famille_reve)
            && isset($id_utilisateur)
            && isset($id_type_reve)
            && isset($titre_reve)
            && isset($libelle_type_reve)) {

//Si le reve existe, inserer le reve dans la bdd

            if (partagerReve($newReve) > 0) {
// Redirige l'utilisateur vers une page de confirmation
                header("Location: index.php?page=share-dream&action=categ-reves");
                exit;
            } else if (count($errors) > 0) {
// Afficher les erreurs
                foreach ($errors as $error) {
                    print $error . "<br>";
                }
            } else {
                print "Erreur lors de l'insertion de l'utilisateur dans la base de données.";
            }
        }else{
            print('Condition incorrecte !');
        }
    }
}

?>