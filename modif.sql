DELETE FROM `CLASSE_MATIERE`;
DELETE FROM `ETUDIANT_CLASSE`;
DELETE FROM `NOTE_ETUDIANT`;
DELETE FROM `ENSEIGNER`;
DELETE FROM `ENSEIGNANT`;
DELETE FROM `CLASSE`;
DELETE FROM `MATIERE`;
DELETE FROM `ETUDIANT`;


INSERT INTO `ETUDIANT` (`codeetudiant`, `NOMETUDIANT`, `PRENOMETUDIANT`, `datedenaissance`, `Numeronational`) VALUES
(1, 'VARELA-TAVARES', 'Catia', '2002-01-12', ''),
(2, 'MOUTHY', 'Théo', '2004-10-01', ''),
(3, 'AZZEDDINE', 'Amine', '2001-02-07', ''),
(4, 'CARNI-LAGARDE', 'Jayson', '2001-05-11', ''),
(5, 'PUCHAUX', 'Baptiste', '2003-01-16', ''),
(6, 'GRAIET', 'Ouassila', '2004-08-05', ''),
(7, 'DAKI', 'Maël', '2001-06-03', ''),
(8, 'SACHETTO', 'Yoan', '2003-11-16', ''),
(9, 'RICCA', 'Dana', '2004-12-03', ''),
(10, 'BEN SETHOUM', 'Eya', '2004-08-18', ''),
(11, 'NAAMANE', 'André', '2004-11-10', ''),
(12, 'TRIKI', 'Aurélie', '2001-08-16', ''),
(13, 'ESSALAH', 'Méric', '2003-02-22', ''),
(14, 'ANANI', 'Mathilda', '2004-03-26', '');


INSERT INTO `MATIERE` (`CodeMatiere`, `LibMatiere`) VALUES
(1, 'Mathématiques'),
(2, 'Langue vivante1'),
(3, 'Comptabilite et audit'),
(4, 'Culture G'),
(5, 'Culture economique juridique et manageriale'),
(6, 'Bloc 1'),
(7, 'Bloc 2: SLAM/SISR'),
(8, 'Bloc 3: Cybersecurite'),
(9, 'Droit general et droit notarial'),
(10, 'CEJM Appliquee'),
(11, 'Langue vivante 2'),
(12, 'environnement économique et managérial du notariat');


INSERT INTO `CLASSE` (`classecode`, `Libelleclasse`, `specialite`, `Annee`, `Libellecourt`) VALUES
(1, 'Brevet de technicien superieur', 'Services informatiques aux organisations', 1, 'BTS1SIO1'),
(2, 'Brevet de technicien superieur', 'Notariat', 1, 'BTS1NOT1'),
(3, 'Brevet de technicien superieur', 'Services informatiques aux organisations', 2, 'BTS2SIO'),
(4, 'Brevet de technicien superieur', 'Notariat', 2, 'BTS2NOT'),
(5, 'Brevet de technicien superieur', 'Support a l\'Action Manageriale', 1, 'BTS1SAM1'),
(6, 'Brevet de technicien superieur', 'Support a l\'Action Manageriale', 2, 'BTS2SAM'),
(7, 'Brevet de technicien superieur', 'Services et prestations des secteurs sanitaire et social', 2, 'BTS2SP3S'),
(8, 'Brevet de technicien superieur', 'Services et prestations des secteurs sanitaire et social', 1, 'BTS1SP3S1'),
(9, 'Brevet de technicien superieur', 'Comptabilite et gestion', 1, 'BTS1CG1'),
(10, 'Brevet de technicien superieur', 'Comptabilite et gestion', 2, 'BTS2CG');


INSERT INTO `CLASSE_MATIERE` (`classecode`, `CodeMatiere`) VALUES
(3, 1),
(3, 2),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 10),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(4, 9),
(4, 12);


INSERT INTO `ENSEIGNANT` (`CodeEnseignant`, `NOM`, `PRENOM`) VALUES
(1, 'Novales', 'Corrine'),
(2, 'Sainsaulieu', 'tt'),
(3, 'Ghionda', 'Estelle'),
(4, 'Confusus', 'Benoît'),
(5,'Delmas', 'Michel'),
(6,'Cyrano', 'Laurent'),
(7, 'Puyol', 'André');


INSERT INTO `ENSEIGNER` (`classecode`, `CodeEnseignant`, `CodeMatiere`) VALUES
(3, 4, 1),
(3, 5, 2),
(3, 7, 4),
(3, 1, 6),
(3, 1, 7),
(3, 1, 8),
(3, 2, 6),
(3, 2, 7),
(3, 2, 8),
(3, 3, 5),
(3, 3, 10),
(4, 4, 1),
(4, 5, 2),
(4, 7, 4),
(4, 6, 5),
(4, 6, 9),
(4, 6, 12);


INSERT INTO `ETUDIANT_CLASSE` (`codeetudiant`, `classecode`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4);





INSERT INTO `NOTE_ETUDIANT` (`NoteCode`, `Semestre1`, `Semestre2`, `Appreciation`, `Semestre3`, `Semestre4`, `codeetudiant`, `codematiere`, `classecode`) VALUES
(93, 12, 9, 'test app 1', '17', '15', 1, 1, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 2, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 4, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 5, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 6, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 7, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 8, 3),
(93, 12, 9, 'test app 1', '17', '15', 1, 10, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 1, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 2, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 4, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 5, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 6, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 7, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 8, 3),
(94, 10, 13, 'test app 1', '14', '12', 2, 10, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 1, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 2, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 4, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 5, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 6, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 7, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 8, 3),
(95, 12, 12, 'test app 1', '8', '9', 3, 10, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 1, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 2, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 4, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 5, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 6, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 7, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 8, 3),
(96, 13, 11, 'test app 1', '9', '10', 4, 10, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 1, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 2, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 4, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 5, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 6, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 7, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 8, 3),
(97, 9.5, 11.5, 'test app 1', '10.5', '12', 5, 10, 3),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 1, 4),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 2, 4),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 4, 4),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 5, 4),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 9, 4),
(98, 7, 6, 'test app 1', '8', '4.75', 6, 12, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 1, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 2, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 4, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 5, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 9, 4),
(99, 9, 11, 'test app 1', '17', '14', 7, 12, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 1, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 2, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 4, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 5, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 9, 4),
(100, 13, 11, 'test app 1', '14', '12', 8, 12, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 1, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 2, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 4, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 5, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 9, 4),
(101, 18, 15, 'test app 1', '12', '14', 9, 12, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 1, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 2, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 4, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 5, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 9, 4),
(102, 15, 16, 'test app 1', '18', '12', 10, 12, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 1, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 2, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 4, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 5, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 9, 4),
(103, 14.5, 15, 'test app 1', '15', '13.5', 11, 12, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 1, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 2, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 4, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 5, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 9, 4),
(104, 17.5, 15, 'test app 1', '14', '12', 12, 12, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 1, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 2, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 4, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 5, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 9, 4),
(105, 5.5, 14, 'test app 1', '12', '14', 13, 12, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 1, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 2, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 4, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 5, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 9, 4),
(106, 11.5, 13, 'test app 1', '18', '12', 14, 12, 4);