<?php
require_once('../modele/BDD.php');
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(100)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo "<meta http-equiv='refresh' content='0; url=".$path."/view' />";
    exit();
}


/**
 * Créer par : Théo mouty
 * 
 * Programme qui permet d'importer les élèves depuis un fichier csv
 * Elle vérifie que le fichier est bien au bon format
 * Elle vérifie que les classes sont bien présentes dans la base de données
 * Si un élève n'a pas pu être inséré, il est ajouté dans un tableau d'erreur
 * On affiche le nombre d'élèves insérés et s'il y a des erreurs
 * on affiche le nombre d'erreurs et on affiche les élèves qui n'ont pas pu être insérés
 * et on affiche un bouton de téléchargement du fichier csv avec les élèves qui n'ont pas pu être insérés
 */
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
        // il faut que toutes la ligne ne soit pas vide pour l'ajouter
        $data[] = array_combine($first_line, $row);
    }

    // vérifiez que chaque ligne n'est pas vide
    $newdata = array();
    foreach ($data as $row) {
        // enlever la ligne si elle est vide
        if (!empty($row['NOM']) && !empty($row['PRENOM']) && !empty($row['SEXE']) && !empty($row['NE(E)LE']) && !empty($row['DIV.'])) {
            $newdata[] = $row;
        }
    }
    $data = $newdata;



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
    $eleve_error_insert = array();


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
        document.querySelectorAll('.card-body')[1].innerHTML += "<h5><?php echo "Erreur d'insertion : " . count($eleve_error_insert) ?></h5>";
    </script>
    <?php
    // afficher la liste des éléves
    foreach ($data as $row) {

        // vérifier si toutes les données sont présentes
        if (!empty($row['NOM']) || !empty($row['PRENOM']) || !empty($row['SEXE']) || !empty($row['NE(E)LE']) || !empty($row['DIV.'])) {

            $classe = str_replace('', '', $row['DIV.']);
            if (in_array($classe, $nomclasse)) {
                // trouvé l'id de la classe avec nomclasse
                $id_classe = array_search($classe, $nomclasse);

                $date_naissance = explode("/", $row['NE(E)LE']);
                $date_naissance = $date_naissance[2] . "-" . $date_naissance[1] . "-" . $date_naissance[0];

                $verif_insert = insert_etudiant($row['NOM'], $row['PRENOM'], $date_naissance, $id_classe, "");
                // si verif_insert == False, alors 
                if ($verif_insert == False) {
                    $eleve_error_insert[] = $row;
                    echo "<script>console.log('Impossible dinsérer lélève : " . $row['NOM'] . " " . $row['PRENOM'] . " dans la classe : " . $classe . "');</script>";
                }
                // si il y a pas de numéro national
            } else {
                // ajouter toutes les données de l'élève dans un tableau d'erreur, si la classe n'existe pas
                echo "<script>console.log('Impossible dinsérer lélève erreur classe : " . $row['NOM'] . " " . $row['PRENOM'] . " dans la classe : " . $classe . "');</script>";
                $eleve_error_insert[] = $row;
            }
            $compteur++;
            $nb_eleve_error = count($eleve_error_insert);
    ?>
            <script>
                // mettre à jour le compteur
                document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Insertion des élèves en cours</h4>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Merci de ne pas actualiser la page !</h4>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h5>Nombre d'étudiants insérés : <?php echo $compteur - $nb_eleve_error; ?>/<?php echo count($data); ?></h5>";
                document.querySelectorAll('.card-body')[1].innerHTML += "<h5><?php echo "Erreur d'insertion : " . $nb_eleve_error; ?></h5>";
            </script>
    <?php
        } else {
            // ajouter toutes les données de l'élève dans un tableau d'erreur, si il manque des données
            echo "<script>console.log('Impossible dinsérer lélève erreur données non présentes : " . $row['NOM'] . " " . $row['PRENOM'] . " dans la classe : " . $classe . "');</script>";
            $eleve_error_insert[] = $row;
        }
    }

    fclose($handle);

    ?>
    <?php


    // retourner le tableau d'erreur en csv
    // si le tableau n'est pas vide
    if (count($eleve_error_insert) > 0) {
        // créer un fichier csv
        $file = fopen('error.csv', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); //formart UTF-8

        // modifier le nom de la première feuille
        // mettre un message dans le fichier excel avec l'erreur : Classe inconnu
        // mettre les données dans le fichier csv
        // ajouter une seul fois les clés du tableau, qui sont les noms des colonnes, dans chaque colonne
        fputcsv($file, array_keys($eleve_error_insert[0]));
        // ajouter les valeurs du tableau
        foreach ($eleve_error_insert as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    ?>
        <script>
            // ajouter dans card-body
            document.querySelectorAll('.card-body')[1].innerHTML = "<h4>Attention, tous les élèves n'ont pas été insérés</h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Vous pouvez télécharger le fichier d'erreur au format CSV : <a href='error.csv'>Télécharger</a></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<br />";

            document.querySelectorAll('.card-body')[1].innerHTML += "<h3>Résultat de l'insertion :</h3>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Nombre d'étudiants insérés : <?php echo count($data) - (count($eleve_error_insert)); ?></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<h4>Nombre d'étudiants non insérés : <?php echo count($eleve_error_insert); ?></h4>";
            document.querySelectorAll('.card-body')[1].innerHTML += "<a href='<?= $path?>/controller/C_import.php' class='btn btn-primary'>Retour</a>";
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
            document.querySelectorAll('.card-body')[1].innerHTML += "<a href='<?= $path?>/controller/C_import.php' class='btn btn-primary'>Retour</a>";
        </script>
<?php

    }
}
