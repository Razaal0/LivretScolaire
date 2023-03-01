<?php
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
?>
    <script>
        window.location.replace("/view");
    </script>
    <?php
    exit();
}


?>
<?php
require_once('../modele/BDD.php');
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
?>

<?php
//r�cup�re la mati�re et l'ins�re dans la BDD
$matiere = recupere_matieres();
insert_matieres();
require_once('../view/Matiere.php');
require_once('../view/includes/footer.php');