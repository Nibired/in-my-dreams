<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . "/../controllers/connexionController.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Reve.php";
require_once __DIR__ . "/../models/Note.php";


$conn = getConnexion();


function getIdUtilisateur() {
    $conn = getConnexion();

    
    if (isset($_SESSION['login']) && isset($_SESSION['id_utilisateur'])) {
        error_log('ID utilisateur dans la session: ' . $_SESSION['id_utilisateur']);
        return ['id_utilisateur' => (int) $_SESSION['id_utilisateur']];
    } else {
        error_log('$_SESSION: ' . print_r($_SESSION, true));
        error_log('ID utilisateur non défini dans la session');
        return ['error' => "Fichier d'authentification non trouvé"];
    }
}

// envoie une réponse JSON avec les données spécifiées.
function outputJson($data) {
    error_log("outputJson appelé avec: " . print_r($data, true));
    header('Content-Type: application/json');
    echo json_encode($data);
}

function insererNote($id_utilisateur, $id_reve, $note) {
    $conn = getConnexion();

    error_log("Note: " . $note);
error_log("ID utilisateur: " . $id_utilisateur);
error_log("ID rêve: " . $id_reve);

    $SQLStmt = $conn->prepare(
        'INSERT INTO NOTE (note, id_utilisateur, id_reve)
        VALUES (:note, :id_utilisateur, :id_reve)'
    );

    $SQLStmt->bindValue(':note', $note, PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_reve', $id_reve, PDO::PARAM_INT);

    $SQLStmt->execute();

    $last_id = $conn->lastInsertId();
    return $last_id;
}


function getTypeLucide() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 1
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}


function afficherTypePremo() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 2
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeRecurrent() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 3
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeCollectif() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 6
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeAmoureux() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 22
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeErotique() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 23
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}



function afficherTypeTerrifiant() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 32
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeCata() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 35
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeFunebre() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 36
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeAbandon() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 38
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}

function afficherTypeEchec() {
    $conn = getConnexion();

    $SQLStmt = $conn->prepare(
        'SELECT r.*, u.pseudo, AVG(n.note) as note
        FROM REVE r
        JOIN UTILISATEUR u 
        ON r.id_utilisateur = u.id_utilisateur
        LEFT JOIN NOTE n
        ON r.id_reve = n.id_reve
        WHERE r.id_type_reve = 40
        GROUP BY r.id_reve;'
    );

    $SQLStmt->execute();
    $reves = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    return $reves;
}
?>