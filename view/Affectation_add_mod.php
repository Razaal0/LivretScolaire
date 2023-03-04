<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>
<main id="main" class="main">
    <div class="pagetitle">
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <?php if ($type == 'add') { ?>
                            <h5 class="card-title">Ajouter les matières à la classe <?php echo $nom_classe; ?></h5>
                        <?php } else if ($type == 'edit') { ?>
                            <h5 class="card-title">Modifier les matières à la classe <?php echo $nom_classe; ?></h5>
                        <?php } ?>
                        <h5 class="card-title"></h5>

                        <form action="#" method="POST">
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <?php
                                    // afficher la liste des matière
                                    foreach ($matiere as $key => $value) {
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="matiere[]" value="<?php echo $value['CodeMatiere']; ?>" id="matiere<?php echo $value['CodeMatiere']; ?>" <label class="form-check-label" for="matiere<?php echo $value['CodeMatiere']; ?>">
                                            <?php echo $value['LibMatiere']; ?>
                                            </label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <input type="hidden" name="form_prof" value="<?php echo $code_prof; ?>">
                                            <input type="hidden" name="form_classe" value="<?php echo $code_classe; ?>">
                                            <input type="hidden" name="form_type" value="<?php echo $type; ?>">
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main><!-- End #main -->
<script>
    // mettre le checked sur les matières de la classe
    // enseignant_classe = "CodeEnseignant" => 0,
    //     "CodeMatiere" => [
    //    "1",
    //    "2"
    //],
    //     "classecode" => ""
    // );
    enseignant_classe.forEach(element => {
        if (element.classecode == "<?php echo $code_classe; ?>") {
            element.CodeMatiere.forEach(element2 => {
                // rechercher le code matière dans la liste des matières
                document.getElementById("matiere" + element2).checked = true;
            });
        }
    });
</script>