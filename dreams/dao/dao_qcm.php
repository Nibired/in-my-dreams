<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/Qcm.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Choix.php';
require_once __DIR__ . '/../models/Reponse.php';


function getQuestions() {
    $SQLQuery = 'SELECT c.id_choix, c.Libelle_Choix, c.id_question, q.Libelle_Question, q.id_qcm 
    FROM CHOIX c 
    JOIN QUESTION q ON c.id_question = q.id_question';

    $conn = getConnexion();
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->execute();

    $lesQuestions = array();

    foreach ($SQLStmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $id_question = $row['id_question'];
        $libelle_question = $row['Libelle_Question']; // Définir la valeur à partir de la bdd
    
        if (!array_key_exists($id_question, $lesQuestions)) {
            $lesQuestions[$id_question] = new Question($id_question,$libelle_question, $row['id_qcm']);
        }
    
        $id_choix = $row['id_choix'];
        $libelle_choix = $row['Libelle_Choix']; // Réinitialiser la valeur à partir de la bdd
    
        $choix = new Choix($id_choix, $libelle_choix);
        $lesQuestions[$id_question]->addChoix($choix);
    }
    $SQLStmt->closeCursor();

    return $lesQuestions;
}

function getReponse($id_reponse, $id_utilisateur, $id_choix) {
    $conn = getConnexion();

    $SQLQuery = "SELECT r.*, u.id_utilisateur 
                 FROM REPONSE r 
                 JOIN UTILISATEUR u ON r.id_utilisateur = u.id_utilisateur 
                 WHERE r.id_reponse = :id_reponse AND r.id_utilisateur = :id_utilisateur";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_reponse', $id_reponse, PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $SQLStmt->execute();

    $row = $SQLStmt->fetch(PDO::FETCH_ASSOC);

    $reponse = new Reponse(
        $row['id_reponse'],
        $row['id_choix'],
        $row['id_question'],
        $row['id_utilisateur'],
        $row['id_qcm'],
        $row['date_reponse'],
        $row['libelle_reponse']
    );

    $SQLStmt->closeCursor();

    return $reponse;
}




function insertReponses($reponses, $id_utilisateur, $id_qcm) 
{   
    $conn = getConnexion();
    $date_reponse = date('Y-m-d H:i:s');
    
    $SQLQuery = "INSERT INTO REPONSE (id_choix, id_question, id_utilisateur, id_qcm, date_reponse, libelle_reponse) 
    VALUES (:id_choix, :id_question, :id_utilisateur, :id_qcm, :date_reponse, :libelle_reponse)";
    $SQLStmt = $conn->prepare($SQLQuery);

    $insertionSuccess = true;

    foreach ($reponses as $reponse) {
        $SQLStmt->bindValue(':id_choix', $reponse->getIdChoix(), PDO::PARAM_INT);
        $SQLStmt->bindValue(':id_question', $reponse->getIdQuestion(), PDO::PARAM_INT);
        $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $SQLStmt->bindValue(':id_qcm', $reponse->getIdQcm(), PDO::PARAM_INT);
        $SQLStmt->bindValue(':date_reponse', $reponse->getDateReponse());
        $SQLStmt->bindValue(':libelle_reponse', $reponse->getLibelleReponse());

        if (!$SQLStmt->execute()) {
            $insertionSuccess = false;
            break;
        }
    }

    return $insertionSuccess;
}



function getLibelleChoixById($id_choix) {
    $conn = getConnexion();
    $SQLQuery = "SELECT Libelle_Choix FROM CHOIX WHERE id_choix = :id_choix";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_choix', $id_choix, PDO::PARAM_INT);
    $SQLStmt->execute();

    $row = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $libelle_choix = $row['Libelle_Choix'];

    $SQLStmt->closeCursor();

    return $libelle_choix;
}




function getAllReponses() {
    $conn = getConnexion();
    $SQLQuery = "SELECT * FROM REPONSE";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->execute();

    $reponses = [];

    while ($row = $SQLStmt->fetch(PDO::FETCH_ASSOC)) {
        $reponse = new Reponse(
            $row['id_reponse'],
            $row['id_choix'],
            $row['id_question'],
            $row['id_utilisateur'],
            $row['id_qcm'],
            $row['date_reponse'],
            $row['libelle_reponse']
        );
        $reponses[] = $reponse;
    }

    $SQLStmt->closeCursor();

    return $reponses;
}

?>