-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2016 at 01:59 PM
-- Server version: 5.6.31-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pinto`
--

-- --------------------------------------------------------

--
-- Table structure for table `bars`
--

CREATE TABLE IF NOT EXISTS `bars` (
  `id_bar` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `photos_id_photo` int(11) unsigned DEFAULT NULL,
  `styles_bars_id_style_bar` int(11) unsigned DEFAULT NULL,
  `villes_id_ville` int(11) unsigned DEFAULT NULL,
  `nom_bar` varchar(255) DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `rue` varchar(255) DEFAULT NULL,
  `description` text,
  `telephone` varchar(20) DEFAULT NULL,
  `mot_patron` text,
  `site_web` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_bar`),
  KEY `bars_FKIndex1` (`villes_id_ville`),
  KEY `bars_FKIndex2` (`styles_bars_id_style_bar`),
  KEY `bars_FKIndex3` (`photos_id_photo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bars`
--

INSERT INTO `bars` (`id_bar`, `photos_id_photo`, `styles_bars_id_style_bar`, `villes_id_ville`, `nom_bar`, `longitude`, `latitude`, `numero`, `rue`, `description`, `telephone`, `mot_patron`, `site_web`) VALUES
(1, 5, 1, 1, 'Le Virgil', 6.44668, 48.1754, '4', 'Rue des Pompes', 'Superbe terrasse en rue piétonne et soirées bien animées comme on les aime !\r\n\r\nTrès bien situé dans le centre-ville d’Épinal, le bar-brasserie, Le Virgile vous reçoit dans un cadre lumineux, tendance et confortable.\r\n\r\nIl dispose d’une belle et grande terrasse donnant sur une rue piétonnière agréable.\r\n\r\nParfait pour un déjeuner du midi, il propose une carte de brasserie classique et sans mauvaise surprises.\r\n\r\nIdéal pour vos apéritifs prolongés, et vos Before, il organise de nombreuses soirées bien festives, avec des Mix DJ et des retransmissions TV de vos matchs préférés.\r\n\r\nUn espace fumeur fermé. ', '0329823946', 'Bienvenue au Virgil', NULL),
(2, 3, 1, 1, 'Au Bureau', 6.45094, 48.1748, '1', 'Place Edmond Henry', 'Burgers, cuisine bistro et spécialités locales dans une chaîne de brasseries-pubs au décor anglo-saxon rétro', '0329301300', NULL, 'http://www.aubureau-epinal.com/'),
(3, 9, 2, 1, 'Le Sulky', 6.44628, 48.1748, '4', 'Rue des Petites Boucheries', NULL, NULL, 'Venez écoutez vos disques au Sulky', NULL),
(4, 13, 7, 1, 'Les caves de Fontenay', NULL, NULL, '8', 'rue de la maix', 'La locomotive du train de nuit de la jeunesse d’Epinal !\r\n\r\nAvec sa cave voûtée en pierres apparentes, la cave–bar à vins et à bières, Les Caves de Fontenay d’Epinal possède un charme authentique indéniable.\r\n\r\nAvec son choix de plus de 200 bières spéciales, 150 vins de producteurs-récoltants, plus de 50 whiskys, rhums, vodkas, mini-fûts, cognacs et autre pompes à bière, elle tient un caractère bien trempé qui n’est pas pour déplaire aux jeunes et aux moins jeunes qui aiment baigner dans la convivialité.', '0329323352', 'Avec son équipe pleine d’entrain, de professionnels qui sauront vous conseiller sur vos choix.\r\n\r\nAvec la possibilité de siroter sur place ou d'' emporter chez vous à prix cave, que vous soyez particuliers, professionnel, association ou comité d’entreprise.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bar_biere`
--

CREATE TABLE IF NOT EXISTS `bar_biere` (
  `bars_id_bar` int(10) unsigned NOT NULL,
  `bieres_id_biere` int(10) unsigned NOT NULL,
  `prix_normal_bar` float NOT NULL,
  `prix_happy_bar` float NOT NULL,
  PRIMARY KEY (`bars_id_bar`,`bieres_id_biere`),
  KEY `bars_has_bieres_FKIndex1` (`bars_id_bar`),
  KEY `bars_has_bieres_FKIndex2` (`bieres_id_biere`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bar_biere`
--

INSERT INTO `bar_biere` (`bars_id_bar`, `bieres_id_biere`, `prix_normal_bar`, `prix_happy_bar`) VALUES
(1, 2, 5, 4),
(1, 3, 5, 4),
(2, 4, 6, 4.5),
(3, 1, 4.5, 3.5),
(4, 4, 5.5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bar_favori`
--

CREATE TABLE IF NOT EXISTS `bar_favori` (
  `bars_id_bar` int(10) unsigned NOT NULL,
  `utilisateurs_id_utilisateur` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bars_id_bar`,`utilisateurs_id_utilisateur`),
  KEY `bars_has_utilisateurs_FKIndex1` (`bars_id_bar`),
  KEY `bars_has_utilisateurs_FKIndex2` (`utilisateurs_id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bar_favori`
--

INSERT INTO `bar_favori` (`bars_id_bar`, `utilisateurs_id_utilisateur`) VALUES
(3, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bieres`
--

CREATE TABLE IF NOT EXISTS `bieres` (
  `id_biere` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_biere_id_type_biere` int(11) unsigned DEFAULT NULL,
  `pays_id_pays` int(11) unsigned DEFAULT NULL,
  `photos_id_photo` int(11) unsigned DEFAULT NULL,
  `nom_biere` varchar(255) DEFAULT NULL,
  `degree_biere` float DEFAULT NULL,
  `prix_normal` float DEFAULT NULL,
  `prix_happy` float DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_biere`),
  KEY `type_biere_id_type_biere` (`type_biere_id_type_biere`),
  KEY `pays_id_pays` (`pays_id_pays`),
  KEY `photos_id_photo` (`photos_id_photo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bieres`
--

INSERT INTO `bieres` (`id_biere`, `type_biere_id_type_biere`, `pays_id_pays`, `photos_id_photo`, `nom_biere`, `degree_biere`, `prix_normal`, `prix_happy`, `description`) VALUES
(1, 2, 1, 1, 'Kronenbourg', 4.2, NULL, NULL, 'Kronenbourg est la marque phare de Brasseries Kronenbourg, brasseur alsacien installé à Obernai dans le Bas-Rhin et appartenant aujourd''hui au groupe danois Carlsberg. Elle est la marque de bière la plus consommée en France, une bière sur cinq vendue en France étant une Kronenbourg1.'),
(2, 6, 6, 8, 'Guinness', 6, NULL, NULL, 'La Guinness est une bière d''IRLANDE  qui appartient à la famille des stouts (Brasserie GUINNESS). Ce terme désigne des bières fortes en goût et/ou en alcool, dont la fermentation exalte tous les arômes de la bière.\nLa couleur de la Guinness est particulièrement sombre, proche du noir, du fait de l''utilisation de malts torréfiés et de grains d''orges grillés.Contrairement aux idées reçues , la bière arbore un liquide fluide et léger 4,2°'),
(3, 2, 2, 7, 'KARMELIET Triple', 8.4, NULL, NULL, 'Bière de fermentation haute, la Tripel Karmeliet 8°  est issue de la Brasserie BOSTEELS à BUGGENHOUT flandre orientale (Belgique) . Elle doit son nom à la recette de moines carmélites de Dendermonde . Elle est élaborée à partir de trois céréales (orge-froment et avoine). Elle offre une mousse très généreuse, dévoile une saveur très épicée et une bouche très sucrée. Bière relativement récente qui est déjà devenue un grand classique. '),
(4, 5, 2, 2, 'Delirium Red', 8.5, NULL, NULL, 'Aromatisée à la cerise, la Delirium Red vient ainsi compléter la gamme de bière de la brasserie en s''adressant aussi bien aux femmes qu''aux étudiants, sans oublier les amateurs de bières fortes ! \nDans son verre Delirium, elle révèle une robe rouge foncée au col de mousse fin et compact. Elle dévoile une odeur douce et fruitée, mélange d''amandes douces et de notes puissantes de cerise qui s''évaporent rapidement dans l''air.');

-- --------------------------------------------------------

--
-- Table structure for table `biere_favori`
--

CREATE TABLE IF NOT EXISTS `biere_favori` (
  `bieres_id_biere` int(10) unsigned NOT NULL,
  `utilisateurs_id_utilisateur` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bieres_id_biere`,`utilisateurs_id_utilisateur`),
  KEY `bieres_has_utilisateurs_FKIndex1` (`bieres_id_biere`),
  KEY `bieres_has_utilisateurs_FKIndex2` (`utilisateurs_id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biere_favori`
--

INSERT INTO `biere_favori` (`bieres_id_biere`, `utilisateurs_id_utilisateur`) VALUES
(2, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `galerie_bar`
--

CREATE TABLE IF NOT EXISTS `galerie_bar` (
  `bars_id_bar` int(10) unsigned NOT NULL,
  `photos_id_photo` int(11) unsigned NOT NULL,
  PRIMARY KEY (`bars_id_bar`,`photos_id_photo`),
  KEY `bars_has_photos_FKIndex1` (`bars_id_bar`),
  KEY `bars_has_photos_FKIndex2` (`photos_id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `galerie_bar`
--

INSERT INTO `galerie_bar` (`bars_id_bar`, `photos_id_photo`) VALUES
(1, 5),
(1, 6),
(2, 3),
(2, 4),
(3, 9),
(3, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14);

-- --------------------------------------------------------

--
-- Table structure for table `horaires`
--

CREATE TABLE IF NOT EXISTS `horaires` (
  `id_horaire` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bars_id_bar` int(10) unsigned DEFAULT NULL,
  `numero_jour` int(1) unsigned DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `is_happy_hour` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_horaire`),
  KEY `horaires_FKIndex1` (`bars_id_bar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `horaires`
--

INSERT INTO `horaires` (`id_horaire`, `bars_id_bar`, `numero_jour`, `heure_debut`, `heure_fin`, `is_happy_hour`) VALUES
(1, 1, 1, '15:00:00', '23:00:00', 0),
(2, 2, 1, '20:00:00', '22:00:00', 0),
(3, 3, 1, '07:00:00', '09:00:00', 0),
(4, 1, 4, '15:00:00', '19:00:00', 1),
(5, 2, 1, '20:00:00', '21:00:00', 1),
(6, 3, 1, '07:30:00', '08:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id_pays`, `nom_pays`) VALUES
(1, 'France'),
(2, 'Belgique'),
(5, 'Allemagne'),
(6, 'Irlande');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id_photo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fichier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id_photo`, `fichier`) VALUES
(1, '/PintoHH/images/photosbieres/kro.png'),
(2, '/PintoHH/images/photosbieres/delirium-red.png'),
(3, '/PintoHH/images/photosbars/le_bureau1.jpg'),
(4, '/PintoHH/images/photosbars/le_bureau2.jpg'),
(5, '/PintoHH/images/photosbars/le_virgil1.jpg'),
(6, '/PintoHH/images/photosbars/le_virgil2.jpg'),
(7, '/PintoHH/images/photosbieres/karmeliet_triple.png'),
(8, '/PintoHH/images/photosbieres/guinness.png'),
(9, '/PintoHH/images/photosbars/le_sulky1.jpg'),
(10, '/PintoHH/images/photosbars/le_sulky2.jpg'),
(11, '/PintoHH/images/photosbars/les_caves_de_fontenay1.jpg'),
(12, '/PintoHH/images/photosbars/les_caves_de_fontenay2.jpg'),
(13, '/PintoHH/images/photosbars/les_caves_de_fontenay3.jpg'),
(14, '/PintoHH/images/photosbars/les_caves_de_fontenay4.jpg'),
(15, '');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'Admin'),
(2, 'Membre');

-- --------------------------------------------------------

--
-- Table structure for table `styles_bars`
--

CREATE TABLE IF NOT EXISTS `styles_bars` (
  `id_style_bar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_style_bar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_style_bar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `styles_bars`
--

INSERT INTO `styles_bars` (`id_style_bar`, `nom_style_bar`) VALUES
(1, 'Lounge'),
(2, 'Bar de Quartier'),
(3, 'Pub'),
(4, 'Brasserie'),
(5, 'Bar d''ambiance'),
(6, 'Bar à vin'),
(7, 'Bar à bières');

-- --------------------------------------------------------

--
-- Table structure for table `type_biere`
--

CREATE TABLE IF NOT EXISTS `type_biere` (
  `id_type_biere` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_type_biere` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_type_biere`),
  KEY `id_type_biere` (`id_type_biere`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `type_biere`
--

INSERT INTO `type_biere` (`id_type_biere`, `nom_type_biere`) VALUES
(1, 'Blanche'),
(2, 'Blonde'),
(3, 'Brune'),
(4, 'Ambrée'),
(5, 'Rouge'),
(6, 'Noire');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roles_id_role` int(11) unsigned DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `sexe` char(1) DEFAULT NULL,
  `identifiant` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `confirmation_token` char(100) DEFAULT NULL,
  `confirmation_mail` datetime DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  KEY `utilisateurs_FKIndex1` (`roles_id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `roles_id_role`, `nom`, `sexe`, `identifiant`, `email`, `password`, `confirmation_token`, `confirmation_mail`) VALUES
(1, 2, 'dylan88', '2', 'dylan88', 'dylan88@gmail.fr', 'dylan88', NULL, NULL),
(2, 2, 'chloé', '1', 'chloe88', 'ch-ch-@hotmail.fr', 'chloe88', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `villes`
--

CREATE TABLE IF NOT EXISTS `villes` (
  `id_ville` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code_postal` varchar(10) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ville`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `villes`
--

INSERT INTO `villes` (`id_ville`, `code_postal`, `ville`) VALUES
(1, '88000', 'Épinal');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bars`
--
ALTER TABLE `bars`
  ADD CONSTRAINT `bars_ibfk_1` FOREIGN KEY (`photos_id_photo`) REFERENCES `photos` (`id_photo`),
  ADD CONSTRAINT `bars_ibfk_2` FOREIGN KEY (`styles_bars_id_style_bar`) REFERENCES `styles_bars` (`id_style_bar`),
  ADD CONSTRAINT `bars_ibfk_3` FOREIGN KEY (`villes_id_ville`) REFERENCES `villes` (`id_ville`);

--
-- Constraints for table `bar_biere`
--
ALTER TABLE `bar_biere`
  ADD CONSTRAINT `bar_biere_ibfk_1` FOREIGN KEY (`bars_id_bar`) REFERENCES `bars` (`id_bar`),
  ADD CONSTRAINT `bar_biere_ibfk_2` FOREIGN KEY (`bieres_id_biere`) REFERENCES `bieres` (`id_biere`);

--
-- Constraints for table `bar_favori`
--
ALTER TABLE `bar_favori`
  ADD CONSTRAINT `bar_favori_ibfk_1` FOREIGN KEY (`bars_id_bar`) REFERENCES `bars` (`id_bar`),
  ADD CONSTRAINT `bar_favori_ibfk_2` FOREIGN KEY (`utilisateurs_id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Constraints for table `bieres`
--
ALTER TABLE `bieres`
  ADD CONSTRAINT `bieres_ibfk_1` FOREIGN KEY (`type_biere_id_type_biere`) REFERENCES `type_biere` (`id_type_biere`),
  ADD CONSTRAINT `bieres_ibfk_2` FOREIGN KEY (`pays_id_pays`) REFERENCES `pays` (`id_pays`),
  ADD CONSTRAINT `bieres_ibfk_3` FOREIGN KEY (`photos_id_photo`) REFERENCES `photos` (`id_photo`);

--
-- Constraints for table `biere_favori`
--
ALTER TABLE `biere_favori`
  ADD CONSTRAINT `biere_favori_ibfk_1` FOREIGN KEY (`bieres_id_biere`) REFERENCES `bieres` (`id_biere`),
  ADD CONSTRAINT `biere_favori_ibfk_2` FOREIGN KEY (`utilisateurs_id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Constraints for table `galerie_bar`
--
ALTER TABLE `galerie_bar`
  ADD CONSTRAINT `galerie_bar_ibfk_1` FOREIGN KEY (`bars_id_bar`) REFERENCES `bars` (`id_bar`),
  ADD CONSTRAINT `galerie_bar_ibfk_2` FOREIGN KEY (`photos_id_photo`) REFERENCES `photos` (`id_photo`);

--
-- Constraints for table `horaires`
--
ALTER TABLE `horaires`
  ADD CONSTRAINT `horaires_ibfk_1` FOREIGN KEY (`bars_id_bar`) REFERENCES `bars` (`id_bar`);

--
-- Constraints for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`roles_id_role`) REFERENCES `roles` (`id_role`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
