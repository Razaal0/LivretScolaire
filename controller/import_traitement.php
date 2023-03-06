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
    $file = $_FILES['import']['tmp_name'];
    $handle = fopen($file, "r");

    // récupérer la première ligne qui désignera les colonnes
    $first_line = fgetcsv($handle, 0, ";");
    // faire un filter pour enlever les ﻿
    $first_line = array_map('trim', $first_line);
    // faire un filter pour enlever les espaces
    foreach ($first_line as $key => $value) {
        $first_line[$key] = str_replace('﻿', '', $value);
    }
    // récupérer les autres lignes. Les mettres dans un dictionnaire avec comme clé le nom de la colonne
    $data = array();
    while ($row = fgetcsv($handle, 0, ";")) {
        $data[] = array_combine($first_line, $row);
    }
    // vérifier que les entêtes sont correctes comme dans le fichier exemple
    // (NOM | PRENOM | SEXE | NE(E) LE | DIV. | REG. | OPT1 | OPT2 | DIV.PREC.)
    $entete = array('NOM', 'PRENOM', 'SEXE', 'NE(E) LE', 'DIV.', 'REG.', 'OPT1', 'OPT2', 'DIV.PREC.)');
    if ($first_line != $entete) {
        echo '<h4>Le fichier n\'est pas au bon format.</h4>';
        echo '<h4>Le fichier que vous avez importé est : </h4>';
        echo '<h4>';
        echo $first_line;
        echo '</h4>';
        echo '<h4>Le fichier exemple est : </h4>';
        echo '<h4>';
        print_r($entete);
        echo '</h4>';
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
    <!-- Sert à suvire l'évolution de l'ajout des étudiants -->
    <div class="suivie_insertion">
        <h2>Insertion des élèves en cours</h2>
        <h2>Merci de ne pas actualiser la page !</h2>
        <h3><?php echo $compteur; ?>/<?php echo count($data); ?></h3>
        <h3><?php echo "Erreur d'insertion : " . count($eleve_error_insert_inconnu) + count($eleve_error_insert_classe); ?></h3>
    </div>
    <?php

    foreach ($data as $row) {
        $classe = $row['DIV.'];
        if (in_array($classe, $nomclasse)) {
            // trouvé l'id de la classe avec nomclasse
            $id_classe = array_search($classe, $nomclasse);

            // Si il y a un numéro national :
            if (isset($row['NumeroNational'])) {
                $date_naissance = explode("/", $row['NE(E) LE']);
                $date_naissance = $date_naissance[2] . "-" . $date_naissance[1] . "-" . $date_naissance[0];

                $verif_insert = insert_etudiant($row['NOM'], $row['PRENOM'], $date_naissance, $id_classe, $row['Numeronationals']);
                // si verif_insert == False, alors 
                if ($verif_insert == False) {
                    $eleve_error_insert_classe[] = $row;
                    echo "<script>console.log('Impossible d'insérer l'élève : " . $row['NOM'] . " " . $row['PRENOM'] . " dans la classe : " . $classe . " avec le numéro national : " . $row['NumeroNational'] . "');
                    </script>";
                }
                // si il y a pas de numéro national
            } else {
                $date_naissance = explode("/", $row['NE(E) LE']);
                $date_naissance = $date_naissance[2] . "-" . $date_naissance[1] . "-" . $date_naissance[0];
                $verif_insert = insert_etudiant($row['NOM'], $row['PRENOM'], $date_naissance, $id_classe, '');
                // si verif_insert == False, alors 
                if ($verif_insert == False) {
                    $eleve_error_insert_classe[] = $row;
                }
            }
        } else {
            // ajouter toutes les données de l'élève dans un tableau d'erreur, si la classe n'existe pas
            $eleve_error_insert_classe[] = $row;
        }
        $compteur++;
        $nb_eleve_error = count($eleve_error_insert_inconnu) + count($eleve_error_insert_classe);
    ?>
        <script>
            // mettre à jour le compteur
            document.querySelectorAll('.suivie_insertion h3')[0].innerHTML = '<?php echo $compteur; ?>/<?php echo count($data); ?>';
            // pareil pour les erreurs
            document.querySelectorAll('.suivie_insertion h3')[1].innerHTML = '<?php echo "Nombre de étudiant non inséré : " . $nb_eleve_error; ?>';
        </script>
    <?php
    }
    fclose($handle);



    ?>
    <script>
        // cacher la div de suivi
        document.querySelector('.suivie_insertion').style.display = 'none';
    </script>
    <?php


    // retourner le tableau d'erreur en csv
    // si le tableau n'est pas vide
    if (count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu) > 0) {
        // créer un fichier csv
        $file = fopen('error.csv', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); //formart UTF-8
        // modifier le nom de la première feuille
        // mettre un message dans le fichier excel avec l'erreur : Classe inconnu
        $error = array('Classe inconnu');
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
            $error = array('Erreur inconnu');
            fputcsv($file, $error, ';');
            // modifier le nom de la deuxième feuille
            // ajouter une seul fois les clés du tableau, qui sont les noms des colonnes, dans chaque colonne
            fputcsv($file, array_keys($eleve_error_insert_inconnu[0]));
            // ajouter les valeurs du tableau
            foreach ($eleve_error_insert_inconnu as $row) {
                fputcsv($file, $row);
            }
        }
        fclose($file);

    ?>
        <h2>Malheuresement, tous les élèves n'ont pas été insérés</h2>
        <h2>Vous pouvez télécharger le fichier d'erreur au format CSV : <a href="error.csv">Télécharger</a></h2>
        <br />
        <h3>Résultat de l'insertion :</h3>
        <h4>Nombre d'étudiants insérés : <?php echo count($data) - (count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu)); ?></h4>
        <h4>Nombre d'étudiants non insérés : <?php echo count($eleve_error_insert_classe) + count($eleve_error_insert_inconnu); ?></h4>
    <?php
    } else {
        // compter nombre d'étudiants inséré
        $nb_eleve_insert = count($data);
    ?>
        <script>
            // faire passer en get le nombre d'étudiant inséré, et le nombre d'erreur
            window.location.href = "Import.php?nb_eleve_insert=<?php echo $nb_eleve_insert ?>";
        </script>
<?php
    }
} else {
    header("Location: Import.php");
}