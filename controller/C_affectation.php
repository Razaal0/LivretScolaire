<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';

// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}

$enseignant = recupere_enseignants();
// On envoie les données en JSON pour pouvoir les récupérer dans le JS
echo "<script>enseignant = " . json_encode($enseignant) . "</script>";
$classe = recupere_classes();
// On envoie les données en JSON pour pouvoir les récupérer dans le JS
echo "<script>classe = " . json_encode($classe) . "</script>";

// Quand on choisi un enseignant :
if (isset($_POST['code_enseignant'])) {
    $enseignant_classe = recupere_classe_enseignant(htmlspecialchars($_POST['code_enseignant']));
    // On envoie les données en JSON pour pouvoir les récupérer dans le JS
    echo "<script>enseignant_classe = ". json_encode($enseignant_classe) .";</script>";
}

require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
require_once('../view/Affectation.php');





if (verif_submit('sub') == 'Valider') {
    $error = 0;

    // On vérifie que la classe existe et qu'elle n'est pas vide
    // Si il y a "Classe : " dans la variable classe, sa veux dire qu'il n'a pas choisi de classe à affecter
    if (!isset($_POST['class']) || empty($_POST['class']) || in_array('Classe :', $_POST['class'])) {
    ?>
        <script>
            document.querySelector('#test_error').innerHTML += '<span>Veuillez choisir une classe</span>';
        </script>
    <?php
        $error = 1;
    }

    // On vérifie que la classe existe et qu'elle n'est pas vide
    if (!isset($_POST['liste']) || empty($_POST['liste'])) {
    ?>
        <script>
            document.querySelector('#test_error').innerHTML += '<span>Veuillez choisir un enseignant</span>';
        </script>
        <?php
        $error = 1;
    }


    // Fonction pour vérifier que la matière existe et qu'elle n'est pas vide
    function verif_matiere($class_count)
    {
        if (!isset($_POST['matiere' . $class_count]) || empty($_POST['matiere' . $class_count])) {
        ?>
            <script>
                document.querySelector('#test_error').innerHTML += '<span>Veuillez choisir au moins une matière pour chaque classe(s)</span>';
            </script>
            <?php
            return 1;
        } else {
            return 0;
        }
    }


    // On vérifie toutes les données envoyé. Si aucune erreur n'est détecté, on envoie les données dans la base de données
    function verif_donnes($error, $partie)
    {
        if ($error == 0) {
            // On récupère les données envoyé
            $enseignant_insert = htmlspecialchars($_POST['liste']);
            $classe__insert = $_POST['class'];
            // Le class_count
            $class_count = 0;
            foreach ($classe__insert as $cl) {
                $error += verif_matiere($class_count);
                if ($error == 0) {
                    $verif_classe = htmlspecialchars($cl);
                    $matiere_insert = $_POST['matiere' . $class_count];
                    $class_count++;
                    if (isset($matiere_insert) && !empty($matiere_insert)) {
                        foreach ($matiere_insert as $mat) {
                            $verif_matiere = htmlspecialchars($mat);
                            if ($partie == "insertion") {
                                if (!empty(verif_enseigner_existe($verif_classe, $verif_matiere, $enseignant_insert))) {
            ?>
                                    <script>
                                        document.querySelector('#test_error').innerHTML += '<span> affection du professeur <?php echo $enseignant_insert; ?> à la classe <?php echo $verif_classe; ?> pour la matière <?php echo $verif_matiere; ?> existe déjà </span>';
                                        // Couleur du texte en rouge seulement pour cette ligne
                                        document.querySelector('#test_error').style.color = 'red';
                                    </script>
                                <?php
                                } else {
                                    insert_enseigner($verif_classe, $verif_matiere, $enseignant_insert);
                                ?>
                                    <script>
                                        document.querySelector('#test_error').innerHTML += '<span> affection du professeur <?php echo $enseignant_insert; ?> à la classe <?php echo $verif_classe; ?> pour la matière <?php echo $verif_matiere; ?> a été effectué </span>';
                                        // couleur du texte en vert seulement pour cette ligne
                                        document.querySelector('#test_error').lastChild.style.color = 'green';
                                    </script>
        <?php
                                }
                            }
                        }
                    } else {
                        return 1;
                    }
                } else {
                    return 1;
                }
            }
        } else {
            return 1;
        }
        return 0;
    }

    $error = verif_donnes($error, "verification");
    if ($error == 0) {
        verif_donnes($error, "insertion");
    }

    if ($error != 0) {
        ?><script>
            document.querySelector('#test_error').classList.add('error');
            document.querySelector('#test_error').innerHTML += "<span>Erreur lors de l'insertion des données</span>";
        </script><?php
                } else {
                    ?><script>
            document.querySelector('#test_error').classList.add('success');
        </script><?php
                }
            }
            require_once '../view/includes/footer.php';
