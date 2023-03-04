<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
require_once('../modele/BDD.php');
require_once 'includes/user-session.php';
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Affectation d'enseignants et de matières à une classe</em></h1>
    </div>
    <section class="section">

        <div class="row">
            <div class="col-lg-10">
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
                                <div class="card col">
                                    <div class="card-body">
                                        <h5 class="card-title">Classes de l'enseignant</h5>
                                        <table class="table">
                                            <thead>
                                                <tr class="table-light">
                                                    <th scope="col">Classe</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="classe_prof">
                                                <tr>
                                                    <script>
                                                        // afficher les classe de l'enseignant avec en plus un bouton editer et supprimer
                                                        enseignant_classe.forEach(element => {
                                                            document.querySelector('#classe_prof').innerHTML += '<tr id="' + element.classecode + '"><td>' + classe[element.classecode - 1].Libellecourt + '</td><td><a href="/controller/C_affectation_add_mod.php?type=edit&code_prof=' + <?php echo $_POST['code_enseignant']; ?> + '&code_classe=' + element.classecode + '"class="btn btn-primary">Editer</a></td><td><a onClick="Delete_Association_Prof_Classe(' + element.CodeEnseignant + ',' + element.classecode + ',\'' + classe[element.classecode - 1].Libellecourt + '\')" class="btn btn-danger">Supprimer</a></td></tr>';
                                                        });
                                                    </script>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Table Variants -->

                                    </div>
                                </div>
                                <!-- margin left 3 -->
                                <div class="card col" style="margin-left: 3rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">Autres classes</h5>
                                        <table class="table">
                                            <thead>
                                                <tr class="table-light">
                                                    <th scope="col">Classe</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="classe_pas_au_prof">
                                                <tr>
                                                    <script>
                                                        // afficher les classe qui n'ont pas assigné à l'enseignant
                                                        classe.forEach(element => {
                                                            // parcourir le tableau enseignant_classe et vérifier que element.CodeClasse n'est pas dedans
                                                            var classe_deja_affecte = false;
                                                            enseignant_classe.forEach(element2 => {
                                                                if (element.classecode == element2.classecode) {
                                                                    classe_deja_affecte = true;
                                                                }
                                                            });
                                                            if (!classe_deja_affecte) {
                                                                document.querySelector('#classe_pas_au_prof').innerHTML += '<tr><td>' + element.Libellecourt + '</td><td><a href="/controller/C_affectation_add_mod.php?type=add&code_prof=' + <?php echo $_POST['code_enseignant']; ?> + '&code_classe=' + element.classecode + '" class="btn btn-primary">Ajouter</a></td></tr>';
                                                            }
                                                        });
                                                    </script>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Table Variants -->

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
    // quand la valeur du select enseignant change on fait le submit
    document.querySelector('#enseignant').addEventListener('change', function() {
        document.querySelector('#enseignant').form.submit();
    });

    // Supprimer une affectation d'enseignant à une classe
    function Delete_Association_Prof_Classe(prof, Code_classe, nom_classe) {
        $.ajax({
            url: 'Supprime.php',
            method: 'POST',
            data: {
                code_enseignant: prof,
                code_classe: Code_classe
            },

            success: function(response) {
                console.log("compare " + response + " et success = " + (response == 'success'));
                // afficher le type de la variable 
                if (response.trim() == 'success') {
                    // supprimer la ligne du tableau*
                    $('#classe_prof #' + Code_classe).remove();
                    // ajouter la ligne dans le tableau des classes non affectées
                    $('#classe_pas_au_prof').append('<tr><td>' + nom_classe + '</td><td><a href="/controller/C_affectation_add_mod.php?type=add&code_prof=' + prof + '&code_classe=' + Code_classe + '" class="btn btn-primary">Ajouter</a></td></tr>');
                } else {
                    // faire une autre action si la réponse n'est pas "success"
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>