<?php
require_once('../modele/BDD.php');
require_once('../view/includes/user-session.php');
session_destroy();
add_notif_modal("success", "Déconnexion réussie", "Vous êtes maintenant déconnecté");
header('Location: ../view/index.php');
?>