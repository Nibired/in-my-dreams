<?php


require_once __DIR__ . '/../models/config.php';
require_once __DIR__ .'/../models/Temoignages.php';
require_once __DIR__ .'/../models/Utilisateur.php';



function getLatestTemoignages($limit) {
    $conn = getConnexion();
    $SQLQuery = "SELECT t.id_temoignage, t.libelle_temoignage, t.id_utilisateur, t.date_temoignage, u.pseudo
                 FROM TEMOIGNAGES t
                 JOIN UTILISATEUR u ON t.id_utilisateur = u.id_utilisateur
                 ORDER BY t.date_temoignage DESC
                 LIMIT ?";

    $SQLResult = $conn->prepare($SQLQuery);
    $SQLResult->bindValue(1, $limit, PDO::PARAM_INT);
    $SQLResult->execute();

    $latestTemoignages = [];
    while ($row = $SQLResult->fetch(PDO::FETCH_ASSOC)) {
        $temoignage = new Temoignages(
            $row['id_temoignage'],
            $row['libelle_temoignage'],
            $row['id_utilisateur'],
            $row['date_temoignage'],
            $row['pseudo']
        );
        $latestTemoignages[] = $temoignage;
    }

    return $latestTemoignages;
}


function addTemoignage($temoignage) {
    $conn = getConnexion();

    $SQLQuery = "INSERT INTO TEMOIGNAGES (libelle_temoignage, id_utilisateur, date_temoignage) VALUES (?, ?, ?)";
    $SQLResult = $conn->prepare($SQLQuery);
    $SQLResult->bindValue(1, $temoignage->getLibelleTemoignage(), PDO::PARAM_STR);
    $SQLResult->bindValue(2, $temoignage->getIdUtilisateur(), PDO::PARAM_INT);
    $SQLResult->bindValue(3, $temoignage->getDateTemoignage()->format('Y-m-d H:i:s'), PDO::PARAM_STR);

    return $SQLResult->execute();
}



?>