<html>

<body>
    <main id="main" class="main container">
        <h2>Modification</h2>
        <?php
        if ($codemat) {
        ?>
            <form method="post" class="form-control">
                Nouvelle matière : <input type="text" name="matiere" required />
                <input type="submit" value="Valider" name="saisie_ma" id="submit" />
            </form>
        <?php
        }
        ?>

        <?php
        if ($codeens) {
        ?>
            <form method="post" class="form-control">
                Nouveau nom enseignant : <input type="text" name="nomens" /><br>
                Nouveau prenom enseignant : <input type="text" name="prenomens" /><br>
                <input type="submit" value="Valider" name="saisie_en" id="submit" />
            </form>
        <?php
        }
        ?>

        <?php
        if ($codeetudiant) {
            $classe = recupere_classes();
        ?>
            <form method="post" class="form-control">
                Nouveau nom etudiant: <input type="text" name="nometu" />
                Nouveau prenom etudiant : <input type="text" name="prenometu" />
                Nouvelle date de naissance : <input type="date" name="date" />
                <select name="classe" required>
                    <option value="">Classe :</option>
                    <?php
                    foreach ($classe as $c) {
                        echo "\t" . '<option value=' . $c['Libellecourt'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
                    }
                    ?>
                </select>
                <input type="submit" value="Valider" name="saisie_et" id="submit" />
            </form>
        <?php
        }
        ?>
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