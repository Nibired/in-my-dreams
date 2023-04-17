<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ .'/../models/Temoignages.php';
require_once __DIR__ .'/../dao/temoignage_dao.php';
require_once __DIR__ .'/../models/Utilisateur.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnexion();


//Vérifie si la requête est une requête POST et si la var 'libelle_temoignage' est présente dans les données POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['libelle_temoignage'])) {
    if (isset($_SESSION['id_utilisateur'])) { // Vérifier si l'utilisateur est connecté
//// Récupère les données POST, crée un nouvel objet Temoignages et ajoute le témoignage.
        try {
            $libelle_temoignage = $_POST['libelle_temoignage'];
            $id_utilisateur = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : -1;
            $date_temoignage = date('Y-m-d H:i:s');
            $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : 'Anonyme';
            $temoignage = new Temoignages(-1, $libelle_temoignage, $id_utilisateur, $date_temoignage, $pseudo);
            addTemoignage($temoignage);
// Crée un tableau $temoignageData avec les propriéts du nouvel objet Temoignages.
            $temoignageData = [
                'pseudo' => $temoignage->getPseudo(),
                'libelle_temoignage' => $temoignage->getLibelleTemoignage(),
                'date_temoignage' => $temoignage->getDateTemoignage()->format('d/m/Y'),
            ];
//Envoie une réponse JSON avec le succès et les données du témoignage créé.
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'temoignageData' => $temoignageData]);
            exit;
//Si erreur il y a , enregistre l'erreur dans les journaux d'erreus et envoie une réponse jsonavec l'erreur.
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
//Si utilisateur non connecté, envoie une réponse json avec une erreur demandant de se connecter pour publier .
    } else {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['error' => 'Veuillez vous connecter pour publier un témoignage.']);
        exit;
    }
}

// Récupère les derniers 10 témoignages enregistrés.
    global $temoignage;
    $temoignage = getLatestTemoignages(10);

?>