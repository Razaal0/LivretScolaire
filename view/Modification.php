<main id="main" class="">
    <section class="section d-flex justify-content-center">
        <div class="card col-lg-6">
            <div class="card-body">
                <?php
                // Formulaire pour Modifier un enseignant
                if ($codeens) {
                    $enseignant = recupere_enseignants_by_id($codeens);
                ?>
                    <h5 class="card-title align-center d-flex justify-content-center">Modifier un Professeur</h5>
                    <!-- Formulaire pour Modifier un Professeur -->
                    <form class="row g-3 d-flex justify-content-center" method="POST">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" name="nomens" id="nomens" value="<?php echo $enseignant["NOM"] ?>" placeholder=" " >
                                <label for="nometu" class="form-label">Prénom</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" name="prenomens" id="prenomens" value="<?php echo $enseignant["PRENOM"] ?>" placeholder=" " >
                                <label for="prenomens" class="form-label">Nom</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" name="saisie_en" type="submit">Modifier</button>
                        </div>
                    </form>
                    <!-- Fin Formulaire pour Modifier un Professeur -->
                <?php
                }


                // Formulaire pour Modifier un étudiant
                if ($codeetudiant) {
                    $classe = recupere_classes();
                    $etudiant = recupere_etudiants_by_id($codeetudiant);
                ?>
                    <h5 class="card-title align-center d-flex justify-content-center">Modifier un étudiant</h5>
                    <!-- Formulaire pour Modifier un Professeur -->
                    <form class="row g-3 d-flex justify-content-center" method="POST">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" name="nometu" id="nometu" value="<?php echo $etudiant["NOMETUDIANT"] ?>" placeholder=" " >
                                <label for="nomens" class="form-label">Nom</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control w-100" name="prenometu" id="prenometu" value="<?php echo $etudiant["PRENOMETUDIANT"] ?>" placeholder=" " >
                                <label for="prenometu" class="form-label">Prénom</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="date" class="form-control w-100" name="date" id="date" value="<?php echo $etudiant["datedenaissance"] ?>" >
                                <label for="date" class="form-label">Date de naissance</label>
                            </div>
                        </div>

                        <div class="col-md-2 w-25">
                            <div class="form-floating">
                                <select class="form-select" name="classe" id="classe" >
                                    <option value=""></option>
                                    <?php
                                    foreach ($classe as $c) {
                                        ?>
                                        <option value="<?php echo $c["classecode"];?>"<?php if ($c["classecode"] == $etudiant["classecode"]) {echo "selected";}?>><?php echo $c["Libellecourt"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="classe" class="form-label">Classe</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" name="saisie_et" type="submit">Modifier</button>
                        </div>
                    </form>
                    <!-- Fin Formulaire pour Modifier un Professeur -->
                <?php
                }

                // Formulaire pour Modifier une matière
                if ($codemat) {
                    $matiere = recupere_matieres_by_id($codemat);
                ?>
                    <h5 class="card-title align-center d-flex justify-content-center">Modifier une matière</h5>
                    <!-- Formulaire pour Modifier un Professeur -->
                    <form class="row g-3 d-flex justify-content-center" method="POST">

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="matiere" id="matiere" value="<?php echo $matiere["LibMatiere"] ?>" placeholder=" " >
                                <label for="matiere" for="matiere" class="form-label">Matière</label>
                            </div>
                        </div>
                        <!-- right -->
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-primary" name="saisie_ma" type="submit">Modifier</button>
                        </div>
                    </form>
                    <!-- Fin Formulaire pour Modifier un étudiant -->
                <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>


<style>
    input[type=date],
    textarea {
        display: block;
        padding: 5px;
        margin-bottom: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
        text-align: center;
    }

    input[type=date],
    input[type=text] {
        width: 200px;
    }
</style>