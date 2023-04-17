// Crée une Map pour stocker les utilisateurs
const utilisateurs = new Map();

// définir userId et toUserId comme une variable globale
let userId;
let toUserId;


// Parcourt les valeurs de la Map (les objets utilisateur)
for (const utilisateur of utilisateurs.values()) {
    console.log(utilisateur.pseudo, utilisateur.id);
  }


  // Fonction appelée lorsqu'un utilisateur se connecte
function onUtilisateurSeConnecte(nouvelUtilisateur) {
    // Vérifie si l'utilisateur est déjà présent dans la Map
    if (!utilisateurs.has(nouvelUtilisateur.id)) {
      // Ajoute l'utilisateur à la Map s'il n'est pas déjà présent
      utilisateurs.set(nouvelUtilisateur.id, nouvelUtilisateur);
    }
  
// Met à jour l'affichage des utilisateurs connectés ici
const userElement = document.querySelector(`.card-usersCo[data-userid="${nouvelUtilisateur.id}"]`);
if (userElement) {
  userElement.querySelector(".online-status").classList.add("online");
  userElement.querySelector(".online-status").classList.remove("offline");
  userElement.querySelector(".bouton-chat").textContent = "Tchattez";
}
  }
  
  // Fonction appelée lorsqu'un utilisateur se déconnecte
  function onUtilisateurSeDeconnecte(utilisateurDeconnecte) {
    // Supprime l'utilisateur de la Map
    utilisateurs.delete(utilisateurDeconnecte.id);
  
    const userElement = document.querySelector(`.card-usersCo[data-userid="${utilisateurDeconnecte.id}"]`);
    if (userElement) {
      userElement.querySelector(".online-status").classList.add("offline");
      userElement.querySelector(".online-status").classList.remove("online");
      userElement.querySelector(".bouton-chat").textContent = "Envoyer un message";
    }
  }




  function showChatWindow(userId) {
    const chatWindow = document.getElementById("chat-window");
    chatWindow.classList.remove("hidden");
    openChatWithUser(userId);
  }

  function sendMessage(fromUserId, toUserId, isDirect, senderPseudo, recipientPseudo, messageText, isRecipient, messageId) {
    console.log('Message text in sendMessage function:', messageText);
    const url = `index.php?page=chat&action=${isDirect ? 'sendDirectMessage' : 'sendStoredMessage'}`;
    const formData = new FormData();
    formData.append('fromUserId', fromUserId);
    formData.append('toUserId', toUserId);
    formData.append('senderPseudo', senderPseudo);
    formData.append('recipientPseudo', recipientPseudo);
    formData.append('messageText', messageText);
  
    return fetch(url, {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur réseau');
        }
        return response.text();
      })
      .then(rawResponse => {
        console.log("Raw response:", rawResponse);
        let data;
        try {
          data = JSON.parse(rawResponse);
        } catch (error) {
          console.error('Erreur lors de la conversion de la réponse brute en JSON:', error);
          return;
        }
        if (isDirect && isRecipient) {
          messageId = data.messageId; 
          showNotification("Vous avez un message", messageId, toUserId);
        }
      })
      .catch(error => {
        console.error('Erreur lors de la requête AJAX:', error);
      });
  }
  

  document.querySelectorAll('.bouton-chat').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
  
      // Mettrea jour la valeur de toUserId ici
      userId = parseInt(document.documentElement.dataset.userId, 10);
      toUserId = parseInt(e.target.closest('.card-usersCo').dataset.userid, 10);
      const buttonText = e.target.textContent;
  
      if (buttonText === 'Tchattez') {
        // Montre la fenêtre de chat
        showChatWindow(toUserId);
      } else {
        // Pour les messages stockés
        sendMessage(window.fromUserId, toUserId, false, '', true, null);
      }
    });
  });


  document.getElementById('chat-send-btn').addEventListener('click', () => {
    console.log("Click event triggered");
    const chatInput = document.getElementById('chat-input');
    const message = chatInput.value;
    const recipientPseudo = document.querySelector(`.card-usersCo[data-userid="${toUserId}"]`).querySelector("h3").textContent.trim();
    const isRecipient = toUserId !== window.fromUserId;
  
    if (message.trim()) {
      console.log('Message à envoyer :', message);
      senderPseudo = window.senderPseudo;
      console.log("Message to send:", message);
      sendMessage(window.fromUserId, toUserId, true, senderPseudo, recipientPseudo, message, isRecipient, null)
      .then(() => {
        displayMessage(senderPseudo, message);
      })
      .catch((error) => {
        console.error('Erreur lors de l\'envoi du message:', error);
      });
    }
    chatInput.value = '';
  });
  



  function displayMessage(senderPseudo, message, isDirect = false) {
    const chatMessages = document.getElementById("chat-messages");
    const currentTime = new Date().toLocaleTimeString();
  
    // Vérif si le message vient de l'utilisateur actuel
    const isCurrentUser = senderPseudo === window.senderPseudo;
  
    // Affiche "moi" si le message vient de l'utilisateur actuel, sinon affiche le pseudo de l'expéditeur
    const displayPseudo = isCurrentUser ? "moi" : (senderPseudo || 'Inconnu');
  
    chatMessages.innerHTML += `<p>[${currentTime}] <b>${displayPseudo}</b>: ${message}</p>`;
    chatMessages.scrollTop = chatMessages.scrollHeight;
  
    // Affiche la notification
    if (isDirect && !isCurrentUser) {
      showNotification("Vous avez un message");
    }
  }



    
  function showNotification(message, messageId, toUserId) {
    if (toUserId === window.fromUserId) {
    const notificationContainer = document.getElementById("notification-container");
    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
  
    // Stock le message et l'ID du message dans des attributs data sur l'élément de notification
    notification.dataset.message = message;
    notification.dataset.messageId = messageId;
  
    // Ajoute un gestionnaire d'événements pour le clic sur la notification
    notification.addEventListener("click", () => {
      // Montre la fenêtre de chat
      showChatWindow();
      // Récupére le message à partir de l'attribut data-message
      const messageText = notification.dataset.message;
      // Affiche le message dans la fenêtre de chat
      displayMessage(window.senderPseudo, messageText);
      // Supprime la notification
      notificationContainer.removeChild(notification);
  
      // Supprime la notification du serveur
      deleteNotification(notification.dataset.messageId);
    });
  
    notificationContainer.appendChild(notification);
  }}


