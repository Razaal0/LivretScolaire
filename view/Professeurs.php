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
require_once('includes/header.php');
require_once('includes/nav.php');
?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Enseignants</title>
    </head>

    <body>
        <main id="main" class="container">
            <div style="display: inline-table">
                <form method="post" class="form-control">
                    <h4>Ajouter un professeur :</h4><br />
                    Nom : <input type="text" name="nom" require />
                    Prenom : <input type="text" name="prenom" require />
                    <input type="submit" value="Ajouter" name="saisie_pr" />
                </form>
                <span id="ajouter&supprimer" class="ajouter_supprimer">
                    <p id="controller">
                    </p>
                </span>
            </div>
            &emsp;&emsp;

            <div style="display: inline-table">
                <table>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th colspan="2"></th>
                    <?php
                    echo 'Liste des enseignants : ' . '<br><br>';
                    foreach ($enseignant as $e) {
                    ?>
                        <tr>
                        <?php
                        echo '<td>' . $e['NOM'] . '</td>';
                        echo '<td>' . $e['PRENOM'] . '</td>';
                        echo '<td><a href=../Controller/C_modif.php?codeens=' . $e['CodeEnseignant'] . '>Modifier <img src="../bootstrap-icons-1.8.3/pencil.svg" height="14" width="25"/></a></td>';
                        echo '<td><a href=../Controller/Supprime.php?codeens=' . $e['CodeEnseignant'] . ' ' . 'onclick="return confirmation();"' . '>Supprimer <img src="../bootstrap-icons-1.8.3/trash.svg" height="14" width="25"/></a></td>';
                    }
                        ?>
                        </tr>
                </table>
            </div>
        </main>
    </body>

    </html>

    <style>
        .ajouter_supprimer {
            display: flex;
            justify-content: center;
            font-size: 17px;
        }
    </style>