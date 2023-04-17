<?php
require_once __DIR__ . "/../models/config.php";

function getUtilisateurBysearch($pseudo, $id_sexe, $date_naissance, $id_cp_ville) {
    $conn = getConnexion();

    $queries = [];
    $params = [];

    if ($pseudo != '') {
        $queries[] = "u.pseudo LIKE :pseudo";
        $params[':pseudo'] = "%$pseudo%";
    }

    if ($id_sexe != '') {
        $queries[] = "u.id_sexe = :id_sexe";
        $params[':id_sexe'] = $id_sexe;
    }

    if ($id_cp_ville != '') {
        $queries[] = "cv.Libelle_ville LIKE :ville OR cv.Libelle_Cp_Ville LIKE :ville";
        $params[':ville'] = "%$id_cp_ville%";
    }

    $whereClause = implode(' AND ', $queries);

    $SQLQuery = "
    SELECT u.id_utilisateur, u.pseudo, u.prenom, u.date_naissance, s.Libelle_sexe, cv.Libelle_ville, cv.Libelle_Cp_Ville, u.descript
    FROM UTILISATEUR u
    JOIN SEXE s ON u.id_sexe = s.id_sexe
    JOIN CP_VILLE cv ON u.id_cp_ville = cv.id_cp_ville
    WHERE $whereClause
    ";

    error_log('SQL Query: ' . $SQLQuery);

    $SQLQuery = $conn->prepare($SQLQuery);
    $SQLQuery->execute($params);
    return $SQLQuery->fetchAll(PDO::FETCH_ASSOC);
}





function getRevesByUtilisateur($id_utilisateur) {
    $conn = getConnexion();
    $sqlQuery = "
        SELECT r.Titre_Reve, r.Libelle_Reve, r.Date_Creation_Reve, tr.Libelle_Type_Reve
        FROM REVE r
        JOIN TYPE_REVE tr ON r.id_type_reve = tr.id_type_reve
        WHERE r.id_utilisateur = :id_utilisateur
    ";
    $SQLQuery = $conn->prepare($sqlQuery);
    $SQLQuery->execute([':id_utilisateur' => $id_utilisateur]);
    return $SQLQuery->fetchAll(PDO::FETCH_ASSOC);
}



?>



