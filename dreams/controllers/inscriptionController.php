<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../dao/dao_inscript.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Sexe.php';
require_once __DIR__ . '/../models/Cp_ville.php';



$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';


switch($action) {
    case 'view': {
        require_once __DIR__ . '/../views/frm-inscript.phtml';
        break;
    }
    case 'submit': {
// Récup les données du form soumis  
    $id_utilisateur = 0;
    $pseudo = $_POST['pseudo'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $date_naissance = new DateTime();
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $id_sexe = intval($_POST['id_sexe'] ?? 1);
    $libelle_sexe = '';
    $id_cp_ville = intval($_POST['id_cp_ville'] ?? 1);
    $libelle_cp_ville ='';
    
//Attribuer des id aus genres
    switch($id_sexe) 
    {
        case 1: $libelle_sexe = 'Femme'; break;
        case 2: $libelle_sexe = 'Homme'; break;
        case 3: $libelle_sexe = 'Autre'; break;
    }

//Attribuer id aux villes  (A faire avec une appli)
    switch($id_cp_ville) 
    {
        case 1: 
            $libelle_ville = 'Paris'; 
            $libelle_cp_ville = '75000'; 
        break;
        case 2: 
            $libelle_ville = 'Marseille'; 
            $libelle_cp_ville = '13000'; 
        break;
        case 3: 
            $libelle_ville = 'Lyon'; 
            $libelle_cp_ville = '69000'; 
        break;
        case 4: 
            $libelle_ville = 'Toulouse'; 
            $libelle_cp_ville = '31000'; 
        break;
        case 5: 
            $libelle_ville = 'Nice'; 
            $libelle_cp_ville = '06000'; 
        break;
        case 6: 
            $libelle_ville = 'Nantes'; 
            $libelle_cp_ville = '44000'; 
        break;
        case 7: 
            $libelle_ville = 'Strasbourg'; 
            $libelle_cp_ville = '67000'; 
        break;
        case 8: 
            $libelle_ville = 'Montpellier'; 
            $libelle_cp_ville = '34000'; 
        break;
        case 9: 
            $libelle_ville = 'Bordeaux'; 
            $libelle_cp_ville = '33000'; 
        break;
        case 10: 
            $libelle_ville = 'Lille'; 
            $libelle_cp_ville = '59000'; 
        break;
        default:
            $libelle_ville = '';
            $libelle_cp_ville = '';
        break;       
    }


//Creation des objets
    $sexe = new Sexe($id_sexe, $libelle_sexe);
    $cp_ville = new Cp_ville($id_cp_ville, $libelle_cp_ville, $libelle_ville);
    $descript = $_POST['descript'] ?? '';
  

//Verification mauvaises infos ou manquantes
    $errors = [];

    if (empty($_POST['date_naissance'])) {
        $errors[] = "La date de naissance est obligatoire.";
    } else {
        $date_naissance = new DateTime($_POST['date_naissance']);
    }
    if ($date_naissance === null) {
        $date_naissance = new DateTime();
    }
    if (verifierPseudo($pseudo)) {
        $errors[] = "Le pseudo est déjà utilisé.";
    }
    if (verifierEmail($email)) {
        $errors[] = "L'email est déjà utilisé.";
    }
    if (!validerEmail($email)) {
        $errors[] = "L'email n'est pas valide.";
    }
    if (!validerMotDePasse($mdp)) {
        $errors[] = "Mauvais mot de passe";
    }


//Si pas d'erreur , création de l'objet new Utilisateur
    if (empty($errors)) {
    
        $newUtilisateur = new Utilisateur(
            $id_utilisateur = 0,
            $pseudo,
            $prenom,
            $date_naissance,
            $email,
            password_hash($mdp, PASSWORD_BCRYPT),
            $sexe,
            $cp_ville,
            $descript = $_POST['descript'] ?? ''
        );


//Si l'insertion est valide alors l'utilisateur est redirigé page confirm
    if (insererUtilisateur($newUtilisateur) > 0){
        header("Location: index.php?page=accueil&action=confirmation");
        exit;
    } else {
        print "Erreur lors de l'insertion du rêve dans la base de données.";
    }   
} else {
    // Afficher les erreurs
    foreach ($errors as $error) {
        print $error . "<br>";
    }
}}
}


?>


