<?php
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
?>
    <script>
        window.location.replace("/view");
    </script>
    <?php
    exit();
}


require_once('../modele/BDD.php');
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');

$cla = filter_var(htmlspecialchars($_GET['classe']));
$etud = asso_cl_et($cla);
$matiere = recupere_enseigner($cla);
print_r($matiere);
exit();
require_once '../view/Note.php';
?>

<!--A résoudre : Ne fonctionne seulement si on coche à partir de la première matière jusqu'à celle souhaitée -->
<?php

if (verif_submit('saisie_n') == 'Valider') {
    for ($i = 0; $i < count($nb_matiere); $i++) {
        $sem1 = filtrer_character('S1,'.$nb_matiere[$i]);
        $sem2 = filtrer_character('S2,'.$nb_matiere[$i]);
        $checkmat = verif_matiere_note('matiere,'.$nb_matiere[$i]);
        $appreciation = filtrer_character('appreciations,'.$nb_matiere[$i]);
        for ($j = 0; $j < count($sem1); $j++) {
            echo $checkmat[$j] . ' ';
            echo $sem1[$j] . ' ';
            echo $sem2[$j] . ' ';
            echo $appreciation[$j] . '<br>';
            note_saisie($sem1[$i], $sem2[$i], $appreciation[$i], $codeetudiant, $checkmat[$i], $cla);
        }
    }
}
require_once '../view/includes/footer.php';
?>
