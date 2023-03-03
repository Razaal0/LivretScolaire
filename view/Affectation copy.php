<?php
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>
<html>

<body>
    <main id="main" class="main">
        <script>
            var class_count = 0;
        </script>
        <div id="texte">
            <h3>Affectation d'enseignants et de matières à une classe</h3>
            <div id="test_error">
            </div>
            <form action=" " method="post">
                <p>Liste des enseignants :</p>
                <select name="liste" required>
                    <option value="">Enseignants : </option>
                    <?php
                    foreach ($enseignant as $e) {
                        echo "\t" . '<option value=' . $e['CodeEnseignant'] . '>' . $e['NOM'] . " " . $e['PRENOM'] . '</option>' . "\n";
                    }
                    ?>
                </select>
                <button onclick="add_class()" style="margin-top:20px;padding:5px;">Ajouter une classe</button><br />
                <button onclick="remove_class()" style="margin-top:10px;margin-bottom:20px;padding:5px;">Supprimer la dernière classe</button><br />
                <div class="classe_group">

                </div>
                <input type="submit" value="Valider" name="sub" />
            </form>
        </div>
    </main>
</body>

</html>

<!-- JAVASCRIPT -->
<script>
    document.querySelector('[onclick="add_class()"]').click(); // Ajouter la première classe au chargement de la page

    function add_class() {
        event.preventDefault(); // Empêcher le rechargement de la page
        nombre_classe_affiche = document.querySelectorAll('.classe').length; // Nombre de classe affichées
        nombre_classe_total = <?php echo count($classe); ?>; // Nombre de classe total
        // ne pas pouvoir ajouter plus de classe que le nombre de classe total
        if (nombre_classe_affiche < nombre_classe_total) {
            class_group = document.querySelector('.classe_group');
            classe = document.createElement('div');
            classe.classList.add('classe');
            classe.id = class_count;
            classe.innerHTML = `
        <select name="class[]" required>
            <option>Classe :</option>
            <?php
            foreach ($classe as $c) {
                echo "\t" . '<option value=' . $c['classecode'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
            }
            ?>
        </select>
        <?php
        echo '<br>Cochez la/les matières suivantes : <br>';
        foreach ($matiere as $m) {
        ?>
            <input type='checkbox' name='matiere` + class_count + `[]' value='<?php echo $m['CodeMatiere'] ?>'></input> &nbsp<?php echo $m['LibMatiere'] ?> <br>
            <?php
        }
        echo '<br>';
            ?>
        `;
            class_group.appendChild(classe);
            class_count++;
            check_selected_classe();
        }
    }

    function remove_class() {
        event.preventDefault();
        // ne pas supprimer la première classe
        if (class_count > 1) {
            class_group = document.querySelector('.classe_group');
            class_group.removeChild(class_group.lastChild);
            class_count--;
        }
        check_selected_classe();
    }
    // ajout d'un event listener sur les classe choisie
    // ajouter ou supprimer les option sélectionnées dans le tableau option_selected
    // grisé les option déjà sélectionnées
    // Quand on clique sur ajouter une classe, sa lance la fonction check_selected_classe()
    document.addEventListener('change', function(event) {
        check_selected_classe();
    });

    function check_selected_classe() {
        selected = document.querySelectorAll('select[name="class[]"] option:checked');
        // si le contenu de selected est Class : alors on ne fait rien
        option_selected = [];
        for (let i = 0; i < selected.length; i++) {
            if (selected[i].value != "Classe :") {
                option_selected.push(selected[i].value);
            }
        }
        // pour chaque option, vérifier si son value est dans le tableau option_selected
        // si oui, grisé l'option
        // si non, laisser l'option normale
        options = document.querySelectorAll('select[name="class[]"] option');
        for (let i = 0; i < options.length; i++) {
            if (option_selected.includes(options[i].value)) {
                options[i].style.color = 'red';
                // options[i].disabled = true;
            } else {
                options[i].style.color = 'black';
                // options[i].disabled = false;
            }
        }
    }
</script>

<!-- STYLE CSS -->
<style>
    .classe_group {
        max-width: 100%;
        margin: auto;
        text-align: left;
    }

    .classe {
        width: auto;
        height: auto;
        display: inline-block;
        text-align: left;
        margin-bottom: 30px;
        margin-left: 80px;
    }

    .classe select {
        width: auto;
    }

    .error {
        color: red;
        font-weight: bold;
        display: grid;
        justify-content: center;
    }

    .success {
        color: green;
        font-weight: bold;
        display: grid;
        justify-content: center;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>