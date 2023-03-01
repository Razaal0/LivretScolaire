<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>
<main id="main" class="">
    <form method="post">
        <table border="1">
            <?php
            foreach ($etud as $et) {
            ?>
                <tr>
                    <td><?php echo 'Classe: ' . $cla ?></td>
                    <td colspan="2"><?php echo $et['NOMETUDIANT'] . ' ' . $et['PRENOMETUDIANT'] ?></td>
                    <th colspan="3"></th>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="2">Notes</th>
                <th>Matières</th>
                <th>Appréciations</th>

            </tr>
            <tr>
                <td>Semestre 1</td>
                <td>Semestre 2</td>
                <th colspan="3"></th>
            </tr>
            <?php
            $compteur = 0;
            foreach ($matiere as $m) {
            ?>
                <tr>
                    <td><input type="number" step="0.001" min="0" max="20" name="S1,<?php echo $compteur ?>[]" /></td>
                    <td><input type="number" step="0.001" min="0" max="20" name="S2,<?php echo $compteur ?>[]" /></td>
                    <td><?php echo $m['LibMatiere'] ?></td>
                    <td><textarea rows="2" cols="40" name="appreciations,<?php echo $compteur ?>[]" maxlength="1000"></textarea></td>
                </tr>
            <?php
                $compteur++;
            }
            ?>
        </table>
        <input type="submit" value="Valider" name="saisie_n" id="submit" />
    </form>
</main>