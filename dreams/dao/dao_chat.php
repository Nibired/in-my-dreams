<?php

require_once __DIR__ . "/../models/config.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Messages.php";
require_once __DIR__ . "/../models/Notification.php";
 

$conn = getConnexion();


//Récupérer les pseudo des utilisateurs recepteur via leur id_utilisateur
function getRecipientPseudoById($toUserId) {
    $conn = getConnexion();

    $SQLQuery = "SELECT pseudo FROM UTILISATEUR WHERE id_utilisateur = :userId";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':userId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->execute();
    $user = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $SQLStmt->closeCursor();

    return $user['pseudo'];
}



//UTILISATEUR CO ET DECO


//Selectionner les utilisateurs selon leur etat
function getMembersCo() {
    $conn = getConnexion();

    $SQLQuery = "SELECT U.id_utilisateur, U.pseudo, U.prenom, U.date_naissance, U.descript,
    COALESCE(MAX(C.etat), 'déconnecté') as etat
    FROM UTILISATEUR U
    LEFT JOIN (
    SELECT C1.id_utilisateur, C1.etat
    FROM CONNEXIONS C1
    INNER JOIN (
    SELECT id_utilisateur, MAX(last_action) as max_last_action
    FROM CONNEXIONS
    GROUP BY id_utilisateur
    ) Cmax ON C1.id_utilisateur = Cmax.id_utilisateur AND C1.last_action = Cmax.max_last_action
    ) C ON U.id_utilisateur = C.id_utilisateur
    GROUP BY U.id_utilisateur
    ORDER BY U.id_utilisateur";
    $SQLStmt = $conn->prepare($SQLQuery); 
    $SQLStmt->execute(); 
    $membersCo = $SQLStmt->fetchAll(PDO::FETCH_ASSOC); 
    $SQLStmt->closeCursor(); 
  
    return $membersCo;
}

//Récupérer l'etat de connexion des utilisateurs
function getUserStatus($userId) {
    $conn = getConnexion();

    // Requête SQL pour récupérer l'état de connexion de l'utilisateur spécifié
    $SQLQuery = "SELECT COALESCE(MAX(C.etat), 'déconnecté') as etat
                 FROM CONNEXIONS C
                 WHERE C.id_utilisateur = :userId";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $SQLStmt->execute();
    $userStatus = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $SQLStmt->closeCursor();

    return $userStatus['etat'];
}


//Mettre à jour l'etat de connexion des utilisateurs 
function updateConnexionStatus($userId, $status) {
    $conn = getConnexion();
    $date = date("Y-m-d H:i:s");

    if ($status == 'connecté') {
        $SQLQuery = "INSERT INTO CONNEXIONS (id_utilisateur, date_connexion, last_action, etat) 
                     VALUES (:userId, :date, :date, 'connecté')
                     ON DUPLICATE KEY UPDATE date_connexion = :date, last_action = :date, etat = 'connecté'";
    } else {
        $SQLQuery = "UPDATE CONNEXIONS SET date_deconnexion = :date, last_action = :date, etat = 'déconnecté' WHERE id_utilisateur = :userId";
    }

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':date', $date, PDO::PARAM_STR);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();
}

//Mettre à jour l'etat deconnexion des utilisateurs 
function updateDeconnexionStatus($userId) {   
    $conn = getConnexion();
    $date = date("Y-m-d H:i:s");

    $SQLQuery = "UPDATE CONNEXIONS SET date_deconnexion = :date, last_action = :date, etat = 'déconnecté' WHERE id_utilisateur = :userId";

    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':date', $date, PDO::PARAM_STR);
    $SQLStmt->execute();
    if ($SQLStmt->errorCode() != "00000") {
        echo "SQL Error: " . print_r($SQLStmt->errorInfo(), true);
    }
    $SQLStmt->closeCursor();
}




//INSERTION MESSAGES

//Insérer les messages dans la bdd et appeler à inserer les id_message ds notitifations
function storeMessage($fromUserId, $toUserId, $messageText, $isDirect) {
    $conn = getConnexion();
    $date_sent = date("Y-m-d H:i:s");
  
    $SQLQuery = "INSERT INTO MESSAGES (from_user_id, to_user_id, message, date_sent, is_direct) 
                VALUES (:fromUserId, :toUserId, :messageText, :date_sent, :isDirect)";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':fromUserId', $fromUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':toUserId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':messageText', $messageText, PDO::PARAM_STR);
    $SQLStmt->bindValue(':date_sent', $date_sent, PDO::PARAM_STR);
    $SQLStmt->bindValue(':isDirect', $isDirect, PDO::PARAM_BOOL);
    $SQLStmt->execute();


    if (!$isDirect) {
        $messageId = $conn->lastInsertId();
        storeNotification($fromUserId, $toUserId, $messageId);
    }
}


