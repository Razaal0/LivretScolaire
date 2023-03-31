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
        <h1>Étudiants</em></h1>
    </div>
    <section class="section">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ajouter un nouveau étudiant :</h5>
                <!-- Formulaire pour ajouter un étudiant -->
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

                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="date_naissance" id="date_naissance" value="" placeholder=" " required>
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating">
                            <select class="form-select" name="classe" id="classe" required>
                                <option value=""></option>
                                <?php
                                foreach ($classe as $c) {
                                    echo "\t" . '<option value=' . $c['classecode'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
                                }
                                ?>
                            </select>
                            <label for="classe" class="form-label">Classe</label>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-floating">
                            <input type="number" class="form-control" name="numero_national" id="numero_national" placeholder=" ">
                            <label for="numero_national" class="form-label">Numéro National</label>
                        </div>
                    </div>


                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Ajouter</button>
                    </div>
                </form>
                <!-- End Formulaire pour ajouter un étudiant -->

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listes des étudiants :</h5>
                        
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Date de naissance</th>
                                    <th scope="col">Classe</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($etudiant as $et) {
                                ?>
                                    <tr data-toggle="collapse">
                                        <td><?php echo $et['NOMETUDIANT']; ?></td>
                                        <td><?php echo $et['PRENOMETUDIANT']; ?></td>
                                        <td><?php echo $et['datedenaissance']; ?></td>
                                        <td><?php echo $et['Libellecourt']; ?></td>
                                        <td><?php echo "<a href=../Controller/C_modif.php?codeetud=" . $et['codeetudiant'] . ">" ?>Modifier <img src="../bootstrap-icons-1.8.3/pencil.svg" height="14" width="25" /></a> </td>
                                        <td><?php echo "<a href=../Controller/Supprime.php?codeetud=" . $et['codeetudiant'] . " " . "onclick='return confirmation();'" . ">" ?> Supprimer <img src="../bootstrap-icons-1.8.3/trash.svg" height="14" width="25" /></a> </td>
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