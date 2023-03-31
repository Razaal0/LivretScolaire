<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
    exit();
}


require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');

$cla = filter_var(htmlspecialchars($_GET['classe']));
$etudiant = filter_var(htmlspecialchars($_GET['codeetud']));
$asso = asso_cl_et_un_etudiant($cla, $etudiant);
$noteetudiant = recupere_notes($etudiant);
echo "<script>classe = " . json_encode($noteetudiant) . "</script>";
$matiere = recupere_enseigner($cla);

?>

<?php
if (isset($_POST["donnee"])) {
    $donnee = $_POST["donnee"];
    foreach ($donnee as $idMatiere => $note) {
      $sem1 = $note['semestre1'];
      $sem2  = $note['semestre2'];
      $sem3 = $note['semestre3'];
      $sem4  = $note['semestre4'];
      $app = $note['appreciation'];
      $codeetudiant = $_POST["codeetudiant"];
      $codematiere = $idMatiere;
      $codeclasse = $_POST["codeclasse"];
      
      
      note_saisie($sem1, $sem2, $sem3, $sem4, $app, $codeetudiant, $codematiere, $codeclasse);
    }
    add_notif_modal("success", "Modifications Sauvegardés.", "Vos modifications ont été enregistrées avec succès !");
    
    $noteetudiant = recupere_notes($etudiant);
    echo "<script>classe = " . json_encode($noteetudiant) . "</script>";
}
require_once '../view/Note.php';

require_once '../view/includes/footer.php';

//ajout des notes et appreciations dans la bdd



//if (isset($_POST['code']) && isset($_POST['code'])

?>
