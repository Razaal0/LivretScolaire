<?php
require_once '../view/includes/user-session.php';
// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
if (!hasAccess(10)) {
    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
    echo '<meta http-equiv="refresh" content="0; url=/view" />';
    exit();
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link href="styles/cascade.css" rel="stylesheet">
</head>

<body>
    <?php
    //Se connecte à la base de données et récupère le code étudiant et le classe code
    require_once('../modele/BDD.php');
    $codeetudiant = filter_input(INPUT_GET, 'codeetud');
    $cla = $_GET['classe'];
    $etud = asso_cl_et_un_etudiant($cla, $codeetudiant);
    $note = recupere_notes($codeetudiant);
    if (empty($note)) {
        echo "<h3>Cette étudiant à aucune note ou n'existe pas</h3>";
    } else {
    ?>

        <table border="1">
            <tr>
                <?php
                //affiche toutes les informations récupérées sous forme de tableau
                foreach ($etud as $et) {
                ?>
                    <td>Classe: <?php echo $et['Libelleclasse'] ?></td>
                    <td colspan="2">Option :</td>
                    <td colspan="2">Nom: <?php echo $et['NOMETUDIANT'] . ' ' ?>Prénom:<?php echo $et['PRENOMETUDIANT'] ?></td>
                    <td colspan="2">Année: 2022</td>
            </tr>

            <tr>
                <td rowspan="2">Spécialité: <?php echo $et['specialite'] ?></td>
            <?php
                }
            ?>

            <th colspan="3">Classe de 1<sup>ère</sup> Année</th>
            <th rowspan="2">Matières</th>
            <th colspan="3">Classe de 2<sup>ème</sup> Année</th>
            <th rowspan="2">Appréciations</th>
            </tr>
            <tr>
                <th>Semestre 1</th>
                <th>Semestre 2</th>
                <th>Moyenne</th>
                <th>Semestre 1</th>
                <th>Semestre 2</th>
                <th>Moyenne</th>
            </tr>
            <tr>
                <td rowspan="10"> </td>
                <?php
                foreach ($note as $n) {
                ?>
                    <td><?php echo $n['Semestre1'] ?></td>
                    <td><?php echo $n['Semestre2'] ?></td>
                    <td><?php echo ($n['Semestre1'] + $n['Semestre2']) / 2 ?></td>
                    <td><?php echo $n['LibMatiere'] ?></td>
                    <td><?php echo $n['Semestre3'] ?></td>
                    <td><?php echo $n['Semestre4'] ?></td>
                    <td><?php echo round(($n['Semestre3'] + $n['Semestre4']) / 2, 2) ?></td>
                    <td><?php echo $n['Appreciation'] ?></td>
            </tr>
        <?php
                }
        ?>
        </table>
</body>

</html>
<?php
    }
