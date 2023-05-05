<?php
//require_once('../includes/user-session.php');
//// On vérifie que l'utilisateur est connecté et qu'il a les droits pour accéder à cette page
//if (!hasAccess(100)) {
//    add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
//    echo '<meta http-equiv="refresh" content="0; url=/view" />';
//    exit();
//}
?>
<html>
    <body>        
        <title>Classes</title>
        <main id="main" class="">

        <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Liste des classes :</h5>
                    <form name="classe" action="" method="post" >
                        <select name="clas[]" onChange="this.form.submit()" required>
                            <option value ="">Classe :</option>
                            <?php
                            foreach ($classe as $c) {
                                echo "\t" . '<option value=' . $c['classecode'] . '>' . $c['Libellecourt'] . '</option>' . "\n";
                            }
                            ?>
                            <?php
                            $valeur = verif_saisi('clas');
                            $etud = asso_cl_et($valeur);
                            ?>
                        </select>     
                    </form>

        <?php if ($valeur) { ?>
            <h5 class="card-title">Liste des étudiants :</h5>
                        <table>
                            <tr> 
                                <?php
                                foreach ($etud as $et) {
                                    ?>
                                    <td><?php echo $et['NOMETUDIANT']; ?> </td>
                                    <td><?php echo $et['PRENOMETUDIANT']; ?></td>
                                    <td><?php echo '<a href="/modele/Test.php?codeetud=' . $et['codeetudiant'] . '&classe='.$valeur.'">'?>Afficher les graphes <img src="../bootstrap-icons-1.8.3/file-earmark-pdf.svg" height="14" width="25"/></a> </td>
                                    <td><?php echo '<a href="/controller/exporterPDF.php?codeetud=' . $et['codeetudiant'] . '&classe='.$valeur.'">'?>Imprimer en PDF <img src="../bootstrap-icons-1.8.3/file-earmark-pdf.svg" height="14" width="25"/></a> </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </main>
    </body>
</html>
