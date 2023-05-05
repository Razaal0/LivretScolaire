<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}

require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
$classe = recupere_classes();

require_once '../view/ImprimerPDF.php';
require_once '../view/includes/footer.php';
?>