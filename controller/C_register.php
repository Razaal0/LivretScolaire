<?php
// post email, username and password
require_once('../modele/BDD.php');
require_once('../view/includes/user-session.php');

if (UserConnected()) {
    header('Location: ../view/');
    add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
    exit();
}

$inscription_on = true;
if ($inscription_on) {
    if (isset($_POST['email']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password'])) {

        // récupéré les données du formulaire
        $email = htmlspecialchars($_POST['email']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

        // vérifier si un compte existe déjà avec cet email
        if (email_exist($email)) {
            add_notif_modal("danger", "Inscription échouée", "Un compte existe déjà avec cet email");
            header('Location: ../view/pages-register.php');
            exit();
        }
        
        // si tout est ok, on inscrit le compte
        if (insert_user($email, $nom, $prenom, $password)) {
            // créer la session
            $_SESSION['EMAIL'] = $email;
            $_SESSION['PRENOM'] = $prenom;
            $_SESSION['NOM'] = $nom;
            $_SESSION['Permission'] = 0;
            $_SESSION['START'] = true;
            // on redirige vers la page d'accueil
            add_notif_modal("success", "Inscription réussie", "Vous êtes maintenant inscrit");
            header('Location: ../view/');
        } else {
            add_notif_modal("danger", "Inscription échouée", "Une erreur est survenue, veuillez réessayer");
            header('Location: ../view/pages-register.php');
        }
    }
} else {
    add_notif_modal("danger", "Inscription échouée", "L'inscription est désactivée");
    header('Location: ../view/');
}
