<?php
// post email, username and password
require_once('../modele/BDD.php');
require_once('../view/includes/user-session.php');

if (UserConnected()) {
    header('Location: ../view/');
    add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
    exit();
}


if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email'])) {
    $code = kodex_random_string();
    $_SESSION['code'] = $code;
    
    // récupéré les données du formulaire
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    
    $_SESSION['emailmdp'] = $email;
    
    $to = $email;
    $subject = 'Mot de passe oublié';
    $message = '<html><body>';
    $message .= '<h1 style="color:#00c3ff"> Mot de passe oublié </h1>';
    $message .= '<p style="color:#000000; font-size:12px"> Voici le code permettant de réinitialiser votre mot de passe :</p>';
    $message .= '<br />';
    $message .= '<h2 style="color:#2657eb>' . $code . '</h2>';
    $message .= '</body></html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Livret Scolaire' . "\r\n";
    
    try {
        mail($to, $subject, $message, $headers);
        add_notif_modal("success", "Un mail vous a été envoyé.", "Veuillez vérifier votre boite mail ! $code");
        header('Location: ../view/insert_psw_code.php');
    } catch (Exception $ex) {
        add_notif_modal("danger", "Une erreur est survenue", "Une ou plusieurs de ces informations sont incorrectes, veuillez réessayer !");
        header('Location: ../view/edit-password.php');
    }
}

if (isset($_POST['code'])) {
    $verify_code = $_POST['code'];
    
    echo $verify_code;
    if ($_SESSION['code'] === $verify_code) {
        add_notif_modal("success", "Le code inséré est bon", "Vous pouvez désormais modifier votre mot de passe");
        header('Location: ../view/change-password.php');
    } else {
        add_notif_modal("danger", "Une erreur est survenue", "Une ou plusieurs de ces informations sont incorrectes");
        header('Location: ../view/edit-password.php');
    }
} else {
    echo 'erreur erreur';
}


if (isset($_POST['mdp']) && isset($_POST['rmdp'])) {
    $mdp = htmlspecialchars($_POST['mdp']);
    $rmdp = htmlspecialchars($_POST['rmdp']);
    
    if($mdp === $rmdp) {
        $mdp = password_hash(htmlspecialchars($_POST['mdp']), PASSWORD_DEFAULT);
        $emailmdp = $_SESSION['emailmdp'];
        
        if (update_pw($mdp, $emailmdp)) {
            
            // on redirige vers la page d'accueil
            add_notif_modal("success", "Mot de passe mis à jour", "Votre mot de passe a été modifié avec succès");
            header('Location: ../view/pages-login');
        } else {
            add_notif_modal("danger", "Erreur", "Une erreur est survenue lors de la modification");
            header('Location: ../view/change-password.php');
        }
        
    }
}
