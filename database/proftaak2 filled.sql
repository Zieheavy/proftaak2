-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2018 at 10:33 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

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
-- Table structure for table `attached-files`
--

CREATE TABLE IF NOT EXISTS `attached-files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages` varchar(400) DEFAULT NULL,
  `sourcefiles_id` int(11) NOT NULL,
  `versions_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_attached-files_sourcefiles1_idx` (`sourcefiles_id`),
  KEY `fk_attached-files_versions1_idx` (`versions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attached-files`
--

INSERT INTO `attached-files` (`id`, `pages`, `sourcefiles_id`, `versions_id`) VALUES
(90, 'all', 4, 89),
(91, 'all', 10, 89),
(92, 'all', 5, 89),
(93, 'all', 6, 90),
(94, 'all', 11, 90),
(95, 'all', 7, 91),
(96, 'all', 11, 91),
(97, 'all', 9, 91),
(98, 'all', 11, 91),
(99, 'all', 8, 91),
(100, 'all', 11, 92),
(101, 'all', 10, 92),
(102, 'all', 4, 93),
(103, 'all', 5, 93),
(104, 'all', 6, 93),
(105, 'all', 7, 93),
(106, 'all', 8, 93),
(107, 'all', 9, 93);

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`) VALUES
(1, 'ictcollege'),
(2, 'bouwcollege'),
(3, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `colleges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_courses_colleges_idx` (`colleges_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `colleges_id`) VALUES
(1, 'applicatie', 1),
(2, 'beheer', 1),
(3, 'bouwcourse1', 2),
(4, 'bouwcourse2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mergedfiles`
--

CREATE TABLE IF NOT EXISTS `mergedfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mergedfiles_users1_idx` (`users_id`),
  KEY `fk_mergedfiles_courses1_idx` (`courses_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mergedfiles`
--

INSERT INTO `mergedfiles` (`id`, `name`, `users_id`, `courses_id`) VALUES
(38, 'BouwGids1', 2, 1),
(39, 'ApplicatieGids1', 2, 1),
(40, 'Beheer1', 2, 1),
(41, 'AllExcel1', 2, 1),
(42, 'AllWord1', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `read` tinyint(4) DEFAULT '0',
  `write` tinyint(4) DEFAULT '0',
  `edit` tinyint(4) DEFAULT '0',
  `users_id` int(11) NOT NULL,
  `colleges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_permissions_users1_idx` (`users_id`),
  KEY `fk_permissions_colleges1_idx` (`colleges_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `read`, `write`, `edit`, `users_id`, `colleges_id`) VALUES
(1, 1, 0, 1, 2, 1),
(2, 1, 0, 0, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sourcefiles`
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sourcefiles`
--

INSERT INTO `sourcefiles` (`id`, `name`, `extension`, `users_id`, `colleges_id`, `courses_id`) VALUES
(4, 'Bouw Opleiding 1 Deel 1', 'docx', 3, 2, 3),
(5, 'Bouw Opleiding 2 Deel 1', 'docx', 3, 2, 4),
(6, 'ICT Applicatie Deel 1', 'docx', 2, 1, 1),
(7, 'ICT Beheer Deel 1', 'docx', 2, 1, 2),
(8, 'ICT Beheer Deel 2', 'docx', 2, 1, 2),
(9, 'ICT Beheer Deel 3', 'docx', 2, 1, 2),
(10, 'Bouw', 'xlsx', 3, 2, 3),
(11, 'ICT', 'xlsx', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `confirm` tinyint(4) DEFAULT '0',
  `newcollege` tinyint(4) DEFAULT '0',
  `verified` tinyint(4) DEFAULT '0',
  `colleges_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_colleges1_idx` (`colleges_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `confirm`, `newcollege`, `verified`, `colleges_id`) VALUES
(1, 'admin', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 1, 1, 1, 3),
(2, 'ictuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 1, 0, 1, 1),
(3, 'bouwuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 0, 0, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `versions`
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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`id`, `version`, `filedate`, `mergedfiles_id`, `sourcefiles_id`) VALUES
(89, 0, '29-11-2018 09:05:21', 38, NULL),
(90, 0, '29-11-2018 09:05:41', 39, NULL),
(91, 0, '29-11-2018 09:06:12', 40, NULL),
(92, 0, '29-11-2018 09:06:28', 41, NULL),
(93, 0, '29-11-2018 09:06:55', 42, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attached-files`
--
ALTER TABLE `attached-files`
  ADD CONSTRAINT `fk_attached-files_sourcefiles1` FOREIGN KEY (`sourcefiles_id`) REFERENCES `sourcefiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_attached-files_versions1` FOREIGN KEY (`versions_id`) REFERENCES `versions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_colleges` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mergedfiles`
--
ALTER TABLE `mergedfiles`
  ADD CONSTRAINT `fk_mergedfiles_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mergedfiles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `fk_permissions_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_permissions_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sourcefiles`
--
ALTER TABLE `sourcefiles`
  ADD CONSTRAINT `fk_sourcefiles_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sourcefiles_courses1` FOREIGN KEY (`courses_id`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sourcefiles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `versions`
--
ALTER TABLE `versions`
  ADD CONSTRAINT `fk_versions_mergedfiles1` FOREIGN KEY (`mergedfiles_id`) REFERENCES `mergedfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_versions_sourcefiles1` FOREIGN KEY (`sourcefiles_id`) REFERENCES `sourcefiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
