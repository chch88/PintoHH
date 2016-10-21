-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2016 at 09:21 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bars`
--

INSERT INTO `bars` (`id_bar`, `photos_id_photo`, `styles_bars_id_style_bar`, `villes_id_ville`, `nom_bar`, `longitude`, `latitude`, `numero`, `rue`, `description`, `telephone`, `mot_patron`, `site_web`) VALUES
(1, NULL, 4, 1, 'Le Virgil', 6.44668, 48.1754, '4', 'Rue des Pompes', 'Superbe terrasse en rue piétonne et soirées bien animées comme on les aime !\r\n\r\nTrès bien situé dans le centre-ville d’Épinal, le bar-brasserie, Le Virgile vous reçoit dans un cadre lumineux, tendance et confortable.\r\n\r\nIl dispose d’une belle et grande terrasse donnant sur une rue piétonnière agréable.\r\n\r\nParfait pour un déjeuner du midi, il propose une carte de brasserie classique et sans mauvaise surprises.\r\n\r\nIdéal pour vos apéritifs prolongés, et vos Before, il organise de nombreuses soirées bien festives, avec des Mix DJ et des retransmissions TV de vos matchs préférés.\r\n\r\nUn espace fumeur fermé. ', '0329823946', '', NULL),
(2, NULL, 4, 1, 'Au Bureau Epinal', 6.45094, 48.1748, '1', 'Place Edmond Henry', 'Burgers, cuisine bistro et spécialités locales dans une chaîne de brasseries-pubs au décor anglo-saxon rétro', '0329301300', NULL, 'http://www.aubureau-epinal.com/'),
(3, NULL, 2, 1, 'Le Sulky', 6.44628, 48.1748, '4', 'Rue des Petites Boucheries', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bar_biere`
--

CREATE TABLE IF NOT EXISTS `bar_biere` (
  `bars_id_bar` int(10) unsigned NOT NULL,
  `bieres_id_biere` int(10) unsigned NOT NULL,
  PRIMARY KEY (`bars_id_bar`,`bieres_id_biere`),
  KEY `bars_has_bieres_FKIndex1` (`bars_id_bar`),
  KEY `bars_has_bieres_FKIndex2` (`bieres_id_biere`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bieres`
--

INSERT INTO `bieres` (`id_biere`, `type_biere_id_type_biere`, `pays_id_pays`, `photos_id_photo`, `nom_biere`, `degree_biere`, `prix_normal`, `prix_happy`, `description`) VALUES
(1, 3, 2, NULL, 'Kronenbourg', 5, NULL, NULL, NULL);

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
  `is_happy_hour` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_horaire`),
  KEY `horaires_FKIndex1` (`bars_id_bar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_pays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id_pays`, `nom_pays`) VALUES
(1, 'France'),
(2, 'Belgique'),
(5, 'Allemagne');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id_photo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fichier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `styles_bars`
--

CREATE TABLE IF NOT EXISTS `styles_bars` (
  `id_style_bar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_style_bar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_style_bar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `styles_bars`
--

INSERT INTO `styles_bars` (`id_style_bar`, `nom_style_bar`) VALUES
(1, 'Lounge'),
(2, 'Bar de Quartier'),
(3, 'Pub'),
(4, 'Brasserie');

-- --------------------------------------------------------

--
-- Table structure for table `type_biere`
--

CREATE TABLE IF NOT EXISTS `type_biere` (
  `id_type_biere` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom_type_biere` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_type_biere`),
  KEY `id_type_biere` (`id_type_biere`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `type_biere`
--

INSERT INTO `type_biere` (`id_type_biere`, `nom_type_biere`) VALUES
(1, 'Blonde'),
(2, 'Brune'),
(3, 'Ambrée'),
(4, 'Rousse');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(10) UNSIGNED NOT NULL,
  `roles_id_role` int(11) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `sexe` char(1) DEFAULT NULL,
  `identifiant` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `confirmation_token` varchar(100) DEFAULT NULL,
  `confirmation_mail` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


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
