<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}

// Vérification que les variables sont bien définies
if (isset($_GET['code_prof']) & isset($_GET['code_classe']) & isset($_GET['type'])) {
    $code_prof = htmlspecialchars($_GET['code_prof']);
    $code_classe = htmlspecialchars($_GET['code_classe']);
    $type = htmlspecialchars($_GET['type']);

    $classe = recupere_classes();
    $matiere = recupere_matieres();

    $enseignant_classe = recupere_classe_enseignant(htmlspecialchars($_GET['code_prof']));
    // On envoie les données en JSON pour pouvoir les récupérer dans le JS
    echo "<script>enseignant_classe = " . json_encode($enseignant_classe) . ";</script>";

    // rechercher le nom de la classe dans recupere_classes()
    $nom_classe = "";
    foreach ($classe as $key => $value) {
        if ($value['classecode'] == $code_classe) {
            $nom_classe = $value['Libellecourt'];
        }
    }
}

if (isset($_POST['form_prof']) & isset($_POST['form_classe']) & isset($_POST['form_type']) & isset($_POST['matiere'])) {
    $code_prof = htmlspecialchars($_POST['form_prof']);
    $code_classe = htmlspecialchars($_POST['form_classe']);
    $type = htmlspecialchars($_POST['form_type']);


    // On redirige vers la page de gestion des affectations
    echo '<meta http-equiv="refresh" content="0; url=/view/Affectation.php" />';
    exit();
}


require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
require_once('../view/Affectation_add_mod.php');
require_once '../view/includes/footer.php';