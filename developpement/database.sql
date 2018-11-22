SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
