<?php
// inclusion des fichiers nécessaires
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
  add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
  echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
  exit();
}
?>

<?php
// inclusion de l'en-tête et de la navigation
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
?>

<?php
// récupération des enseignants existants
$enseignant = recupere_enseignants();

// vérifier que la personne a cliqué sur le bouton submit et que les champs ne sont pas vides
if (verif_submit('saisie_pr') == 'Ajouter') {
  if (isset($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {
    // insertion des données de l'enseignant dans la base de données
    insert_enseignants();
    // message de confirmation
    add_notif_modal("success", "Enseignant ajouté", "L'enseignant a bien été ajouté");
    // redirection
    echo "<meta http-equiv='refresh' content='0; url=".$path."/controller/C_prof.php' />";
    exit();
  } else {
    // message d'erreur si au moins un des champs est vide
    add_notif_modal("danger", "Erreur", "Veuillez remplir tous les champs");
  }
}

// inclusion de la page de formulaire pour ajouter un enseignant et du pied de page
require_once '../view/Professeurs.php';
require_once '../view/includes/footer.php';
