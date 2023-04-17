<?php
require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . "/../dao/dao_Utilisateur.php";
require_once __DIR__ . "/../models/Reve.php";
require_once __DIR__ . "/../models/Famille_reve.php";

$conn = getConnexion();

//Recupérer les reves stockés à partir de leur id_famille_reve en appelant la fonction du dao
if (isset($_GET['id_famille_reve'])) {
    $id_famille_reve = $_GET['id_famille_reve'];
    $reves = getLastPubliByFamily($id_famille_reve);
    echo json_encode($reves);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}

?>