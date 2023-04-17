<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../models/Qcm.php';
require_once __DIR__ . '/../models/Question.php';
require_once __DIR__ . '/../models/Choix.php';
require_once __DIR__ . '/../models/Reponse.php';
require_once __DIR__ . '/../dao/dao_qcm.php';


    $page = $_GET['page'] ?? 'index';
    $action = $_GET['action'] ?? 'view';

//Création objet qcm
    $qcm = new QCM(1, 'Qui partage vos rêves?');
        $qcm->getLibelleQcm();
        $id_question = 0;
        $libelle_question = '';
        $id_choix = 0;
        $libelle_choix = '';
        $id_utilisateur = 0;
        $id_qcm = 1;
        $date_reponse = date('Y-m-d H:i:s');
        $reponses = [];
        $id_reponse = 0;

    switch ($action) {
        case 'view':
            $conn = getConnexion();

            if (isset($_SESSION['id_utilisateur'])) {
                $id_utilisateur = $_SESSION['id_utilisateur'];
            } else {
                // gérr cette erreur 
            }

// récupérer toutes les questions depuis la bdd
        $questions = getQuestions(); 

// Pour chaque question, création d'une nouvelle instance de question et ajout des choix correspondants
        foreach ($questions as $row) {
            $id_question = $row->getIdQuestion();
            $libelle_question = $row->getLibelleQuestion();
            $id_qcm = 1;

// Création d'une nouvelle instance de question avec les attributs récupérés et l'id du QCM
            $question = new Question(
                $id_question,
                $libelle_question,
                $id_qcm
            );

// Récupération des choix associés à la question
            $choixs = $row->getChoix();

// Pour chaque choix, ajout à la question cré précédemmnt
            foreach ($choixs as $choix) {
                $id_choix = $choix->getIdChoix();
                $libelle_choix = $choix->getLibelleChoix();
                $question->addChoix(new Choix($id_choix, $libelle_choix));
            }

// Ajout de la question au QCM
            $qcm->addQuestion($question);
        }
        break;
        case 'submit':
            $conn = getConnexion();
        
// Initialiser $id_utilisateur
            if (isset($_SESSION['id_utilisateur'])) {
                $id_utilisateur = $_SESSION['id_utilisateur'];
            } else {
                // a gérer
            }
        
// Vérifier si des données ont été soumises
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id_utilisateur = isset($_SESSION['id_utilisateur']) ? (int)$_SESSION['id_utilisateur'] : 0;
        
// Récupérer l'id desréponses du formulaire et les stocker dans la variable $reponses
            foreach ($_POST as $id_question => $id_choix) {
                if (strpos($id_question, 'question') === 0) {
                    $id_question = intval(substr($id_question, 8));
                    $id_reponse = 0;
                    $choixId = intval($id_choix);
                    $libelle_reponse = getLibelleChoixById($choixId);
        
// Création d'une nouvelle instance de Reponse avec les attributs récupérés
                $reponse = new Reponse(
                    $id_reponse,
                    $id_question,
                    $choixId,
                    $id_utilisateur,
                    $id_qcm,
                    $date_reponse,
                    $libelle_reponse
                    );       
// Ajout de la réponse au tableau des réponses
            array_push($reponses, $reponse);
            }
            }
            if (insertReponses($reponses, $id_utilisateur, $id_qcm)) {
// Mettre à jour les données de la session avec les nouvelles réponses
             $_SESSION['reponses'] = $reponses;
// Rediriger vers la page de correspondance
            header('Location: index.php?page=qcm&action=match');
            exit();
            } else {
// Gérer l'erreur d'enregistrement des réponses
            }
            }
        break;
        case 'match':
            $allReponses = getAllReponses();
            $matchingUsers = [];
// Comparaison des réponses et comptage des réponses similaires, recuperation id utilisateur similitude
        foreach ($allReponses as $reponse) {
            if ($reponse->getIdUtilisateur() != $id_utilisateur) {
                if (!isset($matchingUsers[$reponse->getIdUtilisateur()])) {
                    $matchingUsers[$reponse->getIdUtilisateur()] = 0;
                }
                foreach ($reponses as $userReponse) {
                    if ($reponse->getIdQuestion() == $userReponse->getIdQuestion() && $reponse->getIdChoix() == $userReponse->getIdChoix()) {
                        $matchingUsers[$reponse->getIdUtilisateur()]++;
                    }
                }
            }
        }
// Trie les utilisateurs correspondants en fonction du nombre de réponses similaires (ordre décroissant)
        arsort($matchingUsers);
        break;
}
//Redirection vers la page match si match il y a sinon retour parge qcm
        if ($action == 'match') {
            require_once(__DIR__ . '/../views/match.phtml');
        } else {
            require_once(__DIR__ . '/../views/qcm.phtml');
        }

?>