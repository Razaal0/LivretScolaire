<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
    exit();
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Enseignants</em></h1>
    </div>
    <section class="section">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ajouter un nouveau professeur :</h5>
                <!-- Formulaire pour ajouter un professeur -->
                <form class="row g-3" method="POST">

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="prenom" id="prenom" value="" placeholder=" " required>
                            <label for="prenom" class="form-label">Prénom</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="nom" id="nom" value="" placeholder=" " required>
                            <label for="nom" class="form-label">Nom</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary"value="Ajouter" name="saisie_pr" type="submit">Ajouter</button>
                    </div>
                </form>
                <!-- End Formulaire pour ajouter un professeur -->

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listes des professeurs :</h5>
                        
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($enseignant as $e) {
                                ?>
                                    <tr data-toggle="collapse">
                                        <td><?php echo $e['NOM']; ?></td>
                                        <td><?php echo $e['PRENOM']; ?></td>
                                        <td><?php echo "<a href=../Controller/C_modif.php?codeens=" . $e['CodeEnseignant'] . ">" ?>Modifier <img src="../bootstrap-icons-1.8.3/pencil.svg" height="14" width="25" /></a> </td>
                                        <td><?php echo "<a href=../Controller/Supprime.php?codeens=" . $e['CodeEnseignant'] . " " . "onclick='return confirmation();'" . ">" ?> Supprimer <img src="../bootstrap-icons-1.8.3/trash.svg" height="14" width="25" /></a> </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</main><!-- End #main -->
<?php
?>

<script>
    $(document).ready(function() {
        $('table.datatable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    });
</script>