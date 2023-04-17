<?php
$utilisateurs = isset($utilisateur) ? [$utilisateur] : [];

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: /inmydreams/views/frm-connexion.phtml");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <base href="/inmydreams/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/inmydreams/dreams/style/style.css">
    <title>Membres trouvé</title>
  </head>


  <body>
  
    <nav>
      <?php require_once __DIR__ . '/../partials/nav.phtml'; ?>
    </nav>
    <main>
    <div class="container-resultat-user">
      <?php if (!empty($utilisateurs)) : ?>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
          <div class="user-info">
            <div class="avatar-and-details">
              <form action="/inmydreams/controllers/utilisateurController.php?action=upload" method="post" enctype="multipart/form-data">
                <img class="img-avatar-user" src="<?= !empty($utilisateur['avatar']) ? strip_tags($utilisateur['avatar']) : '/inmydreams/dreams/avatars/avatar.png' ?>" alt="Avatar de <?=strip_tags($utilisateur['pseudo'])?>">
              </form>
              <div class="user-details">
                <h1><?=strip_tags($utilisateur['pseudo'] ?? '')?></h1>
                <p>Prénom : <?=strip_tags($utilisateur['prenom'] ?? '')?></p>
                <p>Date de naissance : <?=strip_tags($utilisateur['date_naissance'] ?? '')?></p>
                <p>Ville : <?=strip_tags($utilisateur['Libelle_ville'] ?? '')?></p>
                <p>Description : <?=strip_tags($utilisateur['descript'] ?? '')?></p>
                <button class="favorite-heart" data-id_utilisateur_suivre="<?= isset($utilisateur['id_utilisateur_suivre']) ? htmlspecialchars($utilisateur['id_utilisateur_suivre'], ENT_QUOTES, 'UTF-8') : '' ?>">&#x2764;</button>
              </div>
            </div>
            <div class="user-reves">
              <?php if (!empty($utilisateur['reves'])) : ?>
                <h2>Rêves publiés</h2>
                <?php foreach ($utilisateur['reves'] as $reve) : ?>
                  <div class="reve"> 
                    <h3><?=strip_tags($reve['Titre_Reve'] ?? '')?></h3>
                    <p><?=strip_tags($reve['Libelle_Reve'] ?? '')?></p>
                  </div>
                <?php endforeach; ?>
              <?php else : ?>
                <p>Aucun rêve publié</p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p>Aucun utilisateur trouvé</p>
      <?php endif; ?>
    </div>
    </main>
    <footer>
      <?php require_once __DIR__ . '/../partials/footer.phtml'; ?>
    </footer>
    <script  src="/inmydreams/dreams/js/fav.js"></script>
  </body>
</html>



