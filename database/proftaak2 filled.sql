-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 dec 2018 om 11:24
-- Serverversie: 10.1.30-MariaDB
-- PHP-versie: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proftaak2`
--
CREATE DATABASE IF NOT EXISTS `proftaak2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `proftaak2`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `attached-files`
--

CREATE TABLE IF NOT EXISTS `attached-files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages` varchar(400) DEFAULT NULL,
  `sourcefiles_id` int(11) NOT NULL,
  `versions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attached-files_sourcefiles1_idx` (`sourcefiles_id`),
  KEY `fk_attached-files_versions1_idx` (`versions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `colleges`
--

INSERT INTO `colleges` (`id`, `name`) VALUES
(1, 'none'),
(2, 'ICT'),
(3, 'Bouw');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `colleges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_courses_colleges_idx` (`colleges_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `courses`
--

INSERT INTO `courses` (`id`, `name`, `colleges_id`) VALUES
(1, 'none', 1),
(2, 'Beheer', 2),
(3, 'Bouw 1', 3),
(4, 'Applicatieontwikkeling', 2),
(5, 'Bouw 2', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mergedfiles`
--

CREATE TABLE IF NOT EXISTS `mergedfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mergedfiles_users1_idx` (`users_id`),
  KEY `fk_mergedfiles_courses1_idx` (`courses_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `read` tinyint(4) DEFAULT '0',
  `edit` tinyint(4) DEFAULT '0',
  `users_id` int(11) NOT NULL,
  `colleges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_permissions_users1_idx` (`users_id`),
  KEY `fk_permissions_colleges1_idx` (`colleges_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sourcefiles`
--

CREATE TABLE IF NOT EXISTS `sourcefiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `colleges_id` int(11) DEFAULT NULL,
  `courses_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sourcefiles_users1_idx` (`users_id`),
  KEY `fk_sourcefiles_colleges1_idx` (`colleges_id`),
  KEY `fk_sourcefiles_courses1_idx` (`courses_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `confirm` tinyint(4) DEFAULT '0',
  `newcollege` tinyint(4) DEFAULT '0',
  `verified` tinyint(4) DEFAULT '0',
  `admin` tinyint(4) DEFAULT '0',
  `colleges_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_colleges1_idx` (`colleges_id`),
  KEY `fk_users_courses1_idx` (`courses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `confirm`, `newcollege`, `verified`, `admin`, `colleges_id`, `courses_id`) VALUES
(1, 'admin', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 1, 1, 1, 1, 1, 1),
(2, 'ictuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 0, 0, 0, 0, 2, 4),
(3, 'bouwuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 0, 0, 0, 0, 3, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `versions`
--

CREATE TABLE IF NOT EXISTS `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `filedate` varchar(20) DEFAULT NULL,
  `mergedfiles_id` int(11) DEFAULT NULL,
  `sourcefiles_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_versions_mergedfiles1_idx` (`mergedfiles_id`),
  KEY `fk_versions_sourcefiles1_idx` (`sourcefiles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `attached-files`
--
ALTER TABLE `attached-files`
  ADD CONSTRAINT `fk_attached-files_sourcefiles1` FOREIGN KEY (`sourcefiles_id`) REFERENCES `sourcefiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_attached-files_versions1` FOREIGN KEY (`versions_id`) REFERENCES `versions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_colleges` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `mergedfiles`
--
ALTER TABLE `mergedfiles`
  ADD CONSTRAINT `fk_mergedfiles_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mergedfiles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `fk_permissions_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `sourcefiles`
--
ALTER TABLE `sourcefiles`
  ADD CONSTRAINT `fk_sourcefiles_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sourcefiles_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sourcefiles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `versions`
--
ALTER TABLE `versions`
  ADD CONSTRAINT `fk_versions_mergedfiles1` FOREIGN KEY (`mergedfiles_id`) REFERENCES `mergedfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_versions_sourcefiles1` FOREIGN KEY (`sourcefiles_id`) REFERENCES `sourcefiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
