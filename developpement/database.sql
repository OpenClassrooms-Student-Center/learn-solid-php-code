-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: mysql.info.unicaen.fr
-- Généré le : Mer 04 Avril 2012 à 23:03
-- Version du serveur: 5.1.61
-- Version de PHP: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `21106438_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` varchar(32) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `id_album` varchar(32) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tp_upload`
--

CREATE TABLE IF NOT EXISTS `tp_upload` (
  `id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 NOT NULL,
  `auteur` varchar(70) CHARACTER SET utf8 NOT NULL,
  `fichier` varchar(255) CHARACTER SET utf8 NOT NULL,
  `dateIns` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
