<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
    exit();
}

$enseignant = recupere_enseignants();
// On envoie les données en JSON pour pouvoir les récupérer dans le JS
echo "<script>enseignant = " . json_encode($enseignant) . "</script>";
$classe = recupere_classes();
// On envoie les données en JSON pour pouvoir les récupérer dans le JS
echo "<script>classe = " . json_encode($classe) . "</script>";

// Quand on choisi un enseignant :
if (isset($_POST['code_enseignant']) || isset($_SESSION['C_affectation_code_enseignant'])) {
    $_POST['code_enseignant'] = isset($_POST['code_enseignant']) ? $_POST['code_enseignant'] : $_SESSION['C_affectation_code_enseignant'];
    unset($_SESSION['C_affectation_code_enseignant']);
    $enseignant_classe = recupere_classe_enseignant(htmlspecialchars($_POST['code_enseignant']));
    // On envoie les données en JSON pour pouvoir les récupérer dans le JS
    echo "<script>enseignant_classe = ". json_encode($enseignant_classe) .";</script>";
}

require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
require_once('../view/Affectation.php');
require_once '../view/includes/footer.php';