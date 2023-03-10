<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}


require_once('../view/includes/header.php');
require_once('../view/includes/nav.php');
if (isset($_FILES['import']) && !empty($_FILES['import']['tmp_name'])) {
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1></h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php
    $file = $_FILES['import']['tmp_name'];
    $handle = fopen($file, "r");

    // récupérer la première ligne qui désignera les colonnes
    $first_line = fgetcsv($handle, 0, ";");
    // faire un filter pour enlever les ﻿
    $first_line = array_map('trim', $first_line);
    // faire un filter pour enlever les espaces
    foreach ($first_line as $key => $value) {
        $first_line[$key] = str_replace('﻿', '', $value);
        // enelver les espaces
        $first_line[$key] = str_replace(' ', '', $value);
    }
    // récupérer les autres lignes. Les mettres dans un dictionnaire avec comme clé le nom de la colonne
    $data = array();
    while ($row = fgetcsv($handle, 0, ";")) {
        $data[] = array_combine($first_line, $row);
    }


    // vérifier que les entêtes sont correctes comme dans le fichier exemple
    // (NOM | PRENOM | SEXE | NE(E) LE | DIV. | REG. | OPT1 | OPT2 | DIV.PREC.)
    $entete = array('NOM', 'PRENOM', 'SEXE', 'NE(E)LE', 'DIV.', 'REG.', 'OPT1', 'OPT2', 'DIV.PREC.');
    if ($first_line != $entete) {
    ?>
        <script>
            // ajouter dans card-body
            document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Erreur : Les entêtes du fichier ne sont pas correctes</h4>";
            // afficher les entêtes attendues et celles du fichier
            document.querySelectorAll('.card-body')[1].innerHTML += "<br /><h5>Entêtes attendues : <?php echo implode(" | ", $entete); ?></h5>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h5>Entêtes du fichier : <?php echo implode(" | ", $first_line); ?></h5>";

            // ajouter un bouton pour revenir à l'import
            document.querySelectorAll('.card-body')[1].innerHTML += "<br /><a href='/controller/C_import.php' class='btn btn-primary'>Retour à l'import</a>";
        </script>
    <?php
        exit();
    }
    // initiation des tableaux d'erreur
    $eleve_error_insert_classe = array();
    $eleve_error_insert_inconnu = array();


    // garder juste l'id et le libellecourt des classes
    $classe_bdd = recupere_classes();
    $nomclasse = array();
    foreach ($classe_bdd as $classe) {
        $nomclasse[$classe['classecode']] = $classe['Libellecourt'];
    }

    // le compteur sert à savoir à quelle étudiant on est
    $compteur = 0;
    ?>
    <script>
        // ajouter dans card-body
        document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Insertion des élèves en cours</h4>";
        document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Merci de ne pas actualiser la page !</h4>";
        document.querySelectorAll('.card-body')[1].innerHTML += "<h5><?php echo $compteur; ?>/<?php echo count($data); ?></h5>";
        document.querySelectorAll('.card-body')[1].innerHTML += "<h5><?php echo "Erreur d'insertion : " . count($eleve_error_insert_inconnu) + count($eleve_error_insert_classe); ?></h5>";
    </script>
    <?php
    // afficher la liste des éléves
    foreach ($data as $row) {

        // vérifier si toutes les données sont présentes
        if (!empty($row['NOM']) || !empty($row['PRENOM']) || !empty($row['SEXE']) || !empty($row['NE(E)LE']) || !empty($row['DIV.'])) {

            $classe = $row['DIV.'];
            if (in_array($classe, $nomclasse)) {
                // trouvé l'id de la classe avec nomclasse
                $id_classe = array_search($classe, $nomclasse);

                $date_naissance = explode("/", $row['NE(E)LE']);
                $date_naissance = $date_naissance[2] . "-" . $date_naissance[1] . "-" . $date_naissance[0];

                $verif_insert = insert_etudiant($row['NOM'], $row['PRENOM'], $date_naissance, $id_classe, "");
                // si verif_insert == False, alors 
                if ($verif_insert == False) {
                    $eleve_error_insert_inconnu[] = $row;
                    echo "<script>console.log('Impossible d'insérer l'élève : " . $row['NOM'] . " " . $row['PRENOM'] . " dans la classe : " . $classe . "');</script>";
                }
                // si il y a pas de numéro national
            } else {
                // ajouter toutes les données de l'élève dans un tableau d'erreur, si la classe n'existe pas
                $eleve_error_insert_classe[] = $row;
            }
            $compteur++;
            $nb_eleve_error = count($eleve_error_insert_inconnu) + count($eleve_error_insert_classe);
    ?>
            <script>
                // mettre à jour le compteur
                document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Insertion des élèves en cours</h4>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Merci de ne pas actualiser la page !</h4>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h5>Nombre d'étudiants insérés : <?php echo $compteur; ?>/<?php echo count($data); ?></h5>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h5><?php echo "Erreur d'insertion : " . $nb_eleve_error; ?></h5>";
            </script>
    <?php
        }
    }

    fclose($handle);


    ?>
    <?php


    // retourner le tableau d'erreur en csv
    // si le tableau n'est pas vide
    if (count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu) > 0 && !empty($error)){
        // créer un fichier csv
        $file = fopen('error.csv', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); //formart UTF-8

        // modifier le nom de la première feuille
        // mettre un message dans le fichier excel avec l'erreur : Classe inconnu
        fputcsv($file, $error, ';');
        // mettre les données dans le fichier csv
        // ajouter une seul fois les clés du tableau, qui sont les noms des colonnes, dans chaque colonne
        fputcsv($file, array_keys($eleve_error_insert_classe[0]));
        // ajouter les valeurs du tableau
        foreach ($eleve_error_insert_classe as $row) {
            fputcsv($file, $row);
        }

        // créer une deuxième feuille si le tableau elev_error_insert_inconnu n'est pas vide
        if (!empty($eleve_error_insert_inconnu)) {
            // créer une deuxième feuille
            $file = $spreadsheet->createSheet();
            // mettre un message dans le fichier excel avec l'erreur : Erreur inconnu
            fputcsv($file, $error, ';');
            // ajouter une seul fois les clés du tableau, qui sont les noms des colonnes, dans chaque colonne
            fputcsv($file, array_keys($eleve_error_insert_inconnu[0]));
            // ajouter les valeurs du tableau
            foreach ($eleve_error_insert_inconnu as $row) {
                fputcsv($file, $row);
            }
        }
        fclose($file);

        ?>
        <script>
            // ajouter dans card-body
            document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Attention, tous les élèves n'ont pas été insérés</h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Vous pouvez télécharger le fichier d'erreur au format CSV : <a href='error.csv'>Télécharger</a></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<br />";

            document.querySelectorAll('.card-body')[1].innerHTML += "<h3>Résultat de l'insertion :</h3>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Nombre d'étudiants insérés : <?php echo count($data) - (count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu)); ?></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Nombre d'étudiants non insérés : <?php echo count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu); ?></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<a href='/controller/C_import.php' class='btn btn-primary'>Retour</a>";
        </script>
        <?php
    } else {
        // compter nombre d'étudiants inséré
        $nb_eleve_insert = count($data);
    ?>
        <script>
            // ajouter dans card-body
            document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Tous les élèves ont été insérés</h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<br />";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h3>Résultat de l'insertion :</h3>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Nombre d'étudiants insérés : <?php echo $nb_eleve_insert; ?></h4>";
            // bouton pour revenir à la page d'imporation
            document.querySelectorAll('.card-body')[1].innerHTML += "<a href='/controller/C_import.php' class='btn btn-primary'>Retour</a>";
        </script>
<?php

    }
}
