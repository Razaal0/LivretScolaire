<?php
require_once('../modele/BDD.php');
require_once('../view/includes/user-session.php');
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
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
    add_notif_modal("success", "Matière supprimée", "La matière a bien été supprimée");
?>
    <script>
         window.location.replace("/controller/C_matiere.php");
    </script>
<?php
}
//Suppression de l'enseignant
if ($codeens) {
    supprimer_enseignant($codeens);
    add_notif_modal("success", "Enseignant supprimé", "L'enseignant a bien été supprimé");
?>
    <script>
       window.location.replace("/controller/C_prof.php");
    </script>
<?php
}

//Suppression de l'�tudiant
if ($codeetudiant) {
    try {
        supprimer_etudiant($codeetudiant);
        $error = 0;
        add_notif_modal("success", "Etudiant supprimé", "L'étudiant a bien été supprimé");
    } catch (Exception $e) {
        $error = 1;
        add_notif_modal("danger", "Erreur", "L'étudiant n'a pas pu être supprimé" . $e->getMessage());
    }
?>
    <script>
       window.location.replace("/controller/C_etudiant.php");
    </script>
<?php
}


//Affectation

// Suppresion d'une affectation d'un enseignant à une classe
if (isset($_POST['code_enseignant']) && isset($_POST['code_classe'])) {
    $code_enseignant = htmlspecialchars($_POST['code_enseignant']);
    $code_classe = htmlspecialchars($_POST['code_classe']);
    $test = supprimer_affectation_enseignant_classe($code_enseignant, $code_classe);
    if ($test){
    echo "success";
    } else {
    echo $test;
    }
    exit();
}