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

<head>
    <meta charset="UTF-8">
    <title>Matières</title>
</head>

<body>
    <main id="main" class="main container">
        <div style="display: inline-table">
            <form action="" method="post" class="form-control">
                <h4>Ajouter une nouvelle matière : </h4><br>
                Matière : <input type="text" name="matieres" required />
                <input type="submit" value="Ajouter" name="saisie_mat" />
            </form>
        </div>
        &emsp;&emsp;

        <div style="display: inline-table">
            <table>
                <tr>
                    <th colspan="10">Matières</th>
                </tr>
                <?php
                foreach ($matiere as $m) {
                    echo '<tr>';
                    echo '<td>' . $m['LibMatiere'] . '</td>';
                    echo '<td><a href=../Controller/C_modif.php?codemat=' . $m['CodeMatiere'] . '>Modifier <img src="../bootstrap-icons-1.8.3/pencil.svg" height="14" width="15"/></a></td>';
                    echo '<td><a href=../Controller/Supprime.php?codemat=' . $m['CodeMatiere'] . ' ' . 'onclick="return confirmation();"' . '>Supprimer <img src="../bootstrap-icons-1.8.3/trash.svg" height="14" width="25"/></a></td>';
                }
                ?>
                </tr>
            </table>
        </div>
    </main>
</body>

</html>