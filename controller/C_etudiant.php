<?php
// Inclusion des fichiers nécessaires, celui du fichier de la base et celui du fichier et le fichier session utilisateur
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
// Inclure les fichiers header.php et nav.php
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
?>

<?php
// Récupérer le nom et la classe de l'étudiant et attribuer les informations aux bonnes variables

//fonction qui récupère les étudiants depuis la base de données
$etudiant = recupere_etudiants(); 
//fonction qui récupère les classes depuis la base de données
$classe = recupere_classes(); 

// Vérifier si les informations requises pour l'ajout d'un étudiant ont été fournies via un formulaire
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['classe'])) {

    // Stocker les informations dans des variables
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $date = htmlspecialchars($_POST['date_naissance']);
    $classes = htmlspecialchars($_POST['classe']);

    // Vérifier si le numéro national a été fourni
    if (isset($_POST['numero_national'])){
        $numero_national = htmlspecialchars($_POST['numero_national']);
    } else {
        $numero_national = "";
    }

    // Inscrire dans la base de données les informations renseignées
    if ($nom && $prenom && $date && $classe) {
        try {
            insert_etudiant($nom, $prenom, $date, $classes, $numero_national); // fonction qui insère l'étudiant dans la base de données
            // Ajouter une notification de réussite
            add_notif_modal("success", "Etudiant ajouté", "L'étudiant a bien été ajouté");
            $error = 0; // Définir la variable d'erreur à 0
        } catch (Exception $e) {
            // Ajouter une notification d'erreur
            add_notif_modal("danger", "Erreur", "Erreur lors de l'insertion de l'étudiant : " . $nom . " " . $prenom . " dans la classe : " . $classes);
            $error = 1; // Définir la variable d'erreur à 1
        }
    } else {
        // Ajouter une notification d'erreur
        add_notif_modal("danger", "Erreur", "Erreur lors de l'insertion de l'étudiant : " . $nom . " " . $prenom . " dans la classe : " . $classes);
        $error = 1; // Définir la variable d'erreur à 1
    }
        echo "<meta http-equiv='refresh' content='0; url=".$path."/controller/C_etudiant.php' />";
        exit();
}

// Inclure les fichiers Etudiant.php et footer.php
require_once '../view/Etudiant.php';
require_once '../view/includes/footer.php';
