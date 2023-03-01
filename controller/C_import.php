<?php
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>



<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
require_once('../modele/BDD.php');
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');

    if (!isset($_GET['nb_eleve_insert'])) {
    ?>
        <main id="main" class="">
            <form method="POST" action="import_traitement.php" enctype="multipart/form-data" style="display: inline-table">
                <h3>Importation des élèves format csv : </h3>
                <h6>(NOM | PRENOM | SEXE | NE(E) LE | DIV. | REG. | OPT1 | OPT2 | DIV.PREC.)</h6>
                <input type="file" name="import" id="import" accept=".csv" required>
                <input type="submit" name='Importer' value="Ajouter">
            </form>
        </main>
    <?php
    } else {
        // afficher que l'insertion a été effectué
        $eleve_insert = htmlspecialchars($_GET['nb_eleve_insert']);
    ?>
        <h4>Tous les étudiants ont été insérés dans la base de données.</h4>
        <br />
        <h5>Nombre d'étudiant inséré : <?php echo $eleve_insert; ?></h5>
    <?php
    }
    ?>
</body>

</html>

<?php
require_once '../view/includes/footer.php';
