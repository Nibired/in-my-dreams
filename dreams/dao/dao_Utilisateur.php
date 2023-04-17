<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



 require_once __DIR__ . "/../models/config.php";
 require_once __DIR__ . "/../models/Reve.php";
require_once __DIR__ . "/../models/Famille_reve.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . '/../models/Note.php';



  $conn = getConnexion();




function getAllUtilisateurs() {
        $SQLQuery = "SELECT  id_utilisateur, pseudo, prenom, 
        DATE_FORMAT(date_naissance, \"%d/%m/%Y\") as date_naissance,
        email, mdp, descript, id_sexe, id_cp_ville
        FROM UTILISATEUR";
      
        $conn = getConnexion();
        $SQLStmt = $conn->prepare($SQLQuery); // Prépare la requête
        $SQLStmt->execute(); // Exécute la requête
        $lesUtilisateurs = $SQLStmt->fetchAll(PDO::FETCH_ASSOC); // Récupère les résultats de la requête
        $SQLStmt->closeCursor(); 
      
        return $lesUtilisateurs;
      }

      
   
      function getRevesByUtilisateur($id_utilisateur) {
        $conn = getConnexion();
    
        $SQLQuery = "SELECT R.id_reve, R.Titre_Reve, R.Libelle_Reve, TR.Libelle_Type_Reve, R.Date_Creation_Reve, N.note, U.pseudo
        FROM REVE R
        INNER JOIN TYPE_REVE TR ON R.id_type_reve = TR.id_type_reve
        INNER JOIN UTILISATEUR U ON R.id_utilisateur = U.id_utilisateur
        LEFT JOIN NOTE N ON R.id_reve = N.id_reve AND N.id_utilisateur = :id_utilisateur
        WHERE R.id_utilisateur = :id_utilisateur
    ";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
    $SQLStmt->closeCursor();

    return $reves;
    }



    function getReveByNote($id_utilisateur) {
        $conn = getConnexion();
    
        $SQLQuery = "SELECT R.id_reve, R.Titre_Reve, R.Libelle_Reve, TR.Libelle_Type_Reve, R.Date_Creation_Reve, N.note, U.pseudo
            FROM REVE R
            INNER JOIN TYPE_REVE TR ON R.id_type_reve = TR.id_type_reve
            INNER JOIN UTILISATEUR U ON R.id_utilisateur = U.id_utilisateur
            LEFT JOIN NOTE N ON R.id_reve = N.id_reve AND N.id_utilisateur = :id_utilisateur
            WHERE R.id_utilisateur = :id_utilisateur
        ";
    
        $SQLStmt = $conn->prepare($SQLQuery);
        $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $SQLStmt->execute();
        $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
        $SQLStmt->closeCursor();
    
        return $reves;
    }


      function getLastMembers() {
        $SQLQuery = "SELECT id_utilisateur, pseudo, descript
                     FROM UTILISATEUR
                     ORDER BY id_utilisateur DESC
                     LIMIT 20";
    
        $conn = getConnexion();
        $SQLStmt = $conn->prepare($SQLQuery);
        $SQLStmt->execute();
        $lastMembers = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
        $SQLStmt->closeCursor();
    
        return $lastMembers;
    }






      function getIdUtilisateurByLogin($login) {
        $conn = getConnexion();
    
        $SQLStmt = $conn->prepare(
            'SELECT id_utilisateur 
            FROM UTILISATEUR
            WHERE pseudo = :login');
        $SQLStmt->bindParam(':login', $login);
        $SQLStmt->execute();
    
        $result = $SQLStmt->fetchColumn();
    
        return $result;
    }


        function userExist(string $pseudo): bool {
                $conn = getConnexion();

                //req dans la bdd pour aller chercher un pseudo existant
                $SQLQuery = "
                select COUNT(id_utilisateur) as existe
                from Utilisateur
                where pseudo = :pseudo";

                //Prepare la req et bind une val à pseudo
                $SQLStmt = $conn->prepare($SQLQuery);
                $SQLStmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $SQLStmt->execute();

                //Verif si le pseudo existe

                $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
                $pseudoTrouve = $SQLRow['existe'];

                $SQLStmt->closeCursor();

                return ($pseudoTrouve > 0); //verif avec bool si cela renvoi vrai ou faux 
               
                
}


function checkAuth($loginSaisi, $mdpSaisi) {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT id_utilisateur, pseudo, mdp 
        FROM UTILISATEUR 
        WHERE pseudo = :pseudo');
    $SQLStmt->bindParam(':pseudo', $loginSaisi);
    $SQLStmt->execute();

    $result = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    if ($result && password_verify($mdpSaisi, $result['mdp'])) {
        return $result['id_utilisateur'];
    } else {
        return false;
    }
}





   
        function getUserIdByLogin(string $pseudo): int {
                $conn = getConnexion();

                $SQLQuery = "
                select id_utilisateur
                from Utilisateur
                where pseudo = :pseudo";

                 //Prepare la req et bind une val à pseudo et mdp
                 $SQLStmt = $conn->prepare($SQLQuery);
                 $SQLStmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                 $SQLStmt->execute();
 
                 //Verif si le pseudo et mdp existent dans le même enregistrement bdd
 
                 $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
                 $idUser = $SQLRow['id_utilisateur'];

                 $SQLStmt->closeCursor();
 
                 return ($idUser);
                
                
        }


        function getUtilisateurById($id_utilisateur) {
            $conn = getConnexion();
            var_dump($conn);
            $id_utilisateur = intval($id_utilisateur);
        
            $SQLQuery = "
                SELECT U.pseudo, U.prenom, U.date_naissance, U.descript, CV.Libelle_ville, CV.Libelle_Cp_Ville
                FROM UTILISATEUR U
                INNER JOIN CP_VILLE CV ON U.id_cp_ville = CV.id_cp_ville
                WHERE U.id_utilisateur = :id_utilisateur
            ";
        
            $SQLStmt = $conn->prepare($SQLQuery);

            $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $SQLStmt->execute();
            $SQLRow = $SQLStmt->fetch(PDO::FETCH_ASSOC);
            $SQLStmt->closeCursor();
        
            if (!$SQLRow) {
                return null;
            }
        
            $utilisateur = array(
                    'pseudo' => $SQLRow['pseudo'],
                    'prenom' => $SQLRow['prenom'],
                    'date_naissance' => $SQLRow['date_naissance'],
                    'descript' => $SQLRow['descript'],
                    'Libelle_ville' => $SQLRow['Libelle_ville'],
                    'Libelle_Cp_Ville' => $SQLRow['Libelle_Cp_Ville'],
                    'reves' => getRevesByUtilisateur($id_utilisateur)
                );
        
            return $utilisateur;
        }
       


            function getLastPubliByFamily($id_famille_reve) {
                $conn = getConnexion();
            
                $SQLQuery = "
                    SELECT *
                    FROM REVE
                    WHERE id_famille_reve = :id_famille_reve
                    ORDER BY Date_Creation_Reve DESC
                    LIMIT 5";
            
                $SQLStmt = $conn->prepare($SQLQuery);
                $SQLStmt->bindParam(':id_famille_reve', $id_famille_reve, PDO::PARAM_INT);
                $SQLStmt->execute();
            
                $result = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }
          

?>

