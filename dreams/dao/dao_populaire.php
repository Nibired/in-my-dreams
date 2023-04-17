<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . "/../models/config.php";


$conn = getConnexion();



function getTopRatedDreams($limit = 7) {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        "SELECT r.*, u.pseudo, AVG(n.note) as avg_note
        FROM REVE r
        JOIN UTILISATEUR u ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n ON r.id_reve = n.id_reve
        GROUP BY r.id_reve
        ORDER BY avg_note DESC
        LIMIT :limit"
    );

    $SQLStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $SQLStmt->execute();

    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}
?>

