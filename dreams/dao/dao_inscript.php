<?php


require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../controllers/inscriptionController.php';



$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';



    function getIdUtilisateur(int $id_utilisateur)
    {
        $conn = getConnexion();

        $SQLQuery = 
        "SELECT * FROM UTILISATEUR WHERE id_utilisateur = :id_utilisateur";
        $stmt = $conn->prepare($SQLQuery);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $id_utilisateur = new Utilisateur( $result['pseudo'], $result['prenom'], $result['date_naissance'], 
                $result['email'], $result['mdp'], $result['id_sexe'], $result['id_cp_ville'], $result['descript'], $result['id_utilisateur']);
                return $id_utilisateur;
            } else {
                return false;
            }     
}


    /**
    * Vérif si un pseudo est déjà utilisé par un autre utilisateur dans la bdd.
    * @param string $pseudo Le pseudo à vérifier.
    * @return bool True si le pseudo est déjà utilisé, False sinon.
     */

    function verifierPseudo($pseudo) 
    {
        $conn = getConnexion();
        $SQLQuery = 
        "SELECT * FROM UTILISATEUR WHERE pseudo = :pseudo";
        $stmt = $conn->prepare($SQLQuery);
        $stmt->bindValue(':pseudo', $pseudo);
        $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true; // Le pseudo est déjà utilisé
    } else {
        return false; // Le pseudo n'est pas utilisé
    }
    
}




    /**
     * Vérif si un email est déjà utilisé par un autre utilisateur dans la bdd.
    * @param string $email L'email à vérifier.
    * @return bool True si l'email est disponible et valide, False sinon.
    */

    function verifierEmail($email) 
    {
        $conn = getConnexion();
        $SQLQuery = 
        "SELECT * FROM UTILISATEUR WHERE email = :email";
        $stmt = $conn->prepare($SQLQuery);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true; // L'email est déjà utilisé
    } elseif (!validerEmail($email)) {
        return true; // L'email est invalide
    } else {
        return false; // L'email est disponible et valide
    }
   
}


    /**
     * Vérif si un email est valide.
    * @param string $email L'email à valider.
    * @return bool True si l'email est valide, False sinon.
     */

    function validerEmail($email) 
    { 
        $conn = getConnexion();
        if (!is_string($email)) {
            return false; // L'argument n'est pas une chaîne de caractères
    }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // L'email est invalide
    } else {
            return true; // L'email est valide
    }
 
}


    /**
     * Vérif si le mdp répond aux exigenes de sécurité.
    * @param string $mdp Le mot de passe à vérifier.
    * @return bool True si le mot de passe répond aux exigences de sécurité, False sinon.
     */

     function validerMotDePasse($mdp) 
     {
        $conn = getConnexion();
        if (strlen($mdp) <= 15 && preg_match('/[A-Za-z]/', $mdp)) {
            return true; 
    } else {
            return false; 
    }
    
}


    /*Insérer utilisateur dans la bdd*/

    function insererUtilisateur(Utilisateur $newUtilisateur)
    {
       
        $conn = getConnexion();

        $id_utilisateur = null;
        $pseudo = $newUtilisateur->getPseudo();
        $prenom = $newUtilisateur->getPrenom();
        $date_naissance = $newUtilisateur->getDateNaissance();
        $email = $newUtilisateur->getEmail();
        $mdp = $newUtilisateur->getMdp();
        $sexe = $newUtilisateur->getSexe();
        $cp_ville = $newUtilisateur->getCpVille();
        $id_sexe = $sexe->getIdSexe();
        $id_cp_ville = $cp_ville->getIdCpVille();
        $descript = $newUtilisateur->getDescript();

        if (isset($pseudo) && !empty($pseudo) 
        && isset($prenom) && !empty($prenom) 
        && isset($date_naissance) && !empty($date_naissance)
        && isset($email) && !empty($email) 
        && isset($mdp) && !empty($mdp) 
        && isset($id_sexe) && !empty($id_sexe)
        && isset($id_cp_ville) && !empty($id_cp_ville)) {
                
         if ($date_naissance === null) {
             $date_naissance = new DateTime();
         }
         
    
         if (isset($_POST['id_sexe'])) {
             $id_sexe = intval($_POST['id_sexe']);
             $sexe = new Sexe($id_sexe, '');
         } else {
             $sexe = new Sexe(1, '');
         }
     
         if (isset($_POST['id_cp_ville'])) {
             $id_cp_ville = intval($_POST['id_cp_ville']);
             $cp_ville = new Cp_ville($id_cp_ville, '', '');
         } else {
             $cp_ville = new Cp_ville(0, '', '');
         }
         

         $conn = getConnexion();
         

          $SQLQuery = 
         "INSERT INTO UTILISATEUR (id_utilisateur, pseudo, prenom, date_naissance, email, mdp, id_sexe, id_cp_ville, descript )
         SELECT :id_utilisateur, :pseudo, :prenom, :date_naissance, :email, :mdp, s.id_sexe, v.id_cp_ville, :descript 
         FROM SEXE s
         INNER JOIN CP_VILLE v 
         ON s.id_sexe = :id_sexe AND v.id_cp_ville = :id_cp_ville
         ";

        $SQLStmt = $conn->prepare($SQLQuery);
        
        $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_NULL);
        $SQLStmt->bindValue(':pseudo', $pseudo);
        $SQLStmt->bindValue(':prenom', $prenom);
        $date_naissance_formatee = $date_naissance->format('Y-m-d');
        $SQLStmt->bindValue(':date_naissance', $date_naissance_formatee);
        $SQLStmt->bindValue(':email', $email);
        $SQLStmt->bindValue(':mdp', $mdp);
        $SQLStmt->bindValue(':id_sexe', $sexe->getIdSexe(), PDO::PARAM_INT);
        $SQLStmt->bindValue(':id_cp_ville', $cp_ville->getIdCpVille(), PDO::PARAM_INT);

        if (!empty($descript)) {
            $SQLStmt->bindValue(':descript', $descript);
        } else {
            $SQLStmt->bindValue(':descript', null, PDO::PARAM_NULL);
        }
    $SQLStmt->execute();
    $last_id = $conn->lastInsertId();
         return $last_id;
     } else {
         return false;
     }

 }





//NOTES

//strlen = vérif si la longueur du mdp est inférieure à 8 caractères
//!preg_match('/[A-Za-z]/', $mdp): verif si le mdp contient au moins une lettre (maj ou min) .
//filter_var: fonction qui filtre une var en utilisant un filtre spécifié.
//FILTER_VALIDATE_EMAIL:  indique le filtre à utiliser pour valider l'adresse email. Dans ce cas,  la variable $email doit être une 
//adresse email valide pour que la condition soit vraie.
//utilisée pour déterminer s'il y a des résultats de la requête SELECT qui ont été retournés pour l'email donné. 
//Si $stmt->rowCount() > 0, cela signifie qu'il y a déjà un utilisateur qui utilise l'adresse email 

?>

