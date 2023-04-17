<?php

require_once __DIR__ . '/../models/config.php';

if (isset($_POST['MOT_CLE']) || isset($_POST['pseudo']) || isset($_POST['id_type_reve']) || isset($_POST['id_sexe'])) {
    $conn = getConnexion();

    $MOT_CLE = $_POST['MOT_CLE'];
    $pseudo = $_POST['pseudo'];
    $id_type_reve = $_POST['id_type_reve'];
    $id_sexe = $_POST['id_sexe'];
    

    $queries = [];
    $params = [];

    // Recherche par pseudo
    if ($pseudo != '') {
        $queries[] = "u.pseudo LIKE :pseudo";
        $params[':pseudo'] = "%$pseudo%";
    }

    // Recherche par catégorie
    if ($id_type_reve != '') {
        $queries[] = "r.id_type_reve = :id_type_reve";
        $params[':id_type_reve'] = $id_type_reve;
    }

    // Recherche par sexe
    if ($id_sexe != '') {
        $queries[] = "u.id_sexe = :id_sexe";
        $params[':id_sexe'] = $id_sexe;
    }

    // Concaténation des conditions
    $whereClause = implode(' OR ', $queries);



    // Requête de recherche
    $SQLQuery = $conn->prepare("
        SELECT r.id_reve, r.Titre_Reve, r.Libelle_Reve, r.Date_Creation_Reve, u.pseudo
        FROM REVE r
        JOIN UTILISATEUR u ON r.id_utilisateur = u.id_utilisateur
        JOIN CP_VILLE c ON c.id_cp_ville = u.id_cp_ville
        WHERE ($whereClause) AND (r.Titre_Reve LIKE :MOT_CLE OR r.Libelle_Reve LIKE :MOT_CLE)
    ");

    $params[':MOT_CLE'] = "%$MOT_CLE%";

    $SQLQuery->execute($params);

    $reveFounds = $SQLQuery->fetchAll(PDO::FETCH_ASSOC);
}

?>

<section>
    <?php foreach($reveFounds as $reveFound): ?>
        <article>
            <h1><a href="result_dreams.php?id=<?=$reveFound["id_reve"]?>"><?=strip_tags($reveFound['Titre_Reve'])?></a></h1>
            <p>Description du rêve : <?=strip_tags($reveFound["Libelle_Reve"])?></p>
            <p>Publié le : <?=$reveFound["Date_Creation_Reve"]?></p>
            <p><a href="">Par : <?=strip_tags($reveFound["pseudo"])?></a></p>
        </article>
    <?php endforeach;?>
</section>
