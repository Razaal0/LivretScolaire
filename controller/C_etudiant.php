<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}


?>
<?php
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
?>

<?php
//R�cup�re le nom et la classe de l'�tudiant et attribue les informations aux bonnes variables
$etudiant = recupere_etudiants();
$classe = recupere_classes();
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['classe'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date = htmlspecialchars($_POST['date_naissance']);
    $classes = htmlspecialchars($_POST['classe']);
    
    if (isset($_POST['numero_national'])){
    $numero_national = htmlspecialchars($_POST['numero_national']);
    } else {
        $numero_national = "";
    }
    //Ins�re dans la base de donn�es les infos renseign�es
    if ($nom && $prenom && $date && $classe) {
        try {
            insert_etudiant($nom, $prenom, $date, $classes, $numero_national);
            //Renvoie "Erreur" si une erreur d'insertion � eu lieu
            add_notif_modal("success", "Etudiant ajouté", "L'étudiant a bien été ajouté");
            $error = 0;
        } catch (Exception $e) {
            add_notif_modal("danger", "Erreur", "Erreur lors de l'insertion de l'étudiant : " . $nom . " " . $prenom . " dans la classe : " . $classes);
            $error = 1;
        }
    } else {
        add_notif_modal("danger", "Erreur", "Erreur lors de l'insertion de l'étudiant : " . $nom . " " . $prenom . " dans la classe : " . $classes);
        $error = 1;
    }
        echo '<meta http-equiv="refresh" content="0; url=/controller/C_etudiant.php" />';
        exit();
}
require_once '../view/Etudiant.php';
require_once '../view/includes/footer.php';