<?php

require_once('../view/includes/fpdf/MYPDF.php');
require_once('../modele/BDD.php');
$etud_note = recupere_notes($_GET['codeetud']);
$class_etud = recupere_classe_etud($_GET['codeetud']);
$matieres = recupere_matieres_by_eleve($_GET['codeetud']);
$MOY_annee1 = moyenneAnnee1($_GET['codeetud']);
$MOY_annee2 = moyenneAnnee2($_GET['codeetud']);
//echo json_encode($MOY_annee2);
//exit;

// create pdf
$pdf=new MYPDF('L','mm','A4');
$pdf->SetFont('Arial','B',10);
$pdf->AliasNbPages();
$pdf->SetMargins($pdf->left, $pdf->top, $pdf->right); 
$pdf->AddPage();

// Insère un logo en haut à gauche à 300 dpi
$pdf->Image('../view/logo.png', 1, 1, 30, 30, 'PNG');

//$pdf->Cell(0,30,'BREVET DE TECHNICIEN SUPERIEUR:',0,0,'C');
$pdf->Cell(0,30,$class_etud[0]['Libelleclasse'] ,0,0,'C');
//s$pdf->MultiCell(0,6,$risks,1,1,'L');
$pdf->Ln();

// create table
$columns = array();      
   
// header col
$col = array();
$col[] = array('text' => "CACHET DE L'ETABLISSEMENT:", 'width' => '70', 'height' => '18', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'Num INSEE (sur 15 chiffres, avec la cle):', 'width' => '70', 'height' => '18', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "NOM, PRENOM:\n" . $etud_note[0]['NOMETUDIANT'] ." " . $etud_note[0]['PRENOMETUDIANT'] , 'width' => '70', 'height' => '18', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "Date de naissance:\n". $etud_note[0]['datedenaissance'], 'width' => '35', 'height' => '18', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR'); 
$col[] = array('text' => 'LANGUE VIVANTE: '.'Anglais', 'width' => '35', 'height' => '18', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
   
// data col
$col = array();
$col[] = array('text' => 'Classe de (1)', 'width' => '60', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'MATIERES OBLIGATOIRES', 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'Classe de (1)', 'width' => '60', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'APPRECIATIONTS', 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');       
$columns[] = $col;
 
// data col
$col = array();
$col[] = array('text' => '1er (3)', 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '2eme', 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'Moyenne', 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '', 'width' => '70', 'height' => '10', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '1er (3)', 'width' => '20', 'height' => '10', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '2eme', 'width' => '20', 'height' => '10', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'Moyenne', 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => '', 'width' => '90', 'height' => '10', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1 = print_r($matieres[0]['Semestre1'], true);
$semestre2 = print_r($matieres[0]['Semestre2'], true);
$semestre3 = print_r($matieres[0]['Semestre3'], true);
$semestre4 = print_r($matieres[0]['Semestre4'], true);
$apreciation = print_r($matieres[0]['Appreciation'], true);
$matiere = print_r($matieres[0]['LibMatiere'], true);
$moy1 = print_r($MOY_annee1[0]['moyetudiant'], true);
$moy2 = print_r($MOY_annee2[0]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_2 = print_r($matieres[1]['Semestre1'], true);
$semestre2_2 = print_r($matieres[1]['Semestre2'], true);
$semestre3_2 = print_r($matieres[1]['Semestre3'], true);
$semestre4_2 = print_r($matieres[1]['Semestre4'], true);
$apreciation_2 = print_r($matieres[1]['Appreciation'], true);
$matiere_2 = print_r($matieres[1]['LibMatiere'], true);
$moy1_2 = print_r($MOY_annee1[1]['moyetudiant'], true);
$moy2_2 = print_r($MOY_annee2[1]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_2", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_2", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_2", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_3 = print_r($matieres[2]['Semestre1'], true);
$semestre2_3 = print_r($matieres[2]['Semestre2'], true);
$semestre3_3 = print_r($matieres[2]['Semestre3'], true);
$semestre4_3 = print_r($matieres[2]['Semestre4'], true);
$apreciation_3 = print_r($matieres[2]['Appreciation'], true);
$matiere_3 = print_r($matieres[2]['LibMatiere'], true);
$moy1_3 = print_r($MOY_annee1[2]['moyetudiant'], true);
$moy2_3 = print_r($MOY_annee2[2]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_3", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_3", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_3", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_4 = print_r($matieres[2]['Semestre1'], true);
$semestre2_4 = print_r($matieres[2]['Semestre2'], true);
$semestre3_4 = print_r($matieres[2]['Semestre3'], true);
$semestre4_4 = print_r($matieres[2]['Semestre4'], true);
$apreciation_4 = print_r($matieres[2]['Appreciation'], true);
$matiere_4 = print_r($matieres[2]['LibMatiere'], true);
$moy1_4 = print_r($MOY_annee1[2]['moyetudiant'], true);
$moy2_4 = print_r($MOY_annee2[2]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_4", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_4", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_4", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_5 = print_r($matieres[3]['Semestre1'], true);
$semestre2_5 = print_r($matieres[3]['Semestre2'], true);
$semestre3_5 = print_r($matieres[3]['Semestre3'], true);
$semestre4_5 = print_r($matieres[3]['Semestre4'], true);
$apreciation_5 = print_r($matieres[3]['Appreciation'], true);
$matiere_5 = print_r($matieres[3]['LibMatiere'], true);
$moy1_5 = print_r($MOY_annee1[3]['moyetudiant'], true);
$moy2_5 = print_r($MOY_annee2[3]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_5", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_5", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_5", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_6 = print_r($matieres[4]['Semestre1'], true);
$semestre2_6 = print_r($matieres[4]['Semestre2'], true);
$semestre3_6 = print_r($matieres[4]['Semestre3'], true);
$semestre4_6 = print_r($matieres[4]['Semestre4'], true);
$apreciation_6 = print_r($matieres[4]['Appreciation'], true);
$matiere_6 = print_r($matieres[4]['LibMatiere'], true);
$moy1_6 = print_r($MOY_annee1[4]['moyetudiant'], true);
$moy2_6 = print_r($MOY_annee2[4]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_6", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_6", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_6", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;
$semestre1_7 = print_r($matieres[5]['Semestre1'], true);
$semestre2_7 = print_r($matieres[5]['Semestre2'], true);
$semestre3_7 = print_r($matieres[5]['Semestre3'], true);
$semestre4_7 = print_r($matieres[5]['Semestre4'], true);
$apreciation_7 = print_r($matieres[5]['Appreciation'], true);
$matiere_7 = print_r($matieres[5]['LibMatiere'], true);
$moy1_7 = print_r($MOY_annee1[5]['moyetudiant'], true);
$moy2_7 = print_r($MOY_annee2[5]['moyetudiant'], true);
$col = array();
$col[] = array('text' => "$semestre1_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre2_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy1_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$matiere_7", 'width' => '70', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre3_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$semestre4_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$moy2_7", 'width' => '20', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => "$apreciation_7", 'width' => '90', 'height' => '10', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$columns[] = $col;

$col = array();
$col[] = array('text' => "AVIS (4) DU CONSEIL DE CLASSE ET OBSERVATIONS EVENTUELLES", 'width' => '70', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'COTATION DE LA CLASSE', 'width' => '90', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'RESULTATS DE LA SECTION LES 3 DERNIERES ANNEES', 'width' => '70', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
$col[] = array('text' => 'Date, signature du candidat et remarques eventuelles', 'width' => '50', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR'); 
$columns[] = $col;

// Draw Table
$pdf->WriteTable($columns);

// Add a new page
$pdf->AddPage();

// Récupéré le graphique
$_GET['classe'] = $class_etud[0]['classecode'];
require 'Generer_graphique.php';
ob_start();
header('Content-type: image/png');
imagepng($image);
$image_content = ob_get_clean();

// Create a temporary file
$tmp_file = tempnam(sys_get_temp_dir(), 'graph');

// Write the image content to the temporary file
file_put_contents($tmp_file, $image_content);

// Ajoutez l'image dans le pdf :
$pdf->Image($tmp_file, $pdf->GetX(), $pdf->GetY(), 280, 200, 'PNG');

// Delete the temporary file
unlink($tmp_file);

// Show PDF
$pdf->Output();
