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


require_once('../modele/BDD.php');
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
//R�cup�re le code enseignant, le code mati�re et le code �tudiant
$codeens = filter_input(INPUT_GET, 'codeens');
$codemat = filter_input(INPUT_GET, 'codemat');
$codeetudiant = filter_input(INPUT_GET, 'codeetud');

require_once '../view/Modification.php';
//Si une nouvelle mati�re est rentr�e, modifie l'ancienne
if (isset($_POST['matiere'])) {
    modif_matiere($codemat);
?>
    <script>
        window.location.href = "../controller/C_matiere.php";
    </script>
<?php
}

//Si un nouveau nom/pr�nom enseignant est rentr�, modifie l'ancien
if (isset($_POST['nomens']) || isset($_POST['prenomens'])) {
    modif_ens($codeens);
?>
    <script>
        window.location.href = "../controller/C_prof.php";
    </script>
<?php
}

//Si un nouveau nom/pr�nom/date de naissance/classe �tudiant est rentr�, modifie l'ancien
if (isset($_POST['nometu']) || isset($_POST['prenometu']) || isset($_POST['date']) || isset($_POST['classe'])) {

    modif_etud($codeetudiant);
?>
    <script>
        window.location.href = "../controller/C_etudiant.php";
    </script>
<?php
}
require_once '../view/includes/footer.php';
