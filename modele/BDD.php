<?php

/**
 * Crée une nouvelle connexion à la base de données.
 *
 * @return PDO La nouvelle connexion à la base de données.
 */
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

/**
 * Cette fonction ferme la connexion à la base de données en mettant la variable $conn à null.
 *
 * @return PDO|null Retourne la variable $conn mise à null.
 */
function deconnexion()
{
    $conn = null;
    return $conn;
}

/**
 * Vérifie si une saisie utilisateur est présente en méthode POST et renvoie un tableau filtré de valeurs entières.
 *
 * @param string $saisie Le nom de l'entrée POST à vérifier.
 * @return array|false Retourne un tableau de valeurs entières si la saisie est présente en POST, ou false sinon.
 */
function verif_matiere_note($saisie)
{
    if (filter_has_var(INPUT_POST, $saisie)) {
        $saisie = filter_input(INPUT_POST, $saisie, FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        return $saisie;
    }
}

/**
 * Vérifie la saisie d'un formulaire et renvoie une chaîne de caractères.
 *
 * @param string $saisie Le nom du champ à vérifier dans la superglobale $_POST.
 * @return string|false La valeur du champ si présent, false sinon.
 */
function verif_saisi($saisie)
{
    if (filter_has_var(INPUT_POST, $saisie)) {
        $saisie = filter_input(INPUT_POST, $saisie, FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
        $saisi = implode($saisie);
        return $saisi;
    }
}

/**
 * Vérifie si le bouton d'envoi a été soumis via une requête POST et retourne sa valeur.
 *
 * @param string $envoyer Le nom du bouton d'envoi à vérifier.
 *
 * @return mixed La valeur du bouton d'envoi si la requête POST a été soumise, NULL sinon.
 */
function verif_submit($envoyer)
{
    if (filter_input(INPUT_POST, $envoyer) != NULL) {
        $envoyer = filter_input(INPUT_POST, $envoyer);
    }
    return $envoyer;
}

/**
 * Filtre les caractères spéciaux d'un tableau de saisies utilisateur, si celui-ci est vide, retourne la variable d'entrée.
 *
 * @param string $nombre Nom de l'élément HTML contenant la saisie utilisateur.
 * @return mixed Retourne le tableau de saisies filtrées des caractères spéciaux, ou la variable d'entrée si le tableau est vide.
 */
function filtrer_character($nombre)
{
    if (filter_input(INPUT_POST, $nombre) == NULL) {
        $tab = filter_input(INPUT_POST, $nombre, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        $nombre = filter_var_array($tab);
    }
    return $nombre;
}

/**
 * Récupère la liste de tous les enseignants depuis la base de données
 *
 * @return array Tableau associatif contenant les informations de tous les enseignants
 *
 * @throws PDOException si une erreur se produit lors de la récupération des données depuis la base de données
 */
function recupere_enseignants()
{
    $enseignant = connexion()->prepare("SELECT * FROM `ENSEIGNANT`");
    $enseignant->execute();
    $profs = $enseignant->fetchAll(PDO::FETCH_ASSOC);
    return $profs;
}

/**
 * Récupère les informations d'un enseignant à partir de son code enseignant.
 *
 * @param int $codeenseignant Le code de l'enseignant dont on veut récupérer les informations.
 *
 * @return array|false Retourne un tableau associatif contenant les informations de l'enseignant s'il existe, false sinon.
 */
function recupere_enseignants_by_id($codeenseignant)
{
    $enseignant = connexion()->prepare("SELECT * FROM `ENSEIGNANT` WHERE CodeEnseignant = :codeens");
    $enseignant->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
    $enseignant->execute();
    $profs = $enseignant->fetch (PDO::FETCH_ASSOC);
    return $profs;
}

/**
 * Insère un enseignant dans la base de données.
 *
 * @return PDOStatement|false Retourne la requête PDO préparée si l'insertion a réussi, sinon retourne false.
 *
 * @throws PDOException Si une erreur PDO survient lors de la préparation ou de l'exécution de la requête.
 */
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

/**
 * Modifie le nom et/ou le prénom d'un enseignant dans la base de données.
 *
 * @param int $codeenseignant L'identifiant de l'enseignant à modifier.
 *
 * @return bool Retourne true si la modification a été effectuée avec succès, sinon false.
 * @throws Exception Si une erreur survient pendant l'exécution de la requête SQL.
 */
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

/**
 * Supprime un enseignant de la base de données en utilisant son code enseignant.
 *
 * @param int $codeenseignant Le code de l'enseignant à supprimer.
 *
 * @return PDOStatement|false Retourne l'objet PDOStatement en cas de succès, ou false en cas d'échec.
 */
function supprimer_enseignant($codeenseignant)
{
    $supp_ens = connexion()->prepare("DELETE from `ENSEIGNANT` WHERE CodeEnseignant =:codeens");
    $supp_ens->bindParam(':codeens', $codeenseignant, PDO::PARAM_INT);
    $supp_ens->execute();
    return $supp_ens;
}

/**
 * Récupère toutes les matières dans la base de données
 *
 * @return array|false Retourne un tableau associatif contenant toutes les matières s'il y en a, ou false sinon
 * @throws PDOException si une erreur se produit lors de l'exécution de la requête SQL
 */
function recupere_matieres()
{
    $matiere = connexion()->prepare("SELECT * FROM `MATIERE`");
    $matiere->execute();
    $m = $matiere->fetchAll(PDO::FETCH_ASSOC);
    return $m;
}

/**
 * Récupère une matière en fonction de son code
 *
 * @param int $codematiere Le code de la matière à récupérer
 *
 * @return array|false Retourne un tableau associatif contenant les informations de la matière ou false si la matière n'a pas été trouvée
 */
function recupere_matieres_by_id($codematiere)
{
    $matiere = connexion()->prepare("SELECT * FROM `MATIERE` WHERE CodeMatiere = :codemat");
    $matiere->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $matiere->execute();
    $m = $matiere->fetch(PDO::FETCH_ASSOC);
    return $m;
}

/**
 * Récupère les matières associées à une classe à partir de son code de classe.
 * @param int $classecode Le code de la classe dont on souhaite récupérer les matières.
 * @return array|false Retourne un tableau associatif des matières de la classe avec leur code et leur libellé.
 * Si aucune matière n'est associée à la classe, retourne false.
 */
function recupere_matieres_by_classe($classecode)
{
    $matiere = connexion()->prepare("SELECT `MATIERE`.`CodeMatiere`,`MATIERE`.`LibMatiere` FROM `CLASSE_MATIERE` JOIN `MATIERE` ON `CLASSE_MATIERE`.`CodeMatiere` = `MATIERE`.`CodeMatiere` WHERE classecode = :classecode");
    $matiere->bindParam(':classecode', $classecode, PDO::PARAM_INT);
    $matiere->execute();
    $m = $matiere->fetchAll(PDO::FETCH_ASSOC);
    return $m;
}

/**
 * Récupère la liste des matières suivies par un étudiant donné
 *
 * @param int $codeetudiant Le code de l'étudiant dont on veut récupérer les matières
 *
 * @return array|false Retourne un tableau contenant les matières suivies par l'étudiant, ou false en cas d'erreur
 */
function recupere_matieres_by_eleve($codeetudiant) {
    $matiere = connexion()->prepare("SELECT * FROM `NOTE_ETUDIANT` JOIN MATIERE on NOTE_ETUDIANT.codematiere = MATIERE.CodeMatiere where codeetudiant = :codeetudiant ");
    $matiere->bindParam(':codeetudiant', $codeetudiant, PDO::PARAM_INT);
    $matiere->execute();
    $m = $matiere->fetchAll(PDO::FETCH_ASSOC);
    return $m;
}

/**
 * Inserte une nouvelle matière dans la base de données.
 *
 * @return PDOStatement|false Retourne l'objet PDOStatement en cas de succès ou false en cas d'échec.
 */
function insert_matieres()
{
    $matiere = filter_input(INPUT_POST, "matieres");
    $ajoutmat = connexion()->prepare("INSERT INTO `MATIERE`(LibMatiere) VALUES(:matiere)");
    if (isset($matiere)) {
        $ajoutmat->bindParam(':matiere', $matiere, PDO::PARAM_STR);
        $ajoutmat->execute();
?>
        <script>
            window.location.href = "../controller/C_matiere.php ";
        </script>
<?php
    }
    return $ajoutmat;
}

/**
 * Met à jour le nom d'une matière dans la base de données.
 *
 * @param int $codematiere Le code de la matière à modifier.
 *
 * @return bool Retourne true si la modification a réussi, ou false en cas d'erreur.
 */
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

/**
 * Supprime une matière de la base de données.
 *
 * @param int $codematiere Le code de la matière à supprimer.
 *
 * @return PDOStatement|false Retourne l'objet PDOStatement en cas de succès ou false en cas d'échec.
 */
function supprimer_matiere($codematiere)
{
    $suppm = connexion()->prepare("DELETE from `MATIERE` WHERE CodeMatiere =:codemat");
    $suppm->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $suppm->execute();
    return $suppm;
}

/**
 * Récupère toutes les classes depuis la base de données.
 *
 * @return array|false Retourne un tableau associatif contenant toutes les classes si la requête est un succès, ou false si elle échoue.
 */
function recupere_classes()
{
    $classe = connexion()->prepare("SELECT * FROM `CLASSE`");
    $classe->execute();
    $c = $classe->fetchAll(PDO::FETCH_ASSOC);
    return $c;
}

/**
 * Récupère la liste des étudiants associés à une classe donnée.
 *
 * @param string $valeur Le code de la classe pour laquelle récupérer les étudiants.
 * @return array|false Retourne un tableau associatif contenant les informations des étudiants de la classe ou false si une erreur survient.
 */
function asso_cl_et($valeur)
{
    $etud = connexion()->prepare("SELECT * from `ETUDIANT_CLASSE` join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode join `ETUDIANT` on `ETUDIANT`.codeetudiant = `ETUDIANT_CLASSE`.codeetudiant where `ETUDIANT_CLASSE`.classecode ='" . $valeur."'");
    $etud->execute();
    $et = $etud->fetchAll(PDO::FETCH_ASSOC);
    return $et;
}

/**
 * récupère les informations d'une classe d'un étudiant
 * 
 * @param int $codeetud Le code de l'étudiant dont on veut récupérer les informations.
 * 
 * @return array|false Retourne un tableau associatif contenant les informations de la classe de l'étudiant ou false si une erreur survient.
*/
function recupere_classe_etud($codeetud){
    $etud = connexion()->prepare("SELECT e.*,ec.codeetudiant FROM `CLASSE` e JOIN `ETUDIANT_CLASSE` ec on e.classecode=ec.classecode where ec.codeetudiant=:codeetudiant");
    $etud->bindParam(':codeetudiant', $codeetud, PDO::PARAM_STR);
    $etud->execute();
    $et = $etud->fetchAll(PDO::FETCH_ASSOC);
    
    return $et;
}


/**
 * Récupère les informations d'un étudiant pour une classe donnée.
 *
 * @param int $classe Le code de la classe recherchée.
 * @param int $codeEtu Le code de l'étudiant recherché.
 *
 * @return array|false Un tableau associatif contenant les informations de l'étudiant pour la classe donnée, ou false si aucune information n'est trouvée.
 */
function asso_cl_et_un_etudiant($classe,$codeEtu)
{
    $etud = connexion()->prepare("SELECT * from `ETUDIANT_CLASSE` join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode join `ETUDIANT` on `ETUDIANT`.codeetudiant = `ETUDIANT_CLASSE`.codeetudiant where `ETUDIANT_CLASSE`.classecode =" . $classe . " and `ETUDIANT_CLASSE`.codeetudiant = " . $codeEtu);
    $etud->execute();
    $et = $etud->fetchAll(PDO::FETCH_ASSOC);
    return $et;
}

/**
 * Récupère tous les étudiants inscrits dans une classe
 *
 * @return array Un tableau contenant les informations des étudiants
 * récupérés depuis la base de données, sous la forme d'un tableau associatif
 * avec les clés suivantes :
 * - 'codeetudiant' : le code de l'étudiant
 * - 'nom' : le nom de l'étudiant
 * - 'prenom' : le prénom de l'étudiant
 * - 'datenaissance' : la date de naissance de l'étudiant
 * - 'classecode' : le code de la classe dans laquelle l'étudiant est inscrit
 * - 'anneescolaire' : l'année scolaire de l'inscription de l'étudiant dans la classe
 * - 'niveau' : le niveau de la classe dans laquelle l'étudiant est inscrit
 * - 'libelleclasse' : le libellé de la classe dans laquelle l'étudiant est inscrit
 */
function recupere_etudiants()
{
    $req = connexion()->prepare("SELECT * from `ETUDIANT` join `ETUDIANT_CLASSE` on `ETUDIANT_CLASSE`.codeetudiant = `ETUDIANT`.codeetudiant join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode;");
    $req->execute();
    $r = $req->fetchAll(PDO::FETCH_ASSOC);
    return $r;
}

/**
 * Récupère les informations d'un étudiant et de sa classe à partir de son identifiant
 *
 * @param int $id L'identifiant de l'étudiant à récupérer
 *
 * @return array|false Un tableau associatif contenant les informations de l'étudiant et de sa classe si l'identifiant correspond à un étudiant existant, ou false sinon
 */
function recupere_etudiants_by_id($id)
{
    $req = connexion()->prepare("SELECT * from `ETUDIANT` join `ETUDIANT_CLASSE` on `ETUDIANT_CLASSE`.codeetudiant = `ETUDIANT`.codeetudiant join `CLASSE` on `CLASSE`.classecode = `ETUDIANT_CLASSE`.classecode where `ETUDIANT`.codeetudiant = :id");
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $r = $req->fetch(PDO::FETCH_ASSOC);
    return $r;
}

/**
 * Modifie les informations d'un étudiant dans la base de données.
 *
 * @param int $codeetudiant L'identifiant de l'étudiant à modifier.
 *
 * @return bool Retourne true si la modification s'est bien passée, sinon false.
 * @throws PDOException Si une erreur PDO se produit lors de la modification.
 */
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

/**
 * Supprime un étudiant de la base de données.
 *
 * @param int $codeetudiant Le code de l'étudiant à supprimer.
 *
 * @return PDOStatement|false Retourne un objet PDOStatement si la suppression s'est déroulée avec succès, ou false si une erreur est survenue.
 */
function supprimer_etudiant($codeetudiant)
{
    $supp_etud = connexion()->prepare("DELETE from `ETUDIANT` WHERE codeetudiant =:codeetud");
    $supp_etud->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
    $supp_etud->execute();
    return $supp_etud;
}

/**
 * Récupère les informations sur les enseignants d'une classe et les matières qu'ils enseignent.
 *
 * @param int $classe Le code de la classe pour laquelle récupérer les informations.
 * @return array Un tableau associatif contenant les informations sur les enseignants et les matières qu'ils enseignent.
 */
function recupere_enseigner($classe)
{
    $mat = connexion()->prepare("SELECT `CodeEnseignant`, `classecode`,`ENSEIGNER`.`CodeMatiere`,`LibMatiere` FROM `ENSEIGNER` join `MATIERE` on ENSEIGNER.CodeMatiere = MATIERE.CodeMatiere where ENSEIGNER.CLASSECODE =" . $classe);
    $mat->execute();
    $m = $mat->fetchAll(PDO::FETCH_ASSOC);
    return $m;
}

/**
 * Vérifie si une association enseignant-matière-classe existe dans la table ENSEIGNER
 *
 * @param int $classe : le code de la classe
 * @param int $matiere : le code de la matière
 * @param int $enseignant : le code de l'enseignant
 * @return mixed : un tableau associatif contenant les données de l'association s'il existe, false sinon
 */
function verif_enseigner_existe($classe, $matiere, $enseignant) {
    $recup_enseigner = connexion()->prepare("SELECT * FROM `ENSEIGNER` WHERE `classecode` = " . $classe . " AND `CodeEnseignant` = " . $enseignant . " AND `CodeMatiere` = " . $matiere . "");
    $recup_enseigner->execute();
    return  $recup_enseigner->fetch(PDO::FETCH_ASSOC);
}

/**
 * Insère une ligne dans la table ENSEIGNER avec les valeurs de classe, matière et enseignant spécifiées.
 * 
 * @param int $classe Le code de la classe à insérer.
 * @param int $matiere Le code de la matière à insérer.
 * @param int $enseignant Le code de l'enseignant à insérer.
 * @return PDOStatement|false Retourne un objet PDOStatement si la requête est exécutée avec succès, ou false si une erreur survient.
 */
function insert_enseigner($classe, $matiere, $enseignant)
{
    $inserer = connexion()->prepare("INSERT INTO `ENSEIGNER`(classecode,CodeMatiere,CodeEnseignant) VALUES(:classe,:matiere,:enseignant)");
    $inserer->bindParam(':classe', $classe, PDO::PARAM_INT);
    $inserer->bindParam(':matiere', $matiere, PDO::PARAM_INT);
    $inserer->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $inserer->execute();
    return $inserer;
}

/**
 * * Créer par : Théo mouty
 * 
 * Méthode qui permet de supprimer toutes les affectations d'un enseignant à une classe
 * @param $classe - Code de la classe
 * @param $enseignant - Code de l'enseignant
 * @return bool
 */
function supprimer_affectation_enseignant_classe($enseignant, $classe) {
    try{
    $us = connexion()->prepare("DELETE FROM `ENSEIGNER` WHERE `CodeEnseignant` = :enseignant AND `classecode` = :classe");
    $us->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $us->bindParam(':classe', $classe, PDO::PARAM_INT);
    $us->execute();
    return true;
    } catch (Exception $e) {
        return $e;
    }
}

/**
 * * Créer par : Théo mouty
 * 
 * Méthode qui permet de voir si une affectation d'un enseignant à une classe et une matière existe
 * @param $classe - Code de la classe
 * @param $matiere - Code de la matière
 * @param $enseignant - Code de l'enseignant
 * @return bool
 */
function verif_existe_affectation_enseignant_classe_matiere($classe, $matiere, $enseignant) {
    $recup_enseigner = connexion()->prepare("SELECT * FROM `ENSEIGNER` WHERE `classecode` = :classe AND `CodeEnseignant` = :enseignant AND `CodeMatiere` = :matiere");
    $recup_enseigner->bindParam(':classe', $classe, PDO::PARAM_INT);
    $recup_enseigner->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $recup_enseigner->bindParam(':matiere', $matiere, PDO::PARAM_INT);
    $recup_enseigner->execute();
    return  $recup_enseigner->fetch(PDO::FETCH_ASSOC);
}

/**
 *  * Créer par : Théo mouty
 * 
 * Méthode qui permet de supprimer une affectation d'un enseignant à une classe et une matière
 * @param $classe - Code de la classe
 * @param $matiere - Code de la matière
 * @param $enseignant - Code de l'enseignant
 */
function supprimer_affecation_enseignant_classe_matiere($classe, $matiere, $enseignant)
{
    $supp_affecation = connexion()->prepare("DELETE FROM `ENSEIGNER` WHERE `classecode` = :classe AND `CodeEnseignant` = :enseignant AND `CodeMatiere` = :matiere");
    $supp_affecation->bindParam(':classe', $classe, PDO::PARAM_INT);
    $supp_affecation->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $supp_affecation->bindParam(':matiere', $matiere, PDO::PARAM_INT);
    $supp_affecation->execute();
    return $supp_affecation;
}

/**
 * Créer par : Théo mouty
 * 
 * Fonction qui permet d'insérer un étudiant dans la base de données
 * @param $nom - Nom de l'étudiant
 * @param $prenom - Prénom de l'étudiant
 * @param $date - Date de naissance de l'étudiant
 * @param $classe - Code de la classe de l'étudiant
 * @param $numero_national - Numéro national de l'étudiant (pas obligatoire)
 * @return bool true si l'insertion s'est bien passée, false sinon
 * 
 */
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

    // On vérifire si l'insertion a bien été faite
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

/**
 * Récupère les notes d'un étudiant donné.
 *
 * @param int $codeetudiant Le code de l'étudiant.
 * @return array Tableau associatif contenant les informations des notes de l'étudiant.
 */
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

/**
 * Insère ou met à jour les notes d'un étudiant pour une matière et une classe données.
 *
 * @param int $semestre1 La note du semestre 1.
 * @param int $semestre2 La note du semestre 2.
 * @param int $semestre3 La note du semestre 3.
 * @param int $semestre4 La note du semestre 4.
 * @param string $appreciation L'appréciation générale pour l'étudiant.
 * @param int $codeetudiant Le code de l'étudiant concerné.
 * @param int $codematiere Le code de la matière concernée.
 * @param int $codeclasse Le code de la classe concernée.
 * @return PDOStatement|false Retourne l'objet PDOStatement représentant la requête préparée en cas de succès, ou false en cas d'échec.
 */
function note_saisie($semestre1, $semestre2, $semestre3, $semestre4, $appreciation, $codeetudiant, $codematiere, $codeclasse)
{
    $note = connexion()->prepare("INSERT INTO `NOTE_ETUDIANT`(Semestre1,Semestre2,Semestre3,Semestre4,Appreciation,CodeEtudiant,CodeMatiere,Classecode) values(:S1,:S2,:S3,:S4,:app,:codeetud,:codemat,:codeclas) on duplicate key update Semestre1 = :S1, Semestre2 = :S2, Semestre3 = :S3 , Semestre4 = :S4, Appreciation=:app");
    $note->bindParam(':S1', $semestre1, PDO::PARAM_INT);
    $note->bindParam(':S2', $semestre2, PDO::PARAM_INT);
    $note->bindParam(':S3', $semestre3, PDO::PARAM_INT);
    $note->bindParam(':S4', $semestre4, PDO::PARAM_INT);
    $note->bindParam(':app', $appreciation, PDO::PARAM_STR);
    $note->bindParam(':codeetud', $codeetudiant, PDO::PARAM_INT);
    $note->bindParam(':codemat', $codematiere, PDO::PARAM_INT);
    $note->bindParam(':codeclas', $codeclasse, PDO::PARAM_INT);
    $note->execute();
    return $note;
}

/**
 * Ajoute un étudiant à la base de données et l'insère dans une classe
 *
 * @param string $NOMETUDIANT Nom de l'étudiant
 * @param string $PRENOMETUDIANT Prénom de l'étudiant
 * @param string $datedenaissance Date de naissance de l'étudiant (format : YYYY-MM-DD)
 * @param int $Numeronational Numéro national de l'étudiant
 * @return PDOStatement Renvoie l'objet PDOStatement correspondant à l'ajout de l'étudiant
 */
function ajouter_etudiant_csv($NOMETUDIANT, $PRENOMETUDIANT, $datedenaissance, $Numeronational) {
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

/**
 * Récupère les informations d'un utilisateur à partir de son adresse email.
 *
 * @param string $email l'adresse email de l'utilisateur à récupérer
 *
 * @return array les informations de l'utilisateur, sous forme d'un tableau associatif,
 *               ou un tableau vide s'il n'existe pas d'utilisateur avec cette adresse email.
 *               Les clés du tableau sont : ID, EMAIL, NOM, PRENOM, MDP et Permission.
 */
function recupere_user($email) {
    $us = connexion()->prepare("SELECT * FROM UTILISATEUR WHERE EMAIL = :username");
    $us->bindParam(':username', $email, PDO::PARAM_STR);
    $us->execute();
    $m = $us->fetch(PDO::FETCH_ASSOC);
    if (!empty($m)) {
        return $m;
    }
    // return : Array ( [ID] => 6 [EMAIL] => test@test.fr [NOM] => root [PRENOM] => root [MDP] => $2y$10$lwlgaraStCBYrHzgpeJLOeZIQnxk2NKqrh9WjS5P.vbgRLOBGgnB2 [Permission] => 0 )
    return array(
        "ID" => 0,
        "EMAIL" => "",
        "NOM" => "",
        "PRENOM" => "",
        "MDP" => '',
        "Permission" => 0
    );
}


/**
 * Créer par : Théo mouty
 * 
 * Méthode qui permet de créer un utilisateur
 * @param $email : email de l'utilisateur
 * @param $nom : nom de l'utilisateur
 * @param $prenom : prénom de l'utilisateur
 * @param $password : mot de passe de l'utilisateur
 * @return : retourne un tableau contenant les informations de l'utilisateur
 */
function insert_user($email,$nom,$prenom,$password) {
    $us = connexion()->prepare("INSERT INTO UTILISATEUR (NOM,PRENOM,EMAIL,MDP) VALUES (:nom,:prenom,:email,:password)");
    $us->bindParam(':nom', $nom, PDO::PARAM_STR);
    $us->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->bindParam(':password', $password, PDO::PARAM_STR);
    $us->execute();
    return $us;
}

/**
 * Créer par : Théo mouty
 * 
 * Méthode qui permet de mettre à jour un utilisateur
 * @param $email : email de l'utilisateur
 * @param $nom : nom de l'utilisateur
 * @param $prenom : prénom de l'utilisateur
 * @param $ancien_email : ancien email de l'utilisateur
 * @return : retourne un tableau contenant les informations de l'utilisateur
 */
function update_user($email, $prenom, $nom, $ancien_email) {
    $us = connexion()->prepare("UPDATE UTILISATEUR set NOM = :nom, PRENOM = :prenom, EMAIL = :email WHERE EMAIL = :ancien_email");
    $us->bindParam(':nom', $nom, PDO::PARAM_STR);
    $us->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->bindParam(':ancien_email', $ancien_email, PDO::PARAM_STR);
    $us->execute();
    return $us;
}

/**
 * Créer par : Théo mouty
 *
 * Méthode qui permet de récupérer le niveau d'un utilisateur
 * @param $email : email de l'utilisateur
 * @return : retourne le niveau de l'utilisateur
 * @return : 0 si l'utilisateur n'existe pas
 */
function getPermission($email){
    $us = connexion()->prepare("SELECT Permission FROM UTILISATEUR WHERE EMAIL = :email");
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->execute();
    $m = $us->fetch(PDO::FETCH_ASSOC);
    if (!empty($m)) {
        return $m['Permission'];
    }
    return "0";
}


/**
 * Créer par : Théo mouty
 * 
 * Méthode qui permet de vérifier si un utilisateur existe
 * @param $email : email de l'utilisateur
 * @return : True si l'utilisateur existe
 * @return : False si l'utilisateur n'existe pas
 */
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

/**
 * Met à jour le mot de passe d'un utilisateur dans la base de données
 *
 * @param string $mdp Le nouveau mot de passe de l'utilisateur
 * @param string $email L'email de l'utilisateur dont le mot de passe doit être mis à jour
 *
 * @return PDOStatement|false Retourne l'objet PDOStatement en cas de succès ou false en cas d'erreur
 */
function update_pw($mdp, $email) {
    $us = connexion()->prepare("UPDATE UTILISATEUR set MDP = :password WHERE EMAIL = :email");
    $us->bindParam(':password', $mdp, PDO::PARAM_STR);
    $us->bindParam(':email', $email, PDO::PARAM_STR);
    $us->execute();
    return $us;
}


/**
 * Génère une chaîne aléatoire de caractères alphanumériques.
 *
 * @param int $length La longueur de la chaîne aléatoire à générer (par défaut 6).
 * @return string La chaîne aléatoire générée.
 */
function kodex_random_string($length=6){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for($i=0; $i<$length; $i++){
        $string .= $chars[rand(0, strlen($chars)-1)];
    }
    return $string;
}


/**
 * Récupère les classes d'un enseignant
 *
 * @param int $enseignant L'ID de l'enseignant
 * @return array Un tableau contenant les informations des classes de l'enseignant, ou un tableau vide si aucun résultat n'est trouvé.
 */
function recupere_classe_enseignant($enseignant){
    $us = connexion()->prepare("SELECT * FROM `ENSEIGNER` WHERE `CodeEnseignant` = :enseignant");
    $us->bindParam(':enseignant', $enseignant, PDO::PARAM_INT);
    $us->execute();
    $m = $us->fetchAll(PDO::FETCH_ASSOC);
    $enseignant_classes = array();
    foreach ($m as $element) {
        if (count($enseignant_classes) == 0) {
          $enseignant_classes[] = array(
            "classecode" => $element["classecode"],
            "CodeEnseignant" => $element["CodeEnseignant"],
            "CodeMatiere" => array($element["CodeMatiere"])
          );
        } else {
          $i = 0;
          $trouve = false;
          while ($i < count($enseignant_classes) && !$trouve) {
            if ($enseignant_classes[$i]["classecode"] == $element["classecode"]) {
              $trouve = true;
              $enseignant_classes[$i]["CodeMatiere"][] = $element["CodeMatiere"];
            }
            $i++;
          }
          if (!$trouve) {
            $enseignant_classes[] = array(
              "classecode" => $element["classecode"],
              "CodeEnseignant" => $element["CodeEnseignant"],
              "CodeMatiere" => array($element["CodeMatiere"])
            );
          }
        }
      }
    if (!empty($enseignant_classes)) {
        return $enseignant_classes;
    }
    return array(
        "CodeEnseignant" => 0,
        "CodeMatiere" => [],
        "classecode" => ""
    );
}

/**
 * Récupère la moyenne de l'étudiant en divisant sa moyenne par la moyenne de la classe pour chaque matière.
 *
 * @param int $codeetudiant Le code de l'étudiant
 *
 * @return PDOStatement|null La requête PDO qui contient les informations de la moyenne de l'étudiant ou NULL si l'étudiant n'a pas de moyenne.
 */
function moyennea10($codeetudiant) {
    // récupération de l'étudiant dans la étudiant
    $etudiant = connexion()->prepare("SELECT M.classecode, codeetudiant, M.codematiere, ROUND((moyetudiant2*10)/moyenneClasseMatiere,1) AS MoyenneFinale FROM MOYENNEELEVE M JOIN vMoyeneClasseParMatiere V ON (V.codematiere=M.codematiere and M.classecode=V.classecode) WHERE codeetudiant=:codeetudiant group by M.classecode,M.codematiere, codeetudiant");
    $etudiant->bindParam(':codeetudiant', $codeetudiant, PDO::PARAM_INT);
    $etudiant->execute();
    return $etudiant;
}

/**

  * Récupère la moyenne annuelle d'un étudiant pour chaque matière pour l'année 1.
  * @param int $codeetudiant le code de l'étudiant dont on veut récupérer les moyennes
  * @return PDOStatement un objet PDOStatement contenant les résultats de la requête SQL
    */
function moyenneAnnee1($codeetudiant) {
    // récupération de l'étudiant dans la étudiant
    $etudiant1 = connexion()->prepare("SELECT codeetudiant,codematiere,ROUND(SUM(semestre1+ semestre2)/2,1) AS moyetudiant
        From NOTE_ETUDIANT
        WHERE codeetudiant = :codeetudiant
        group by codeetudiant,codematiere;");
    $etudiant1->bindParam(':codeetudiant', $codeetudiant, PDO::PARAM_INT);
    $etudiant1->execute();
    return $etudiant1;
}

/**
 * Récupère les moyennes des matières pour un étudiant pour le deuxième semestre
 *
 * @param int $codeetudiant Le code de l'étudiant dont on veut récupérer les moyennes
 *
 * @return PDOStatement|false Retourne une instance de PDOStatement si la requête est exécutée avec succès, false sinon.
 */
function moyenneAnnee2($codeetudiant) {
    // récupération de l'étudiant dans la étudiant
    $etudiant2 = connexion()->prepare("SELECT codeetudiant,codematiere,ROUND(SUM(semestre3+ semestre4)/2,1) AS moyetudiant
        From NOTE_ETUDIANT
        WHERE codeetudiant = :codeetudiant
        group by codeetudiant,codematiere;");
    $etudiant2->bindParam(':codeetudiant', $codeetudiant, PDO::PARAM_INT);
    $etudiant2->execute();
    return $etudiant2;
}

/**
 * Cette fonction permet de récupérer la moyenne de chaque classe pour chaque matière
 *
 * @return array|false Retourne un tableau associatif contenant la moyenne de chaque classe pour chaque matière
 * ou false si la requête échoue
 */
function recupere_moy_classeMat() {
    $MoyClassM = connexion()->prepare("SELECT classecode, codematiere ,TOTAL/nbNote as moyenneMatiere FROM `vtotNoteParClasseEtMatiere` group by classecode, codematiere;");
    $MoyClassM->execute();
    return $MoyClassM->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère la moyenne de chaque matière pour une classe donnée.
 *
 * @param int $classecode Le code de la classe pour laquelle récupérer la moyenne.
 *
 * @return PDOStatement|false Retourne une instance de PDOStatement en cas de succès, ou false en cas d'échec.
 */
function recuperer_MoyParClasse($classecode) {
    $recup_class = connexion()->prepare("SELECT classecode, codematiere ,TOTAL/nbNote as moyenneMatiere FROM `vtotNoteParClasseEtMatiere` WHERE classecode =:codeclass group by classecode, codematiere");
    $recup_class->bindParam(':codeclass', $classecode, PDO::PARAM_INT);
    $recup_class->execute();
    return $recup_class;
}

/**
 * Cette fonction appelle une procédure stockée pour calculer la note de chaque élève dans chaque matière d'une classe donnée.
 * @param int $classecode Le code de la classe pour laquelle on souhaite calculer les notes.
 * @return PDOStatement Retourne un objet PDOStatement contenant les résultats de la procédure.
 */
function procedure_NoteparClasseetMatiere($classecode) {
    $appelprocedure = connexion()->prepare("Call NoteparClasseetMatiere(:classecode)");
    $appelprocedure->bindParam(':classecode', $classecode);
    $appelprocedure->execute();
    return $appelprocedure;
}

/**
 * Calcule la moyenne de chaque classe pour chaque matière pour la première année.
 *
 * @return PDOStatement|false Retourne un objet PDOStatement représentant un jeu de résultats ou false si une erreur survient.
 */
function MoyenneparClasse1erAnnee() {
    $recup_class = connexion()->prepare("select `NOTE_ETUDIANT`.`classecode` AS `classecode`,`NOTE_ETUDIANT`.`codematiere` AS `codematiere`,sum(`NOTE_ETUDIANT`.`Semestre1` + `NOTE_ETUDIANT`.`Semestre2`) / 2 AS `TOTAL`,count(0) AS `nbNote` from `NOTE_ETUDIANT` group by `NOTE_ETUDIANT`.`classecode`,`NOTE_ETUDIANT`.`codematiere`");
    $recup_class->execute();
    return $recup_class;
}