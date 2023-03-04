<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}

// Vérification que les variables sont bien définies
if (isset($_GET['code_prof']) & isset($_GET['code_classe']) & isset($_GET['type'])) {
    $code_prof = htmlspecialchars($_GET['code_prof']);
    $code_classe = htmlspecialchars($_GET['code_classe']);
    $type = htmlspecialchars($_GET['type']);

    // on met une variable de session pour pouvoir afficher automatiquement le dernier enseignant sélectionné dans la  vue C_affectation.php
    $_SESSION['C_affectation_code_enseignant'] = $code_prof;

    $classe = recupere_classes();
    $matiere_classe = recupere_matieres_by_classe($code_classe);

    $enseignant_classe = recupere_classe_enseignant(htmlspecialchars($_GET['code_prof']));
    // On envoie les données en JSON pour pouvoir les récupérer dans le JS
    echo "<script>enseignant_classe = " . json_encode($enseignant_classe) . ";</script>";

    // rechercher le nom de la classe dans recupere_classes()
    $nom_classe = "";
    foreach ($classe as $key => $value) {
        if ($value['classecode'] == $code_classe) {
            $nom_classe = $value['Libellecourt'];
        }
    }

    // récupérer le nom de l'enseignant
    $nom_prof = recupere_enseignants_by_id($code_prof);
    $nom_prof = $nom_prof["PRENOM"] . " " . $nom_prof["NOM"];
}

if (isset($_POST['form_prof']) & isset($_POST['form_classe']) & isset($_POST['form_type'])) {
    $code_prof = htmlspecialchars($_POST['form_prof']);
    $code_classe = htmlspecialchars($_POST['form_classe']);
    $type = htmlspecialchars($_POST['form_type']);

    // on parcours les matières
    foreach ($matiere_classe as $key => $value) {
        // vérifier si aucune matière n'est cochée
        if (!isset($_POST['matiere'])) {
            // si oui, on supprime toutes les affectations de l'enseignant pour cette classe
            // demande de confirmation avant de supprimer en JS
            ?>
            <script>
                if (confirm("Voulez-vous vraiment supprimer toutes les affectations de l'enseignant : <?php echo $nom_prof; ?> pour la classe : <?php echo $nom_classe; ?> ?")) {
                    <?php
                    supprimer_affectation_enseignant_classe($code_classe, $code_prof);
                    ?>
                    window.location.href = "/controller/C_affectation.php";
                } else {
                    window.location.href = "/controller/C_affectation.php";
                }
            </script>
            <?php
            exit();
        }

        $matiere = $_POST['matiere'];
        // on vérifie si la matière est dans la liste des matières envoyées
        if (in_array($value['CodeMatiere'], $matiere)) {
            // si oui, on vérifie si l'affectation existe déjà
            if (!verif_existe_affectation_enseignant_classe_matiere($code_classe, $value['CodeMatiere'], $code_prof)) {
                // si non, on l'ajoute
                insert_enseigner($code_classe, $value['CodeMatiere'], $code_prof);
            }
        } else {
            // vérifie si l'affectation existe déjà
            if (verif_existe_affectation_enseignant_classe_matiere($code_classe, $value['CodeMatiere'], $code_prof)) {
                // si oui, on la supprime
                supprimer_affecation_enseignant_classe_matiere($code_classe, $value['CodeMatiere'], $code_prof);
            }
        }
    }

    // On redirige vers la page de gestion des affectations
    echo '<meta http-equiv="refresh" content="0; url=/controller/C_affectation.php" />';
    exit();
}


require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
require_once('../view/Affectation_add_mod.php');
require_once '../view/includes/footer.php';