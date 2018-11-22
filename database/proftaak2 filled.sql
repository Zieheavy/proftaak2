-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2018 at 10:30 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `attached-files`
--

CREATE TABLE `attached-files` (
  `id` int(11) NOT NULL,
  `pages` varchar(400) DEFAULT NULL,
  `mergedfiles_id` int(11) NOT NULL,
  `sourcefiles_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `name`) VALUES
(1, 'BouwCollege'),
(2, 'ICTCollege'),
(3, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `colleges_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `colleges_id`) VALUES
(1, 'Applicatie', 2),
(2, 'Beheer', 2),
(3, ' bouw opleiding 1', 1),
(4, 'bouw opleiding 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mergedfiles`
--

CREATE TABLE `mergedfiles` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mergedfiles`
--

INSERT INTO `mergedfiles` (`id`, `name`, `version`, `users_id`, `courses_id`) VALUES
(1, 'merged1', 0, 3, 1),
(2, 'merged2', 0, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `read` tinyint(4) DEFAULT '0',
  `write` tinyint(4) DEFAULT '0',
  `edit` tinyint(4) DEFAULT '0',
  `users_id` int(11) NOT NULL,
  `colleges_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `read`, `write`, `edit`, `users_id`, `colleges_id`) VALUES
(1, 1, 1, 1, 1, 3),
(2, 1, 1, 0, 3, 2),
(3, 1, 0, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sourcefiles`
--

CREATE TABLE `sourcefiles` (
  `id` int(11) NOT NULL,
  `name` varchar(400) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(400) DEFAULT NULL,
  `confirm` tinyint(4) DEFAULT '0',
  `newcollege` tinyint(4) DEFAULT '0',
  `verified` tinyint(4) DEFAULT '0',
  `colleges_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `confirm`, `newcollege`, `verified`, `colleges_id`) VALUES
(1, 'admin', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 1, 1, 1, 3),
(2, 'bouwuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 0, 0, 1, 1),
(3, 'ictuser', '$2y$10$flaaac3eoz86G5q0z/./M.2aD./x/kwmdfXuWje9x9tCBCNAsFF4C', 1, 0, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attached-files`
--
ALTER TABLE `attached-files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_attached-files_mergedfiles1_idx` (`mergedfiles_id`),
  ADD KEY `fk_attached-files_sourcefiles1_idx` (`sourcefiles_id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_courses_colleges_idx` (`colleges_id`);

--
-- Indexes for table `mergedfiles`
--
ALTER TABLE `mergedfiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mergedfiles_users1_idx` (`users_id`),
  ADD KEY `fk_mergedfiles_courses1_idx` (`courses_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permissions_users1_idx` (`users_id`),
  ADD KEY `fk_permissions_colleges1_idx` (`colleges_id`);

--
-- Indexes for table `sourcefiles`
--
ALTER TABLE `sourcefiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sourcefiles_users1_idx` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_colleges1_idx` (`colleges_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attached-files`
--
ALTER TABLE `attached-files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `mergedfiles`
--
ALTER TABLE `mergedfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sourcefiles`
--
ALTER TABLE `sourcefiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attached-files`
--
ALTER TABLE `attached-files`
  ADD CONSTRAINT `fk_attached-files_mergedfiles1` FOREIGN KEY (`mergedfiles_id`) REFERENCES `mergedfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_attached-files_sourcefiles1` FOREIGN KEY (`sourcefiles_id`) REFERENCES `sourcefiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_sourcefiles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_colleges1` FOREIGN KEY (`colleges_id`) REFERENCES `colleges` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
