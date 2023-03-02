<?php

function connexion()
{
    try {
        // ip :  145.239.62.99
        $conn = new PDO('mysql:host=readergen.synology.me;dbname=livret;port=3307', 'livret', 'Livret2023*');
    } catch (Exception $ex) {
        die('Erreur:' . $ex->getMessage());
    }
    return $conn;
}

function deconnexion()
{
    $conn = null;
    return $conn;
}

function verif_matiere_note($saisie)
{
    if (filter_has_var(INPUT_POST, $saisie)) {
        $saisie = filter_input(INPUT_POST, $saisie, FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        return $saisie;
    }
}

function verif_saisi($saisie)
{
    if (filter_has_var(INPUT_POST, $saisie)) {
        $saisie = filter_input(INPUT_POST, $saisie, FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $saisi = implode($saisie);
        return $saisi;
    }
}

function verif_submit($envoyer)
{
    if (filter_input(INPUT_POST, $envoyer) != NULL) {
        $envoyer = filter_input(INPUT_POST, $envoyer);
    }
    return $envoyer;
}

function filtrer_character($nombre)
{
    if (filter_input(INPUT_POST, $nombre) == NULL) {
        $tab = filter_input(INPUT_POST, $nombre, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $nombre = filter_var_array($tab);
    }
    return $nombre;
}

//function filtrer_character($nombre) {
//    if (filter_input(INPUT_POST, $nombre) == NULL) {
//        $nombre = $_POST[$nombre];
//        $dec = implode($nombre);
//    }
//    return $dec;
//}

function recupere_enseignants()
{
    $enseignant = connexion()->prepare("SELECT * FROM `ENSEIGNANT`");
    $enseignant->execute();
    $profs = $enseignant->fetchAll(PDO::FETCH_ASSOC);
    return $profs;
}

function recupere_enseignants_by_id($codeenseignant)
{
    $enseignant = connexion()->prepare("SELECT * FROM `ENSEIGNANT` WHERE CodeEnseignant = :codeens");
    $enseignant->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
    $enseignant->execute();
    $profs = $enseignant->fetch (PDO::FETCH_ASSOC);
    return $profs;
}

function insert_enseignants()
{
    $name = filter_input(INPUT_POST, "nom");
    $firstname = filter_input(INPUT_POST, "prenom");
    $ens = false;
    if (isset($name) && isset($firstname)) {
        $ens = connexion()->prepare("INSERT INTO `ENSEIGNANT`(NOM,PRENOM) VALUES(:name,:firstname)");
        $ens->bindParam(':name', $name, PDO::PARAM_STR);
        $ens->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $ens->execute();
    }
    return $ens;
}

function modif_ens($codeenseignant)
{
    $nomens = filter_input(INPUT_POST, "nomens");
    $prenomens = filter_input(INPUT_POST, "prenomens");
    try{
    if ($nomens && !empty($nomens)) {
        $modifn = connexion()->prepare("UPDATE `ENSEIGNANT` SET NOM ='" . $nomens . "' WHERE CodeEnseignant = :codeens");
        $modifn->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
        $modifn->execute();
    }
    if ($prenomens && !empty($prenomens)) {
        $modifp = connexion()->prepare("UPDATE `ENSEIGNANT` SET PRENOM ='" . $prenomens . "' WHERE CodeEnseignant = :codeens");
        $modifp->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
        $modifp->execute();
    }
    return true;
    }catch(Exception $ex){
        die('Erreur:' . $ex->getMessage());
        return false;
    }
}

function supprimer_enseignant($codeenseignant)
{
    $supp_ens = connexion()->prepare("DELETE from `ENSEIGNANT` WHERE CodeEnseignant =:codeens");
    $supp_ens->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
    $supp_ens->execute();
    return $supp_ens;
}

function recupere_matieres()
{
    $matiere = connexion()->prepare("SELECT * FROM `MATIERE`");
    $matiere->execute();
    $m = $matiere->fetchAll(PDO::FETCH_ASSOC);
    return $m;
}

function recupere_matieres_by_id($codematiere)
{
    $matiere = connexion()->prepare("SELECT * FROM `MATIERE` WHERE CodeMatiere = :codemat");
    $matiere->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $matiere->execute();
    $m = $matiere->fetch(PDO::FETCH_ASSOC);
    return $m;
}

function insert_matieres()
{
    $matiere = filter_input(INPUT_POST, "matieres");
    $ajoutmat = connexion()->prepare("INSERT INTO `MATIERE`(LibMatiere) VALUES(:matiere)");
    if (isset($matiere)) {
        $ajoutmat->bindParam(':matiere', $matiere, PDO::PARAM_STR);
        $ajoutmat->execute();
?>
        <script>
            window.location.href = "../Controller/C_matiere.php ";
        </script>
<?php
    }
    return $ajoutmat;
}

function modif_matiere($codematiere)
{
    $matiere = filter_input(INPUT_POST, "matiere");
    try{
    if ($matiere) {
        $modifm = connexion()->prepare("UPDATE `MATIERE` SET LibMatiere ='" . $matiere . "' WHERE CodeMatiere =:codemat");
        $modifm->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
        $modifm->execute();
    }
    return true;
    }catch(Exception $ex){
        die('Erreur:' . $ex->getMessage());
        return false;
    }
}

function supprimer_matiere($codematiere)
{
    $suppm = connexion()->prepare("DELETE from `MATIERE` WHERE CodeMatiere =:codemat");
    $suppm->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $suppm->execute();
    return $suppm;
}

function recupere_classes()
{
    $classe = connexion()->prepare("SELECT * FROM `CLASSE`");
    $classe->execute();
    $c = $classe->fetchAll(PDO::FETCH_ASSOC);
    return $c;
}

function asso_cl_et($valeur)
{
    $etud = connexion()->prepare("SELECT * from `ETUDIANT_CLASSE` join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode join `ETUDIANT` on `ETUDIANT`.codeetudiant = `ETUDIANT_CLASSE`.codeetudiant where `ETUDIANT_CLASSE`.classecode ='" . $valeur."'");
    $etud->execute();
    $et = $etud->fetchAll(PDO::FETCH_ASSOC);
    return $et;
}

function asso_cl_et_un_etudiant($classe,$codeEtu)
{
    $etud = connexion()->prepare("SELECT * from `ETUDIANT_CLASSE` join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode join `ETUDIANT` on `ETUDIANT`.codeetudiant = `ETUDIANT_CLASSE`.codeetudiant where `ETUDIANT_CLASSE`.classecode =" . $classe . " and `ETUDIANT_CLASSE`.codeetudiant = " . $codeEtu);
    $etud->execute();
    $et = $etud->fetchAll(PDO::FETCH_ASSOC);
    return $et;
}
function recupere_etudiants()
{
    $req = connexion()->prepare("SELECT * from `ETUDIANT` join `ETUDIANT_CLASSE` on `ETUDIANT_CLASSE`.codeetudiant = `ETUDIANT`.codeetudiant join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode;");
    $req->execute();
    $r = $req->fetchAll(PDO::FETCH_ASSOC);
    return $r;
}

function recupere_etudiants_by_id($id)
{
    $req = connexion()->prepare("SELECT * from `ETUDIANT` join `ETUDIANT_CLASSE` on `ETUDIANT_CLASSE`.codeetudiant = `ETUDIANT`.codeetudiant join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode where `ETUDIANT`.codeetudiant = :id");
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $r = $req->fetch(PDO::FETCH_ASSOC);
    return $r;
}

function modif_etud($codeetudiant)
{
    $nometu = filter_input(INPUT_POST, "nometu");
    $prenometu = filter_input(INPUT_POST, "prenometu");
    $datenaissance = filter_input(INPUT_POST, "date");
    $classe = filter_input(INPUT_POST, "classe");
    try{
    if ($nometu) {
        $modifetu = connexion()->prepare("UPDATE `ETUDIANT` SET NomEtudiant ='" . $nometu . "' WHERE codeetudiant = :codeetud");
        $modifetu->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
        $modifetu->execute();
    }
    if ($prenometu) {
        $modifetu = connexion()->prepare("UPDATE `ETUDIANT` SET PrenomEtudiant ='" . $prenometu . "' WHERE codeetudiant = :codeetud");
        $modifetu->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
        $modifetu->execute();
    }
    if ($datenaissance) {
        $modifetu = connexion()->prepare("UPDATE `ETUDIANT` SET Datedenaissance ='" . $datenaissance . "' WHERE codeetudiant = :codeetud");
        $modifetu->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
        $modifetu->execute();
    }
    if ($classe) {
        $modifetu = connexion()->prepare("UPDATE `ETUDIANT_CLASSE` SET classecode ='" . $classe . "' WHERE codeetudiant = :codeetud");
        $modifetu->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
        $modifetu->execute();
    }
    return true;
    }catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

function supprimer_etudiant($codeetudiant)
{
    $supp_etud = connexion()->prepare("DELETE from `ETUDIANT` WHERE codeetudiant =:codeetud");
    $supp_etud->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
    $supp_etud->execute();
    return $supp_etud;
}

function recupere_enseigner($classe)
{
    $mat = connexion()->prepare("SELECT `CodeEnseignant`, `classecode`,`ENSEIGNER`.`CodeMatiere`,`LibMatiere` FROM `ENSEIGNER` join `MATIERE` on ENSEIGNER.CodeMatiere = MATIERE.CodeMatiere where ENSEIGNER.CLASSECODE =" . $classe);
    $mat->execute();
    $m = $mat->fetchAll(PDO::FETCH_ASSOC);
    return "SELECT `CodeEnseignant`, `classecode`,`ENSEIGNER`.`CodeMatiere`,`LibMatiere` FROM `ENSEIGNER` join `MATIERE` on ENSEIGNER.CodeMatiere = MATIERE.CodeMatiere where ENSEIGNER.CLASSECODE =" . $classe;
}

function verif_enseigner_existe($classe, $matiere, $enseignant) {
    $recup_enseigner = connexion()->prepare("SELECT * FROM `ENSEIGNER` WHERE `classecode` = " . $classe . " AND `CodeEnseignant` = " . $enseignant . " AND `CodeMatiere` = " . $matiere . "");
    $recup_enseigner->execute();
    return  $recup_enseigner->fetch(PDO::FETCH_ASSOC);
}

function insert_enseigner($classe, $matiere, $enseignant)
{
    $inserer = connexion()->prepare("INSERT INTO `ENSEIGNER`(classecode,CodeMatiere,CodeEnseignant) VALUES(:classe,:matiere,:enseignant)");
    $inserer->bindParam(':classe', $classe, PDO::PARAM_INT);
    $inserer->bindParam(':matiere', $matiere, PDO::PARAM_INT);
    $inserer->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $inserer->execute();
    return $inserer;
}

function insert_etudiant($nom, $prenom, $date, $classe, $numero_national)
{
    // insertion de l'étudiant dans la table ETUDIANT
    $ajout_etud = connexion()->prepare("INSERT INTO `ETUDIANT`(`NOMETUDIANT`, `PRENOMETUDIANT`, `datedenaissance`, `Numeronational`) VALUES (:nom,:prenom,:datee,:numero_national)");
    $ajout_etud->bindParam(':nom', $nom, PDO::PARAM_STR);
    $ajout_etud->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $ajout_etud->bindParam(':datee', $date, PDO::PARAM_STR);
    $ajout_etud->bindParam(':numero_national', $numero_national, PDO::PARAM_STR);
    $ajout_etud->execute();

    // Il faut récupérer le dernier étudiant inséré
    $eleve_test = connexion()->prepare("SELECT * FROM `ETUDIANT` ORDER BY `ETUDIANT`.`codeetudiant` DESC LIMIT 1");
    $eleve_test->execute();
    $eleve_test = $eleve_test->fetchAll(PDO::FETCH_ASSOC);
    $id_eleve_test = $eleve_test[0]['codeetudiant'];

    // si sa correspond à l'étudiant inséré, on l'ajoute dans assos_9
    if ($eleve_test[0]['codeetudiant'] == $id_eleve_test && $eleve_test[0]['NOMETUDIANT'] == $nom && $eleve_test[0]['PRENOMETUDIANT'] == $prenom && $eleve_test[0]['datedenaissance'] == $date) {
        $ajout_etud = connexion()->prepare("INSERT INTO `ETUDIANT_CLASSE` (`codeetudiant`, `classecode`) VALUES (:code_etudiant, :code_classe);");
        $ajout_etud->bindParam(':code_etudiant', $id_eleve_test, PDO::PARAM_INT);
        $ajout_etud->bindParam(':code_classe', $classe, PDO::PARAM_INT);
        $ajout_etud->execute();
        return $ajout_etud;
    }

    // si on le trouve pas, il y a peux être un décalage dans les codes, donc on vérifie 5 incréments avant et après
    // on vérifire avant
    for ($i = $id_eleve_test + 1; $id_eleve_test < $id_eleve_test + 6; $i++) {
        // récupération de l'étudiant dans la étudiant
        $eleve_test = connexion()->prepare("SELECT * FROM `ETUDIANT` WHERE `codeetudiant` = $i");
        $eleve_test->execute();
        $eleve_test = $eleve_test->fetchAll(PDO::FETCH_ASSOC);

        // si eleve_test est non vide, on vérifie que les données correspondent
        if (!empty($eleve_test)) {
            // si on le trouve, on l'insère dans la table ETUDIANT_CLASSE (codeclasse, codeetudiant)
            if ($eleve_test[0]['codeetudiant'] == $i && $eleve_test[0]['NOMETUDIANT'] == $nom && $eleve_test[0]['PRENOMETUDIANT'] == $prenom && $eleve_test[0]['datedenaissance'] == $date) {
                $ajout_etud = connexion()->prepare("INSERT INTO `ETUDIANT_CLASSE` (`codeetudiant`, `classecode`) VALUES (:code_etudiant, :code_classe);");
                $ajout_etud->bindParam(':code_etudiant', $i, PDO::PARAM_INT);
                $ajout_etud->bindParam(':code_classe', $classe, PDO::PARAM_INT);
                $ajout_etud->execute();
                return $ajout_etud;
            }
        }
    }

    // On vérifire après
    for ($i = $id_eleve_test - 1; $id_eleve_test < $id_eleve_test - 6; $i--) {
        // récupération de l'étudiant dans la étudiant
        $eleve_test = connexion()->prepare("SELECT * FROM `ETUDIANT` WHERE `codeetudiant` = $i");
        $eleve_test->execute();
        $eleve_test = $eleve_test->fetchAll(PDO::FETCH_ASSOC);

        // si eleve_test est non vide, on vérifie que les données correspondent
        if (!empty($eleve_test)) {
            if ($eleve_test[0]['codeetudiant'] == $i && $eleve_test[0]['NOMETUDIANT'] == $nom && $eleve_test[0]['PRENOMETUDIANT'] == $prenom && $eleve_test[0]['datedenaissance'] == $date) {
                $ajout_etud = connexion()->prepare("INSERT INTO `ETUDIANT_CLASSE` (`codeetudiant`, `classecode`) VALUES (:code_etudiant, :code_classe);");
                $ajout_etud->bindParam(':code_etudiant', $i, PDO::PARAM_INT);
                $ajout_etud->bindParam(':code_classe', $classe, PDO::PARAM_INT);
                $ajout_etud->execute();
                return $ajout_etud;
            }
        }
    }
    return False;
}

function recupere_notes($codeetudiant)
{
    $note = connexion()->prepare("select * from `NOTE_ETUDIANT` join `ETUDIANT` on `NOTE_ETUDIANT`.Codeetudiant = `ETUDIANT`.codeetudiant 
                                  join `MATIERE` on `NOTE_ETUDIANT`.codematiere = `MATIERE`.codematiere 
                                  where `NOTE_ETUDIANT`.codeetudiant=:codeetud order by Libmatiere");
    $note->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
    $note->execute();
    $note = $note->fetchAll(PDO::FETCH_ASSOC);
    return $note;
}

function note_saisie($semestre1, $semestre2, $appreciation, $codeetudiant, $codematiere, $codeclasse)
{
    $note = connexion()->prepare("INSERT INTO `NOTE_ETUDIANT`(Semestre1,Semestre2,Appreciation,CodeEtudiant,CodeMatiere,Classecode) values(:S1,:S2,:app,:codeetud,:codemat,:codeclas) on duplicate key update Semestre1 = :S1, Semestre2 = :S2, Appreciation=:app");
    $note->bindParam(':S1', $semestre1, PDO::PARAM_INT);
    $note->bindParam(':S2', $semestre2, PDO::PARAM_INT);
    $note->bindParam(':app', $appreciation, PDO::PARAM_STR);
    $note->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
    $note->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $note->bindParam(':codeclas', $codeclasse, PDO::PARAM_INT);
    $note->execute();
    return $note;
}

function ajouter_etudiant_csv($NOMETUDIANT, $PRENOMETUDIANT, $datedenaissance, $Numeronational)
{
    $note = connexion()->prepare("INSERT INTO `ETUDIANT`(`NOMETUDIANT`, `PRENOMETUDIANT`, `datedenaissance`, `Numeronational`) values(:NOMETUDIANT, :PRENOMETUDIANT, :datedenaissance, :Numeronational)");
    $note->bindParam(':NOMETUDIANT', $NOMETUDIANT, PDO::PARAM_STR);
    $note->bindParam(':PRENOMETUDIANT', $PRENOMETUDIANT, PDO::PARAM_STR);
    $note->bindParam(':datedenaissance', $datedenaissance, PDO::PARAM_STR);
    $note->bindParam(':Numeronational', $Numeronational, PDO::PARAM_INT);
    $note->execute();


    $ajout_etud = connexion()->prepare("INSERT INTO `ETUDIANT_CLASSE` (`codeetudiant`, `classecode`) VALUES (:code_etudiant, :code_classe);");
    $ajout_etud->bindParam(':code_etudiant', $id_eleve_test, PDO::PARAM_INT);
    $ajout_etud->bindParam(':code_classe', $classe, PDO::PARAM_INT);
    $ajout_etud->execute();
    return $note;
}

function recupere_user($user,$password) {
    $us = connexion()->prepare("SELECT * FROM UTILISATEUR WHERE NOM = :username and MDP = :password OR EMAIL = :username and MDP = :password");
    $us->bindParam(':username', $user, PDO::PARAM_STR);
    $us->bindParam(':password', $password, PDO::PARAM_STR);
    $us->execute();
    $m = $us->fetch(PDO::FETCH_ASSOC);
    if (!empty($m)) {
        return $m;
    }
}

function insert_user($email,$nom,$prenom,$password) {
    $us = connexion()->prepare("INSERT INTO UTILISATEUR (NOM,PRENOM,EMAIL,MDP) VALUES (:nom,:prenom,:email,:password)");
    $us->bindParam(':nom', $nom, PDO::PARAM_STR);
    $us->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->bindParam(':password', $password, PDO::PARAM_STR);
    $us->execute();
    return $us;
}

function email_exist($email) {
    $us = connexion()->prepare("SELECT * FROM UTILISATEUR WHERE EMAIL = :email");
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->execute();
    $m = $us->fetch(PDO::FETCH_ASSOC);
    if (!empty($m)) {
        return True;
    } else {
        return False;
    }
}
