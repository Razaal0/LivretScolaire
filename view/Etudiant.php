<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
?>
    <script>
        window.location.replace("/view");
    </script>
    <?php
    exit();
}


?>
    <html>

    <body>
        <title>Etudiants</title>
        <main id="main" class="main container">
            <div style="display: inline-table; margin-right: 30px">
                <form method="post" class="form-control">
                    <h4>Ajouter un(e) étudiant:</h4><br />
                    <label>Nom :</label>
                    <input type="text" name="nom" required />
                    <label>Prenom :</label>
                    <input type="text" name="prenom" required />
                    <label>Date de naissance :</label>
                    <input type="date" name="date_naissance" required />
                    <label>Numéro National</label>
                    <input type="text" name="numero_national" />
                    <select name="classe" required>
                        <option value="">Classe :</option>
                        <?php
                        foreach ($classe as $c) {
                            echo "\t" . '<option value=' . $c['classecode'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Ajouter" name="saisie_pr" />
                </form>
                <span id="ajouter&supprimer" class="ajouter_supprimer">
                    <?php
                    if (isset($_GET['message'])) {
                        if ($_GET['error'] == 0) {
                            echo '<div class="alert alert-success" role="alert">' . $_GET['message'] . '</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">' . $_GET['message'] . '</div>';
                        }
                    }
                    ?>
                </span>
            </div>
            <div style="display: inline-table">
                <h2> Liste des étudiants </h2>
                <table border="1">
                    <tr>
                        <th colspan="6">Etudiants</th>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Classe</th>
                        <th colspan="2"></th>
                    </tr>
                    <?php
                    foreach ($etudiant as $et) {
                    ?>
                        <tr>
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
                </table>
            </div>
        </main>
    </body>

    </html>

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