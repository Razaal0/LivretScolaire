<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
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
                <h5 class="card-title">Saisie des notes et des appréciations</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nom et Prénom de l'étudiant</h5>
                <p> <?php foreach ($asso as $et) {
                    echo $et ['NOMETUDIANT'].' '.$et['PRENOMETUDIANT']; } ?> </p>
                <form class="row g-3 needs-validation" action="#"  method="POST" novalidate>
                    <table class="table" style="text-align: center" id="tableau-notes">
                        <thead>
                            <tr>
                                <th scope="col">Matières</th>
                                <th scope="col" colspan="4"> Notes </th>
                                <th scope="col">Appréciations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th></th>
                                <th scope="col"> Semestre 1 </th>
                                <th scope="col"> Semestre 2 </th>
                                <th scope="col"> Semestre 3 </th>
                                <th scope="col"> Semestre 4 </th>
                                <th></th>
                            </tr>
                                 <div name="donnee">
                                    <?php
                                    $classcode;
                                    foreach ($matiere as $m) {
                                        $classcode = $m['classecode'];
                                        ?>
                                <tr data-id-mat="<?= $m['CodeMatiere']?>">
                                    <td class="w-25"><?php echo $m['LibMatiere'] ?> </td>
                                    <td><input placeholder="Note Semestre 1" name="donnee[<?php echo $m['CodeMatiere'] ?>][semestre1]" data="sem1" type="number" max="20" min="0" value=""/></td>
                                    <td><input placeholder="Note Semestre 2" name="donnee[<?php echo $m['CodeMatiere'] ?>][semestre2]" data="sem2" type="number" max="20" min="0" /></td>
                                    <td><input placeholder="Note Semestre 3" name="donnee[<?php echo $m['CodeMatiere'] ?>][semestre3]" data="sem3" type="number" max="20" min="0" value=""/></td>
                                    <td><input placeholder="Note Semestre 4" name="donnee[<?php echo $m['CodeMatiere'] ?>][semestre4]" data="sem4" type="number" max="20" min="0" /></td>
                                    <td><input placeholder="Appréciation"  name="donnee[<?php echo $m['CodeMatiere'] ?>][appreciation]" data="app" class="w-100"/></td>
                                </tr>
                                <?php
                            }
                            ?>
                                <input type="hidden" placeholder="Appréciation"  name="codeetudiant" class="w-100" value="<?= $et["codeetudiant"];?>"/>
                                <input type="hidden" placeholder="Appréciation"  name="codeclasse" class="w-100" value="<?php echo $classcode ?>"/>
                             </div>
                        </tbody>
                    </table>
                                <!-- End Active Table -->
                <button class="btn btn-primary w-25" name="saisie_n" value="valider" type="submit"> Enregistrer </button>
                </form>
            </div>
        </div>

    </section>
</main><!-- End #main -->

<script>
// obtenir la référence du tableau HTML
const tableau = document.querySelector("#tableau-notes");

// boucler sur chaque objet de la liste 'classe'
classe.forEach((m) => {
  // obtenir la référence de la ligne correspondante dans le tableau HTML
  const ligne = tableau.querySelector(`[data-id-mat="${m.CodeMatiere}"]`);

  // si la ligne existe, remplir les champs avec les données de l'objet
  if (ligne) {
    ligne.querySelector('[name$="[semestre1]"]').value = m.Semestre1;
    ligne.querySelector('[name$="[semestre2]"]').value = m.Semestre2;
    ligne.querySelector('[name$="[semestre3]"]').value = m.Semestre3;
    ligne.querySelector('[name$="[semestre4]"]').value = m.Semestre4;
    ligne.querySelector('[name$="[appreciation]"]').value = m.Appreciation;
  }
});

</script>