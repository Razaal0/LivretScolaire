<?php
/*Inclusion des fichiers nécessaires, 
 * celui du fichier de la base
 * celui du fichier et le fichier session utilisateur
 */
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

/* Vérification que l'utilisateur est connecté et qu'il a les droits d'accéder à cette page.
*S'il n'a pas les droits, un message d'erreur est affiché et l'utilisateur est redirigé vers la page d'accueil*/
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
    exit();
}

// Inclusion des fichiers d'en-tête et de navigation pour la page
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');

/* Récupération de la matière et inscription dans la base de données si l'utilisateur a soumis le formulaire de matière.
* Operation reussi: un message de succés est affiché et l'utilisateur est redirigé vers la page des matières */
$matiere = recupere_matieres();
if (isset($_POST['matieres'])) {
    $matieres = $_POST['matieres'];
    insert_matieres($matieres);
    add_notif_modal("success", "Matière ajoutée", "La matière a bien été ajoutée");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/controller/C_matiere.php' />";
    exit();
}

// Inclusion de la vue de la page Matière et du pied de page
require_once('../view/Matiere.php');
require_once('../view/includes/footer.php');


