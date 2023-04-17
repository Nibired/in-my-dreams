<?php


require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Reve.php';






function getIdFamilleReve($id_famille_reve) {

// Connexion à la base de données
    $conn = getConnexion();

// Vérification de l'existence de la famille de rêve
    $SQLStmt = $conn->prepare("SELECT * FROM FAMILLE_REVE WHERE id_famille_reve = :id_famille_reve");
    $SQLStmt->bindValue(':id_famille_reve', $id_famille_reve, PDO::PARAM_INT);
    $SQLStmt->execute();

    if ($SQLStmt->rowCount() > 0) {
        $id_famille_reve = $SQLStmt->fetch(PDO::FETCH_ASSOC);
        return $id_famille_reve['id_famille_reve'];
    } else {
        return false;
    }
}




function getIdFamilleFromType(int $id_type_reve): int {

    
        $conn = getConnexion();
    
    // Vérification de l'existence de la famille de rêve
        $SQLStmt = $conn->prepare("select id_famille_reve  
        from type_reve tr  
        where id_type_reve = :id_type_reve");
        $SQLStmt->bindValue(':id_type_reve', $id_type_reve, PDO::PARAM_INT);
        $SQLStmt->execute();
    
        if ($SQLStmt->rowCount() > 0) {
            $id_famille_reve = $SQLStmt->fetch(PDO::FETCH_ASSOC);
            return $id_famille_reve['id_famille_reve'];
        } else {
            return 0;
        }
    }



function partagerReve(Reve $newReve) {

    $conn = getConnexion();

// Insérer un new reve dans la table REVE

    $SQLStmt = $conn->prepare(
        "INSERT INTO REVE (id_reve, Libelle_Reve, Date_Creation_Reve, id_famille_reve, id_utilisateur, id_type_reve, Titre_Reve, libelle_type_reve )
        VALUES (:id_reve, :Libelle_Reve, :Date_Creation_Reve, :id_famille_reve, :id_utilisateur, :id_type_reve, :Titre_Reve, :libelle_type_reve)"
    );

    $SQLStmt->bindValue(':id_reve', $newReve->getIdReve(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':Libelle_Reve', $newReve->getLibelleReve(), PDO::PARAM_STR);
    //$date_creation_reve_formatee = $date_creation_reve->format('Y-m-d');
    $SQLStmt->bindValue(':Date_Creation_Reve', $newReve->getDateCreationReve()->format('Y-m-d'), PDO::PARAM_STR);
    $SQLStmt->bindValue(':id_famille_reve', $newReve->getIdFamilleReve(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_utilisateur', $newReve->getIdUtilisateur(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_type_reve', $newReve->getIdTypeReve(), PDO::PARAM_INT);
    $SQLStmt->bindValue(':Titre_Reve', $newReve->getTitreReve(), PDO::PARAM_STR);
    $SQLStmt->bindValue(':libelle_type_reve',  $newReve->getLibelleTypeReve(), PDO::PARAM_STR);

    $SQLStmt->execute();

    $last_id = $conn->lastInsertId();
    return $last_id;
} 
