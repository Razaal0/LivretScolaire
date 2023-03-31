<?php
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
require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1></h1>
    </div>
    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Importer les élèves</h5>
                        <form method="POST" action="<?php echo $path?>/controller/import_traitement.php" enctype="multipart/form-data" style="display: inline-table">
                <h3>Importation des élèves format csv : </h3>
                <h6>(NOM | PRENOM | SEXE | NE(E) LE | DIV. | REG. | OPT1 | OPT2 | DIV.PREC.)</h6>
                <input type="file" name="import" id="import" accept=".csv" required>
                <input type="submit" name='Importer' value="Ajouter">
            </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main><!-- End #main -->


<?php
require_once '../view/includes/footer.php';
