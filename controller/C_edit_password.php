<?php
// post email, username and password
require_once('../modele/BDD.php');
require_once('../view/includes/PHPMailer/Exception.php');
require_once('../view/includes/PHPMailer/PHPMailer.php');
require_once('../view/includes/PHPMailer/SMTP.php');
require_once('../view/includes/user-session.php');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Méthode pour envoyer le code de réinitialisation par mail
if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && !UserConnected()) {
    $code = kodex_random_string();
    $_SESSION['code'] = $code;

    // récupéré les données du formulaire
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);

    $_SESSION['emailmdp'] = $email;


    $phpMailer = new PHPMailer(true);

    try{
        $to = $email;
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour $prenom $nom, <br> Votre code de réinitialisation est : $code";
        
        $headers .= "Reply-To: expéditeur@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $mail_sent = mail($to, $subject, $message, $headers);
        add_notif_modal("success", "Un mail vous a été envoyé.", "Veuillez vérifier votre boite mail !");
    } catch (Exception $ex) {
        // echo "danger", "Une erreur est survenue", "Email non envoyé erreur : $ex";
        add_notif_modal("success", "Un mail vous a été envoyé.", "Veuillez vérifier votre boite mail ! ".$code);
        echo "<meta http-equiv='refresh' content='0; url=".$path."/view/insert_psw_code.php' />";
    }
}

// Méthode pour vérifier le code envoyé par mail
if (isset($_POST['code']) && !UserConnected()) {
    $verify_code = $_POST['code'];

    if ($_SESSION['code'] === $verify_code) {
        add_notif_modal("success", "Le code inséré est bon", "Vous pouvez désormais modifier votre mot de passe");
        header('Location: ../view/change-password.php');
    } else {
        add_notif_modal("danger", "Une erreur est survenue", "Une ou plusieurs de ces informations sont incorrectes");
        unset($_SESSION['code']); 
        header('Location: ../view/edit-password.php');
    }
}

//  Méthode pour modifier le mot de passe lors d'une réinitialisation
if (isset($_POST['mdp']) && isset($_POST['rmdp']) && !UserConnected()) {
    $mdp = htmlspecialchars($_POST['mdp']);
    $rmdp = htmlspecialchars($_POST['rmdp']);

    if ($mdp === $rmdp) {
        $mdp = password_hash(htmlspecialchars($_POST['mdp']), PASSWORD_DEFAULT);
        $emailmdp = $_SESSION['emailmdp'];

        if (update_pw($mdp, $emailmdp)) {

            // on redirige vers la page d'accueil
            add_notif_modal("success", "Mot de passe mis à jour", "Votre mot de passe a été modifié avec succès");
            header('Location: ../view/pages-login.php');
        } else {
            add_notif_modal("danger", "Erreur", "Une erreur est survenue lors de la modification");
            header('Location: ../view/change-password.php');
        }
    } else {
        add_notif_modal("danger", "Erreur", "Les mots de passe ne correspondent pas");
        header('Location: ../view/change-password.php');
    }
}

// Méthode pour modifier le mot de passe lors d'une modification
if (isset($_POST['CurrentPassword']) && isset($_POST['NewPassword']) && isset($_POST['ConfirmPassword']) && UserConnected()) {

    // Vérification si le mot de passe actuel est correct par rapport à la BDD
    $CurrentPassword = htmlspecialchars($_POST['CurrentPassword']);
    // récupérer le compte
    $account = recupere_user($_SESSION['EMAIL']);
    // On vérifie que le mot de passe est correct
    if (!password_verify($CurrentPassword, $account['MDP'])) {
        add_notif_modal("danger", "Erreur", "Le mot de passe ne correspond pas à celui de votre compte");
        header('Location: ../view/users-profile.php');
        exit();
    }

    // On vérifie que le mot de passe et le mot de passe de confirmation sont identiques
    $NewPassword = htmlspecialchars($_POST['NewPassword']);
    $ConfirmPassword = htmlspecialchars($_POST['ConfirmPassword']);
    if ($NewPassword !== $ConfirmPassword) {
        add_notif_modal("danger", "Erreur", "Les nouveaux mots de passe ne correspondent pas");
        header('Location: ../view/users-profile.php');
        exit();
    }

    // On met à jour le mot de passe
    $NewPassword = password_hash(htmlspecialchars($_POST['NewPassword']), PASSWORD_DEFAULT);
    $emailmdp = $_SESSION['EMAIL'];
    if (update_pw($NewPassword, $emailmdp)) {
        // on redirige vers la page d'accueil
        add_notif_modal("success", "Mot de passe mis à jour", "Votre mot de passe a été modifié avec succès");
        header('Location: ../view/pages-login');
    } else {
        add_notif_modal("danger", "Erreur", "Une erreur est survenue lors de la modification");
        header('Location: ../view/change-password.php');
    }
}

// Méthode pour changer l'email / prenom ou le nom
if (isset($_POST['change_email']) && isset($_POST['change_prenom']) && isset($_POST['change_nom']) && UserConnected()) {
    $email = htmlspecialchars($_POST['change_email']);
    $prenom = htmlspecialchars($_POST['change_prenom']);
    $nom = htmlspecialchars($_POST['change_nom']);

    if (update_user($email, $prenom, $nom, $_SESSION['EMAIL'])) {
        $_SESSION['EMAIL'] = $email;
        $_SESSION['PRENOM'] = $prenom;
        $_SESSION['NOM'] = $nom;
        add_notif_modal("success", "Modification effectuée", "Vos informations ont été modifiées avec succès");
        header('Location: ../view/users-profile.php');
    } else {
        add_notif_modal("danger", "Erreur", "Une erreur est survenue lors de la modification");
        header('Location: ../view/users-profile.php');
    }
}