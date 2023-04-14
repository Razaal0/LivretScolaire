<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=" . $path . "/view' />";
    exit();
}
?>
<html>

<body>
    <title>Classes</title>
    <main id="main" class="">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Liste des classes :</h5>
                <form name="classe" action="" method="post">
                    <select name="clas[]" onChange="this.form.submit()" required>
                        <option value="">Classe :</option>
                        <?php
                        foreach ($classe as $c) {
                            echo "\t" . '<option value=' . $c['classecode'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
                        }
                        ?>
                        <?php
                        $valeur = verif_saisi('clas');
                        $etud = asso_cl_et($valeur);
                        ?>
                    </select>
                </form>

                <?php if ($valeur) { ?>
                    <div class="row mt-5">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Listes des étudiants :</h5>

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
                                            foreach ($etud as $et) {
                                            ?>
                                                <tr data-toggle="collapse">
                                                    <td><?php echo $et['NOMETUDIANT']; ?></td>
                                                    <td><?php echo $et['PRENOMETUDIANT']; ?></td>
                                                    <td><?php echo '<a href="' . $path . '/controller/C_note.php?codeetud=' . $et['codeetudiant'] . '&classe=' . $valeur . '">' ?>Saisir Notes <img src="../bootstrap-icons-1.8.3/pencil-square.svg" height="14" width="25" /></a> </td>
                                                    <td><?php echo '<a href="' . $path . '/modele/Test.php?codeetud=' . $et['codeetudiant'] . '&classe=' . $valeur . '">' ?>Editer <img src="../bootstrap-icons-1.8.3/file-earmark-pdf.svg" height="14" width="25" /></a> </td>
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
                <?php } ?>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    $(document).ready(function() {
        $('table.datatable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
            }
        });
    });
</script>