//Insertion d'un message envoyé en direct + sa notif
function sendMessageDirect($fromUserId, $toUserId, $messageText) {
    $conn = getConnexion();
    $date = date("Y-m-d H:i:s");

    $SQLQuery = "INSERT INTO MESSAGES (from_user_id, to_user_id, message, date_sent, is_direct) 
                 VALUES (:fromUserId, :toUserId, :messageText, :date_sent, 1)";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':fromUserId', $fromUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':toUserId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':messageText', $messageText, PDO::PARAM_STR);
    $SQLStmt->bindValue(':date_sent', $date, PDO::PARAM_STR);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();

    // Ajouter une notification
    $messageId = $conn->lastInsertId();
    storeNotification($fromUserId, $toUserId, $messageId);
}


//Insertion d'un message envoyé en différé + sa notif
function sendMessageDeferred($fromUserId, $toUserId, $messageText) {
    $conn = getConnexion();
    $date = date("Y-m-d H:i:s");

    $SQLQuery = "INSERT INTO MESSAGES (from_user_id, to_user_id, message, date_sent, is_direct) 
                 VALUES (:fromUserId, :toUserId, :messageText, :date_sent, 0)";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':fromUserId', $fromUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':toUserId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':messageText', $messageText, PDO::PARAM_STR);
    $SQLStmt->bindValue(':date_sent', $date, PDO::PARAM_STR);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();

     // Ajouter une notification
    $messageId = $conn->lastInsertId();
    storeNotification($fromUserId, $toUserId, $messageId);
}

//Récupérer les message via leur id_message
function getMessageTextById($messageId) {
    $conn = getConnexion();

    $SQLQuery = "SELECT message FROM MESSAGES WHERE id_message = :messageId";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
    $SQLStmt->execute();
    $message = $SQLStmt->fetch(PDO::FETCH_ASSOC);
    $SQLStmt->closeCursor();

    return $message['message'];
}


function fetchMessages($fromUserId, $toUserId) {
    $conn = getConnexion();
    
    $SQLQuery = "SELECT * FROM MESSAGES WHERE (from_user_id = :fromUserId AND to_user_id = :toUserId) 
     ORDER BY date_sent ASC";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':fromUserId', $fromUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':toUserId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->execute();
  
    return $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    
}




//INSERTION NOTIFICATIONS

//Insérer les notifs dans la bdd
function storeNotification($fromUserId, $toUserId, $messageId) {
    $conn = getConnexion();
    $date_created = date("Y-m-d H:i:s");
    $is_read = false;

    // Récupérer le texte du message
    $messageText = getMessageTextById($messageId);

    $SQLQuery = "INSERT INTO NOTIFICATION (id_message, from_user_id, to_user_id, message, date_created, is_read) 
                 VALUES (:messageId, :fromUserId, :toUserId, :messageText, :date_created, :is_read)";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':fromUserId', $fromUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':toUserId', $toUserId, PDO::PARAM_INT);
    $SQLStmt->bindValue(':messageText', $messageText, PDO::PARAM_STR);
    $SQLStmt->bindValue(':date_created', $date_created, PDO::PARAM_STR);
    $SQLStmt->bindValue(':is_read', $is_read, PDO::PARAM_INT);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();
}


//Récupérer les notifications stockées pour l'utilisateur recepteur
function getStoredNotificationsForUser($userId) {
    $conn = getConnexion();

    $SQLQuery = "SELECT * 
    FROM notification
    WHERE to_user_id = :userId";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $SQLStmt->execute();

    return $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
}

//Récuperer les messages stockés dans la table NOTIFICATION pour l'utilisateur recepteur
function getStoredMessagesForUser($userId) {
    $conn = getConnexion();

    $SQLQuery = "SELECT * FROM `notification` WHERE `to_user_id` = :userId AND `is_read` = 0";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $SQLStmt->execute();
    $notifications = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);

    $SQLStmt->closeCursor();
    return $notifications;
}

//Marquer les notifs comme as read
function markNotificationAsRead($notificationId) {
    $conn = getConnexion();
  
    $SQLQuery = "UPDATE `NOTIFICATION` SET `is_read` = 1 WHERE `id_notification` = ?";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(1, $notificationId, PDO::PARAM_INT);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();
}

//Effacer lesnotifs une fois consultées
function removeReadNotifications($toUserId) {
    $conn = getConnexion();

    $SQLQuery = "DELETE FROM NOTIFICATION WHERE to_user_id = ? AND is_read = 1";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindParam("i", $toUserId);
    $SQLStmt->execute();
}

?>