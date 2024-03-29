LOCK TABLES `family_animals` WRITE;
INSERT INTO `family_animals` (`name`, `description`) VALUES
('Rongeurs', 'On les reconnaît à leur corps généralement court et trapu, à de petites oreilles dressées mais collées à la tête, et à de petites pattes qui leur octroient un centre de gravité bas, grâce auquel ils se déplacent avec une surprenante célérité.'),
('Oiseaux', "Les Oiseaux (Aves) sont une classe de Vertébrés tétrapodes caractérisée par la bipédie, des ailes, un plumage et un bec sans dents. Survivants de l'extinction Crétacé-Paléogène, les oiseaux modernes (Neornithes) sont les seuls représentants actuels des dinosaures théropodes, tandis que tous les autres groupes de Dinosaures sont éteints. Les crocodiliens constituent aujourd’hui les plus proches parents des oiseaux."),
('Poissons', "Les poissons sont des animaux vertébrés aquatiques à branchies, pourvus de nageoires et dont le corps est généralement couvert d'écailles. On les trouve abondamment aussi bien en eau douce, en eau saumâtre et en eau de mer, depuis les sources de montagne (omble de fontaine, goujon) jusqu'au plus profond des océans (grandgousier, poisson-ogre). Leur répartition est toutefois très inégale : 50 % des poissons vivraient dans 17 % de la surface des océans1."),
('Reptiles', "Les Reptiles (Reptilia) sont une classe de vertébrés tétrapodes à température variable (ectothermes) et recouverts d'écailles. Ce taxon de la classification classique inclut des animaux comme les dinosaures non aviens, les Ptérosaures, les Ichthyosaures, les Plésiosaures et les Pliosaures, mais s'est révélé être non pertinent avec l'essor de la cladistique. Son utilisation est de ce fait controversée : depuis l'apparition de la classification phylogénétique, un nombre croissant de chercheurs considèrent que le concept de « Reptiles » ne devrait plus être utilisé dans la classification scientifique des espèces. Il désigne en effet un groupe paraphylétique d'espèces semblables par les caractères de l'ectothermie et des écailles, mais dont les ancêtres communs ont produit une descendance qui ne possède pas ces caractères : les Oiseaux et les Mammifères.");
UNLOCK TABLES;