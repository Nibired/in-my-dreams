<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/Reponse.php';

function getMatchingUsers($id_utilisateur) {
    $conn = getConnexion();
    $SQLQuery = "SELECT r1.id_utilisateur as user1, r2.id_utilisateur as user2, u.pseudo, COUNT(*) as matching_answers
                 FROM REPONSE r1
                 JOIN REPONSE r2 ON r1.id_question = r2.id_question AND r1.id_choix = r2.id_choix
                 JOIN UTILISATEUR u ON r2.id_utilisateur = u.id_utilisateur
                 WHERE r1.id_utilisateur = :id_utilisateur AND r2.id_utilisateur != :id_utilisateur
                 GROUP BY r1.id_utilisateur, r2.id_utilisateur, u.pseudo
                 ORDER BY matching_answers DESC";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $SQLStmt->execute();

    $matchingUsers = [];
    $result = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $matchingUsers[] = ['user1' => $row['user1'], 'user2' => $row['user2'], 'pseudo' => $row['pseudo'], 'matching_answers' => $row['matching_answers']];
    }
    $SQLStmt->closeCursor();

    return $matchingUsers;
}


function getLatestMatches() {
    $conn = getConnexion();
    $SQLQuery = "SELECT u.id_utilisateur, u.pseudo, u.descript
                 FROM UTILISATEUR u
                 JOIN REPONSE r ON u.id_utilisateur = r.id_utilisateur
                 GROUP BY u.id_utilisateur, u.pseudo, u.descript
                 ORDER BY MAX(r.date_reponse) DESC
                 LIMIT 2"; // Remplacez 1 par le nombre de matchs que vous souhaitez afficher
    $SQLResult = $conn->prepare($SQLQuery);
    $SQLResult->execute();

    $latestMatches = $SQLResult->fetchAll(PDO::FETCH_ASSOC);
    return $latestMatches;
}
?>