function fetchMessages(fromUserId, toUserId) {
  const url = `index.php?page=chat&action=fetchMessages&fromUserId=${fromUserId}&toUserId=${toUserId}`;

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur réseau");
      }
      return response.json();
    })
    .then((messages) => {
      messages.forEach((message) => {
        displayMessage(message.senderPseudo, message.messageText);
      });
    })
    .catch((error) => {
      console.error("Erreur lors de la requête AJAX:", error);
    });
}

function openChatWithUser(userId) {
  document.getElementById("chat-messages").innerHTML = "";
  fetchMessages(window.fromUserId, userId);

  // Supprime les notif pour cette conversation
  const notifications = document.querySelectorAll('.notification');
  notifications.forEach(notification => {
    if (notification.dataset.messageId && parseInt(notification.dataset.messageId) === parseInt(userId)) {
      // Supprime la notification du serveur
      deleteNotification(notification.dataset.messageId);
      // Supprime la notification de l'affichage
      notification.remove();
    }
  });
}


  
  // Récupére les notifications stockées et les afficher
  function fetchStoredNotifications() {
    // ajax pour récupérer les notifications stockées
    const url = `index.php?page=chat&action=fetchStoredNotifications&toUserId=${window.fromUserId}`;
  
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur réseau');
        }
        return response.text();
      })
      .then(rawResponse => {
        console.log("Raw response:", rawResponse);
        const data = JSON.parse(rawResponse); // analyser la réponse brute en json
  
        // Affich les notifications stockées
        data.forEach(notification => {
          showNotification(notification.message, notification.id, notification.to_user_id);
        });
      })
      .catch(error => {
        console.error('Erreur lors de la requête AJAX:', error);
      });
  }
// Appele la fonction fetchStoredNotifications() lors du chargement de la page
document.addEventListener('DOMContentLoaded', fetchStoredNotifications);



function deleteNotification(messageId) {
  const url = `index.php?page=chat&action=markNotificationAsRead&messageId=${messageId}`;

  return fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur réseau");
      }
      return response.json();
    })
    .catch((error) => {
      console.error("Erreur lors de la requête AJAX:", error);
    });
}
 