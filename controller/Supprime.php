<?php
require_once '../controller/session.php';
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
//R�cup�rer le code de la mati�re
$codemat = filter_input(INPUT_GET, 'codemat');
//R�cup�rer le code de l'enseignant
$codeens = filter_input(INPUT_GET, 'codeens');
//R�cup�rer le code de l'�tudiant
$codeetudiant = filter_input(INPUT_GET, 'codeetud');
?>

<?php
//Suppression de la mati�re

require_once '../modele/BDD.php';
if ($codemat) {
    supprimer_matiere($codemat);
?>
    <script>
        window.location.href = "../controller/C_matiere.php";
    </script>
<?php
}
//Suppression de l'enseignant
if ($codeens) {
    supprimer_enseignant($codeens);
?>
    <script>
        window.location.href = "../controller/C_prof.php";
    </script>
<?php
}
//Suppression de l'�tudiant
if ($codeetudiant) {
    try {
        supprimer_etudiant($codeetudiant);
        $error = 0;
        $message = "Etudiant supprimé avec succès";
    } catch (Exception $e) {
        $error = 1;
        $message = "Erreur lors de la suppression de l'étudiant";
        $message += $e->getMessage();
    }
?>
    <script>
        window.location.href = "../controller/C_etudiant.php?message=<?php echo $message; ?>&error=<?php echo $error; ?>";
    </script>
<?php
}
