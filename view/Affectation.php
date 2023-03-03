<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>
<script>
    // On récupère les enseignants et on les stock dans une variable
    enseignant = <?php echo json_encode(recupere_enseignants()); ?>;
    // On récupère les matières et on les stock dans une variable
    classe = <?php echo json_encode(recupere_classes()); ?>;
</script>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Affectation d'enseignants et de matières à une classe</em></h1>
    </div>
    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>

                        <!-- choisir un enseignant -->
                        <div class="col-lg-3">
                            <form action="#" method="POST">
                                <div class="form-floating">
                                    <select class="form-select" name="code_enseignant" id="enseignant" required="">
                                        <option value="" disabled selected>Choisir un enseignant</option>
                                        <script>
                                            // On affiche les enseignants dans le select
                                            enseignant.forEach(element => {
                                                document.querySelector('#enseignant').innerHTML += '<option value="' + element.CodeEnseignant + '">' + element.NOM + ' ' + element.PRENOM + '</option>';
                                            });
                                        </script>
                                    </select>
                                    <label for="enseignant">Enseignant</label>
                                </div>
                            </form>
                        </div>

                        <!-- Afficher les classe de l'enseignant -->
                        <?php if (isset($_POST['code_enseignant'])) {
                        ?>
                            <script>
                                // mettre le selected sur l'enseignant dans le select
                                document.querySelector('#enseignant [value="<?php echo $_POST['code_enseignant']; ?>"]').setAttribute('selected', 'selected');
                            </script>

                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Listes des classe de l'enseignant :</h5>
                                            <table class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Classe</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <script>
                                                        // [
                                                        //     {
                                                        //         "classecode": 1,
                                                        //         "CodeEnseignant": 46,
                                                        //         "CodeMatiere": 1
                                                        //     }
                                                        // ]
                                                        // format de enseignant_classe en js
                                                        // afficher les classe de l'enseignant
                                                        enseignant_classe.forEach(element => {
                                                                document.querySelector('tbody').innerHTML += '<tr><td>' + classe[element.classecode - 1].NOM + '</td><td><a href="/view/affectation/' + element.classecode + '" class="btn btn-primary">Voir</a></td></tr>';
                                                        });
                                                    </script>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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

    // quand la valeur du select enseignant change on fait le submit
    document.querySelector('#enseignant').addEventListener('change', function() {
        document.querySelector('#enseignant').form.submit();
    });
</script>