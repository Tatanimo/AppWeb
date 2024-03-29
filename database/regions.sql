LOCK TABLES `regions` WRITE;
INSERT INTO `regions` (`code`, `name`, `slug`) VALUES
('01', 'Guadeloupe', 'guadeloupe'),
('02', 'Martinique', 'martinique'),
('03', 'Guyane', 'guyane'),
('04', 'La Réunion', 'la reunion'),
('06', 'Mayotte', 'mayotte'),
('11', 'Île-de-France', 'ile de france'),
('24', 'Centre-Val de Loire', 'centre val de loire'),
('27', 'Bourgogne-Franche-Comté', 'bourgogne franche comte'),
('28', 'Normandie', 'normandie'),
('32', 'Hauts-de-France', 'hauts de france'),
('44', 'Grand Est', 'grand est'),
('52', 'Pays de la Loire', 'pays de la loire'),
('53', 'Bretagne', 'bretagne'),
('75', 'Nouvelle-Aquitaine', 'nouvelle aquitaine'),
('76', 'Occitanie', 'occitanie'),
('84', 'Auvergne-Rhône-Alpes', 'auvergne rhone alpes'),
('93', 'Provence-Alpes-Côte d\'Azur', 'provence alpes cote dazur'),
('94', 'Corse', 'corse'),
('COM', 'Collectivités d\'Outre-Mer', 'collectivites doutre mer');
UNLOCK TABLES;