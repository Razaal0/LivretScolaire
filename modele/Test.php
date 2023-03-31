<?php

require './BDD.php';

$classecode = $_GET['classe'];
$codeetudiant = $_GET['codeetud'];
$matiere = recupere_matieres_by_eleve($codeetudiant);
$moyenne = moyenneAnnee2($codeetudiant);
$moyennea10 = moyennea10($codeetudiant);
$classe = procedure_NoteparClasseetMatiere($classecode);

// Définir les données pour le graphique
foreach ($matiere as $m) {
    $matieres[] = $m['LibMatiere'];
}

if ($classecode == 3) {
    foreach ($moyennea10 as $moy10) {
        $notes[] = $moy10['MoyenneFinale'];
    }
} else {
    foreach ($moyenne as $moy) {
        $notes[] = $moy['moyetudiant'];
    }
}

foreach ($classe as $cla) {
    $notes1[] = $cla['moyenneMatiere'];
}

// Créer une image de 1280x720 pixels
$largeur = 1280;
$hauteur = 720 + 250;
$image = imagecreate($largeur, $hauteur);
// Définir les couleurs
$blanc = imagecolorallocate($image, 255, 255, 255);
$noir = imagecolorallocate($image, 0, 0, 0);
$gris = imagecolorallocate($image, 200, 200, 200);
$bleu = imagecolorallocate($image, 0, 0, 255);
$rouge = imagecolorallocate($image, 255, 0, 0);
$vert = imagecolorallocate($image, 170, 0, 170 );
$couleurmc= imagecolorallocate($image,0, 170, 0);
// Dessiner un rectangle blanc pour le fond
imagefilledrectangle($image, 0, 0, $largeur, $hauteur, $blanc);
// Déterminer les valeurs minimales et maximales des axes des abscisses et des ordonnées
$x_min = 0;
$x_max = count($matieres) - 1;
$y_min = 0;
$y_max = 20;
// Dessiner la grille de fond
for ($i = $y_min; $i <= $y_max; $i++) {
    if ($i == 10) {
        imagesetthickness($image, 2);
        imageline($image, 75, $hauteur - 50 - $i * 30, $largeur - 50, $hauteur - 50 - $i * 30, $rouge);
    } else {
        imagesetthickness($image, 2);
        imageline($image, 75, $hauteur - 50 - $i * 30, $largeur - 50, $hauteur - 50 - $i * 30, $gris);
    }
}
for ($i = 0; $i < count($matieres); $i++) {
    imageline($image, 110 + $i * 80, $hauteur - 65, 110 + $i * 80, 310, $gris);
}
// Dessiner l'axe des ordonnées
imageline($image, 75, 310, 75, $hauteur - 50, $noir);
for ($i = 0; $i <= $y_max; $i++) {
    imageline($image, 70, $hauteur - 50 - $i * 30, 75, $hauteur - 50 - $i * 30, $noir);
    imagestring($image, 3, 30, $hauteur - 58 - $i * 30, strval($i), $noir);
}
// Dessiner l'axe des abscisses
imageline($image, 75, $hauteur - 50, $largeur - 50, $hauteur - 50, $noir);
for ($i = 0; $i < count($matieres); $i++) {
    $x = 110 + $i * 80;
    imageline($image, $x, $hauteur - 65, $x, $hauteur - 50, $noir);
    imagestringup($image, 3, $x - 7, $hauteur - 665, $matieres[$i], $noir);
}
// Dessiner les points pour chaque matière
for ($i = 0; $i < count($notes); $i++) {

    $x = 110 + $i * 80;
    $y = $hauteur - 50 - $notes[$i] * 30;
    imagefilledellipse($image, $x, $y, 10, 10, $bleu);
//    imagestring($image, 3, $x-10, $y-20, strval($notes[$i]), $bleu);  Sert à afficher les notes sur les points du graphique
}
// Relier les points par des lignes noires
for ($i = 0; $i < count($notes) - 1; $i++) {
    $x1 = 110 + $i * 80;
    $y1 = $hauteur - 50 - $notes[$i] * 30;
    $x2 = 110 + ($i + 1) * 80;
    $y2 = $hauteur - 50 - $notes[$i + 1] * 30;
    imageline($image, $x1, $y1, $x2, $y2, $couleurmc);
}
// Dessiner les points pour chaque matière
for ($i = 0; $i < count($notes1); $i++) {

    $x = 110 + $i * 80;
    $y = $hauteur - 50 - $notes1[$i] * 30;
    imagefilledellipse($image, $x, $y, 10, 10, $bleu);
//    imagestring($image, 3, $x-10, $y-20, strval($notes[$i]), $bleu);  Sert à afficher les notes sur les points du graphique
}
// Relier les points par des lignes rouges
for ($i = 0; $i < count($notes1) - 1; $i++) {
    $x1 = 110 + $i * 80;
    $y1 = $hauteur - 50 - $notes1[$i] * 30;
    $x2 = 110 + ($i + 1) * 80;
    $y2 = $hauteur - 50 - $notes1[$i + 1] * 30;
    imageline($image, $x1, $y1, $x2, $y2, $vert);
}
// Dessiner la légende
$legende = array("Moyenne de l'eleve");

$couleur_legende = imagecolorallocate($image, 0, 0, 0);
$texte_legende = "";
$largeur_legende = imagefontwidth(5) * strlen($texte_legende);
$x_legende = 75;
$y_legende = $hauteur - 20;
imagestring($image, 5, $x_legende, $y_legende, $texte_legende, $couleur_legende);

for ($i = 0; $i < count($legende); $i++) {
    $x_legende += 50;
    $couleur_barre = $couleurmc;
    imagefilledrectangle($image, $x_legende, $y_legende - 10, $x_legende + 30, $y_legende, $couleur_barre);
    imagestring($image, 5, $x_legende + 35, $y_legende - 10, $legende[$i], $couleur_legende);
}

// Dessiner la légende
$legende2 = array("Moyenne de la classe");
$couleur_legende2 = imagecolorallocate($image, 0, 0, 0);
$texte_legende2 = "";
$largeur_legende2 = imagefontwidth(5) * strlen($texte_legende2);
$x_legende2 = 75;
$y_legende2 = $hauteur - 20;
imagestring($image, 5, $x_legende2, $y_legende2, $texte_legende2, $couleur_legende2);

for ($i = 0; $i < count($legende2); $i++) {
    $x_legende2 += 350;
    $couleur_barre2 = $vert;
    imagefilledrectangle($image, $x_legende2, $y_legende2 - 10, $x_legende2 + 30, $y_legende2, $couleur_barre2);
    imagestring($image, 5, $x_legende2 + 35, $y_legende2 - 10, $legende2[$i], $couleur_legende2);
}





// Afficher l'image
header('Content-type: image/png');
imagepng($image);
// Libérer la mémoire
imagedestroy($image);
?>


