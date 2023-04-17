<?php

 require_once __DIR__ . "/../models/config.php";
 require_once __DIR__ . "/../models/Reve.php";
require_once __DIR__ . "/../models/Famille_reve.php";
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . '/../models/Note.php';
require_once __DIR__ . '/../models/Suivre.php';



  $conn = getConnexion();


  function ajouterUtilisateurFavori(int $id_utilisateur, int $id_utilisateur_suivre) {
    $conn = getConnexion();
    $SQLQuery = "INSERT INTO SUIVRE (id_utilisateur, id_utilisateur_Suivre) VALUES (:id_utilisateur, :id_utilisateur_Suivre)";
    $SQLStmt = $conn->prepare($SQLQuery);
    $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $SQLStmt->bindValue(':id_utilisateur_suivre', $id_utilisateur_suivre, PDO::PARAM_INT);
    $SQLStmt->execute();
    $SQLStmt->closeCursor();
}


function getUtilisateursFavoris(int $id_utilisateur) {
  $conn = getConnexion();
  $SQLQuery = "SELECT U.* FROM utilisateur U
  INNER JOIN suivre s ON s.id_utilisateur_suivre = U.id_utilisateur
  WHERE s.id_utilisateur = :id_utilisateur;";
  $SQLStmt = $conn->prepare($SQLQuery);
  $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
  $SQLStmt->execute();
  $utilisateursFav = $SQLStmt->fetchAll(PDO::FETCH_ASSOC);
  $SQLStmt->closeCursor();
    return $utilisateursFav;
}


function getIdUtilisateurByPseudo($pseudo) {
  $conn = getConnexion();
  $SQLQuery = "SELECT id_utilisateur FROM utilisateur WHERE pseudo = :pseudo";
  $SQLStmt = $conn->prepare($SQLQuery);
  $SQLStmt->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
  $SQLStmt->execute();
  $user = $SQLStmt->fetch(PDO::FETCH_ASSOC);
  $SQLStmt->closeCursor();
  return $user['id_utilisateur'];
}


function isFavorite(int $id_utilisateur, int $id_utilisateur_suivre) {
  $conn = getConnexion();
  $SQLQuery = "SELECT * FROM suivre WHERE id_utilisateur = :id_utilisateur AND id_utilisateur_suivre = :id_utilisateur_suivre";
  $SQLStmt = $conn->prepare($SQLQuery);
  $SQLStmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
  $SQLStmt->bindValue(':id_utilisateur_suivre', $id_utilisateur_suivre, PDO::PARAM_INT);
  $SQLStmt->execute();
  $result = $SQLStmt->fetch(PDO::FETCH_ASSOC);
  $SQLStmt->closeCursor();
  return $result !== false;
}
?>