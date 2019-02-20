SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- `Songs`
--

CREATE TABLE IF NOT EXISTS `songs` (
  `id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `id_album` varchar(32) NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- `Albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `author` varchar(70) CHARACTER SET utf8 NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
