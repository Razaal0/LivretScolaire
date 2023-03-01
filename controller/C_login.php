<?php
require_once('../modele/BDD.php');
require_once('../view/includes/user-session.php');

if (UserConnected()) {
    header('Location: ../view/');
    add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
    exit();
}

// post username and password
if (isset($_POST['email']) && isset($_POST['password'])) {
    require_once('../view/includes/user-session.php');
    // récupéré les données du formulaire
    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $remember = isset($_POST['remember']) ? true : false;

    // récupérer le compte
    $account = recupere_user($username, $password);
    // si le compte existe
    if ($account) {
        // si on a coché la case "se souvenir de moi", ne pas expirer la session
        if ($remember) {
            // créer le remember me
        }
        // on crée la session
        $_SESSION['EMAIL'] = $account['EMAIL'];
        $_SESSION['PRENOM'] = $account['PRENOM'];
        $_SESSION['NOM'] = $account['NOM'];
        $_SESSION['Permission'] = $account['Permission'];
        $_SESSION['START'] = true;
        // on redirige vers la page d'accueil
        add_notif_modal("success", "Connexion réussie", "Vous êtes maintenant connecté");
        header('Location: ../view/index.php');
    } else{
        // si le compte n'existe pas
        add_notif_modal("danger", "Connexion échouée", "Email ou mot de passe incorrect");
        header('Location: ../view/pages-login.php');
    }
} else {
    // si les données ne sont pas postées
    add_notif_modal("danger", "Connexion échouée", "Veuillez remplir tous les champs");
    header('Location: ../view/pages-login.php');
}