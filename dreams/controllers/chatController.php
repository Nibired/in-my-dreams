<?php

require_once __DIR__ . '/../models/config.php';
require_once __DIR__ . '/../dao/dao_chat.php';

$conn = getConnexion();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$page = $_GET['page'] ?? 'index';
$action = $_GET['action'] ?? 'view';

switch($action){
    case 'view': {
        $membersCo = getMembersCo();
        if (isset($_SESSION['id_utilisateur'])) {
            updateConnexionStatus($_SESSION['id_utilisateur'], 'connecté');
            echo "<script>document.documentElement.dataset.userId = '{$_SESSION['id_utilisateur']}';</script>";
        }
        require_once __DIR__ . '/../views/chat.phtml';
        break;
    }
    case 'connect': {
        $userId = $_SESSION['id_utilisateur'];
        updateConnexionStatus($userId, 'connecté');
        echo "<script>document.documentElement.dataset.userId = '{$_SESSION['id_utilisateur']}';</script>";
        header("Location: index.php?page=chat&action=view");
        break;
    }
    case 'disconnect': {
        $userId = $_SESSION['id_utilisateur'];
        updateConnexionStatus($userId, 'déconnecté');
        echo "<script>document.documentElement.dataset.userId = '{$_SESSION['id_utilisateur']}';</script>";
        header("Location: index.php?page=chat&action=view");
        break;
    }
    case 'sendDirectMessage': {
        $fromUserId = $_SESSION['id_utilisateur'];
        $toUserId = isset($_POST['toUserId']) ? $_POST['toUserId'] : null;
        $messageText = $_POST['messageText'] ?? '';
        $isDirect = true;

        if ($toUserId !== null) {
            storeMessage($fromUserId, $toUserId, $messageText, $isDirect);
        } else {
            // Gérer le cas erreur
            http_response_code(400);
            echo json_encode(["error" => "Destinataire non valide"]);
        }
    
        // Ajoutez ce code pour récupérer le pseudo du destinataire
        $recipientPseudo = getRecipientPseudoById($toUserId);
        $messageId = $conn->lastInsertId();
        echo json_encode(["messageText" => $messageText, "recipientPseudo" => $recipientPseudo, "toUserId" => $toUserId, "messageId" => $messageId]);
        break;
    }
    case 'sendStoredMessage': {
        $fromUserId = $_SESSION['id_utilisateur'];
        $toUserId = $_POST['toUserId'];
        $messageText = $_POST['messageText'] ?? '';
        $isDirect = false;
        storeMessage($fromUserId, $toUserId, $messageText, $isDirect); 
        echo json_encode(["messageText" => $messageText]);
        break;
    }
    case 'send-message': {
        $fromUserId = $_SESSION['id_utilisateur'];
        $toUserId = $_POST['toUserId'];
        $message = $_POST['messageText'];
        // Vérifie si l'utilisateur destinataire est en ligne
        $userStatus = getUserStatus($toUserId);
    
        if ($userStatus == 'connecté') {
            // utilisateur est en ligne, affi  immédiatement
            $isDirect = true;
            storeMessage($fromUserId, $toUserId, $message, $isDirect);
        } else {
            // utilisateur  hors ligne, stock la notification pour plus tard
            $isDirect = false;
            storeMessage($fromUserId, $toUserId, $message, $isDirect);
        }
        header("Location: index.php?page=chat&action=view");
        break;
    }
    case 'fetchStoredNotifications': {
        // Récupérer les notifications stockées pour l'utilisateu
            $toUserId = $_GET['toUserId'];
            $notifications = getStoredMessagesForUser($toUserId);
            echo json_encode($notifications);
            break;
        }
    case "fetchMessages": {
        $fromUserId = $_GET["fromUserId"];
        $toUserId = $_GET["toUserId"];
        $messages = fetchMessages($fromUserId, $toUserId);
        echo json_encode($messages);
        break;
      }
      case 'removeReadNotifications': {
        $toUserId = $_GET['toUserId'];
        removeReadNotifications($toUserId);
        echo json_encode(["status" => "success"]);
        break;
    }
    case 'markNotificationAsRead': {
        $messageId = $_GET['messageId'];
        markNotificationAsRead($messageId);
        echo json_encode(["status" => "success"]);
        break;
      }
    default:{
        require_once __DIR__ . '/../controllers/errorController.php';
    }
}

?>  




